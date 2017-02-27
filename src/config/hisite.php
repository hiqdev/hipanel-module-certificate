<?php

return [
    'aliases' => [
        '@certificate' => '/certificate/certificate',
        '@certificate/order' => '/certificate/certificate-order',
    ],
    'modules' => [
        'cart' => [
            'class' => \hiqdev\yii2\cart\Module::class,
        ],
    ],
    'components' => [
        'themeManager' => [
            'pathMap' => [
                '@hipanel/modules/certificate/views' => '$themedViewPaths',
            ],
        ],
        'i18n' => [
            'translations' => [
                'hipanel:certificate' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hipanel/modules/certificate/messages',
                ],
            ],
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
    ],
    'container' => [
        'definitions' => [
            \hiqdev\thememanager\menus\AbstractSidebarMenu::class => [
                'add' => [
                    'certificate' => [
                        'menu' => \hipanel\modules\certificate\menus\SidebarMenu::class,
                        'where' => [
                            'after' => ['domains'],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
