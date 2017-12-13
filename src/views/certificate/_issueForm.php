<?php

use hipanel\helpers\Url;
use hipanel\modules\certificate\widgets\CSRButton;
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
                    <?php if ($model->name) : ?>
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= $model->name ?></h3>
                        </div>
                    <?php endif ?>
                    <div class="box-body">
                        <?= Html::activeHiddenInput($model, 'id') ?>

                        <?php if ($model->needsDnsNames()) : ?>
                            <?= $form->field($model, 'dns_names') ?>
                        <?php endif ?>

                        <?= $form->field($model, 'dcv_method')->dropDownList($model->dcvMethodOptions()) ?>

                        <?= $form->field($model, 'approver_email') ?>

                        <?php if ($model->scenario !== 'reissue') : ?>
                            <?= $form->field($model, 'admin_id')->widget(ContactCombo::class, ['hasId' => true]) ?>
                            <?= $form->field($model, 'tech_id')->widget(ContactCombo::class, ['hasId' => true]) ?>
                            <?= $form->field($model, 'org_id')->widget(ContactCombo::class, ['hasId' => true]) ?>
                        <?php endif ?>

                        <?= $form->field($model, 'csr')->textarea(['rows' => 5]) ?>
                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between">
                <div>
                    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
                    &nbsp;
                    <?= Html::button(Yii::t('hipanel', 'Cancel'), [
                        'class' => 'btn btn-default',
                        'onclick' => 'history.go(-1)',
                    ]) ?>
                </div>
                <div>
                    <?= CSRButton::widget(compact('model')) ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php $form->end() ?>
