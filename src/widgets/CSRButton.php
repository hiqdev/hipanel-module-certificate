<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\widgets;

use hipanel\helpers\Url;
use hipanel\widgets\AjaxModal;
use Yii;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\web\View;

class CSRButton extends Widget
{
    public $model;

    public $buttonOptions = [];

    public $tagName = 'a';

    public function init()
    {
        $this->view->on(View::EVENT_END_BODY, function ($event) {
            echo AjaxModal::widget([
                'id' => 'csr-modal',
                'size' => AjaxModal::SIZE_LARGE,
                'header' => Html::tag('h4', Yii::t('hipanel:certificate', 'Generate CSR form'), ['class' => 'modal-title']),
                'actionUrl' => Url::to([
                    '@certificate/csr-generate-form',
                    'client' => $this->model ? $this->model->client : null,
                    'fqdn' => $this->model ? $this->model->name : null,
                ]),
                'scenario' => 'csr-generate',
                'toggleButton' => false,
            ]);
        });
    }

    public function run()
    {
        $button = '';
        $button .= Html::tag($this->tagName, '<i class="fa fa-cog fa-fw" aria-hidden="true"></i>&nbsp;' . Yii::t('hipanel:certificate', 'Generate CSR'), array_merge([
            'class' => 'btn btn-warning',
            'data' => [
                'toggle' => 'modal',
                'target' => '#csr-modal',
            ],
        ], $this->buttonOptions));

        return $button;
    }
}
