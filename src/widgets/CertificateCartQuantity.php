<?php

namespace hipanel\modules\certificate\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class CertificateCartQuantity extends Widget
{
    public $quantityOptions = [];
    public $product_id;

    public function run()
    {
        $out = Html::dropDownList('quantity', 'quantity', $this->quantityOptions, ['class' => 'form-control quantity-field']);
        $out .= Html::a(
            '<i class="fa fa-plus fa-fw"></i>&nbsp;&nbsp;' . Yii::t('hipanel:certificate', 'Add the same item'),
            ['@certificate/order/add-to-cart-order', 'product_id' => $this->product_id],
            ['class' => 'btn btn-success btn-flat btn-sm md-mt-10']
        );

        return $out;
    }
}
