<?php

use yii\grid\GridView;

$this->title = Yii::t('hipanel:certificate', 'Get certificate');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
    ],
]) ?>
