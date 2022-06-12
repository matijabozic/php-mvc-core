## About

This libraray represents HTTP Request and HTTP Response. HTTP Request can be used to analyze users HTTP Request, and Response is responsible for returning HTTP Response to browser. This way I can easily return custome 404 error page or any other HTTP Response. And can have all information about current HTTP request, for example, is this AJAX request, and what HTTP Method is sent...
This library is still under development.

## How to use

HTTP Request:

<pre>
$request = new \Core\Http\Request();
// Inspect HTTP Request here
</pre>

HTTP Response:

<pre>
$response = new \Core\Http\Response();
$response->setStatusCode(404);
$response->setContent($content);
$response->send();
</pre>

You can manipulate PHP Sessions and PHP Cookies through Request class.

<pre>
// Cookies
$request->cookies->set('name', 'value');
$request->cookies->get('name');

// Sessions
$request->sessions->start();
$request->sessions->set('name', 'value');
$request->sessions->get('name');
</pre>

## Future Development

This class is still under construction and will change. Response object, Sessions and Cookies are fine, but Request will be rewritten. And Files object will be added to Request.
