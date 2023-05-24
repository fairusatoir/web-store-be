<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class RouteHelper
{

    /**
     * The name of the main route.
     *
     * @var string
     */
    private $name;

    /**
     * The array of sub-routers data.
     *
     * @var array
     */
    private $subroute;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(array $route)
    {
        $this->name = isset($route['name']) ? $route['name'] : null;
        $this->subroute = isset($route['subroute']) ? $route['subroute'] : null;
    }

    /**
     * Clean the given URI name.
     */
    public function getUri(): string
    {
        if (!isset($this->name)) {
            throw new \InvalidArgumentException("Route name is missing.");
        }

        $name = $this->name;
        $name = Str::slug($name, "-");
        $yLast = strrpos($name, 'y');
        $name = $yLast > 0 ? substr_replace($name, "ie", $yLast, 1) : $name;
        $name .= "s";
        return $name; // Product Gallery => product-galleries
    }

    /**
     * Generate URI based on subroute information.
     *
     * @param array $subroute The subroute information.
     * @return string The generated URI.
     */
    function getSubRouteUri(array $subroute = null): string
    {
        if (!isset($subroute['name'])) {
            throw new \InvalidArgumentException("Subroute name is missing.");
        }

        $uri = $this->getUri() . '/';
        $name = Str::slug($subroute['name'], "-");

        if (isset($subroute['params'])) {
            $uri .= '{' . $subroute['params'] . '}' . "/" . $name;
        } else {
            $uri .= $name;
        }

        return $uri;
    }

    /**
     * Get the controller class name based on the given name.
     */
    public function getController(): string
    {
        $name = $this->name;
        $name = str_replace(" ", "", $name);
        $name = 'App\\Http\\Controllers\\' . $name . 'Controller';
        return $name;
    }

    /**
     * Get the controller class name and method based on the given sub route name.
     */
    public function getSubController(array $subroute): string
    {
        if (!isset($subroute['name'])) {
            throw new \InvalidArgumentException("Subroute name is missing.");
        }

        $controller = $this->getController();
        $controller .= '@' . $this->toCamelCase($subroute['name']);
        return $controller;
    }

    /**
     * Get the name uri based on the given sub route name.
     */
    public function getNameSubroute(array $subroute): string
    {
        if (!isset($subroute['name'])) {
            throw new \InvalidArgumentException("Subroute name is missing.");
        }

        $nameSubroute = Str::slug($subroute['name'], "-");
        $name = $this->getUri() . '.' . $nameSubroute;
        return $name;
    }

    /**
     * Get the subroute existence.
     *
     * @return bool
     */
    public function subrouteExist()
    {
        return isset($this->subroute) ? true : false;
    }

    /**
     * Get the subroute.
     *
     * @return array
     */
    public function getSubroute(): array
    {
        return $this->subroute;
    }

    /**
     * Convert a string to Camel Case.
     *
     * @param string $inputString The string to be converted to Camel Case.
     * @return string The string in Camel Case format.
     */
    protected function toCamelCase($string)
    {
        $string = ucwords(str_replace(['-', '_'], ' ', $string));
        $string = lcfirst($string);
        $string = str_replace(' ', '', $string);
        return $string;
    }
}
