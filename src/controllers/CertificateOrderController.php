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

use hipanel\actions\RenderAction;
use hipanel\models\Ref;
use hipanel\modules\certificate\Module;
use hipanel\modules\certificate\cart\CertificateOrderProduct;
use hipanel\modules\certificate\forms\CsrGeneratorForm;
use hipanel\modules\certificate\forms\OrderForm;
use hipanel\modules\certificate\repositories\CertificateTariffRepository;
use hiqdev\yii2\cart\actions\AddToCartAction;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class CertificateOrderController extends Controller
{
    /**
     * @var CertificateTariffRepository
     */
    protected $tariffRepository;

    public function __construct($id, Module $module, CertificateTariffRepository $tariffRepository, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->tariffRepository = $tariffRepository;
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'add-to-cart-order' => [
                'class' => AddToCartAction::class,
                'productClass' => CertificateOrderProduct::class,
                'redirectToCart' => true,
            ],
            'index' => [
                'class' => RenderAction::class,
                'data' => [
                    'resources' => $this->tariffRepository->getResources(),
                ],
            ],
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
}
