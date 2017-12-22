<?php

use hipanel\helpers\Url;
use hipanel\modules\certificate\grid\CertificateGridView;
use hipanel\modules\certificate\menus\CertificateDetailMenu;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use yii\helpers\Html;

$this->title = $model->name;
$this->params['subtitle'] = Yii::t('hipanel:certificate', 'Certificate detailed information') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$getCertificateDataUrl = Url::to(['@certificate/get-data', 'id' => $model->id]);
$this->registerJs("
    $('#get-certificate-data-button').one('click', function(event) {
        var btn = $(event.target)
        btn.button('loading');
        $.get('{$getCertificateDataUrl}').done(function (resp) {
            $('#certificate-data').html(resp);
        });
    });
");

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
                'id',
                'seller_id',
                'client_id',
                'state',
                'certificateType',
                'alt_name',
                'begins',
                'expires',
            ],
        ]) ?>
        <?php $box->endBody() ?>
        <?php $box->end() ?>

        <?php if ($model->isActive()) : ?>
            <div class="box box-widget">
                <div id="certificate-data" class="box-body">
                    <p class="text-center" style="padding: 25px;">
                        <?= Html::button('<i class="fa fa-arrow-circle-down fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;' . Yii::t('hipanel:certificate', 'Get certificate data'), [
                            'id' => 'get-certificate-data-button',
                            'class' => 'btn btn-success',
                            'data' => [
                                'loading-text' => Yii::t('hipanel:certificate', 'Loading certificate data...'),
                            ],
                        ]) ?>
                    </p>
                </div>
            </div>
        <?php endif ?>
    </div>
<?php
