<?php

namespace hipanel\modules\certificate\widgets;

use hipanel\modules\certificate\CertificateOrderIndexAsset;
use Yii;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\View;

class CertificateOrderIndex extends Widget
{
    public $models;

    public function init()
    {
        $view = $this->getView();
        CertificateOrderIndexAsset::register($view);
        $jsPluginOptions = Json::encode([

        ]);
        $view->registerJs("$(document).certificateOrderIndex({$jsPluginOptions})", View::POS_END);
        $view->registerCss(".popover {width: 300px;}");
    }

    public function run()
    {
        return $this->render('CertificateOrderIndex', ['models' => $this->models]);
    }
}
