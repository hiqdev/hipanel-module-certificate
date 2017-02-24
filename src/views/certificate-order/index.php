<?php

use yii\helpers\Html;

$this->title = Yii::t('hipanel:certificate', 'Get certificate');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("$('[data-toggle=\"popover\"]').popover();");
$this->registerCss(".popover {width: 300px;}");

?>
<div class="row">
    <div class="col-md-3 filters">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'SSL Products') ?></h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked" data-filter-group="status">
                    <li class="active">
                        <a href="#" data-filter=""><?= Yii::t('hipanel:certificate', 'All') ?></a>
                    </li>
                    <?php foreach (\hipanel\modules\certificate\models\CertificateType::types() as $key => $filter) : ?>
                        <li>
                            <a href="#" class="">
                                <b><?= $filter['label'] ?></b>
                                <span class="label label-info">
                                    <i class="fa fa-info"></i>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'SSL Products') ?></h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked" data-filter-group="status">
                    <li class="active">
                        <a href="#" data-filter=""><?= Yii::t('hipanel:certificate', 'All') ?></a>
                    </li>
                    <?php foreach (\hipanel\modules\certificate\models\CertificateType::types() as $key => $filter) : ?>
                        <li>
                            <a href="#" class="">
                                <b><?= $filter['label'] ?></b>
                                <span class="label label-info">
                                    <i class="fa fa-info"></i>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <?php foreach ($models as $model) : ?>
            <div class="info-box">
                <span class="info-box-icon">
                    <img src="https://cdn.ukrnames.com/theme/images/ssl-vendors/comodo_vendor.png" alt="">
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"><?= $model->name ?></span>
                    <span class="info-box-number">5,200</span>
                    <span class="progress-description">
                        50% Increase in 30 Days
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        <?php endforeach; ?>
    </div>
</div>

