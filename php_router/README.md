## About

This is Router class, responsible for detecting route and returning information about route so Dispatcher can dispatch request. Router class does not dispatch request, it only matches current URL with defined routes, and tells you if route was matched. It returns null if no route is matched, and it returns instance of \Core\Router\Route if there is a match. Through Route instance you can get all informations to dispatch request.

## How to use Router

To use Router you first need Router instance with `$config` passed as argument:

<pre>
$router = new \Core\Router\Router($config);
</pre>

or you can use setter method to provide routes definitions in `$config` file:

<pre>
$router = new \Core\Router\Router();
$router->setRoutes($config);
</pre>

Then you can match route using `$router->matchRoute($path)` method like this:

<pre>
$route = $router->match($path);
</pre>

If route is matched, route will be assigned with `\Core\Router\Route` instance, and if not then `null` is returned. Once route is matched you can use `\Core\Router\Route` like this to get information for your Dispatcher:

<pre>
$class = $route->getClass();
$method = $route->getMethod();
$params = $route->getParams();
</pre>

`$class` and `$method` are strings, and `$params` is array holding all variables you want to pass to your controller method as arguments. If you need to add some additional arguments for your methods you can use this:

<pre>
$route->addParam('container', $container);
$route->addParam('request', new \Core\Http\Request());
</pre>

This way, once you dispatch request, every controller method would have access to `$container` and `$request`. This is easy way to insert some additional stuff into every action controller.

## Route definitions

First thing you need to do when working with Router is to define route definitions. Il just give examples with all possible scenarios and then explain later. This is how your `$routes` array should look like:

<pre>
$routes = array(

	'routes' => array(
		'/about'              => 'Home->index()',
		'/post'               => 'Blog->post(lang=en)',
		'/posts/:page:        => 'Blog->posts(lang=en)',
		'/categories(/:page:) => 'Blog->categories(lang=en, page=1)',
	),

	'tokens' => array(
		':url:'  => '[a-z]+',
		':page:' => '[0-9]+',
	);

);
</pre>

As you can see, there is routes array, and tokens array, tokens are just regural expressions you can use inside your route definition, this give you some flexibility when defining routes.

- `/about` will match if `$path` provided is `/about`, and then your `$route` instance would return class `Home`, and method `index`, params would be empty array since they are not defined.

- `/post` will match if `$path` provided is `/post`. `$route` instance would return `class Blog`, `method post`, and params would be array holding one value: `array('lang' => 'en');` As you can see, you can define default arguments you need joust as you would define them if using real PHP method or function.

- `/posts/:page:` will get matched if URL is `/posts/1` or `/posts/2` or `/posts/` and any number instead of `:page:`. This is so beacuse we defined that `:page:` token holds this regural expression: `[0-9]+`. You can write as many tokens as you like, to match any regural expression you want. Now this `$route` instance would have `class Blog`, `method posts`, and params array will look like this: `array('page' => 1, 'lang' => 'en');` Notice that page will hold value from `$path`, but it must be a number to match route since thats what that token matches.

- The last route example shows you how to use optional route segments. If you need something optional, just put colon around optional segments. Then route will match if segment exists or not. The last route will match this: `/categories` but also this `/categories/5` And also note that if there is page segment in URL that value will be used for page argument. If not, 1 will be used as its defined in route as default. So Router first checks if optional token is set on the left side, if not it takes value from the right side. So both routes will have `class Blog` and `method categories`. But params array will be different, if no optional :page: token is set in `$path` it would look like this: `array('lang' => 'en', 'page' => 1)`, and if optional token is set it would look like this: `array('lang' => 'en', 'page' => 5)`; You can think of this as an override. You have default argument, and that one is used only if you dont override it with the one from `$path`.

## Current URL, $path

To match route you use `$router->matchRoute($path)` method. But first you need current `$path` that holds current URL. The goal is to match defined routes against your current URL. You can get `$path` like this:

<pre>
$path = $_SERVER['PATH_INFO']
</pre>

or in any other way you want. You can use HTTP Request object to get path, or you can write your own little method to get you path you need like this:

<pre>
public function getPath()
{
	if(isset($_SERVER['ORIG_PATH_INFO'])) {
		return $_SERVER['ORIG_PATH_INFO'];
	} else if(isset($_SERVER['PATH_INFO'])) {
		return $_SERVER['PATH_INFO'];
	}
	return false;
}
</pre>

## Dispatching request

Once you define your routes in `$config`, and you get `$path`, you can match route. If route is matched you get `\Core\Router\Route` instance.

I have Dispatcher class, that takes instance of `\Core\Router\Route`, and dispatches request and deals with errors. Il upload it here later. You can use something simple as this to dispatch request using information provided by `\Core\Router\Route`:

<pre>
// Match route

$router = new \Core\Router\Router($config);
$route = $router->match($path);

if(null === $route) {
	// Route is not matched, throw 404!
	return;
}

// Prepare data for dispatcher

$class = $route->getClass();
$method = $route->getMethod();
$params = $route->getParams();

// Dispatch request

$app = new $class();

$rm = new \ReflectionMethod($app, $method);

$args = array();
foreach($rm->getParameters() as $param) {
	$args[$param->getName()] = $params[$param->getName()];
}

call_user_func_array(array($app, $method), $args);
</pre>

If you instantiate your controller class, and invoke methods this way, you dont have to think in which way you order method parameters in your controller methods. You can order them any way you want, and you dont even need to use them at all. This simple dispatcher knows what params you want to use, and how are they ordered, and he will invoke controller method with only the ones you need.

## Future development

I would like this dispatcher to be aware of HTTP verb / method, so in future routes will be defined like this:

<pre>
'GET /user/:id:' => ...
'DELETE /user/:id:' => ...
</pre>

I already have three versions of this Router and they all work as I want. The thing is its hard to achive that with PHP arrays in a neat way so I can have only one line of code per one route definition. I could really use Python List data type with this one. If you find this useful, or you think you can change something, contact me. Thats it!
