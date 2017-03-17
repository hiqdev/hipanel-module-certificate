<?php

use hipanel\modules\certificate\grid\CertificateGridView;
use hipanel\modules\certificate\menus\CertificateBulkActionsMenu;
use hipanel\widgets\IndexPage;

$this->title = Yii::t('hipanel:certificate', 'My Certificates');
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

    <?= $page->setSearchFormData() ?>

    <?php $page->beginContent('show-actions') ?>
        <?= $page->renderLayoutSwitcher() ?>
        <?= $page->renderSorter([
            'attributes' => [],
        ]) ?>
        <?= $page->renderPerPage() ?>
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
                    'id',
                ],
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>

