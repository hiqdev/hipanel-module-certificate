<?php

namespace hipanel\modules\certificate;

use hipanel\assets\IsotopeAsset;
use hiqdev\assets\icheck\iCheckAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class CertificateOrderIndexAsset extends AssetBundle
{
    public $sourcePath = '@hipanel/modules/certificate/assets';

    public $css = [
        'css/certificateOrderIndex.css',
    ];

    public $js = [
        'js/certificateOrderIndex.js',
    ];

    public $depends = [
        iCheckAsset::class,
        IsotopeAsset::class,
        JqueryAsset::class,
        BootstrapPluginAsset::class,
    ];
}