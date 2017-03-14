<?php

use hipanel\modules\certificate\widgets\CertificateOrderIndex;
use hipanel\modules\certificate\widgets\PreOrderQuestion;

$this->title = Yii::t('hipanel:certificate', 'Get certificate');
$this->params['breadcrumbs'][] = $this->title;

print PreOrderQuestion::widget();
print CertificateOrderIndex::widget(['models' => $models]);
