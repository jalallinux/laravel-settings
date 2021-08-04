## Laravel Settings

Use `jalallinux/laravel-settings` to store key value pair settings in the database.

> All the settings saved in db is cached to improve performance by reducing sql query to zero.

### Installation

**1** - You can install the package via composer:

```bash
composer require jalallinux/laravel-settings
```

**2** - If you are installing on Laravel 5.4 or lower you will be needed to manually register Service Provider by adding it in `config/app.php` providers array and Facade in aliases arrays.

```php
'providers' => [
    //...
    JalalLinuX\Settings\SettingsServiceProvider::class
]

'aliases' => [
    //...
    "Settings" => JalalLinuX\Settings\Facade::class
]
```

In Laravel 5.5 or above the service provider automatically get registered and a facade `Setting::get('app_name')` will be available.

**3** - Now run the migration by `php artisan migrate` to create the settings table.

Optionally you can publish migration by running

```
php artisan vendor:publish --provider="JalalLinuX\Settings\SettingsServiceProvider" --tag="migrations"
```

### Getting Started

You can use helper function `settings('app_name')` or `Settings::get('app_name')` to use laravel settings.

### Available methods

```php
// Pass `true` to ignore cached settings
settings()->all($fresh = false);

// Get a single setting
settings()->get($key, $defautl = null);

// Set a single setting
settings()->set($key, $value);

// Set a multiple settings
settings()->set([
   'app_name' => 'JalalLinuXe',
   'app_email' => 'smjjalalzadeh93@gmail.com',
   'app_type' => 'Laravel'
]);

// check for setting key
settings()->has($key);

// remove a setting
settings()->remove($key);
```

### Groups

You can organize your settings into groups. If you skip the group name it will store settings with `default` group name.

You have all above methods available just set you working group by calling `->group('group_name')` method and chain on:

```php
// My Team App 1
settings()->group('team.1')->set('app_name', 'My Team App');
settings()->group('team.1')->get('app_name');

// My Team App 2
settings()->group('team.2')->set('app_name', 'My Team 2 App');
settings()->group('team.2')->get('app_name');

// You can use facade
\Settings::group('team.1')->get('app_name');

```

### Another helper function
> This helper use only for fetching setting
```php
// Fetch team.2 owner_name from cached settings
_settings('team.2', 'owner_name');

// Fetch all settings of group team.2 from cached settings
_settings('team.2');

// Fetch team.2 owner_name and reset setting cache from database
_settings('team.2', 'owner_name', true);
```