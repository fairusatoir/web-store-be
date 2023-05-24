<?php

namespace Tests\Unit;

use App\Helpers\RouteHelper;
use Illuminate\Http\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RouteHelperTest extends TestCase
{

    /**
     * The Route data test.
     *
     * @var array
     */
    protected $route;
    protected $notSubroute;

    /**
     * Prepare route data test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->route = [
            'name' => 'Product Gallery',
            'subroute' => [
                'name' => 'Detail',
                'params' => 'id'
            ]
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
    public function testGetUri()
    {
        $helper = new RouteHelper($this->route);
        $uri = $helper->getUri();

        $this->assertEquals('product-galleries', $uri);

        $helper = new RouteHelper($this->notSubroute);
        $uri = $helper->getUri();

        $this->assertEquals('product-galleries', $uri);
    }

    /**
     * Test the getUri method.
     *
     * @return void
     */
    public function testUndefiedGetUri()
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
    public function testGetSubRouteUri()
    {
        $helper = new RouteHelper($this->route);
        $subRouteUri = $helper->getSubRouteUri($this->route['subroute']);

        $this->assertEquals('product-galleries/{id}/detail', $subRouteUri);
    }

    /**
     * Test the getSubRouteUri method.
     *
     * @return void
     */
    public function testUndefiedSubRouteUri()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("");

        $helper = new RouteHelper($this->notSubroute);
        $subRouteUri = $helper->getSubRouteUri($this->notSubroute['subroute'] ?? null);
    }

    /**
     * Test the getController method.
     *
     * @return void
     */
    public function testGetController()
    {
        $helper = new RouteHelper($this->route);
        $controller = $helper->getController();

        $this->assertEquals('App\Http\Controllers\ProductGalleryController', $controller);
    }

    /**
     * Test the getSubController method.
     *
     * @return void
     */
    public function testGetSubController()
    {
        $helper = new RouteHelper($this->route);
        $subController = $helper->getSubController($this->route['subroute']);

        $this->assertEquals('App\Http\Controllers\ProductGalleryController@detail', $subController);
    }

    /**
     * Test the getNameSubroute method.
     *
     * @return void
     */
    public function testGetNameSubroute()
    {
        $helper = new RouteHelper($this->route);
        $nameSubroute = $helper->getNameSubroute($this->route['subroute']);

        $this->assertEquals('product-galleries.detail', $nameSubroute);
    }

    /**
     * Test the getSubroute method.
     *
     * @return void
     */
    public function testGetSubroute()
    {
        $helper = new RouteHelper($this->route);

        $subroute = $helper->getSubroute();

        $this->assertEquals($subroute, $this->route['subroute']);
    }

    /**
     * Test the subrouteExist method.
     *
     * @return void
     */
    public function testSubrouteExist()
    {
        $helper = new RouteHelper($this->route);

        $this->assertTrue($helper->subrouteExist());
    }

    /**
     * Test the subrouteExist method.
     *
     * @return void
     */
    public function testSubrouteNotExist()
    {
        $helper = new RouteHelper([]);
        $this->assertFalse($helper->subrouteExist());
    }
}
