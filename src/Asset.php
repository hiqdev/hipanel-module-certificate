<?php

namespace hipanel\modules\certificate;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@hipanel/modules/certificate/assets';

    public $css = [
        'css/certificate.css',
    ];

    public $js = [
    ];

    public $depends = [
    ];
}