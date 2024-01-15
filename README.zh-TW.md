<p align="right">
    <a title="English Document" href="README.md">English Document</a> | 繁體中文文件
</p>

# Laravel System Settings
一個管理系統配置值的 Laravel 套件，並用資料庫存取。

## 安裝
### 1. 使用 Composer 安裝
在終端機中執行 Composer require 指令：
```bash
composer require hankz/laravel-system-settings
```

### 2. 設定
此套件支援 Laravel 的自動發現功能，安裝完成後即可使用。

### 3. 發佈配置檔
您需要發佈配置檔：
```bash
php artisan vendor:publish --provider="Hankz\LaravelSystemSettings\SystemSettingProvider"
```

### 4. 配置
您可以在 `config\system-settings.php` 中配置此套件：
```php
<?php

return [
    /**
     * 使用的資料表名稱。
     */
    'table_name' => 'system_settings',

    /**
     * 預設值。
     */
    'default' => [
        'group' => 'default',
    ],
];

```
- table_name - 將系統設定資料表名稱保存在資料庫中。
- default.group - 在缺少 group 參數時的預設群組名稱。

### 5. 遷移
您還應該運行遷移命令：
```bash
php artisan migrate
```

## 使用
此套件非常簡單，為您提供以下方法。

### `new(string $key, string $value, string $group = null, string $description = null): bool`

創建一個新的系統設定。

#### 參數：
- `$key`（string）：系統設定的唯一標識符。
- `$value`（string）：與系統設定相關聯的值。
- `$group`（string|null）：（可選）系統設定所屬的群組。默認為 `null`。
- `$description`（string|null）：（可選）提供有關系統設定的附加信息的描述。默認為 `null`。

#### 範例：
```php
SystemSettingManager::new('keyName', 'value', 'groupName', 'description');
```

#### 返回：
- `bool`：如果成功創建系統設定，則返回 `true`，如果設定已存在，則拋出 `SystemSettingAlreadyExistsException`。

---

### `has(string $key, string $group = null): bool`

`has()` 方法檢查是否存在具有給定鍵和可選群組的系統設定。

#### 參數：
- `$key`（string）：系統設定的唯一標識符。
- `$group`（string|null）：（可選）系統設定所屬的群組。默認為 `null`。

#### 範例：
```php
SystemSettingManager::has('keyName', 'groupName');
```

#### 返回：
- `bool`：如果系統設定存在，則返回 `true`，否則返回 `false`。

---

### `all(): array`

以鍵值對格式返回所有系統設定的所有鍵和值。

#### 範例：
```php
SystemSettingManager::all();
```

#### 返回：
- `array`：包含所有系統設定的關聯陣列，格式為 `['key' => 'value']`。

---

### `get(string $key, string $group = null, string $default = null): null|string`

`get()` 方法允許您使用鍵名和群組名檢索值，並且還接受默認值。

#### 參數：
- `$key`（string）：系統設定的唯一標識符。
- `$group`（string|null）：（可選）系統設定所屬的群組。默認為 `null`。
- `$default`（string|null）：（可選）如果找不到系統設定，則返回的默認值。默認為 `null`。

#### 範例：
```php
SystemSettingManager::get('keyName', 'groupName', 'defaultValue');
```

#### 返回：
- `string|null`：如果找到系統設定的值，則返回其值，否則返回指定的默認值，如果未提供默認值，則返回 `null`。

---

### `set(string $key, string $value, string $group = null, string $description = null, bool $createWhenNotExist = false): void`

`set()` 方法允許您更新現有系統設定的值和描述，或者在不存在時創建一個新的系統設定。

#### 參數：
- `$key`（string）：系統設定的唯一標識符。
- `$value`（string）：要為系統設定設置的新值。
- `$group`（string|null）：（可選）系統設定所屬的群組。默認為 `null`。
- `$description`（string|null）：（可選）提供有關系統設定的附加信息的描述。默認為 `null`。
- `$createWhenNotExist`（bool）：（可選）如果設置為 `true`，則如果指定的鍵不存在，將創建新的系統設定。默認為 `false`。

#### 範例：
```php
SystemSettingManager::set('keyName', 'newValue', 'groupName', 'newDescription', true);
```

#### 返回：
- `void`

---

### `getByGroup(string $group): array`

檢索指定群組內的所有系統設定。

#### 參數：
- `$group`（string）：要檢索系統設定

的群組。

#### 範例：
```php
SystemSettingManager::getByGroup('groupName');
```

#### 返回：
- `array`：包含指定群組內的系統設定的關聯陣列，格式為 `['key' => 'value']`。

---

### `setByGroup(array $settings, string $group = null, bool $createWhenNotExist = false): void`

在指定群組內更新或創建多個系統設定。

#### 參數：
- `$settings`（array）：包含系統設定的關聯陣列，格式為 `['key' => ['value' => '', 'description' => '']]`。
- `$group`（string|null）：（可選）要將系統設定應用到的群組。默認為 `null`。
- `$createWhenNotExist`（bool）：（可選）如果設置為 `true`，則將在指定群組中不存在的鍵上創建新的系統設定。默認為 `false`。

#### 範例：
```php
SystemSettingManager::setByGroup(['key1' => ['value' => 'value1', 'description' => 'desc1']], 'groupName', true);
```

#### 返回：
- `void`

---

### `delete(string $key, string $group = null): bool|null`

刪除具有指定鍵和可選群組的系統設定。

#### 參數：
- `$key`（string）：系統設定的唯一標識符。
- `$group`（string|null）：（可選）系統設定所屬的群組。默認為 `null`。

#### 範例：
```php
SystemSettingManager::delete('keyName', 'groupName');
```

#### 返回：
- `bool|null`：如果成功刪除系統設定，則返回 `true`，如果設定不存在，則返回 `false`，或者如果發生錯誤，則返回 `null`。

---

## 待辦事項
- 添加審計日誌

## License

[MIT License](https://github.com/hankz1108/laravel-system-settings/blob/main/LICENSE) © 2023 [Hankz](https://github.com/hankz1108)
