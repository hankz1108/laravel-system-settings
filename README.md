# Laravel System Settings
A Laravel package designed for managing system configuration values in database.

## Installation
### 1. Composer install
Run the Composer require command from the Terminal:
```bash
composer require hankz/laravel-system-settings
```

### 2. Setup
This package supports Laravel's auto-discovery feature and it's ready to use once installed.

### 3. Publishing the config file
You need publish the config file.
```bash
php artisan vendor:publish --provider="Hankz\LaravelSystemSettings\SystemSettingProvider"
```

### 4. Configuration
You can configure this package in `config\system-settings.php`
```php
<?php

return [
    /**
     * use table name.
     */
    'table_name' => 'system_settings',

    /**
     * default value.
     */
    'default' => [
        'group' => 'default',
    ],
];

```
- table_name - Save the system settings table name in the database.
- default.group - The default group name when you are missing the group parameter.

### 5. Migration
You should also run the migrate command.
```bash
php artisan migrate
```

## Usage
This package is very simple and provides the following methods for your use.

### `new(string $key, string $value, string $group = null, string $description = null): bool`

Create a new system setting.

#### Parameters:
- `$key` (string): The unique identifier for the system setting.
- `$value` (string): The value associated with the system setting.
- `$group` (string|null): (Optional) The group to which the system setting belongs. Default is `null`.
- `$description` (string|null): (Optional) A description providing additional information about the system setting. Default is `null`.

#### Example:
```php
SystemSettingManager::new('keyName', 'value', 'groupName', 'description');
```

#### Returns:
- `bool`: Returns `true` if the system setting is created successfully, or throws a `SystemSettingAlreadyExistsException` if the setting already exists.

---

### `has(string $key, string $group = null): bool`

The `has()` method checks if a system setting exists with the given key and optional group.

#### Parameters:
- `$key` (string): The unique identifier for the system setting.
- `$group` (string|null): (Optional) The group to which the system setting belongs. Default is `null`.

#### Example:
```php
SystemSettingManager::has('keyName', 'groupName');
```

#### Returns:
- `bool`: Returns `true` if the system setting exists, otherwise `false`.

---

### `all(): array`

Return all system settings with key and value in the format of key-value pairs.

#### Example:
```php
SystemSettingManager::all();
```

#### Returns:
- `array`: An associative array containing all system settings in the format `['key' => 'value']`.

---

### `get(string $key, string $group = null, string $default = null): null|string`

The `get()` method allows you to retrieve the value using both the key name and group name, and it also accepts a default value.

#### Parameters:
- `$key` (string): The unique identifier for the system setting.
- `$group` (string|null): (Optional) The group to which the system setting belongs. Default is `null`.
- `$default` (string|null): (Optional) The default value to return if the system setting is not found. Default is `null`.

#### Example:
```php
SystemSettingManager::get('keyName', 'groupName', 'defaultValue');
```

#### Returns:
- `string|null`: Returns the value of the system setting if found, otherwise returns the specified default value or `null` if no default is provided.

---

### `set(string $key, string $value, string $group = null, string $description = null, bool $createWhenNotExist = false): void`

The `set()` method allows you to update the value and description of an existing system setting or create a new one if it does not exist.

#### Parameters:
- `$key` (string): The unique identifier for the system setting.
- `$value` (string): The new value to set for the system setting.
- `$group` (string|null): (Optional) The group to which the system setting belongs. Default is `null`.
- `$description` (string|null): (Optional) A description providing additional information about the system setting. Default is `null`.
- `$createWhenNotExist` (bool): (Optional) If set to `true`, a new system setting will be created if the specified key does not exist. Default is `false`.

#### Example:
```php
SystemSettingManager::set('keyName', 'newValue', 'groupName', 'newDescription', true);
```

#### Returns:
- `void`

---

### `getByGroup(string $group): array`

Retrieve all system settings within a specified group.

#### Parameters:
- `$group` (string): The group from which to retrieve system settings.

#### Example:
```php
SystemSettingManager::getByGroup('groupName');
```

#### Returns:
- `array`: An associative array containing system settings within the specified group in the format `['key' => 'value']`.

---

### `setByGroup(array $settings, string $group = null, bool $createWhenNotExist = false): void`

Update or create multiple system settings within a specified group.

#### Parameters:
- `$settings` (array): An associative array containing system settings in the format `['key' => ['value' => '', 'description' => '']]`.
- `$group` (string|null): (Optional) The group to which the system settings belong. Default is `null`.
- `$createWhenNotExist` (bool): (Optional) If set to `true`, new system settings will be created for keys that do not exist in the specified group. Default is `false`.

#### Example:
```php
SystemSettingManager::setByGroup(['key1' => ['value' => 'value1', 'description' => 'desc1']], 'groupName', true);
```

#### Returns:
- `void`

---

### `delete(string $key, string $group = null): bool|null`

Delete a system setting with the specified key and optional group.

#### Parameters:
- `$key` (string): The unique identifier for the system setting.
- `$group` (string|null): (Optional) The group to which the system setting belongs. Default is `null`.

#### Example:
```php
SystemSettingManager::delete('keyName', 'groupName');
```

#### Returns:
- `bool|null`: Returns `true` if the system setting is successfully deleted, `false` if the setting does not exist, or `null` if an error occurs.

---

## To-do list
- Write chniese document
- Add audit log

## License

[MIT License](https://github.com/hankz1108/laravel-system-settings/blob/main/LICENSE) © 2024 [Hankz](https://github.com/hankz1108)
