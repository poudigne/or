## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Third party API

### Laravel Medialibrary

```
composer require spatie/laravel-medialibrary
```
https://github.com/spatie/laravel-medialibrary

### Whoops

```
> composer require filp/whoops
```
Edit app/Exceptions/Handler.php so the function render() looks like this
```
public function render($request, Exception $e)
{
	if (config('app.debug'))
	{
		return $this->renderExceptionWithWhoops($e);
	}

	return parent::render($request, $e);
}
```

Then add this function to **app/Exceptions/Handler.php***

```
 /**
	* Render an exception using Whoops.
	* 
	* @param  \Exception $e
	* @return \Illuminate\Http\Response
	*/
protected function renderExceptionWithWhoops(Exception $e)
{
	$whoops = new \Whoops\Run;
	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

	return new \Illuminate\Http\Response(
		$whoops->handleException($e),
		$e->getStatusCode(),
		$e->getHeaders()
	);
}
```

## Troubleshoot homestead

```
> composer dump-autoload
> composer update
```

Or in last resort

``` 
> composer dump-autoload
> composer install
```
