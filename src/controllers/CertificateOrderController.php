<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\controllers;

use hipanel\models\Ref;
use hipanel\modules\certificate\cart\CertificateOrderProduct;
use hipanel\modules\certificate\forms\CsrGeneratorForm;
use hipanel\modules\certificate\forms\OrderForm;
use hipanel\modules\certificate\repositories\CertRepository;
use hipanel\modules\certificate\widgets\PreOrderQuestion;
use hiqdev\yii2\cart\actions\AddToCartAction;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class CertificateOrderController extends Controller
{
    public function actions()
    {
        return [
            'add-to-cart-order' => [
                'class' => AddToCartAction::class,
                'productClass' => CertificateOrderProduct::class,
                'redirectToCart' => true,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'models' => CertRepository::create()->getTypes(),
        ]);
    }

    public function actionCsrGenerator($productId = null)
    {
        $model = new CsrGeneratorForm();
        $model->productId = $productId;
        $orderUrl = Url::toRoute(['@certificate/order/order', 'productId' => $model->productId]);

        return $this->render('csr-generator', [
            'countries' => array_change_key_case(Ref::getList('country_code'), CASE_UPPER),
            'model' => $model,
            'orderUrl' => $orderUrl,
        ]);
    }

    public function actionOrder($productId = null, $email = null)
    {
        $model = new OrderForm();
        $model->attributes = [
            'productId' => $productId,
            'email' => $email,
        ];
        if (Yii::$app->request->isAjax) {
            sleep(2);
            return $this->renderAjax('_orderForm', compact('model'));
        } else {
            return $this->render('order', compact('model'));
        }
    }

    public function actionGetLinksModal($productId)
    {
        return PreOrderQuestion::links($productId);
    }
}
