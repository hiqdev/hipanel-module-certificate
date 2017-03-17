<?php

namespace hipanel\modules\certificate\menus;

use hiqdev\yii2\menus\Menu;
use Yii;

class CertificateActionsMenu extends Menu
{
    public $model;

    public function items()
    {
        return [
            'view' => [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@certificate/view', 'id' => $this->model->id],
                'encode' => false,
            ],
            'renew' => [
                'label' => Yii::t('hipanel:certificate', 'Renew'),
                'icon' => 'fa-refresh',
                'url' => ['@certificate/bulk-renew', 'id' => $this->model->id],
                'encode' => false,
            ],
        ];
    }
}
