<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\menus;

use hiqdev\yii2\menus\Menu;
use Yii;

class CertificateBulkActionsMenu extends Menu
{
    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:certificate', 'Renew'),
                'url' => '#',
                'linkOptions' => [
                    'class' => 'btn btn-success btn-flat',
                    'data-action' => 'bulk-renewal',
                ],
            ],
        ];
    }
}
