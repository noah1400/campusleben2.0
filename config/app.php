<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [


    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
        'Markdown' => GrahamCampbell\Markdown\Facades\Markdown::class,
    ])->toArray(),

];
