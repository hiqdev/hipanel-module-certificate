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

use hipanel\modules\certificate\cart\CertificateOrderProduct;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class CertificateCartQuantity extends Widget
{
    public $quantityOptions = [];

    /**
     * CertificateType model id.
     * @var integer
     */
    public $product_id;

    /**
     * @var CertificateOrderProduct
     */
    public $model;

    /**
     * @var string
     */
    public $scenario = 'order';

    public function run()
    {
        $out = Html::dropDownList('quantity', $this->model->getQuantity(), $this->quantityOptions, ['class' => 'form-control quantity-field']);
        if ($scenario === 'order') {
            $out .= Html::a(
                '<i class="fa fa-plus fa-fw"></i>&nbsp;&nbsp;' . Yii::t('hipanel:certificate', 'Add the same position'),
                ['@certificate/order/add-to-cart-order', 'product_id' => $this->product_id],
                ['class' => 'btn btn-success btn-flat btn-sm md-mt-10']
            );
        }

        return $out;
    }
}
