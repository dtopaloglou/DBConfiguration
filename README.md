DBConfiguration
===============

A simple plugin to retrieve settings from a database.

# How to use

### Step 1

Include the following classes
```php
require_once 'DBconfig.php';
require_once 'ConfigUtils.php';
require_once 'ConfigModel.php';
require_once 'DatabaseConfigModel.php';
require_once 'AppSetting.php';
```

and establish a PDO connection (or any of your choice) and retrieve the results from settings table:
```php
$pdo = new PDO('mysql:......;charset=utf8', 'username', 'password');
$query = $pdo->prepare("SELECT * FROM settings");
$data = $query->fetchAll(); // store settings
```

### Step 2

Load data results into your configuration loader model class.
```php
DatabaseConfigLoaderModel::loadModel( new ConfigModel($data, '.') );  // where $data holds settings retrieved from database
```

### Step 3
Read your settings value from anywhere within your application by calling
```php
$key = "app.version";
echo/print_r DBConfig::read($key)->getValue();
```
And your output will be the one stored in your database depending if it is an array or simple direct access value.

Direct access: no further sub-nodes

---

# Documentation

### The table
This plugin depends on this table structure:

```sql
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `stype` varchar(18) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;
```
As you can see we have an `id`, `key`, `value` and a `type`. The key represents the setting name and the value of course represents the value. The type simply represents the type of value we're dealing with (e.g. string, int etc.).

The settings are then stored as a text delimitted by a dot ( shown in the `ConfigModel` class ). 
In which case 

| id| key        | value           | stype  |
|------| ------------- |:-------------:| :-----:|
|1| app.timezone      | America/Montreal | string |
|2| app.users.passwordReset.expiration      | 1      |   int |
|3| app.users.credentials.passwordLength | 6 |    int  |
|4| app.users.credentials.userLength | 6 |    int  |

would be an example of what your table should look like.

### Expected output

When retrieving the settings from the database, the expected results must have the following format:
```
Array
(
    [0] => Array
        (
            [id] => 0
            [key] => app.timezone
            [value] => America/Montreal
            [stype] => string
        )

    [1] => Array
        (
            [id] => 1
            [key] => app.users.passwordReset.expiration
            [value] => 1
            [stype] => int
        )
  ...
  ...
  ...
  
)
```
Which is stored in a variable and passed in the `ConfigModel` class shown in **Step 2**.

### How is the data manipulated?

The data from the table is outputted into an array and a series of subsequent sub-arrays or sub-nodes. Each dot in your key represents a sub-array. If we use the example table above:

```
Array
(
    [timezone] => America/Montreal
    [users] => Array
        (
            [passwordReset] => Array
                (
                    [expiration] => 1
                )

            [credentials] => Array
                (
                    [passwordLength] => 6
                    [userLength] => 6
                )

        )

)
```
would be the array displayed when  ``` print_r( DBConfig::read("app")->getValue() );``` is called since `app` is the parent or root node. Of course, when you have an array returned, no `key`s or `id`s  are associated. In this case, if a sub-node exists, an array will be returned.

However, if you have

``` print_r( DBConfig::read("app.users.passwordReset.expiration")->getValue() );```

your output would be simply `1` given that `app.users.passwordReset.expiration` has a value of `1` according to the table above. Since `app.users.passwordReset.expiration` has no sub-nodes, you may now call `getId()` and `getType()` methods to return the corresponding `id` represented in your table and the `type`, in which case would be `2` and `int` respectively. As long as there are no sub-nodes, both  `getId()` and `getType()` methods are available.

# Requirements

- PHP 5.3.0
