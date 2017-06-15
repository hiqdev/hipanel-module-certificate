<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\widgets;

use hipanel\modules\certificate\CertificateOrderIndexAsset;
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
        $view->registerCss('.popover {width: 300px;}');
    }

    public function run()
    {
        return $this->render('CertificateOrderIndex', ['models' => $this->models]);
    }
}
