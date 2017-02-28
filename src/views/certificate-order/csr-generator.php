<?php

/** @var \hipanel\modules\certificate\forms\CsrGeneratorForm $model */
/** @var array $countries */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('hipanel:certificate', 'Online CSR Generator');
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
//        var btn = $('#csr-generate-button').button('loading');
        var paramObj = {};
        $.each($(this).serializeArray(), function(_, kv) {
            paramObj[kv.name] = kv.value;
        });
        
        $('#csr-result').modal('show');
//        console.log(paramObj);
//        btn.button('reset');
    }
})
");
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-primary">
            <div class="box-header with-bord">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'CSR Generator form') ?></h3>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'csr-generator-form',
                'action' => '#',
            ]) ?>
            <div class="box-body">
                <?= $form->field($model, 'cn')->textInput(['name' => 'cn', 'placeholder' => 'https://'])->hint(Yii::t('hipanel:certificate', 'Domain to be secured by certificate')) ?>
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
                <?= Html::tag('h3', Yii::t('hipanel:certificate', 'Your CSR for {domain}', ['domain' => Html::tag('b', 'asdf.com')]), ['class' => 'text-center']) ?>
                <pre class="text-center">
-----BEGIN CERTIFICATE REQUEST-----
MIICzTCCAbUCAQAwgYcxCzAJBgNVBAYTAkFaMRAwDgYDVQQIDAdBbGFiYW1hMREw
DwYDVQQHDAhOZXcgWW9yazEMMAoGA1UECgwDT3dsMRAwDgYDVQQLDAdJUCBEZXB0
MREwDwYDVQQDDAhhc2RmLmNvbTEgMB4GCSqGSIb3DQEJARYRYW5kcnVzMjAwQHVr
ci5uZXQwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDpr1Lel2no3sQ5
PyQoAvuKnUXy8qAfSjDO8XjDOHGRHA2pqYmG7DBqz7+/NJJq/qnsBaXzf7FB2WRL
LW6YA6pYJNjr/kIUS2tO/9dlZjo3nEzx4rKNvchz126zj5zj86GDl+6AfxOKsHX6
f/Fw5ufMNTEe5X2LKjUXAHu+d/JZzZATyFh9OWjeOk+dIC//sQGoZ6aOn/JD3Gte
XU19+hfL6RrbQiAaC7kYyj5m/ft5iLFYuvEFFqtY/5Q7ghhwakoQpCnl/BRZoZ94
v2HtCo62RvLELQlisHE7aQiF9CACZR30F12wuVNc3tcMTP95VnhpeZUMqDsU3Ig7
sDlxZAgdAgMBAAGgADANBgkqhkiG9w0BAQQFAAOCAQEArrk4NaFkSsQvdgeuwJgm
2fj3glFGpP6w0pORThq7Ol6PiNMJgwdhijPooi112QKv4ujfoTxx3cs4utZS7H6l
obAVFKhUoNJEzH6DtmkqpFRMWXFFhU+FGzakF6GbMgpayXxnd88TknxpJeKLxKz/
xg20RCtN5Fhf7ZGz6pD6aYMskYp1DBYFrqM/T9kAfN8vOLsEmmmD/IA/A9EtSO6a
DQBm61oEsoMtz1tEuKqYXtyFpMf2mxkpFCfciM04s4e3q+7cmmN6xWjkzMZEZitR
ou6D+b6vxM2GAGSNZppmXhJhwoMclJ8ZeWHSbIxzEVF/1Z9DAS+aDzS3BzQqcFgC
UQ==
-----END CERTIFICATE REQUEST-----
                </pre>
                <hr>
                <?= Html::tag('h3', Yii::t('hipanel:certificate', 'Your Private Server Key'), ['class' => 'text-center']) ?>
                <pre class="text-center">
