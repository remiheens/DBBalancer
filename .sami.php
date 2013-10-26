<?php

include 'vendor/autoload.php';

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir = 'src')
;

return new Sami($iterator, array(
    'title'                => 'DBBalancer API',
    'theme'                => 'enhanced',
    'build_dir'            => __DIR__.'/docs/API',
    'cache_dir'            => __DIR__.'/docs/API/cache',
    'default_opened_level' => 2,
));