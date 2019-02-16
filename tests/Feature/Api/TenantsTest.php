<?php

namespace Tests\Feature\Api;

use App\Entities\User;
use App\Entities\Tenant;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\JwtAuthentication;
use Tests\OnlyAjaxMiddlewareHelper;
use Tests\TestCase;

/**
 * @coversDefaultClass App\Http\Controllers\Api\TenantsController
 */
class TenantsTest extends TestCase
{
    use DatabaseTransactions;
    use JwtAuthentication;
    use OnlyAjaxMiddlewareHelper;

    /**
     * Default admin user to perform actions.
     *
     * @var User
     */
    protected $user = null;

    public function setUp()
    {
        parent::setUp();

        $this->assertGreaterThan(0, User::count(), 'No users in database. Did you seed database?'
        .' `php artisan db:seed`');

        $this->user = User::role('admin')->inRandomOrder()->first();

        $this->assertNotNull($this->user, 'No admin users in database. Did you seed database?'
        .' `php artisan db:seed`');

        if (Tenant::count() < 2) {
            $this->seed('TenantssTestSeeder');
        }
    }


    /**
     * @dataProvider paginateTenantsProvider
     *
     * @covers ::index()
     *
     * @param array     $params
     * @param int       $status
     * @param string[]  $errorFields
     */
    public function testValidatesAndReturnsAListOfPaginatedTenants(array $params, int $status, $errorFields = []) : void
    {
        $response = $this->actingAs($this->user)->json('get', '/api/tenants', $params);

        // dd($response->json());

        $response->assertStatus($status);

        if ($status === 200) {
            $response->assertJsonStructure([
                'current_page',
                'per_page',
                'last_page',
                'from',
                'to',
                'data',
                'total',
            ]);

            $response->assertJson([
                'current_page' => isset($params['page']) ? $params['page'] : 1,
                'per_page'     => isset($params['per_page']) ? $params['per_page'] : 20,
            ]);
        } elseif ($status === 422) {
            $response->assertJsonValidationErrors($errorFields);
        }
    }

    /**
     * - (array) $params,
     * - (int)   $status,
     * - (array) $errorFields,
     *
     * @return array
     */
    public function paginateTenantsProvider() : array
    {
        return [
            'default valid without params' => [[
            ], 200],
            'with only $page' => [[
                'page' => 1,
            ], 200],
            'with only $per_page' => [[
                'per_page' => 13,
            ], 200],
            'with invalid $per_page type' => [[
                'per_page' => 'arroz',
            ], 422, ['per_page']],
            'with invalid $page type' => [[
                'page' => 'arroz',
            ], 422, ['page']],
            'with invalid negative value for $page and $per_page' => [[
                'page' => -1,
                'per_page' => -2
            ], 422, ['page', 'per_page']],
        ];
    }


    /**
     * @dataProvider methodsNeedsTenantProvider
     *
     * @covers ::show()
     * @covers ::update()
     * @covers ::delete()
     *
     * @param string $method
     */
    public function testIsAwareOfNonexistentTenant(string $method) : void
    {
        $response = $this->actingAs($this->user)->json($method, '/api/tenants/0');
        $response->assertStatus(404);
    }


    /**
     * @dataProvider tenantsStoreProvider
     *
     * @covers ::store
     *
     * @param array    $params
     * @param int      $status
     * @param string[] $errorFields
     */
    public function testValidatesAndPerformsTenantsCreation(
        array $params,
        int $status = 201,
        $errorFields = []
    ) : void {
        $response = $this->actingAs($this->user)->json('post', '/api/tenants', $params);

        $response->assertStatus($status);

        if ($status === 201) {
            $response->assertJsonStructure(['id', 'name', 'nicknames', 'number', 'avatar_url', 'title_id']);

            $this->assertDatabaseHas('tenants', ['name' => $params['name']]);

            $response->assertJson([
                'name'   => $params['name'],
                'number' => $params['number'],
            ]);
        } elseif ($status === 422) {
            $response->assertJsonValidationErrors($errorFields);
            $this->assertDatabaseMissing('tenants', ['name' => $params['name']]);
        }
    }

