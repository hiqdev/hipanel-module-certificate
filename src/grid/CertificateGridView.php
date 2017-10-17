<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\grid;

use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\widgets\obj\ObjLinkWidget;
use hipanel\modules\domain\widgets\Expires;
use hipanel\modules\certificate\menus\CertificateActionsMenu;
use hipanel\modules\certificate\widgets\CertificateState;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;

class CertificateGridView extends BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'name' => [
                'class' => MainColumn::class,
                'filterOptions' => ['class' => 'narrow-filter'],
            ],
            'certificateType' => [
                'label' => Yii::t('hipanel:certificate', 'Certificate Type')
            ],
            'object' => [
                'format' => 'raw',
                'filterAttribute' => 'object_like',
                'value' => function ($model) {
                    return ObjLinkWidget::widget(['label' => '', 'model' => $model->object]);
                },
            ],
            'state' => [
                'class'  => RefColumn::class,
                'filterAttribute' => 'state_in',
                'filterOptions' => ['class' => 'narrow-filter'],
                'format' => 'raw',
                'gtype'  => 'state,certificate',
                'i18nDictionary' => 'hipanel:certificate',
                'value'  => function ($model) {
                    return CertificateState::widget(compact('model'));
                },
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => CertificateActionsMenu::class,
            ],
            'expires' => [
                'label' => Yii::t('hipanel:certificate', 'Expires'),
                'format' => 'raw',
                'filter' => false,
                'headerOptions' => ['style' => 'width:1em'],
                'value' => function ($model) {
                    return Expires::widget(compact('model'));
                },
            ],
        ]);
    }
}
