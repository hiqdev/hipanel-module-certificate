<?php

/** @var \hipanel\modules\certificate\forms\OrderForm $model */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'id' => 'order-form',
]) ?>

<?= $form->field($model, 'csr')->textarea(['rows' => 7]) ?>
<?= $form->field($model, 'email') ?>
<?= Html::activeHiddenInput($model, 'productId') ?>
<?= Html::submitButton(Yii::t('hipanel:certificate', 'Order'), ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end() ?>
