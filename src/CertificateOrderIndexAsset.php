<?php

namespace hipanel\modules\certificate;

use hipanel\assets\IsotopeAsset;
use hiqdev\assets\icheck\iCheckAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class OrderIndexAsset extends AssetBundle
{
    public $sourcePath = '@hipanel/modules/certificate/assets';

    public $css = [
        'css/orderIndex.css',
    ];

    public $js = [
        'js/orderIndex.js',
    ];

    public $depends = [
        iCheckAsset::class,
        IsotopeAsset::class,
        JqueryAsset::class,
        BootstrapPluginAsset::class,
    ];
}