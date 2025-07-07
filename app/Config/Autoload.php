<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

class Autoload extends AutoloadConfig
{
    /**
     * Array of namespaces for autoloading.
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'      => APPPATH . 'Config',
    ];

    /**
     * Array of class maps for autoloading.
     */
    public $classmap = [];

    /**
     * Array of files for autoloading.
     */
    public $files = [];

    /**
     * Array of helpers to be autoloaded.
     */
    public $helpers = ['url', 'form', 'navigation'];
}