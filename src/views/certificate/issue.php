<?php

/** @var array $approverEmails */

$this->title = Yii::t('hipanel:certificate', 'Issue certificate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', $model->certificateType->name), 'url' => ['@certificate/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_issueForm', compact('model', 'models', 'webserverTypes')) ?>
