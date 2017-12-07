<?php

use hipanel\helpers\Url;
use hipanel\modules\certificate\widgets\CSRInput;
use hipanel\modules\client\widgets\combo\ContactCombo;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'issue-form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]);

?>

<div class="container-items">
    <div class="row">
        <div class="col-md-4">
            <div class="item">
                <div class="box box-widget">
                    <div class="box-body">
                        <?= Html::activeHiddenInput($model, 'id') ?>

                        <?= $form->field($model, "dns_names") ?>

                        <?= $form->field($model, "approver_email") ?>

                        <?= $form->field($model, "approver_emails") ?>

                        <?= $form->field($model, 'admin_id')->widget(ContactCombo::class, ['hasId' => true]) ?>

                        <?= $form->field($model, 'tech_id')->widget(ContactCombo::class, ['hasId' => true]) ?>

                        <?= $form->field($model, 'org_id')->widget(ContactCombo::class, ['hasId' => true]) ?>

                        <?= $form->field($model, 'dcv_method')->dropDownList($model->dcvMethodOptions()) ?>

                        <?= $form->field($model, "csr")->widget(CSRInput::class) ?>
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
