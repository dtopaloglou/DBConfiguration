DBConfiguration
===============

Retrieving settings from database.

### Step 1

Include the following classes
```php
require_once 'DBconfig.php';
require_once 'ConfigUtils.php';
require_once 'ConfigModel.php';
require_once 'DatabaseConfigModel.php';
require_once 'AppSetting.php';
```

and establish a PDO connection (or any of your choice) and retrieve the results from settings table. Here's an example:
```php
$pdo = new PDO('mysql:......;charset=utf8', 'username', 'password');
$query = $pdo->prepare("select * from settings");
$data = $query->fetchAll();
```

### Step 2

Load data results into your configuration loader model class.
```php
$configurationModel = new ConfigModel($data, '.');
DatabaseConfigLoaderModel::loadModel($configurationModel);
```

### Step 3
Read your settings value from anywhere by calling
```php
$key = 'app.version';
echo DBConfig::read($key)->getValue();
```
And your output will be the one stored in your database.
