<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use hipanel\helpers\Url;
use hipanel\modules\certificate\widgets\DVCMethod;

$form = ActiveForm::begin([
    'id' => 'issue-form',
    'enableAjaxValidation' => true,
    'action' => Url::toRoute('@certificate/change-validation'),
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]);

echo $form->field($model, 'id')->hiddenInput()->label(false);

echo DVCMethod::widget([
    'model' => $model,
    'form' => $form,
    'changeDVC' => true
]);

echo Html::submitButton(Yii::t('hipanel', 'Change'), ['class' => 'btn btn-success']);

$form->end();
