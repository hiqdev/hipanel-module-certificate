<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\DateTimePicker;

/**
 * @var \hipanel\widgets\AdvancedSearch $search
 * @var array $typeOptions
 * @var array $stateOptions
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('name_ilike') ?>
</div>

<?php if (Yii::$app->user->can('support')) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('client_id')->widget(ClientCombo::class, ['formElementSelector' => '.form-group']) ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('seller_id')->widget(ClientCombo::class, ['formElementSelector' => '.form-group']) ?>
    </div>
<?php endif ?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('type')->dropDownList($typeOptions, ['prompt' => '--']) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('state_in')->dropDownList($stateOptions, ['prompt' => '--']) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
        <?= DateTimePicker::widget([
            'model' => $search->model,
            'attribute' => 'expires',
            'options' => [
                'placeholder' => $search->model->getAttributeLabel('expires'),
            ],
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'minView' => 2,
            ],
        ]) ?>
    </div>
</div>
