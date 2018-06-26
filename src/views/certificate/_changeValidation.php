<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use hipanel\helpers\Url;
use hipanel\modules\certificate\widgets\DCVMethod;

$form = ActiveForm::begin([
    'id' => 'issue-form',
    'enableAjaxValidation' => true,
    'action' => Url::toRoute('@certificate/change-validation'),
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]);

echo $form->field($model, 'id')->hiddenInput()->label(false);

echo DCVMethod::widget([
    'model' => $model,
    'form' => $form,
    'changeDCV' => true
]);

echo Html::submitButton(Yii::t('hipanel', 'Change'), ['class' => 'btn btn-success']);

$form->end();
