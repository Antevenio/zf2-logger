[![Build Status](https://travis-ci.org/eddiejaoude/zf2-logger.png)](https://travis-ci.org/eddiejaoude/zf2-logger)
[![Coverage Status](https://coveralls.io/repos/eddiejaoude/zf2-logger/badge.png?branch=master)](https://coveralls.io/r/eddiejaoude/zf2-logger?branch=master)
[![Total Downloads](https://poser.pugx.org/eddiejaoude/zf2-logger/downloads.png)](https://packagist.org/packages/eddiejaoude/zf2-logger)

# EddieJaoude\Zf2Logger

#### Zend Framework 2 Event Logger.
#### Log incoming Requests &amp; Response data with host name.

Below you can see request/response examples.

---

## Installation via Composer

### Steps 

#### 1. Add to composer.

```
    "require" : {
        "eddiejaoude/zf2-logger" : "v0.1"
    }
```

#### 2. Create ```zf2Logger.global.php``` in ```config/autoload``` with configuration (/config/module.config.php)

```
    /module.config.php.dist to /config/autoload/zf2Logger.global.php
```

#### 3. Add module to application config (/config/application.config.php)

```
   ...
   'modules' => array(
        'EddieJaoude\Zf2Logger',
   ),
   ...
```

Then you are good to go. All requests & responses will be logged.

---

## Example usage of manual logging & prority

As the ```Zend\Log\Logger``` is returned from the Service call, one can use the methods:
* emerg  // Emergency: system is unusable
* alert  // Alert: action must be taken immediately
* crit   // Critical: critical conditions
* err    // Error: error conditions
* warn   // Warning: warning conditions
* notice // Notice: normal but significant condition
* info   // Informational: informational messages
* debug  // Debug: debug messages

```
    ...
    $serviceLocator->get('EddieJaoude\Zf2Logger')->emerg('Emergency message');
    ...
```

---

## Example - built in logging

Each output includes & is prepended with the host - this is especially useful when working with multi layer/tier architecture, i.e. F/E (UI) -> B/E (API). As these can all write to the same output in the stack execution order or alternatively to different outputs.

### Request (priority DEBUG)

```
2014-01-09T16:28:23+00:00 DEBUG (7): Array
(
    [zf2.local] => Array
        (
            [Request] => Zend\Uri\Http Object
                (
                    [validHostTypes:protected] => 19
                    [user:protected] =>
                    [password:protected] =>
                    [scheme:protected] => http
                    [userInfo:protected] =>
                    [host:protected] => zf2.local
                    [port:protected] =>
                    [path:protected] => /api/user
                    [query:protected] =>
                    [fragment:protected] =>
                )

        )

)
```

### Response (priority DEBUG)

```
2014-01-09T16:28:24+00:00 DEBUG (7): Array
(
    [zf2.local] => Array
        (
            [Response] => Array
                (
                    [statusCode] => 200
                    [content] => {"total":2,"data":[{"id":"12345 ...
                    ...
                )
        )
)
```

---

## The way it works

In ```Module.php``` in the ```onBootstrap``` method the following are added...

```
$eventManager->attach(
            MvcEvent::EVENT_ROUTE,
            function ($e) {

            ...

            },
        100
    );
```

---

## Unit tests

To run unit tests (from root diectory)

```
vendor/bin/phpunit -c tests/phpunit.xml
```

---

## What Next...

* Additional events

Ideas & requirements welcome.

---

## Contributing

* Discussions from Ideas & Discussions to Pull Requests
* Pull requests with Unit tests

---

## Resources

* Github https://github.com/eddiejaoude/zf2-logger
* Packagist https://packagist.org/packages/eddiejaoude/zf2-logger
* Zend Framework 2 Modules http://modules.zendframework.com/eddiejaoude/zf2-logger
* Travis CI https://travis-ci.org/eddiejaoude/zf2-logger
* Coveralls https://coveralls.io/r/eddiejaoude/zf2-logger

