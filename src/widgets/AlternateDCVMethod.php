<?php

namespace hipanel\modules\certificate\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class AlternateDCVMethod extends Widget
{
    public $data;

    public function run()
    {
        if (!empty($this->data['crt_code'])) {
            return '';
        }

        if (empty($this->data['dcv_data_alternate']['validation'])) {
            return '';
        }

        echo $this->renderAlernateDCVTable($this->data);

    }

    protected function renderAlernateDCVTable($model)
    {
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
    }
}
