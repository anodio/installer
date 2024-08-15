<?php

if (!getenv('PROJECT_NAME')) {
    echo 'PROJECT_NAME is not set'."\n";
    exit(1);
}
copy('/installer/frock.yaml', '/var/www/frock.yaml');
copy('/installer/frock.override.yaml', '/var/www/frock.override.yaml');

$frock = file_get_contents('/var/www/frock.yaml');
$frock = str_replace('MY_SUPER_COOL_PROJECT_NAME', getenv('PROJECT_NAME'), $frock);
file_put_contents('/var/www/frock.yaml', $frock);

$frock = file_get_contents('/var/www/frock.override.yaml');
$frock = str_replace('MY_SUPER_COOL_PROJECT_NAME', getenv('PROJECT_NAME'), $frock);
file_put_contents('/var/www/frock.override.yaml', $frock);

echo 'Frock files copied and updated';

$composer = [
    'name'=>'anodio/'.getenv('PROJECT_NAME'),
    'description'=>'Anod Framework based project '.getenv('PROJECT_NAME'),
    'type'=>'project',
    'require'=>[
        'anodio/core'=>'^0.1'
    ],
    'autoload'=>[
        'psr-4'=>[
            'App\\'=>'app/'
        ],
        'files'=>[
            'vendor/attributes.php'
        ]
    ],
    'extra'=>[
        'composer-attribute-collector'=>[
            'include'=>[
                'app',
                'vendor'
            ]
        ]
    ]
];
@mkdir('/var/www/php', 0777, true);
file_put_contents('/var/www/php/composer.json', json_encode($composer, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));

@mkdir('/var/www/php/app', 0777, true);
@mkdir('/var/www/php/system', 0777, true);
file_put_contents('/var/www/php/app/.gitkeep', '');
file_put_contents('/var/www/php/system/.gitignore', '*.'."\n".'!.gitignore');
file_put_contents('/var/www/php/.env', 'APP_NAME='.getenv('PROJECT_NAME')."\n");
file_put_contents('/var/www/php/.gitignore', 'vendor');

shell_exec('composer install -d /var/www/php');

copy('/var/www/php/vendor/anodio/core/app/app.php', '/var/www/php/app.php');