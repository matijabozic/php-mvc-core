## About

cURL is simple wrapper for PHP cURL. I was working alot with cURL and I just wanted to use OOP instead of using predefined PHP functions. I ended up with this simple class.

## Usage

<pre>
require_once("cURL.php");

$c = new cURL();
$c->init();
$c->option(CURLOPT_URL, "www.google.hr");
$c->option(CURLOPT_RETURNTRANSFER, 1);
$data = $c->exec();
echo $data;
</pre>

This example would save data from defined web into $data, and then show that content in browser.
Method names are the same as PHP cURL functions are. And you can use predefined constants. Its just a way for me to use cURL in OOP manier.
