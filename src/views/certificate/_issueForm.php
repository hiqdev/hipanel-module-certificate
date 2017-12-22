<?php

/** @var array $approverEmails */

use hipanel\helpers\Url;
use hipanel\modules\certificate\grid\CertificateGridView;
use hipanel\modules\certificate\widgets\CSRButton;
use hipanel\modules\client\widgets\combo\ContactCombo;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'issue-form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]);
$getApproverEmailsUrl = Url::to(['@certificate/get-approver-emails']);
$this->registerCss('.method { display: none; }');
$this->registerJs(<<<heredoc
    $(document).on('change', '#certificate-csr', function(e) {
        var dropdown = $("#certificate-approver_email");
        var csr = e.target.value;
        dropdown.find('option').remove().end().append($('<option />').val(null).text('--'));
        if (document.getElementById('certificate-dcv_method').value === 'email') {
            $.post('{$getApproverEmailsUrl}', {'csr': csr}).done(function(data) {
                if (data.success == true) {
                    hipanel.notify.success(data.message);    
                    $.each(data.emails, function() {
                        dropdown.append($('<option />').val(this).text(this));
                    });
                    dropdown.removeAttr('readonly');
                } else {
                    hipanel.notify.error(data.message);    
                    dropdown.attr({readonly: true});
                }  
            });
        }
    });   
    $('#{$form->id}').submit(function () {
        $('#select-csr .btn-success').click();
    });

    // DCV
    showDCVInfo(document.getElementById('certificate-dcv_method').value);
    
    $('#{$form->id} #certificate-dcv_method').on('change', function (event) {
        var state = event.target.value;
        showDCVInfo(state);
    });
    
    function showDCVInfo(state) {
        $('.method').each(function(index, value) {
            if ($(value).hasClass(state)) {
                $(value).show();
            } else {
                $(value).hide();
            }
        });
    }
heredoc
);

?>

<div class="container-items">
    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <?= CertificateGridView::detailView([
                'boxed' => true,
                'boxOptions' => ['bodyOptions' => ['class' => 'no-padding']],
                'model' => $model,
                'columns' => [
                    'id',
                    'seller_id',
                    'client_id',
                    'state',
                    'certificateType',
                ],
            ]) ?>
        </div>
        <div class="col-sm-6 col-xs-12">
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

                        <?php if ($model->scenario !== 'reissue') : ?>
                            <?= $form->field($model, 'admin_id')->widget(ContactCombo::class, ['hasId' => true]) ?>
                            <?= $form->field($model, 'tech_id')->widget(ContactCombo::class, ['hasId' => true]) ?>
                            <?= $form->field($model, 'org_id')->widget(ContactCombo::class, ['hasId' => true]) ?>
                        <?php endif ?>

                        <?= $form->field($model, 'webserver_type')->dropDownList($model->webserverTypeOptions, [
                            'options' => [(function ($model) {
                                foreach ($model->webserverTypeOptions as $k => $v) {
                                    if ($v === 'Nginx') return $k;
                                }
                            })($model) => ['selected' => true]],
                        ])->hint(Yii::t('hipanel:certificate', 'If you are not sure which type of web server suits you, leave Nginx or Other')) ?>
                        <div class="csr-wrap tab-content">
                            <div id="select-csr" class="tab-pane active">
                                <div class="well" style="display: flex; justify-content: space-around">
                                    <?= Html::button(Yii::t('hipanel:certificate', 'I already have CSR'), [
                                        'class' => 'btn btn-success',
                                        'data' => [
                                            'target' => '#input-csr',
                                            'toggle' => 'tab',
                                        ],
                                    ]) ?>
                                    <?= CSRButton::widget(compact('model')) ?>
                                </div>
                            </div>
                            <div id="input-csr" class="tab-pane">
                                <?= CSRButton::widget([
                                    'model' => $model,
                                    'buttonOptions' => [
                                        'class' => 'btn btn-xs btn-warning pull-right',
                                    ],
                                ]) ?>
                                <?= $form->field($model, 'csr')->textarea(['rows' => 5]) ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'dcv_method')->dropDownList($model->dcvMethodOptions(), [
                            'options' => ['email' => ['selected' => true]],
                        ]) ?>

                        <div class="method email">
                            <p class="bg-warning" style="margin-top: 1em; padding: 1em;"><?= Yii::t('hipanel:certificate', 'In order to select an "Approver Email", you first need to fill in the csr field.') ?></p>
                            <?= $form->field($model, 'approver_email')->dropDownList([], [
                                'prompt' => '--',
                                'readonly' => true,
                            ])->hint(Yii::t('hipanel:certificate', 'An Approver Email address will be used during the order process of a Domain Validated SSL Certificate. An email requesting approval will be sent to the designated Approver Email address.')) ?>
                        </div>

                        <div class="method dns">
                            <p class="bg-warning" style="margin-top: 1em; padding: 1em;">
                                <?= Yii::t('hipanel:certificate', 'In order to confirm domain ownership by this method, you will need to create a working DNS record in your domain. Make sure you can do this before choosing this method.') ?>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between">
                <div>
                    <?= Html::submitButton($model->scenario === 'issue' ? Yii::t('hipanel:certificate', 'Issue certificate') : Yii::t('hipanel:certificate', 'Reissue certificate'), ['class' => 'btn btn-success']) ?>
                    &nbsp;
                    <?= Html::button(Yii::t('hipanel', 'Cancel'), [
                        'class' => 'btn btn-default',
                        'onclick' => 'history.go(-1)',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php $form->end() ?>
