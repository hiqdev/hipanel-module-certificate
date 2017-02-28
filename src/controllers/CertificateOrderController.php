<?php

namespace hipanel\modules\certificate\controllers;

use hipanel\models\Ref;
use hipanel\modules\certificate\forms\CsrGeneratorForm;
use hipanel\modules\certificate\repositories\CertRepository;
use hipanel\modules\certificate\widgets\PreOrderQuestion;
use yii\web\Controller;

class CertificateOrderController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'models' => CertRepository::create()->getTypes(),
        ]);
    }

    public function actionCsrGenerator($productId = null)
    {
        $model = new CsrGeneratorForm();
        if ($productId) {
            $model->productId = $productId;
        }

        return $this->render('csr-generator', [
            'countries' => array_change_key_case(Ref::getList('country_code'), CASE_UPPER),
            'model' => $model,
        ]);
    }

    public function actionGetLinksModal($productId)
    {
        return PreOrderQuestion::links($productId);
    }
}
