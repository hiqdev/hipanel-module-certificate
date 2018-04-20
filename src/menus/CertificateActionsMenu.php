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

use hiqdev\yii2\menus\Menu;
use Yii;

class CertificateActionsMenu extends Menu
{
    public $model;

    const STATE_DELETED = 'deleted';
    const STATE_CANCELLED = 'cancelled';

    protected function checkAvailableAction($state)
    {
        return !in_array($sate, [self::STATE_DELETED, self::STATE_CANCELLED], true);
    }

    public function items()
    {
        return $this->checkAvailableAction($this->model->state) ? [
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
            'reissue' => [
                'label' => Yii::t('hipanel:certificate', 'Reissue'),
                'icon' => 'fa-refresh',
                'url' => ['@certificate/reissue', 'id' => $this->model->id],
                'encode' => false,
            ],
            'cancel-order' => [
                'label' => Yii::t('hipanel:certificate', 'Cancel order'),
                'icon' => '',
                'url' => ['@certificate/cancel-order', 'id' => $this->model->id],
                'encode' => false,
            ],
        ] : [];
    }
}
