<?php

$this->title = Yii::t('hipanel:certificate', 'Reissue');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', $model->name), 'url' => ['@certificate/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_reissueForm', compact('model', 'models')) ?>
