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
use hipanel\modules\certificate\widgets\IssueButton;
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
                'filterOptions' => ['class' => 'narrow-filter'],
                'filterAttribute' => 'name_ilike',
                'format' => 'raw',
                'value' => function ($model) {
                    $out = '';
                    if ($model->state === 'incomplete') {
                        $out = IssueButton::widget(['certificate_id' => $model->id]);
                    } else {
                        $out = Html::a($model->name, [
                            '@certificate/view',
                            'id' => $model->id,
                        ], ['class' => 'text-bold']);
                    }

                    return $out;
                },
            ],
            'alt_name' => [
                'attribute' => 'name',
            ],
            'certificateType' => [
                'label' => Yii::t('hipanel:certificate', 'Certificate Type'),
            ],
            'object' => [
                'format' => 'raw',
                'filterAttribute' => 'object_like',
                'value' => function ($model) {
                    return ObjLinkWidget::widget(['label' => '', 'model' => $model->object]);
                },
            ],
            'state' => [
                'class' => RefColumn::class,
                'filterAttribute' => 'state_in',
                'filterOptions' => ['class' => 'narrow-filter'],
                'format' => 'raw',
                'gtype' => 'state,certificate',
                'i18nDictionary' => 'hipanel:certificate',
                'value' => function ($model) {
                    return CertificateState::widget(compact('model'));
                },
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => CertificateActionsMenu::class,
            ],
            'begins' => [
                'format' => 'date',
                'filter' => false,
            ],
            'expires' => [
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
