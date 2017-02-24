<?php

namespace hipanel\modules\certificate\controllers;

use dosamigos\arrayquery\ArrayQuery;
use hipanel\modules\certificate\repositories\CertificateTypesRepository;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class CertificateController extends Controller
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
        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'models' => $models,
        ]);
    }

    public function actionMy()
    {
        return $this->render('my', []);
    }
}
