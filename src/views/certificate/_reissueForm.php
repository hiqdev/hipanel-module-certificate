<?php

use hipanel\helpers\Url;
use hipanel\modules\certificate\widgets\CSRInput;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\DynamicFormWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'reissue-form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]);
?>

<div class="container-items">
    <div class="row">
        <div class="col-md-4">
            <div class="item">
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $model->name ?></h3>
                    </div>
                    <div class="box-body">
                        <?= Html::activeHiddenInput($model, 'id') ?>
                        <?= Html::activeHiddenInput($model, 'remoteid') ?>
                        <?= Html::activeHiddenInput($model, 'name') ?>
                        <?= $form->field($model, "csr")->widget(CSRInput::class, ['fqdn' => $model->name]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
            &nbsp;
            <?= Html::button(Yii::t('hipanel', 'Cancel'), [
                'class' => 'btn btn-default',
                'onclick' => 'history.go(-1)',
            ]) ?>
        </div>
    </div>
</div>
</div>


<?php $form->end() ?>

<?php
$url = Url::to(['@certificate/csr-generate-form']);
echo AjaxModal::widget([
    'id' => 'csr-modal',
    'size' => AjaxModal::SIZE_LARGE,
    'header' => Html::tag('h4', Yii::t('hipanel:certificate', 'Generate CSR form'), ['class' => 'modal-title']),
    'actionUrl' => $url,
    'scenario' => 'csr-generate',
    'toggleButton' => false,
    'clientEvents' => [
        'show.bs.modal' => new \yii\web\JsExpression("function (e) {
            if (e.namespace !== 'bs.modal') return true;
            $.get('{$url}?fqdn=' + e.relatedTarget.getAttribute('data-fqdn')).done(function (data) {
                $('#csr-modal .modal-body').html(data);
            });
        }"),
    ],
]) ?>
