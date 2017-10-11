<?php
use hipanel\modules\client\widgets\combo\ClientCombo;
use hiqdev\combo\StaticCombo;

?>

<?php if (Yii::$app->user->can('support')) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('client_id')->widget(ClientCombo::class, ['formElementSelector' => '.form-group']) ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('seller_id')->widget(ClientCombo::class, ['formElementSelector' => '.form-group']) ?>
    </div>
<?php endif ?>
