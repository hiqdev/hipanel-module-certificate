<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate;

use yii\web\AssetBundle;

class CsrGeneratorAsset extends AssetBundle
{
    public $sourcePath = '@hipanel/modules/certificate/assets/csr-generator/dist';

    public $js = [
        'csr_generator.bundle.js',
    ];
}
