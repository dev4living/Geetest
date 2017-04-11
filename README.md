# Geetest

## Installation

The preferred method of installation is via [Packagist](https://packagist.org/) and [Composer](https://getcomposer.org/). Run the following command to install the package and add it as a requirement to your project's `composer.json`:

```bash
composer require protobia-alpha/geetest
```
> config/app.php

```php
...
'providers' => [
    ...
    ProtobiaAlpha\Geetest\GeetestServiceProvider::class,
]
...
'alias'     => [
    ...
    'Geetest' => ProtobiaAlpha\Geetest\GeetestFacade::class,
]
```

## Configuration

```bash
php artisan vendor:publish
```

## Usage

> .env

```env
...
GEETEST_ID=
GEETEST_KEY=
```

> x.blade.php

```blade
...
{!! Geetest::render() !!}
{!! Geetest::render('embed') !!}
{!! Geetest::render('popup') !!}
...
```

## Example

> ExampleController.php

```php
use Illuminate\Http\Request;

class ExampleController extends Controller 
{
    /**
     * @param Request $request
     */
    public function postValidate(Request $request) {
        $this->validate($request, [
            'geetest_challenge' => 'geetest',
        ], [
                            'geetest' => config('geetest.server_fail_alert'),
                        ]);
        dd(true);
    }
    
    /**
     * @param Request $request
     */
    public function postValidateOther(Request $request) {
        dd(\Geetest::validate($request));
    }
}
```

> example.blade.php

```blade
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>极验测试</title>
</head>
<body>
<form action="/gee/test" method="post">
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <input type="submit" value="submit">
    {!! Geetest::render() !!}
</form>
</body>
</html>
```