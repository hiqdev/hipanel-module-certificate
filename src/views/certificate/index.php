<?php

use hipanel\modules\certificate\grid\CertificateGridView;
use hipanel\modules\certificate\menus\CertificateBulkActionsMenu;
use hipanel\modules\certificate\widgets\CSRButton;
use hipanel\widgets\IndexPage;
use yii\bootstrap\Html;

$this->title = Yii::t('hipanel:certificate', 'Certificates');
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

    <?= $page->setSearchFormData(compact('stateOptions', 'typeOptions')) ?>

    <?php $page->beginContent('main-actions') ?>
        <?php if (Yii::$app->user->can('certificate.pay') && Yii::$app->user->can('test.beta')) : ?>
            <?= Html::a(Yii::t('hipanel:certificate', 'Buy certificate'), ['@certificate/order/index'], ['class' => 'btn btn-sm btn-success']) ?>
        <?php endif; ?>
        <?= CSRButton::widget(['buttonOptions' => ['class' => 'btn btn-sm btn-default'], 'tagName' => 'a']) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => ['id', 'remoteid'],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?= CertificateBulkActionsMenu::widget([], [
            'encodeLabels' => false,
            'itemOptions' => [
                'tag' => false,
            ],
        ]) ?>
    <?php $page->endContent('bulk-actions') ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= CertificateGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel' => $model,
                'columns' => [
                    'checkbox',
                    'certificateType', 'name',
                    'actions',
                    'client_like', 'seller',
                    'state', 'expires',
                ],
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>

