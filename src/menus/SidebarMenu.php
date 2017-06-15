<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\menus;

use Yii;

class SidebarMenu extends \hiqdev\yii2\menus\Menu
{
    public function items()
    {
        $identity = Yii::$app->user->identity;
        if (!in_array($identity->login, ['sol','solex','tofid','tafid','silverfire','bladeroot'])) {
            return [];
        }

        return [
            'certificate' => [
                'label' => Yii::t('hipanel:certificate', 'SSL certificates'),
                'url' => ['@certificate/index'],
                'icon' => 'fa-shield',
                'items' => [
                    'certificates' => [
                        'label' => Yii::t('hipanel:certificate', 'My certificates'),
                        'url' => ['@certificate/index'],
                    ],
                    'certificate-types' => [
                        'label' => Yii::t('hipanel:certificate', 'Get certificate'),
                        'url' => ['@certificate/order/index'],
                    ],
                ],
            ],
        ];
    }
}
