<?php

namespace Tests\Feature\Api;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\JwtAuthentication;
use Tests\OnlyAjaxMiddlewareHelper;
use Tests\TestCase;

/**
 */
class TitlesTest extends TestCase
{
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
        
        $this->user = User::role('admin')->first();

        $this->assertNotNull($this->user, 'No admin users in database. Did you seed database?'
        .' `php artisan db:seed`');
    }


    /**
     * @dataProvider paginateUsersProvider
     *
     *
     * @param array     $params
     * @param int       $status
     * @param string[]  $errorFields
     */
    public function testCanGetTitlesList(array $params, int $status, $errorFields = []) : void
    {
        $response = $this->actingAs($this->user)->json('get', '/api/titles', $params);

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
                'per_page'     => isset($params['per_page']) ? $params['per_page'] : 100,
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
    public function paginateUsersProvider() : array
    {
        return [
            'default valid without params' => [[
            ], 200],
        ];
    }

    public function ajaxRoutesProvider() : array
    {
        return [
            '/api/titles'              => ['/api/titles', ['get', 'head']],
            '/api/titles/{user}'       => ['/api/titles/1', ['get', 'head']],
        ];
    }
}
