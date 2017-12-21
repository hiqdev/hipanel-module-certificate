<?php

namespace hipanel\modules\certificate\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\DetailView;

class DataView extends Widget
{
    public $data;

    public function run()
    {
        $this->view->registerCss("
        .pre {
            white-space: pre-wrap;       /* css-3 */
            white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
        }
        ");

        $detailView = DetailView::widget([
            'model' => $this->data,
            'attributes' => [
                [
                    'attribute' => 'crt_code',
                    'label' => Yii::t('hipanel:certificate', 'Certificate'),
                    'value' => function ($model) {
                        return nl2br($model['crt_code']);
                    },
                    'format' => 'html',
                    'contentOptions' => [
                        'class' => 'pre',
                    ],
                    'captionOptions' => [
                        'style' => 'min-width: 20rem',
                    ],
                ],
                [
                    'attribute' => 'ca_code',
                    'label' => Yii::t('hipanel:certificate', 'Intermediate certificates'),
                    'value' => function ($model) {
                        return nl2br($model['ca_code']);
                    },
                    'format' => 'html',
                    'contentOptions' => [
                        'class' => 'pre',
                    ],
                    'captionOptions' => [
                        'style' => 'min-width: 20rem',
                    ],
                ],
                [
                    'attribute' => 'csr_code',
                    'label' => Yii::t('hipanel:certificate', 'Certificate request'),
                    'value' => function ($model) {
                        return nl2br($model['csr_code']);
                    },
                    'format' => 'html',
                    'contentOptions' => [
                        'class' => 'pre',
                    ],
                    'captionOptions' => [
                        'style' => 'min-width: 20rem',
                    ],
                ],
            ],
        ]);

        return Html::tag('div', $detailView, ['class' => 'table-responsive']);
    }
}
