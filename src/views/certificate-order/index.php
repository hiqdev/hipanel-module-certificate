<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2019, HiQDev (http://hiqdev.com/)
 */

use hipanel\modules\certificate\widgets\CertificateOrderIndex;

$this->title = Yii::t('hipanel:certificate', 'Get certificate');
$this->params['breadcrumbs'][] = $this->title;

echo CertificateOrderIndex::widget(['resources' => $resources]);
