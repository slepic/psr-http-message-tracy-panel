[![Build Status](https://travis-ci.org/slepic/psr-http-message-tracy-panel.svg?branch=master)](https://travis-ci.org/slepic/psr-http-message-tracy-panel)
[![Style Status](https://styleci.io/repos/181732817/shield)](https://styleci.io/repos/181732817)


# psr-http-message-tracy-panel

A panel for [Tracy](https://tracy.nette.org/), that traces PSR HTTP messages travelling between your PHP backend and other HTTP servers.

![Tracy Panel](https://github.com/slepic/psr-http-message-tracy-panel/raw/master/docs/images/panel.png)

![Tracy Bar](https://github.com/slepic/psr-http-message-tracy-panel/raw/master/docs/images/bar.png)

## Requirements

PHP ^5.6 or ^7.0

## Installation

Install with composer:

```composer require --dev slepic/psr-http-message-tracy-panel```

## Usage

Basicaly you just need to:

* create the bar panel using the factory [```Slepic\Tracy\Bar\PsrHttpMessagePanel\Factory```](https://github.com/slepic/psr-http-message-tracy-panel/blob/master/src/Factory.php) and register it with ```Tracy\Debugger::getBar()->addPanel()```.

* to create the panel instance you will need to feed it with an iterator of instances of [```Slepic\Http\Transfer\Log\LogInterface```](https://github.com/slepic/http-transfer/blob/master/src/Log/LogInterface.php).

* simple implementation of such iterator is included in the [```slepic/http-transfer```](https://packagist.org/packages/slepic/http-transfer) package and is named [```Slepic\Psr\Http\Transfer\Log\ArrayStorage```](https://github.com/slepic/http-transfer/blob/master/src/Log/ArrayStorage.php), which simply stores transfer log in a PHP array.

* And lastly, you need to feed the storage with the transfer logs using your http client.
  * The [```slepic/http-transfer```](https://packagist.org/packages/slepic/http-transfer) package provides [```HistoryObserver```](https://github.com/slepic/http-transfer/blob/master/src/History/HistoryObserver.php) class which allows to easily collect the logs into your storage using your favourite http client.
  * Check [```slepic/http-transfer-observer-consumer```](https://packagist.org/providers/slepic/http-transfer-observer-consumer) for a list of adapters to see if there is one for your http client.

For complete usage exaple see [this example!](https://github.com/slepic/psr-http-message-tracy-panel/blob/master/examples/plain.php)

And of course it is super simple to register the panel in Nette's DI as described [here](https://tracy.nette.org/en/extensions).


## Changelog

### 0.3.1

* Improved readme
* Removed dependency on tracy as it is dependent indirectly (through slepic/teplated-tracy-bar-panel).
* Fixed dependecies to a versioned revision instead of just latest commit to master.
* Changed travis setup to only run tests in oldest and newest php versions supported by this package (that is 5.6 and 7.3).

### 0.3.0

* Removed class PsrHttpMessagePanel
* Factory is now used to create the panel, using TemplatedBarPanel class from [```slepic/templated-tracy-bar-panel```](https://packagist.org/packages/slepic/templated-tracy-bar-panel) package as the target implementation.
* Slepic\Psr namespace is now replaced by package [```slepic/http-transfer```](https://packagist.org/packages/slepic/http-transfer)
* support for guzzle moved to [```slepic/guzzle-http-observing-middleware```](https://packagist.org/packages/slepic/guzzle-http-observing-middleware)
* BC break: totally everythig

### 0.2.0

* Added support for transfer duration
* Improved panel layout

