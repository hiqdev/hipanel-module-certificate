<?php

namespace hipanel\modules\certificate\controllers;

use hipanel\modules\certificate\repositories\CertificateTypesRepository;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class CertificateOrderController extends Controller
{
    /**
     * @var CertificateTypesRepository
     */
    private $certificateTypesRepository;

    public function __construct($id, $module, CertificateTypesRepository $certificateTypesRepository, $config = [])
    {
        parent::__construct($id, $module, $config = []);
        $this->certificateTypesRepository = $certificateTypesRepository;
    }

    public function actionIndex()
    {
        $models = $this->certificateTypesRepository->getTypes();

        return $this->render('index', [
            'models' => $models,
        ]);
    }
}
