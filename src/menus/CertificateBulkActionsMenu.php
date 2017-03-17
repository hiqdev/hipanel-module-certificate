<?php

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
