DBConfiguration
===============

A simple plugin to retrieve settings from a database.

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

---

# How's it all set up?

First thing is that you need a table structure. This plugin depends on this table:

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
As you can see we have an id, key, value and a type. The key represents the setting name and the value of course represents the value. The type simply represents the type of value we're dealing with (e.g. string, int etc.).

The settings are then stored as a text delimitted by a dot ( shown in the `ConfigModel` class ). 
In which case 

| id| key        | value           | stype  |
|------| ------------- |:-------------:| :-----:|
|1| app.timezone      | America/Montreal | string |
|2| app.users.passwordReset.expiration      | 1      |   int |
|3| app.users.credentials.passwordLength | 6 |    int  |
|4| app.users.credentials.userLength | 6 |    int  |

would be an example of what your table should look like.

### How is the data manipulated?

The data from the table is outputted into an array and a series of subsequent sub-arrays. Each dot in your key represents a child sub-array. Using the example table above:

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
would be the array displayed when  ``` print_r( DBConfig::read("app")->getValue() );``` is called since `app` is the hierarchy node. Of course when you have an array displayed, no `key` or `id`'s  is associated with it. However, if you have

``` print_r( DBConfig::read("app.users.passwordReset.expiration")->getValue() );```

your output would be simply `1` in this case. Consequently, you may now call `getId()` and `getType()` methods to return the corresponding `id` represented in your table and the `type` as well, in which case would be `2` and `int` respectively.
