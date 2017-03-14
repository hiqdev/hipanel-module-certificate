<?php
/** @var \hipanel\modules\certificate\forms\OrderForm $model */

$this->title = Yii::t('hipanel:certificate', 'Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', 'Get certificate'), 'url' => ['@certificate/order/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box">
            <div class="box-body">
                <?= $this->render('_orderForm', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>
