## About

This is PSR0 compatible class loader. By default it loads PSR0 compatible libraries that use PHP namespace separator <code>\\</code>, but can also load PEAR libraries that use underscore <code>\_</code> as namespace separator.

## Usage

You should first include Autoload class, and that could be the only included file in your application.

<pre>
require_once('/path/to/Autoload.php');
</pre>

Then instantiate Autoload class, and add libraries you want autoloaded.

<pre>
$autoload = new Autoload();
$autoload->addLibrary('/path/to/libraries/', 'LibraryName');
$autoload->register();
</pre>

As you can see here, this autoloaders addLibrary method takes path as first, and library name as secund argument. This way its easier for me to visualize where is that library located. Other class loaders accept library name first and then path to library. Its just my preference, and I find it more intuitive to work this way. And also, you need one class instance to load as many libraries you want, theres no need to instantiate one Autoloader per library. Third argument can be php file extension that defaults to <code>.php</code> but can be overridden.

## Autoloading PSR0 libraries

Autoload class loads PSR0 libraries by default, so its easy to register autoloading:

<pre>
$autoload = new Autoload();
$autoload->addLibrary('/path/to/vendor/', 'Doctrine');
$autoload->addLibrary('/path/to/vendor/', 'Zend');
$autoload->register();
</pre>

## Autoloading PEAR libraries

To load PEAR compatible libraries, we need to change namespace separator.

<pre>
$autoload = new Autoload();
$autoload->setNamespaceSeparator('_');
$autoload->addLibrary('/path/to/vendor/', 'Twig');
$autoload->register();
</pre>

## Autoloading both PSR0 and PEAR libraries

If you need both PSR0 and PEAR libraries loaded in your application you can register one autoload instance for PSR0 and another one for PEAR libraries.

<pre>
// PSR0 libraries
$psr0 = new Autoload();
$psr0->addLibrary('/path/to/vendor/', 'Doctrine');
$psr0->addLibrary('/path/to/vendor/', 'Zend');
$psr0->register();

// PEAR libraries
$pear = new Autoload();
$pear->setNamespaceSeparator('_');
$pear->addLibrary('/path/to/vendor/', 'Twig');
$pear->register();
</pre>

Note that register method can take boolean argument, true or false, which tells Autoloader should this autoloader be prepended to autoload stack. Default is false and loader is appended, if set to true autoloader would be prepended. This tells autoload stack in which order to execute registered loaders.

## Future development

I was thinking about building Autoloader class that can detect is registered library PSR0 or PEAR compatible, so it could be capable to load both PSR0 and PEAR libraries without me thinking about it.
But I like how this works and I like to have one Autoload instance per standard.
