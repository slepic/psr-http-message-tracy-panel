<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

\exec('git diff --cached --name-only', $output, $exitCode);

if ($exitCode !== 0) {
    exit($exitCode);
}

$output = \array_filter($output, function ($item) {
    return \substr($item, -4) === '.php';
});
$output = \array_map(function ($item) {
    return new \SplFileInfo($item);
}, $output);

$config = PhpCsFixer\Config::create();
$config->setFinder($output);

if (\count($output) > 0) {
    echo 'Gonna check these files for code style errors:' . \PHP_EOL;
    foreach ($output as $file) {
        echo $file->getFilename() . \PHP_EOL;
    }
} else {
    echo "No PHP files to check.";
}
echo \PHP_EOL;

return $config;
