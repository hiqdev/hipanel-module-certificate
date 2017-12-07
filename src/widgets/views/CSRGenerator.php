<?php

/** @var \hipanel\modules\certificate\forms\CsrGeneratorForm $model */
/** @var array $countries */

/** @var string $orderUrl */

use yii\base\DynamicModel;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use hipanel\modules\client\widgets\combo\ContactCombo;

$loadingText = Yii::t('hipanel', 'Loadding');
$this->registerJs("

// Form
var CSRForm = $('#csr-generator-form');
CSRForm.on('beforeSubmit', function(event) {
    event.preventDefault();
    var btn = $('#csr-generate-button');
    jQuery.ajax({
        url: CSRForm.attr('action'),
        type: CSRForm.attr('method'),
        data: new FormData(document.getElementById('csr-generator-form')),
        mimeType: 'multipart/form-data',
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            btn.button('loading');
            CSRForm.find(':input').attr('disabled', true);
        },
        complete: function () {
            btn.button('reset');
            CSRForm.find(':input').attr('disabled', false);
        },
        success: function (data) {
            if (data.status == 'success') {
                $('#csr-form-container').remove();
                $('#csr-result-container').show();
                $('#csr_code').text(data.csr.csr_code);
                $('#csr_key').text(data.csr.csr_key);
            } else {
                hipanel.notify.error(data.message);
            }
        }
    });
    
    return false;
});

// Contacts autocomplete
$('#contact-combo').on('select2:select select2:unselect', function (e) {
    var data = e.params.data;
    var formFields = {
        'csr_organization': data.organization ? data.organization : data.name, 
        'csr_department': 'IT Dep.', 
        'csr_city': data.city, 
        'csr_state': data.province, 
        'csr_country': data.country.toUpperCase(), 
        'csr_email': data.email
    };
    for (var field in formFields) {
        if (e.type == 'select2:unselect') {
            $(':input[name=\"CsrGeneratorForm[' + field + ']\"]').val('');
        } else {
            $(':input[name=\"CsrGeneratorForm[' + field + ']\"]').val(formFields[field]);
        }
    }
});


");
?>
<div id="csr-form-container">
    <div class="form-group">
        <?= Html::tag('label', Yii::t('hipanel:certificate', 'You can choose a contact to autocomplete form fields')) ?>
        <?= ContactCombo::widget([
            'inputOptions' => ['id' => 'contact-combo'],
            'model' => new DynamicModel(['id' => null]),
            'attribute' => 'id',
            'hasId' => true,
            'formElementSelector' => 'div',
            'filter' => [
                'client_id_in' => ['format' => Yii::$app->user->id],
            ],
            'pluginOptions' => [
                'select2Options' => [
                ],
            ],
            'return' => ['id', 'name', 'email', 'organization', 'city', 'province', 'country'],
        ]) ?>
        <p class="help-block">
            <?= Yii::t('hipanel:certificate', 'Or fill in the fields manually.') ?>
            <?= Yii::t('hipanel:certificate', 'Also, you can {create_new_contact} and select it for autocomplete.', ['create_new_contact' => Html::a(Yii::t('hipanel:certificate', 'create a new contact'), ['@contact/create'], ['target' => '_blank'])]) ?>
        </p>
    </div>

    <hr>

    <?php $form = ActiveForm::begin([
        'id' => 'csr-generator-form',
        'action' => Url::to($requestUrl),
    ]) ?>

    <?= Html::activeHiddenInput($model, 'client') ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'csr_commonname')->textInput(['readonly' => !empty($model->csr_commonname)])->hint(Yii::t('hipanel:certificate', 'The fully qualified domain name (FQDN) of your server. This must match exactly what you type in your web browser or you will receive a name mismatch error.')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'csr_organization')->hint(Yii::t('hipanel:certificate', 'The legal name of your organization.')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'csr_department')->hint(Yii::t('hipanel:certificate', 'The division of your organization handling the certificate.')) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'csr_city')->hint(Yii::t('hipanel:certificate', 'The city where your organization is located.')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'csr_state')->hint(Yii::t('hipanel:certificate', 'The state/region/province where your organization is located.')) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6">
            <?= $form->field($model, 'csr_country')->dropDownList($countries, ['prompt' => '--'])->hint(Yii::t('hipanel:certificate', 'Business Location - Country.')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'csr_email')->hint(Yii::t('hipanel:certificate', 'An email address used to contact your organization.')) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <?= $form->field($model, 'copy_to_email')->checkbox()->hint(Yii::t('hipanel:certificate', 'Send me CSR and Private Key')) ?>
        </div>
    </div>
    <hr>
    <?= Html::submitButton(Yii::t('hipanel:certificate', 'Generate CSR'), [
        'id' => 'csr-generate-button',
        'class' => 'btn btn-success ',
        'data' => [
            'loading-text' => Yii::t('hipanel:certificate', 'Generating...'),
        ],
    ]) ?>
    <?php $form->end() ?>
</div>

<div id="csr-result-container" style="display: none;">
    <pre id="csr_code" class="text-center"></pre>
    <pre id="csr_key" class="text-center"></pre>
</div>
