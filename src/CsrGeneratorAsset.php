<?php

namespace hipanel\modules\certificate;

use yii\web\AssetBundle;

class CsrGeneratorAsset extends AssetBundle
{
    public $sourcePath = '@hipanel/modules/certificate/assets/csr-generator/dist';

    public $js = [
        'csr_generator.bundle.js',
    ];
}
