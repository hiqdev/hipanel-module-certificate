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
        <?= Yii::t('hipanel:certificate', 'In order to confirm domain ownership by this method, you will need to create a working DNS record in your domain') ?>. <?= Yii::t('hipanel:certificate', 'Make sure you can do this before choosing this method') ?>.
    </p>
</div>

<div class="method file">
    <p class="bg-warning" style="margin-top: 1em; padding: 1em;">
        <?= Yii::t('hipanel:certificate', 'In order to confirm domain ownership by this method, you will need to create a file on site') ?>. <?= Yii::t('hipanel:certificate', 'Make sure you can do this before choosing this method') ?>.
    </p>
</div>

<div class="method http">
    <p class="bg-warning" style="margin-top: 1em; padding: 1em;">
        <?= Yii::t('hipanel:certificate', 'In order to confirm domain ownership by this method, you will need to create a file on site') ?>. <?= Yii::t('hipanel:certificate', 'Make sure you can do this before choosing this method') ?>.
    </p>
</div>

<div class="method https">
    <p class="bg-warning" style="margin-top: 1em; padding: 1em;">
        <?= Yii::t('hipanel:certificate', 'In order to confirm domain ownership by this method, you will need to create a file on site') ?>. <?= Yii::t('hipanel:certificate', 'Make sure you can do this before choosing this method') ?>.
    </p>
</div>

