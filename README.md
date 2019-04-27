[![Build Status](https://travis-ci.org/slepic/psr-http-message-tracy-panel.svg?branch=master)](https://travis-ci.org/slepic/psr-http-message-tracy-panel)
[![Style Status](https://styleci.io/repos/181732817/shield)](https://styleci.io/repos/181732817)


# psr-http-message-tracy-panel

A panel for Tracy, that traces PSR HTTP messages travelling between your PHP backend and other HTTP servers.

![Tracy Panel](https://github.com/slepic/psr-http-message-tracy-panel/raw/master/docs/images/panel.png)
![Tracy Bar](https://github.com/slepic/psr-http-message-tracy-panel/raw/master/docs/images/bar.png)

## Requirements

PHP 5.6 or 7.0

## Installation

Install with composer:

```composer require slepic/psr-http-message-tracy-panel```

## Usage

Basicaly you just need to:

* register an instance of [```Slepic\Tracy\Panels\PsrHttpMessagePanel```](https://github.com/slepic/psr-http-message-tracy-panel/blob/master/src/Tracy/Panels/PsrHttpMessagePanel.php) with ```Tracy\Debugger::getBar()->addPanel()```.

* to create the panel instance you will need to feed it with an instance of [```Slepic\Psr\Http\TransferLog\LogProviderInterface```](https://github.com/slepic/psr-http-message-tracy-panel/blob/master/src/Psr/Http/TransferLog/LogProviderInterface.php).

* simple implementation of the provider interface is included in this package and is named [```Slepic\Psr\Http\TransferLog\ArrayStorage```](https://github.com/slepic/psr-http-message-tracy-panel/blob/master/src/Psr/Http/TransferLog/ArrayStorage.php), which simply stores transfer log in a PHP array.

* And lastly, you need to feed the storage with the transfer logs using your http client.
This package currently provides means to achieve this with [```GuzzleHttp\ClientInterface```](https://github.com/guzzle/guzzle/blob/master/src/ClientInterface.php), but it is planned to move these bindings to a separate package. 

It is also planned to create a separate package with bindings to psr http client.

For usage see [this example!](https://github.com/slepic/psr-http-message-tracy-panel/blob/master/examples/plain.php)

And of course it is super simple to register the panel in Nette's DI as described [here](https://tracy.nette.org/en/extensions).

## TODOs

- Move namesapce Slepic\Psr to a separate package and drop psr/log dependency
- Move guzzle bindings to separate package and drop guzzle dependency
- Create another package to provide integration with PSR HTTP Client (this hasnt been implemented here because it wouldn't work in PHP 5.6)
- Add support for tracing transfer duration.
