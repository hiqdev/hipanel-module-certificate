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
                    'attribute' => 'dcv_method',
                    'label' => Yii::t('hipanel:certificate', 'Domain control validation'),
                    'format' => 'html',
                    'value' => function ($model) {
                        $method = $model['dcv_method'];
                        $value = $model['dcv_data'][$method];
                        if ($method === 'email') {
                            $hint = Yii::t('hipanel:certificate', 'follow confirmation link in email sent to your address:');
                            $value = Html::tag('b', $value ? : $model['approver_email']);
                        } elseif ($method === 'dns') {
                            $hint = Yii::t('hipanel:certificate', 'add following DNS record');
                            $value = Html::tag('pre', $value['record']);
                        }

                        return Yii::t('hipanel:certificate', 'Method:') . ' ' . Html::tag('b', strtoupper($method)) . ', ' . $hint . ' ' . $value;
                    },
                    'visible' => empty($this->data['crt_code']),
                ],
                [
                    'attribute' => 'dcv_method_alternate',
                    'label' => Yii::t('hipanel:certificate', 'Alternate domain validations'),
                    'format' => 'html',
                    'value' => function ($model) {
                        $table = Html::beginTag('table', ["class" => "table table-striped table-bordered detail-view"]) . Html::beginTag('thread') . Html::beginTag('tr');
                        $table .= Html::tag('th', Yii::t('hipanel:certificate', 'Method'));
                        $table .= Html::tag('th', Yii::t('hipanel:certificate', 'Values'), []);
                        $table .= Html::endTag('tr') .  Html::endTag('thread');
                        $table .= Html::beginTag('tbody');

                        foreach ($model['dcv_data_alternate']['validation'] as $dcv_method => $value)  {
                            $table .= Html::beginTag('tr');
                            $table .= Html::tag('th', mb_strtoupper($dcv_method), []);
                            $table .= Html::beginTag('td');
                            $table .= Html::beginTag('table', ["class" => "table table-striped table-bordered detail-view"]) . Html::beginTag('tbody');
                            foreach ($value[$dcv_method] as $k => $v) {
                                $table .= Html::beginTag('tr');
                                $table .= Html::tag('th', mb_strtoupper($k));
                                $table .= Html::tag('td', nl2br($v));
                                $table .= Html::endTag('tr');
                            }
                            $table .= Html::endTag('tbody') . Html::endTag('table');
                        }
                        $table .= Html::endTag('tbody');
                        $table .= Html::endTag('table');
                        return $table;
                    },
                    'visible' => empty($this->data['crt_code']) && !empty($this->data['dcv_data_alternate']['validation']),
                ],
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
                    'visible' => !empty($this->data['crt_code']),
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
                    'visible' => !empty($this->data['ca_code']),
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
