<?php

namespace hipanel\modules\certificate\widgets;

use Yii;
use yii\web\View;
use yii\base\Widget;
use yii\bootstrap\Html;
use hipanel\helpers\Url;
use hipanel\widgets\AjaxModal;

class CSRButton extends Widget
{
    public $model;

    public $buttonOptions = [];

    public $buttonSelector = 'csr-button';

    public function init()
    {
        $this->view->on(View::EVENT_END_BODY, function ($event) {
            echo AjaxModal::widget([
                'id' => 'csr-modal',
                'size' => AjaxModal::SIZE_LARGE,
                'header' => Html::tag('h4', Yii::t('hipanel:certificate', 'Generate CSR form'), ['class' => 'modal-title']),
                'actionUrl' => Url::to([
                    '@certificate/csr-generate-form',
                    'client' => $this->model->client,
                    'fqdn' => $this->model->name,
                ]),
                'scenario' => 'csr-generate',
                'toggleButton' => false,
            ]);
        });
    }

    public function run()
    {
        $html = '';
        $html .= Html::button('<i class="fa fa-cog fa-fw" aria-hidden="true"></i>&nbsp;' . Yii::t('hipanel:certificate', 'Generate CSR'), array_merge([
            'class' => 'btn btn-warning btn-flat',
            'data' => [
                'toggle' => 'modal',
                'target' => '#csr-modal',
            ],
        ], $this->buttonOptions));

        return Html::tag('div', $html, ['class' => 'csr-input-container']);
    }
}
