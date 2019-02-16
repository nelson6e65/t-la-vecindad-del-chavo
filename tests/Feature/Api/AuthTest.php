<?php

namespace Tests\Feature\Api;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;
use Tests\TestCase;
use Tests\JwtAuthentication;
use Tests\OnlyAjaxMiddlewareHelper;

/**
 * @coversDefaultClass App\Http\Controllers\Api\AuthController
 */
class AuthTest extends TestCase
{
    // use RefreshDatabase;
    use JwtAuthentication;
    use OnlyAjaxMiddlewareHelper;

    /**
     *
     */
    public function testDefaultUserExists() : void
    {
        $name  = config('default.user.name');
        $email = config('default.user.email');

        $this->assertDatabaseHas('users', compact('name', 'email'));
    }


    /**
     * @dataProvider loginArgumentsProvider
     * @depends testDefaultUserExists
     * @covers ::login()
     *
     * @param array $params
     * @param int   $status
     */
    public function testLoginReturnsCorrectFormatIfSuccessAndCodeIfFails(array $params, int $status) : void
    {
        $response = $this->json('POST', '/api/auth/login', $params);

        $response->assertStatus($status);

        if ($status == 200) {
            $response->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in'
            ]);
        }
    }

    /**
     * @dataProvider loginMethodsProvider
     *
     * @param string $method
     * @param int    $status
     */
    public function testOnlyPerformsLoginViaJsonPost(string $method, int $status) : void
    {
        $response = $this->json($method, '/api/auth/login');
        $response->assertStatus($status);
    }

    /**
     *
     *
     * @return array
     */
    public function loginMethodsProvider()
    {
        return [
            ['get', 405],
            ['put', 405],
            ['patch', 405],
            ['delete', 405],
            ['post', 422],
        ];
    }


    /**
     *
     *
     * @return array
     */
    public function loginArgumentsProvider() : array
    {
        $email    = env('DEFAULT_USER_EMAIL', 'admin@example.com');
        $password = env('DEFAULT_USER_PASSWORD', 'admin');

        return [
            'Empty' => [[
            ], 422],

            'No <email>' => [[
                'password' => 123,
            ], 422],

            'No <password>' => [[
                'email' => 'no@example.com',
            ], 422],

            'Nonexistent' => [[
                'email' => 'no@example.com',
                'password' => 'THis is NoT a correct password',
            ], 401],

            'Wrong password' => [[
                'email' => $email,
                'password' => $password.'e.e',
            ], 401],

            'Wrong email' => [[
                'email' => $email.'e.e',
                'password' => $password,
            ], 401],

            'Correct credentials' => [[
                'email' => $email,
                'password' => $password,
            ], 200],
        ];
    }

    /**
     * @depends testDefaultUserExists
     * @covers ::me()
     *
     */
    public function testReturnsAuthenticatedUser()
    {
        $name     = config('default.user.name');
        $email    = config('default.user.email');
        $password = config('default.user.password');
        $is_admin = true;

        $meResponse = $this->json('GET', '/api/auth/me');
        $meResponse->assertStatus(401); // Sin autenticar

        $loginResponse = $this->json('POST', '/api/auth/login', compact('email', 'password'));
        $loginResponse->assertOk(); // Ha iniciado sesión

        $meResponse = $this->json('GET', '/api/auth/me');
        $meResponse->assertStatus(200); // Usuario actual

        $meResponse->assertJsonStructure(['id', 'name', 'email', 'is_admin', 'roles', 'avatar_url']);
        $meResponse->assertJson(compact('name', 'email', 'is_admin'));
    }


    /**
     *
     * @depends testReturnsAuthenticatedUser
     * @covers ::logout()
     */
    public function testAuthenticatedUsersCanLogout() : void
    {
        $response = $this->json('GET', '/api/auth/logout');
        $response->assertStatus(405);

        $response = $this->json('POST', '/api/auth/logout');
        $response->assertStatus(401); // Sin autenticar

        $user = User::first();
        $response = $this->actingAs($user)->json('POST', '/api/auth/logout');
        $response->assertStatus(200);

        $response->assertJsonStructure(['message']);
    }


    public function ajaxRoutesProvider() : array
    {
        return [
            ['/api/auth/login', ['post']],
            ['/api/auth/logout', ['post']],
            ['/api/auth/me'],
        ];
    }
}
