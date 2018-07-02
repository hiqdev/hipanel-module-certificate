<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\widgets;

use hipanel\modules\certificate\CertificateOrderIndexAsset;
use hipanel\modules\certificate\models\CertificateType;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\View;

class CertificateOrderIndex extends Widget
{
    public $resources;

    public $secureKeys = ['dv', 'ov', 'ev'];

    public $amountKeys = ['cs', 'san', 'wc'];

    public function init()
    {
        $view = $this->getView();
        CertificateOrderIndexAsset::register($view);
        $jsPluginOptions = Json::encode([]);
        $view->registerJs("$(document).certificateOrderIndex({$jsPluginOptions})", View::POS_END);
        $view->registerCss('.popover {width: 300px;}');
    }

    public function run()
    {
        return $this->render('CertificateOrderIndex', [
            'secureProductFeatures' => $this->getSecureProductFeatures(),
            'amountProductFeatures' => $this->getAmountProductFeatures(),
            'brands' => $this->getBrands(),
            'resources' => $this->resources,
        ]);
    }

    public function widgetRender($view, $params = [])
    {
        return $this->render($view, $params);
    }

    protected function getProductFeatures($kyes = [])
    {
        return array_filter(CertificateType::features(), function ($key) use ($kyes) {
            if (!empty($kyes)) {
                return in_array($key, $kyes, true);
            }

            return true;
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getSecureProductFeatures()
    {
        return $this->getProductFeatures($this->secureKeys);
    }

    protected function getAmountProductFeatures()
    {
        return $this->getProductFeatures($this->amountKeys);
    }

    protected function getBrands()
    {
        return CertificateType::brands();
    }
}
