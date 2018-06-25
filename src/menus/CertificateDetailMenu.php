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
use hipanel\helpers\Url;
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
            'change-validation' => [
                'label' => ModalButton::widget([
                    'model' => $this->model,
                    'scenario' => 'change-validation',
                    'button' => [
                        'label' => '<i class="fa fa-pencil-square-o"></i> ' . Yii::t('hipanel', 'Change validation'),
                    ],
                    'modal' => [
                        'header' => Html::tag('h4', Yii::t('hipanel:certificate', 'Confirm certificate change validation')),
                        'headerOptions' => ['class' => 'label-warning'],
                        'footer' => [
                            'label' => Yii::t('hipanel:certificate', 'Change'),
                            'data-loading-text' => Yii::t('hipanel', 'Changing...'),
                            'class' => 'btn btn-warning btn-flat',
                        ],
                    ],
                    'body' => function($model, $widget) {
                        echo $widget->form->field($model, 'dcv_method')->dropDownList($model->dcvMethodOptions(), [
                            'options' => ['email' => ['selected' => true]],
                        ]);
                        echo Html::beginTag('div', ['class' => 'method email']);
                        echo $widget->form->field($model, 'approver_email')->dropDownList([], [
                            'prompt' => '--',
                            'readonly' => true,
                        ])->hint(Yii::t('hipanel:certificate', 'An Approver Email address will be used during the order process of a Domain Validated SSL Certificate. An email requesting approval will be sent to the designated Approver Email address.'));
                        echo Html::endTag('div');
                        echo Html::beginTag('div', ['class' => 'method dns']);
                        echo Html::beginTag('p', ['class' => 'bg-warning']);
                        echo Yii::t('hipanel:certificate', 'In order to confirm domain ownership by this method, you will need to create a working DNS record in your domain. Make sure you can do this before choosing this method.');
                        echo Html::endTag('p');
                        echo Html::endTag('div');
                    }
                ]),
            'encode' => false,
            ],
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
                'visible' => Yii::$app->user->can('certificate.update'),
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
                'visible' => Yii::$app->user->can('certificate.delete') && $this->model->isDeleteable(),
            ],
        ]);
        unset($items['view']);

        return $items;
    }
}
