<?php

$this->title = Yii::t('hipanel:certificate', 'Reissue certificate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', $model->id), 'url' => ['@certificate/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_issueForm', compact('model', 'models')) ?>
