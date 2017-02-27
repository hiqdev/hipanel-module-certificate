<?php

namespace hipanel\modules\certificate\controllers;

use hipanel\modules\certificate\repositories\CertRepository;
use yii\web\Controller;

class CertificateOrderController extends Controller
{
    public function actionIndex()
    {
        $models = CertRepository::create()->getTypes();

        return $this->render('index', [
            'models' => $models,
        ]);
    }
}
