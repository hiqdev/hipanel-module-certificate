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

use hipanel\menus\AbstractDetailMenu;
use hipanel\modules\certificate\models\Certificate;
use hipanel\widgets\ModalButton;
use Yii;
use yii\bootstrap\Html;

class CertificateDetailMenu extends AbstractDetailMenu
{
    /** @var Certificate */
    public $model;

    public function items()
    {
        $actions = CertificateActionsMenu::create(['model' => $this->model])->items();
        $items = array_merge($actions, [
            [
                'label' => ModalButton::widget([
                    'model' => $this->model,
                    'scenario' => 'cancel',
                    'button' => [
                        'label' => '<i class="fa fa-fw fa-trash-o"></i> ' . Yii::t('hipanel', 'Cancel'),
                    ],
                    'modal' => [
                        'header' => Html::tag('h4', Yii::t('hipanel:certificate', 'Confirm certificate cancel')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer' => [
                            'label' => Yii::t('hipanel:certificate', 'Cancel certificate'),
                            'data-loading-text' => Yii::t('hipanel', 'Canceling...'),
                            'class' => 'btn btn-danger btn-flat',
                        ],
                    ],
                    'body' => function($model, $widget) {
                        echo Yii::t('hipanel:certificate', 'Certificate will be immediately revoked without any refunds or ability to reissue this certificate');
                        echo ". ";
                        echo Yii::t('hipanel:certificate', 'Are you sure to cancel certificate for {name}?', ['name' => $this->model->name]);
                        echo $widget->form->field($model, 'reason');
                    },
                ]),
                'encode' => false,
            ],
            [
                'label' => ModalButton::widget([
                    'model' => $this->model,
                    'scenario' => 'delete',
                    'button' => [
                        'label' => '<i class="fa fa-fw fa-trash-o"></i> ' . Yii::t('hipanel', 'Delete'),
                    ],
                    'modal' => [
                        'header' => Html::tag('h4', Yii::t('hipanel:certificate', 'Confirm certificate deleting')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer' => [
                            'label' => Yii::t('hipanel:certificate', 'Delete certificate'),
                            'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                            'class' => 'btn btn-danger btn-flat',
                        ],
                    ],
                    'body' =>
                        Yii::t('hipanel:certificate', 'Certificate will be immediately revoked without any refunds or ability to reissue this certificate') . ". " .
                        Yii::t('hipanel:certificate', 'Are you sure to delete certificate for {name}?', ['name' => $this->model->name]),
                ]),
                'encode' => false,
                'visible' => false,
            ],
        ]);
        unset($items['view']);

        return $items;
    }
}
