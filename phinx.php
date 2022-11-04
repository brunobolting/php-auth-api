<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'sqlite',
            'name' => './database/app',
            'suffix' => '.db',
        ],
        'test' => [
            'adapter' => 'sqlite',
            'name' => 'app',
            'mode' => 'memory',
            'cache' => 'shared',
        ]
    ],
    'version_order' => 'creation'
];
