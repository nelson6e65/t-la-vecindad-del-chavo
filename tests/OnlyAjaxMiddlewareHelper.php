<?php

namespace Tests;

trait OnlyAjaxMiddlewareHelper
{
    /**
     * Provides the routes that are only accessible as ajax/json request.
     *
     * Signature: [
     *   (string) $route,
     *   (array) $methods (optional: default for only 'get')
     * ]
     *
     * @return array
     */
    abstract public function ajaxRoutesProvider() : array;

    /**
     * @dataProvider ajaxRoutesProvider
     *
     * @param string $route
     * @param array  $methods
     */
    public function testRouteOnlyAcceptAjaxRequests(string $route, array $methods = ['get']) : void
    {
        foreach ($methods as $method) {
            $response = $this->call($method, $route);
            $response->assertStatus(403);
        }
    }
}
