<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2019, HiQDev (http://hiqdev.com/)
 */

use hipanel\helpers\Url;
use hipanel\modules\certificate\widgets\DCVMethod;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

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
    'changeDCV' => true,
]);

echo Html::submitButton(Yii::t('hipanel', 'Change'), ['class' => 'btn btn-success']);

$form->end();
