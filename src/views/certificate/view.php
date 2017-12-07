<?php

use hipanel\modules\certificate\grid\CertificateGridView;
use hipanel\modules\certificate\menus\CertificateDetailMenu;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;

$this->title = $model->name ?: $model->id;
$this->params['subtitle'] = Yii::t('hipanel:certificate', 'Certificate detailed information') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-3">
        <?php Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
            'bodyOptions' => [
                'class' => 'no-padding',
            ],
        ]); ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-shield fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-name"><?= $model->name ?: $model->id ?></span>
            <br>
            <span class="profile-user-name"><?= ClientSellerLink::widget(compact('model')) ?></span>
        </p>

        <div class="profile-usermenu">
            <?= CertificateDetailMenu::widget(['model' => $model]) ?>
        </div>
        <?php Box::end() ?>
    </div>

    <div class="col-md-9">
        <?php $box = Box::begin(['renderBody' => false]) ?>
            <?php $box->beginHeader() ?>
                <?= $box->renderTitle(Yii::t('hipanel:certificate', 'Certificate information')) ?>
            <?php $box->endHeader() ?>
            <?php $box->beginBody() ?>
                <?= CertificateGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => [
                        'id', 'seller_id', 'client_id',
                        'state', 'certificateType',
                        'name',
                        'begins', 'expires',
                    ],
                ]) ?>
            <?php $box->endBody() ?>
        <?php $box->end() ?>
    </div>
<?php