-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDpr1Lel2no3sQ5
PyQoAvuKnUXy8qAfSjDO8XjDOHGRHA2pqYmG7DBqz7+/NJJq/qnsBaXzf7FB2WRL
LW6YA6pYJNjr/kIUS2tO/9dlZjo3nEzx4rKNvchz126zj5zj86GDl+6AfxOKsHX6
f/Fw5ufMNTEe5X2LKjUXAHu+d/JZzZATyFh9OWjeOk+dIC//sQGoZ6aOn/JD3Gte
XU19+hfL6RrbQiAaC7kYyj5m/ft5iLFYuvEFFqtY/5Q7ghhwakoQpCnl/BRZoZ94
v2HtCo62RvLELQlisHE7aQiF9CACZR30F12wuVNc3tcMTP95VnhpeZUMqDsU3Ig7
sDlxZAgdAgMBAAECggEAVOYvk1MrVUFpxOqdtjOvM6MEAMoJRpTruqOcHkDpcbDh
fdxsbKpuxL+JiGwPLfQrw+Yhbp/bxHK4r19oKK5cOv3YGZUcaMcly2PD28ESMZYF
lnOoLzreEsgYHgB1HZQr/+U471I7xU1q74GANGaPnG9O00zJGcBR3XN9gauOTvVg
H9Lxk02gKDLxFtKhQdG+/TITeK5PYscrT5fkITKzYfGfUffCTfdW4q21pYGemMQF
5vGNp2WIcNrINwHndgCQe9rhFTPoyOB93uUgqbF2sxIoi73HMLAiHgcTH0HKKWCn
05w1Aitr8meSuWlUI7IVR8ZpL3dMRdM8nUrVKeXxgQKBgQD+gDTQ1/WVVQIvmLOP
6RWb4mETCyeAeP91V/Ae4t+Z2WjxL36LBp90DBAdv3Fh/hj9eSraTxzO/W3Vk4qc
JSbVTihctqj7VBSlqmOhK6lcdb4XrQknHz7ASr4lzQrfDp3dlR0i1em7QRDmxckU
0PFbQObRARLIi47MWOojAIhoTQKBgQDrD7n2lG+tioTmhO7Dm30BGu6MsFRL2TM1
/XJTCu9DeN2ajC9l9um74NT15G8H8R5j9KRnNcJMG4pAAJppvMfTrATrcINEEDln
pyWMFZYXQmVsDAp05CtHoqlIMa/Ybq8XCc0sW3ZPYqnzcohUZr3/yUBVEQ/euvBs
2sJG0OcHEQKBgQCKS+bnegNU473tWWByGmoIrIqty4jqslW3UVMFpal2NANn1LRC
HhY1/Hwhfi/B3U99JgPYX9c6z9KIlcVjtniUvwUF5KiM8pLJt36uTUiaGs1yli/8
F2mFGtibOAHpVksI5wfPL0j03ZWuodn0Otp9CRakip3HZrbxanvJC3gUnQKBgFvc
zYQ8Blj/5WhhUx5GydeAuvFoh8kMnSLgZalmgJMRzSj02CE1Gas+9nsSRwIHjSTr
GsTrEX/E04antbDVAhMLCvEoC2SyIn0LqXTRitKUNCbBneSItxFL1HROVrZyqyKJ
xhErvVTQ7jIh9H1nmaE4+VdFT7pvvD4OUBZ01ZTBAoGBAOa+QHe6LDYDO4x/aSI2
c0DDqJxaP0JIzqeb5e1zRpt2zW7bfAh1C2Jwb1A+KjdkSlwlbZcLZHlO11GKDTdw
aMKr8v03kTKRgCPuLZfs4YurskmyoRov5fVrqCRdAxrhCyfsZaIKzFEyzANIbFis
7YmsiD5Gzo5P0/phNxH0JQyg
-----END PRIVATE KEY-----
                    </pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal"><?= Yii::t('hipanel:certificate', 'Generate new CSR') ?></button>
                <button type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>
