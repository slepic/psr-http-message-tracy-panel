<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

//init tracy
Tracy\Debugger::enable();

//here we will store our transfer logs
$storage = new \Slepic\Psr\Http\TransferLog\ArrayStorage();

//prepare http message panel
$panel = new \Slepic\Tracy\Panels\PsrHttpMessagePanel($storage);

//register the panel
$tracy = \Tracy\Debugger::getBar();
$tracy->addPanel($panel);

//let's use a guzzle http client to generate some transfers
$client = new \GuzzleHttp\Client();

//now wrap the log storage in logging middleware for guzzle client
$middleware = new \Slepic\Psr\Http\TransferLog\LoggingGuzzleMiddleware($storage);

//register the middleware
$client->getConfig('handler')
    ->unshift($middleware);

//make some example calls to fill the storage with logs
try {
    $client->get('http://www.example.com/e404');
} catch (\Exception $e) {
}

try {
    $client->get('http://www.google.com?q=psr-http-message-tracy-panel');
} catch (\Exception $e) {
}

try {
    $client->post('http://www.google.com', ['body' => 'q=search']);
} catch (\Exception $e) {
}

try {
    $client->get('http://www.example.com');
} catch (\Exception $e) {
}

//display this script source code
echo "<pre>";
echo htmlspecialchars(file_get_contents(__FILE__));
echo "</pre>";
