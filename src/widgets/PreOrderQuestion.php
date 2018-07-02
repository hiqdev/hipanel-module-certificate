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

use Yii;
use yii\base\Widget;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

class PreOrderQuestion extends Widget
{
    public $buttonsCssClass = 'cert-make-order';

    public function init()
    {
        $getLinksUrl = Url::toRoute(['@certificate/order/get-links-modal']);
        $this->getView()->registerJs("
            var productId;
            $('a.{$this->buttonsCssClass}').click(function () { 
                productId = $(this).data('product-id');
                $('#cert-preorder-question').modal('show'); 
            });
            $('#cert-preorder-question').on('shown.bs.modal', function (event) {
                $.get('{$getLinksUrl}?productId=' + productId).done(function (data) {
                    $('#cert-preorder-question .modal-body').html(data);
                });
            });
        ");
    }

    public function run()
    {
        return Modal::widget([
            'id' => 'cert-preorder-question',
            'header' => Html::tag('h4', Yii::t('hipanel:certificate', 'Do you have Certificate Signing Request (CSR)?')),
        ]);
    }

    public static function links($productId)
    {
        $out = Html::a(Yii::t('hipanel:certificate', 'Generate CSR'), ['@certificate/order/csr-generator', 'productId' => $productId], ['class' => 'btn btn-block btn-primary']);
        $out .= Html::a(Yii::t('hipanel:certificate', 'I already have CSR'), ['@certificate/order/order', 'productId' => $productId], ['class' => 'btn btn-block btn-primary']);

        return $out;
    }
}
