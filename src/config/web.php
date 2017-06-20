<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

return [
    'aliases' => [
        '@certificate' => '/certificate/certificate',
        '@certificate/order' => '/certificate/certificate-order',
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
    ],
    'modules' => [
        'certificate' => [
            'class' => \hipanel\modules\certificate\Module::class,
        ],
    ],
    'container' => [
        'definitions' => [
            \hiqdev\thememanager\menus\AbstractSidebarMenu::class => [
                'add' => [
                    'certificates' => [
                        'menu' => \hipanel\modules\certificate\menus\SidebarMenu::class,
                        'where' => [
                            'after' => ['domains'],
                            'before' => ['servers', 'hosting', 'stock'],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
