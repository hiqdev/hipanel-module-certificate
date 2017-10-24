<?php

namespace hipanel\modules\certificate\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Html;

class CSRInput extends Widget
{
    public $model;

    public $attribute = 'csr';

    public $buttonSelector = 'csr-button';

    public $fqdn;

    public function run()
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
        $html = Html::activeTextarea($this->model, $this->attribute, ['class' => 'form-control', 'rows' => 5]);
        $html .= Html::button('<i class="fa fa-cog" aria-hidden="true"></i>&nbsp;'. Yii::t('hipanel:certificate', 'Generate CSR'), [
            'class' => 'btn btn-xs btn-default',
            'data' => [
                'toggle' => 'modal',
                'target' => '#csr-modal',
                'fqdn' => $this->fqdn,
            ],
        ]);

        return Html::tag('div', $html, ['class' => 'csr-input-container']);
    }
}
