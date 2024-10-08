<?php

if (!getenv('PROJECT_NAME')) {
    echo 'PROJECT_NAME is not set'."\n";
    exit(1);
}
copy('/installer/docker-compose.yaml', '/var/www/docker-compose.yaml');

$compose = file_get_contents('/var/www/docker-compose.yaml');
$compose = str_replace('MY_SUPER_COOL_PROJECT_NAME', getenv('PROJECT_NAME'), $compose);
file_put_contents('/var/www/docker-compose.yaml', $compose);

echo 'Compose file copied and updated';

$composer = [
    'name'=>'anodio/'.getenv('PROJECT_NAME'),
    'description'=>'Anod Framework based project '.getenv('PROJECT_NAME'),
    'type'=>'project',
    'require'=>[
        'anodio/core'=>'^0.1',
        'anodio/http-standalone'=>'^0.1'
    ],
    'autoload'=>[
        'psr-4'=>[
            'App\\'=>'app/'
        ],
    ]
];
@mkdir('/var/www/php', 0777, true);
file_put_contents('/var/www/php/composer.json', json_encode($composer, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
shell_exec('composer config -d /var/www/php --no-plugins allow-plugins.olvlvl/composer-attribute-collector true');

@mkdir('/var/www/php/app', 0777, true);
@mkdir('/var/www/php/system', 0777, true);
file_put_contents('/var/www/php/app/.gitkeep', '');
file_put_contents('/var/www/php/system/.gitignore', '*.'."\n".'!.gitignore');
file_put_contents('/var/www/php/.env', 'APP_NAME='.getenv('PROJECT_NAME')."\n");
file_put_contents('/var/www/php/.gitignore', 'vendor'."\n".'.env');
file_put_contents('/var/www/.gitignore', 'docker-compose.override.yaml'."\n");

shell_exec('composer install -n -d /var/www/php');

copy('/var/www/php/vendor/anodio/core/app/app.php', '/var/www/php/app.php');

shell_exec('composer config -d /var/www/php --no-plugins allow-plugins.olvlvl/composer-attribute-collector false');

copy('/installer/xc.md', '/var/www/Readme.md');