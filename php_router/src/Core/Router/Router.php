<?php

/**
 * This file is part of MVC Core framework
 * (c) Matija Božić, www.matijabozic.com
 * 
 * This is Router class, responsible for detecting route and returning
 * parameters for Dispatcher to dispatch request.
 * Router class does not dispatch request, it only analyses request,
 * tells you if route was matched, and return you parameters you need
 * to successfuly dispatch request.
 * 
 * @package    Router
 * @author     Matija Božić <matijabozic@gmx.com>
 * @license    MIT - http://opensource.org/licenses/MIT
 */

namespace Core\Router;

use Core\Router\Route;

class Router
{
    /**
     * Defined routes to match against path
     * 
     * @access  protected
     * @var     array
     */

    protected $routes;

    /**
     * Defined tokens with constrains
     * 
     * @access  protected
     * @var     array
     */

    protected $tokens;

    /**
     * Router constructor
     * 
     * @access  public
     * @param   array
     * @param   string
     * @return  void
     */

    public function __construct(array $routes = null)
    {
        $this->routes = $routes['routes'];
        $this->tokens = $routes['tokens'];
    }

    /**
     * Set configured routes, this sets both routes and tokens
     * 
     * @access  public
     * @param   array
     * @return  void
     */

    public function setRoutes($routes)
    {
        $this->routes = $routes['routes'];
        $this->tokens = $routes['tokens'];
    }

    /**
     * Set new route
     * 
     * @access  public
     * @param   string
     * @param   string
     * @return  void
     */

    public function addRoute($pattern, $route)
    {
        $this->routes[$pattern] = $route;
    }

    /**
     * Returns requested route
     * 
     * @access  public
     * @param   string
     * @return  array
     */

    public function getRoute($pattern)
    {
        return $this->routes[$pattern];
    }

    /**
     * Check if route exits
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function hasRoute($pattern)
    {
        if (isset($this->routes[$pattern])) {
            return true;
        }
        return false;
    }

    /**
     * Sets new token and his constrain
     * 
     * @access  public
     * @param   string
     * @param   string
     * @return  void
     */

    public function addToken($token, $constrain)
    {
        $this->tokens[$token] = $constrain;
    }

    /**
     * Return requested token constrain
     * 
     * @access  public
     * @param   string
     * @return  void
     */

    public function getToken($token)
    {
        return $this->tokens[$token];
    }

    /**
     * Check if token is set
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function hasToken($token)
    {
        if (isset($this->tokens[$token])) {
            return true;
        }
        return false;
    }

    /**
     * Get all defined routes
     * 
     * @access  protected
     * @return  array
     */

    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Get all defined tokens
     * 
     * @access  protected
     * @return  array
     */

    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Returns all regural expressions with coresponding route
     * 
     * @access  public
     * @return  array
     */

    public function getRegexs()
    {
        $regexs = array();

        foreach ($this->routes as $route => $pattern) {
            $regexs[$route] = $this->patternToRegex($route);
        }

        return $regexs;
    }

    /**
     * Builds regex that can be matched against URL path
     * 
     * @access  protected
     * @param   string
     * @return  string
     */

    protected function patternToRegex($pattern)
    {
        $tokens = $this->getTokens();

        $regex = str_replace('/', '\/', $pattern);
        $regex = str_replace(')', ')?', $regex);
        $regex = '/^' . $regex . '$/';

        foreach ($tokens as $token => $constrain) {
            if (preg_match('/' . $token . '/', $regex)) {
                $tkn = preg_replace('/\:|\:/', '', $token);
                $atom = '(?<' . $tkn . '>' . $tokens[$token] . ')';
                $regex = str_replace($token, $atom, $regex);
            }
        }

        return $regex;
    }

    /**
     * Matches all routes against given path, returns matched route or null
     * 
     * @access  protected
     * @return  array | null
     */

    protected function findRoute($path)
    {
        foreach ($this->getRoutes() as $route => $pattern) {
            if (preg_match($this->patternToRegex($route), $path)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Extracts params for requested route / path pair
     * 
     * @access  public
     * @param   array
     * @return  array
     */

    protected function extractData($path, $route)
    {
        $pattern = $this->getRoute($route);
        $regex   = $this->patternToRegex($route);

        // Extract route pattern params

        $params = array_filter(preg_split("/(\-\>)|(\()|(\))/", str_replace(' ', '', $pattern)));

        // Extract route arguments, $args will holds captured aruments

        preg_match($regex, $path, $args);

        // Remove indexed keys from matched vars
        foreach ($args as $key => $value) {
            if (is_int($key)) {
                unset($args[$key]);
            }
        }

        // Extract params arguments
        if (isset($params[2])) {

            $varsOptional = array();
            $varsRoute    = explode(',', $params[2]);

            // Extract optional arguments
            foreach ($varsRoute as $key => $value) {
                $var = explode('=', $value);
                $varsOptional[$var[0]] = $var[1];
            }

            // Merge optional and route arguments
            foreach ($varsOptional as $key => $value) {
                if (!isset($args[$key])) {
                    $args[$key] = $value;
                }
            }
        }

        $data = array();
        $data['controller'] = $params[0];
        $data['method'] = $params[1];
        $data['params'] = $args;
        return $data;
    }

    public function matchRoutes($path)
    {
        $route = $this->findRoute($path);

        if ($route !== null) {
            $data = $this->extractData($path, $route);
            return new Route($data['controller'], $data['method'], $data['params']);
        }

        return null;
    }
}
