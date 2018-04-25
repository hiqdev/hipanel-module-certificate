<?php

/** @var array $model */

use yii\helpers\Html;

echo Html::beginTag('table', ["class" => "table table-striped table-bordered detail-view"]);
    echo Html::beginTag('thread');
        echo Html::beginTag('tr');
            echo Html::tag('th', Yii::t('hipanel:certificate', 'Method'));
            echo Html::tag('th', Yii::t('hipanel:certificate', 'Values'), []);
         echo Html::endTag('tr');
    echo Html::endTag('thread');

    echo Html::beginTag('tbody');
    foreach ($model['dcv_data_alternate']['validation'] as $dcv_method => $value)  {
        echo Html::beginTag('tr');
            echo Html::tag('th', mb_strtoupper($dcv_method), []);
            echo Html::beginTag('td');
                echo Html::beginTag('table', ["class" => "table table-striped table-bordered detail-view"]);
                    echo Html::beginTag('tbody');
                    foreach ($value[$dcv_method] as $k => $v) {
                        echo Html::beginTag('tr');
                            echo Html::tag('th', mb_strtoupper($k));
                            echo Html::tag('td', nl2br($v));
                        echo Html::endTag('tr');
                    }
                    echo Html::endTag('tbody');
                echo Html::endTag('table');
            echo Html::endTag('td');
        echo Html::endTag('tr');
    }
    echo Html::endTag('tbody');
echo Html::endTag('table');

