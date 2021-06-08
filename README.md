# Fuko\\Source [![GitHub license](https://img.shields.io/github/license/fuko-php/source.svg)](https://github.com/fuko-php/source/blob/master/LICENSE) [![Latest Version](http://img.shields.io/packagist/v/fuko-php/source.svg)](https://packagist.org/packages/fuko-php/source)

**Fuko\\Source** is a small PHP library that helps you to extracts chunks of
source code identified by code references, e.g. filename + line.

It is really simple to use. Imagine you want to extract a piece of code, and
you know what source code line exactly you want to reference: for example
`/var/www/html/index.php` at line 17. You must first create a new `\Fuko\Source\Code`
object, and then call the `getLinesAt()` method:

```php
include __DIR__ . '/vendor/autoload.php';

$source = new \Fuko\Source\Code('/var/www/html/index.php');
print_r($source->getLinesAt(17));
/*
Array
(
    [14] => Illuminate\Support\ClassLoader::register();
    [15] => Illuminate\Support\ClassLoader::addDirectories(array(CLASS_DIR,CONTROLLERS,CONTROLLERS.'Middleware/', MODELS, CONTROLLERS.'Admin/'));
    [16] =>
    [17] => $FileLoader = new FileLoader(new Filesystem,  RESOURCES.'lang');
    [18] => $translator = new Translator($FileLoader, 'en');
    [19] => $Container = new Container();
    [20] => $validation = new Factory($translator, $Container);
)
*/

```

By default there are 7 lines of code (LOCs) returned, but you can specify a
different number in the range of 1 to 20 (as defined in `\Fuko\Source\Code::LOC_MAX`):
```php
include __DIR__ . '/vendor/autoload.php';

$source = new \Fuko\Source\Code('/var/www/html/index.php');
print_r($source->getLinesAt(17, 1));
/*
Array
(
    [17] => $FileLoader = new FileLoader(new Filesystem,  RESOURCES.'lang');
)
*/

```
