<?php

namespace hipanel\modules\certificate\widgets;

use Yii;
use yii\web\View;
use yii\base\Widget;
use yii\bootstrap\Html;
use hipanel\helpers\Url;
use hipanel\widgets\AjaxModal;

class CSRInput extends Widget
{
    public $model;

    public $attribute = 'csr';

    public $buttonSelector = 'csr-button';

    public function init()
    {
        $this->addClientCss();
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
        $html = Html::activeTextarea($this->model, $this->attribute, ['class' => 'form-control', 'rows' => 5]);
        $html .= Html::button('<i class="fa fa-cog" aria-hidden="true"></i>&nbsp;' . Yii::t('hipanel:certificate', 'Generate CSR'), [
            'class' => 'btn btn-xs btn-default',
            'data' => [
                'toggle' => 'modal',
                'target' => '#csr-modal',
            ],
        ]);

        return Html::tag('div', $html, ['class' => 'csr-input-container']);
    }

    private function addClientCss()
    {
        $this->view->registerCss("
        .csr-input-container {
            position: relative;
            width: 100%;
        }
        
        .csr-input-container .btn {
            position: absolute;
            top: 8px;
            right: 18px;
            opacity: .7;
        }
        .csr-input-container .btn:hover {
            opacity: 1;
        }
        
        ");
    }
}