    /**
     * [
     *   (array)    $params,
     *   (int)      $status,
     *   (string[]) $errorFields
     * ]
     *
     * @return array
     */
    public function tenantsStoreProvider() : array
    {
        return [
            'valid params' => [[
                'name'                      => 'Juan Cito',
                'title_id'                  => 1,
                'nicknames'                 => ['Juancito'],
                'number'                    => 5,
            ], 201],
            'with invalid name' => [[
                'name'                      => ' 123 12312 12 3123',
                'title_id'                  => 1,
                'nicknames'                 => ['Juancito'],
                'number'                    => 5,
            ], 422, ['name']],
            'with inexistent title' => [[
                'name'                      => 'Juan Cito',
                'title_id'                  => 0,
                'nicknames'                 => ['Juancito'],
                'number'                    => 5,
            ], 422, ['title_id']],
            'with invalid number' => [[
                'name'                      => 'Juan Cito',
                'title_id'                  => 1,
                'nicknames'                 => ['Juancito'],
                'number'                    => -1,
            ], 422, ['number']],
        ];
    }


    /**
     *
     *
     * @covers ::show
     */
    public function testPerformsShowTenant() : void
    {
        $target = Tenant::inRandomOrder()->first();

        $response = $this->actingAs($this->user)->json('get', '/api/tenants/'.$target->id);

        $response->assertStatus(200);

        $response->assertJsonStructure(['id', 'name', 'nicknames', 'number', 'avatar_url', 'title', 'title_id']);

        $response->assertJson([
            'id'        => $target->id,
            'name'      => $target->name,
            'nicknames' => $target->nicknames,
            'title_id'  => $target->title_id,
            'number'    => $target->number,
        ]);
    }


    /**
     * @dataProvider tenantsUpdateProvider
     * @depends testIsAwareOfNonexistentTenant
     *
     * @covers ::update()
     *
     * @param array    $params
     * @param int      $status
     * @param string[] $errorFields
     */
    public function testValidatesAndPerformsTenantUpdate(
        array $params,
        int $status = 200,
        $errorFields = []
    ) : void {
        $target = Tenant::inRandomOrder()->first();
        $id     = $target->id;

        $response = $this->actingAs($this->user)->json('put', '/api/tenants/'.$id, $params);

        $response->assertStatus($status);

        if ($status === 200) {
            $response->assertJsonStructure(['id', 'name', 'nicknames', 'number', 'avatar_url', 'title', 'title_id']);

            $name     = isset($params['name']) ? $params['name'] : $target->name;
            $number   = isset($params['number']) ? $params['number'] : $target->number;
            $title_id = isset($params['title_id']) ? $params['title_id'] : $target->title_id;

            $this->assertDatabaseHas('tenants', compact('name', 'number', 'id'));

            $response->assertJson(compact('name', 'number', 'id', 'title_id'));
        } elseif ($status === 422) {
            $response->assertJsonValidationErrors($errorFields);

            $this->assertDatabaseHas('tenants', [
                'id'         => $id,
                'updated_at' => $target->updated_at // No debió haber cambiado la fecha de actualización
            ]);
        }
    }

    /**
     * [
     *   (array)    $params,
     *   (int)      $status,
     *   (string[]) $errorFields
     * ]
     *
     * @return array
     */
    public function tenantsUpdateProvider() : array
    {
        return [
            'valid params' => [[
                'name'                      => 'Juan Cito',
                'title_id'                  => 1,
                'nicknames'                 => ['Juancito'],
                'number'                    => 5,
            ], 200],
            'valid name only' => [[
                'name'                      => 'Juan Cito',
            ], 200],
            'valid null title' => [[
                'name'                      => 'Juan Cito',
                'title_id'                  => null,
            ], 200],
            'with invalid name' => [[
                'name'                      => ' 123 12312 12 3123',
            ], 422, ['name']],
            'with invalid number' => [[
                'title_id'                  => 1,
                'number'                    => -1,
            ], 422, ['number']],
            'empty' => [[], 200],
        ];
    }

    /**
     *
     * @covers ::destroy
     */
    public function testPerformsDeletion() : void
    {
        $target = Tenant::inRandomOrder()->first();

        $id = $target->id;

        $response = $this->actingAs($this->user)->json('delete', '/api/tenants/'.$id);
        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', compact('id'));

        $response = $this->actingAs($this->user)->json('delete', '/api/tenants/'.$id);
        $response->assertStatus(404);
    }


    /**
     * [
     *   (string) $method,
     * ]
     *
     * @return array
     */
    public function methodsNeedsTenantProvider() : array
    {
        return [
            ['get'],
            ['put'],
            ['patch'],
            ['delete'],
        ];
    }


    public function ajaxRoutesProvider() : array
    {
        return [
            '/api/tenants'              => ['/api/tenants', ['get', 'head', 'post']],
            '/api/tenants/{tenant}'       => ['/api/tenants/1', ['get', 'head', 'put', 'patch', 'delete']],
        ];
    }
}
