<?php

/** @var \hipanel\modules\certificate\forms\CsrGeneratorForm $model */
/** @var array $countries */
/** @var string $orderUrl */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

\hipanel\modules\certificate\CsrGeneratorAsset::register($this);

$csr = '-----BEGIN CERTIFICATE REQUEST-----';

$this->title = Yii::t('hipanel:certificate', 'Generate new CSR and Private Key');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', 'Get certificate'), 'url' => ['@certificate/order/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("

$('#csr-generator-form').on('beforeSubmit', function(event) {
    event.preventDefault();
    
    return false;
});

$('#csr-generator-form').on('afterValidate', function(event, messages, errorAttributes) {
    var form = $(this);
    if (form.find('.has-error').length === 0) {
        var btn = $('#csr-generate-button').button('loading');
        var paramObj = {};
        $.each($(this).serializeArray(), function(_, kv) {
            paramObj[kv.name] = kv.value;
        });
        console.log(paramObj); // todo remove
        $('#csr-result').modal('show');
        $('#csr-result').on('shown.bs.modal', function(e) {
            var email = $('#csrgeneratorform-email').val();
            var productId = '{$model->productId}';
            if (productId) {
                var orderUrl = '{$orderUrl}' + '&email=' + email;
                $.get(orderUrl).done(function(data) {
                    $('#csr-result .modal-body').html(data);
                    $('#orderform-csr').val(genCsr());
                    btn.button('reset');
                });
            }
        });
    }
});

function genCsr() {
    return '{$csr}';
}
");
?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-solid">
            <?php $form = ActiveForm::begin([
                'id' => 'csr-generator-form',
                'action' => '#',
            ]) ?>
            <div class="box-body">
                <?= $form->field($model, 'cn')->textInput(['name' => 'cn'])->hint(Yii::t('hipanel:certificate', 'Domain to be secured by certificate')) ?>
                <?= $form->field($model, 'o')->textInput(['name' => 'o'])->hint(Yii::t('hipanel:certificate', 'Organization’s legal business name.')) ?>
                <?= $form->field($model, 'ou')->textInput(['name' => 'ou'])->hint(Yii::t('hipanel:certificate', 'Organization’s legal business name. Like: IT Dept')) ?>
                <?= $form->field($model, 'l')->textInput(['name' => 'l'])->hint(Yii::t('hipanel:certificate', 'Business Location - City. Ex.: New York')) ?>
                <?= $form->field($model, 'st')->textInput(['name' => 'st'])->hint(Yii::t('hipanel:certificate', 'Business Location - State/Province. Ex.: Alabama/None')) ?>
                <?= $form->field($model, 'email')->textInput(['name' => 'email']) ?>
                <?= $form->field($model, 'c')->textInput(['name' => 'c'])->dropDownList($countries, ['prompt' => '--'])->hint(Yii::t('hipanel:certificate', 'Business Location - Country')) ?>
            </div>
            <div class="box-footer">
                <?= Html::submitButton(Yii::t('hipanel:certificate', 'Generate CSR'), ['id' => 'csr-generate-button', 'class' => 'btn btn-success ']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

<div id="csr-result" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?= Yii::t('hipanel:certificate', 'Your CSR and Private Server Key') ?></h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
