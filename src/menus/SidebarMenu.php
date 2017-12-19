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

use hipanel\modules\certificate\widgets\CSRButton;
use Yii;

class SidebarMenu extends \hiqdev\yii2\menus\Menu
{
    public function items()
    {
        if (!Yii::$app->user->can('test.beta')) {
            return [];
        }

        return [
            'certificates' => [
                'label' => Yii::t('hipanel:certificate', 'SSL certificates'),
                'url' => ['@certificate/index'],
                'icon' => 'fa-shield',
                'visible' => Yii::$app->user->can('certificate.read'),
                'items' => [
                    'certificates' => [
                        'label' => Yii::t('hipanel:certificate', 'Certificates'),
                        'url' => ['@certificate/index'],
                    ],
                    'certificate-order' => [
                        'label' => Yii::t('hipanel:certificate', 'Buy certificate'),
                        'url' => ['@certificate/order/index'],
                        'visible' => Yii::$app->user->can('certificate.pay'),
                    ],
                    'certificate-generate-csr' => [
                        'label' => CSRButton::widget([
                            'tagName' => 'a',
                            'buttonOptions' => ['class' => '', 'href' => '#'],
                        ]),
                        'encode' => false,
                    ],
                ],
            ],
        ];
    }
}
