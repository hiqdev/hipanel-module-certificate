<?php

namespace hipanel\modules\certificate\controllers;

use hipanel\models\Ref;
use hipanel\modules\certificate\forms\CsrGeneratorForm;
use hipanel\modules\certificate\repositories\CertRepository;
use yii\web\Controller;

class CertificateOrderController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'models' => CertRepository::create()->getTypes(),
        ]);
    }

    public function actionCsrGenerator()
    {
        return $this->render('csr-generator', [
            'countries' => array_change_key_case(Ref::getList('country_code'), CASE_UPPER),
            'model' => new CsrGeneratorForm()
        ]);
    }
}
