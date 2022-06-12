## About

This class enables you to set php.ini directives at runtime. Settings class uses ini_set to set php.ini directives. This enables you to setup PHP the way you like it from within your application. Not all php.ini directives can be changed on the runtime, check here for reference: [http://www.php.net/manual/en/ini.list.php](http://www.php.net/manual/en/ini.list.php). This class is useful on shared hosting where you don't have access to php.ini file. Just instantiate this class at bootstrap level and setup PHP the way you want.

## Usage

You should use this class at bootstrap level or in your front controller. Instantiate Settings class like this:

<pre>
$settings = new \Core\Settings\Settings();
</pre>

Now you can check values of php.ini directives:

<pre>
echo $settings->get('display_errors');
echo $settings->get('log_errors');
echo $settings->get('session.name');
</pre>

Use set method to change php.ini directives:

<pre>
$settings->set('display_errors', 0);
$settings->set('log_errors', 1);
$settings->set('session.name', 'SessionCookie');
</pre>

Retrive all php.ini directives as array:

<pre>
$all = $settings->getAll();
</pre>

Restore default php.ini directive:

<pre>
$settings->restore('session.name');
</pre>

## Processing list of directives

If you have lots of directives you want to change you can use process method that would accept array and set all defined directives. For example:

<pre>
$directives = array(
    'display_errors' => 0,
    'log_errors' => 1,
    'session.name' => 'SessionCookie',
);

$settings->proccess($directives);
</pre>

Or you can define your settings in your config folder, in .php file that returns array, and again process directives at bootstrap level like this:

<pre>
// application/config/settings.php
return array(
    'display_errors' => 0,
    'log_errors' => 1,
    'session.name' => 'SessionCookie',
);

// Bootstrap.php
$settings = new \Core\Settings\Settings();
$settings->process(include(/application/config/settings.php));
</pre>

I find this class very useful when working on shared hosting and need a quick way to change php.ini directives. If you find this useful or find any bugs, contact me.
