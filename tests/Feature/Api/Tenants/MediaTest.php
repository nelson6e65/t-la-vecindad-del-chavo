<?php

namespace Tests\Feature\Api\Tenants;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\JwtAuthentication;
use Tests\OnlyAjaxMiddlewareHelper;
use Tests\TestCase;

/**
 * @coversDefaultClass App\Http\Controllers\Api\Tenants\MediaController
 */
class MediaTest extends TestCase
{
    use DatabaseTransactions;
    use JwtAuthentication;
    use OnlyAjaxMiddlewareHelper;

    public function ajaxRoutesProvider() : array
    {
        return [
            '/api/tenants/{tenant}/media' => ['/api/tenants/1/media', ['post']],
        ];
    }
}
