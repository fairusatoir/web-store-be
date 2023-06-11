<?php

namespace Tests\Unit;

use App\Helpers\RouteHelper;
use Illuminate\Http\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RouteGenerateTest extends TestCase
{

    /**
     * The Route data test.
     *
     * @var array
     */
    protected $route;
    protected $nested;
    protected $notSubroute;
    protected $doubleWordRoute;

    /**
     * Prepare route data test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->route = [
            'name' => 'Product',
            'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
            'nested' => [
                [
                    'name' => 'gallery',
                    'method' => 'get',
                    'params' => 'product'
                ]
            ]
        ];

        $this->nested = [
            'name' => 'gallery',
            'method' => 'get',
            'params' => 'product'
        ];

        $this->doubleWordRoute = [
            'name' => 'Product Gallery',
        ];

        $this->notSubroute = [
            'name' => 'Product Gallery',
        ];
    }

    /**
     * Test the getUri method.
     *
     * @return void
     */
    public function test_generate_uri()
    {
        $helper = new RouteHelper($this->route);
        $uri = $helper->getUri();

        $this->assertEquals('products', $uri);
    }

    /**
     * Test the getUri method.
     *
     * @return void
     */
    public function test_generate_uri_with_double_word()
    {
        $helper = new RouteHelper($this->doubleWordRoute);
        $uri = $helper->getUri();

        $this->assertEquals('product-galleries', $uri);
    }

    /**
     * Test the getUri method.
     *
     * @return void
     */
    public function test_generate_invalid_uri()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("");

        $helper = new RouteHelper([]);
        $uri = $helper->getUri();
        $this->assertNull($uri);
    }

    /**
     * Test the getSubRouteUri method.
     *
     * @return void
     */
    public function test_generate_nested_uri()
    {
        $helper = new RouteHelper($this->route);
        $subRouteUri = $helper->getSubRouteUri($this->nested);

        $this->assertEquals('products/{product}/gallery', $subRouteUri);
    }

    /**
     * Test the getSubRouteUri method.
     *
     * @return void
     */
    public function test_generate_nested_uri_without_params()
    {
        $helper = new RouteHelper($this->route);

        $nestedWithoutParams = $this->nested;
        unset($nestedWithoutParams['params']);

        $subRouteUri = $helper->getSubRouteUri($nestedWithoutParams);

        $this->assertEquals('products/gallery', $subRouteUri);
    }

    /**
     * Test the getSubRouteUri method.
     *
     * @return void
     */
    public function test_generate_nested_uri_without_name()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("");

        $helper = new RouteHelper($this->route);

        $nestedWithoutParams = $this->nested;
        unset($nestedWithoutParams['name']);

        $subRouteUri = $helper->getSubRouteUri($nestedWithoutParams);

        $this->assertEquals('{product}/gallery', $subRouteUri);
    }

    /**
     * Test the getController method.
     *
     * @return void
     */
    public function test_generate_controller()
    {
        $helper = new RouteHelper($this->route);
        $controller = $helper->getController();

        $this->assertEquals('App\Http\Controllers\ProductController', $controller);
    }

    /**
     * Test the getController method.
     *
     * @return void
     */
    public function test_generate_api_controller()
    {
        $helper = new RouteHelper($this->route);
        $controller = $helper->getApiController();

        $this->assertEquals('App\Http\Controllers\API\ProductController', $controller);
    }

    /**
     * Test the getController method.
     *
     * @return void
     */
    public function test_generate_controller_double_word()
    {
        $helper = new RouteHelper($this->doubleWordRoute);
        $controller = $helper->getController();

        $this->assertEquals('App\Http\Controllers\ProductGalleryController', $controller);
    }

    /**
     * Test the getController method.
     *
     * @return void
     */
    public function test_generate_api_controller_double_word()
    {
        $helper = new RouteHelper($this->doubleWordRoute);
        $controller = $helper->getApiController();

        $this->assertEquals('App\Http\Controllers\API\ProductGalleryController', $controller);
    }

    /**
     * Test the getSubController method.
     *
     * @return void
     */
    public function test_generate_nested_controller()
    {
        $helper = new RouteHelper($this->route);
        $subController = $helper->getSubController($this->nested);

        $this->assertEquals('App\Http\Controllers\ProductController@gallery', $subController);
    }

    /**
     * Test the getSubController method.
     *
     * @return void
     */
    public function test_generate_nested_controller_without_name()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("");

        $nestedWithoutParams = $this->nested;
        unset($nestedWithoutParams['name']);

        $helper = new RouteHelper([]);
        $subController = $helper->getSubController($nestedWithoutParams);

        $this->assertEquals('App\Http\Controllers\ProductController@gallery', $subController);
    }

    /**
     * Test the getNameSubroute method.
     *
     * @return void
     */
    public function test_generate_nested_controller_name()
    {
        $helper = new RouteHelper($this->route);
        $nameSubroute = $helper->getNameSubroute($this->nested);

        $this->assertEquals('products.gallery', $nameSubroute);
    }

    /**
     * Test the nestedExist method.
     *
     * @return void
     */
    public function test_check_nested_exist()
    {
        $helper = new RouteHelper($this->route);

        $this->assertTrue($helper->nestedExist());
    }

    /**
     * Test the nestedExist method.
     *
     * @return void
     */
    public function test_check_nested_not_exist()
    {
        $helper = new RouteHelper([]);
        $this->assertFalse($helper->nestedExist());
    }

    /**
     * Test the getSubroute method.
     *
     * @return void
     */
    public function test_get_nested_route()
    {
        $helper = new RouteHelper($this->route);
        $this->assertEquals($this->route['nested'], $helper->getSubroute());
    }

    /**
     * Test the getSubroute method.
     *
     * @return void
     */
    public function test_get_null_nested_route()
    {
        $helper = new RouteHelper($this->notSubroute);
        $this->assertEquals([], $helper->getSubroute());
    }
}
