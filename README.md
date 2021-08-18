# Niagahoster Logman ![Generic badge](https://img.shields.io/badge/v-0.0.7-green.svg) [![MIT license](https://img.shields.io/badge/License-MIT-blue.svg)](https://lbesson.mit-license.org/)

Simple reusable logger plugin for any PHP platform to help your development easier.

# Table of contents

- [Client Description](#logman-php-client)
- [Installation](#installation)
- [Usage Examples](#usage-examples)
    - [Setup Configuration](#setup-configuration)
    - [PHP Error Standard Listener](#php-error-standard-listener)
    - [Custom Log](#custom-log)
- [PHPUnit Tests](#phpunit-tests)
- [PHPUnit Code Coverage](#phpunit-code-coverage)
- [Contributing](#contributing)
- [License](#license)

# Installation
Using private repository:
```json
{
    "require": {
        "dnsprogress/logman": "0.1-alpha"
    },
    "repositories": [
        {
            "type": "github",
            "url": "https://github.com/dns2012/logman.git"
        }
    ]
}
```
The only requirement is the installation of SSH keys for a git client.

# Usage Examples

#### Setup Configuration
When you want to start use this plugin, you need to setup the `channel` and `format` first. This `channel` has functionality to set the log file where you log will be stored. And the `format` is the state of the log format it self, currently there is 2 available format :

- Line Format
- JSON Format

###### Example :

```php
use Logman\App\Producer\Format;
use Logman\App\Producer\Stream;
use Logman\Logman;

Logman::setup(Stream::DEFAULT_CHANNEL, Format::LINE_FORMAT);

Logman::setup('my-channel', Format::JSON_FORMAT);
```

###### Explanation :
- `Logman` is the main class of the plugin which should be the gateways for avaialable command
- `setup` is the static method to instruct the `Logman` prepare the log `channel` and `format`, you required to call this method first before continue use the `Logman`
- You can user your own channel name or use the default one for example `Stream::DEFAULT_CHANNEL`, and for the format you can write as the example above

___


#### PHP Error Standard Listener
After complete the setup you can add `php error listener` which will listen any error of your application to the log channel

###### Example :
```php
use Logman\Logman;

Logman::listen();
```
###### Explanation :
- `listen` is the static method to instruct the `Logman` start listening `PHP Error Standard` which happen in the entire of the application and automatically write it to the log channel

___


#### Custom Log
Custom Log is another ability of this plugin, this feature allow you to write your own log (manually) by yourself. So now you can log the event, error, notes or anything in your code so easily.

###### Example :
```php
use Logman\Logman;

Logman::info('Info Message', ['your' => 'params is here']);
Logman::warning('Warning Message', ['your' => 'params is here']);
Logman::error('Error Message', ['your' => 'params is here']);
Logman::critical('Critical Message', ['your' => 'params is here']);
```
###### Explanation :
- `Logman` has 4 error categories
    - `info`
    - `warning`
    - `error`
    - `critical` (only used by `PHP Error Standard Listener)`
- Custom Log has 2 params which able you use in each log level
    - `message` `string` this param should be the message you want to log
    - `arguments` `array` this param could be payload or data you want to store within the `message`


# PHPUnit Tests
`./vendor/bin/phpunit --testsuit Unit`

Or you can do built-in containerized unit tests (Docker required) by doing these steps:
1. `make build-image`
2. `make test-unit`

# PHPUnit Code Coverage
By default, code coverage driver [xdebug] is not installed. You can run the following command inside your container to install the driver.
- Mac Book : 
    ```
    1. pecl install xdebug
    2. export XDEBUG_MODE=coverage
    3. ./vendor/bin/phpunit --testsuit Unit --coverage-html coverage
    ```
# Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

# License
[![MIT license](https://img.shields.io/badge/License-MIT-blue.svg)](https://lbesson.mit-license.org/)
