<?php

namespace hipanel\modules\certificate\widgets;

use yii\base\Widget;
use yii\helpers\Url;

class CSRGenerator extends Widget
{
    public $model;

    public $countries = [];

    public $requestUrl = '@certificate/csr-generate-form';

    public $fqdn;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->fqdn) {
            $this->model->csr_commonname = $this->fqdn;
        }

        return $this->render('CSRGenerator', [
            'model' => $this->model,
            'countries' => $this->countries,
            'requestUrl' => Url::to($this->requestUrl),
        ]);
    }
}
