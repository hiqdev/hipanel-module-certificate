<?php

use hipanel\modules\certificate\models\CertificateType;
use yii\helpers\Html;

$formatter = Yii::$app->formatter;
$secureKeys = ['dv', 'ov', 'ev'];
$amountKeys = ['cs', 'san', 'wc'];

$this->registerCss('
.ca-sort-link:after {
    font: normal normal normal 11px/1 FontAwesome;
    content: " \f0dc";
}
.ca-sort-link[data-direction=asc]:after {
    font: normal normal normal 11px/1 FontAwesome;
    content: " \f160";
}
.ca-sort-link[data-direction=desc]:after {
    font: normal normal normal 11px/1 FontAwesome;
    content: " \f161";
}
');

?>
<div class="row">
    <div class="col-md-3 filters">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'SSL Products') ?></h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked filter-type filter" data-filter-group="secureType">
                    <?php foreach (CertificateType::features() as $key => $filter) : ?>
                        <?php if (in_array($key, $secureKeys)) : ?>
                            <li data-filter=".<?= $key ?>">
                                <b><?= $filter['label'] ?></b>
                                <div class="icheck pull-left" style="margin-right: 1rem">
                                    <input type="checkbox" name="<?= $key ?>">
                                </div>
                                <span><?= $filter['text'] ?></span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="box-footer no-padding" style="border-width: 7px;">
                <ul class="nav nav-pills nav-stacked filter-type filter" data-filter-group="amountType">
                    <?php foreach (CertificateType::features() as $key => $filter) : ?>
                        <?php if (in_array($key, $amountKeys)) : ?>
                            <li data-filter=".<?= $key ?>">
                                <b><?= $filter['label'] ?></b>
                                <div class="icheck pull-left" style="margin-right: 1rem">
                                    <input type="checkbox" name="<?= $key ?>">
                                </div>
                                <span><?= $filter['text'] ?></span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'SSL Brands') ?></h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked filter-brand filter" data-filter-group="brand">
                    <?php foreach (CertificateType::brands() as $key => $brand) : ?>
                        <li data-filter=".<?= $key ?>">
                            <b><?= $brand['label'] ?></b>
                            <div class="icheck pull-left" style="margin-right: 1rem">
                                <input type="checkbox" name="<?= $key ?>">
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div id="filter-display" style="display: none"></div>
        <div class="info-box hidden-xs">
            <div class="info-box-content header ca-header">
                <div class="sq">
                    <a href="#" class="ca-sort-link" data-sort-value="name">
                        <?= Yii::t('hipanel:certificate', 'Certificate name') ?>
                    </a>
                </div>
                <div class="sq text-center">
                    <a href="#" class="ca-sort-link" data-sort-value="fc">
                        <?= Yii::t('hipanel:certificate', 'Features') ?>
                    </a>
                </div>
                <div class="sq text-center">
                    <a href="#" class="ca-sort-link" data-sort-value="price">
                        <?= Yii::t('hipanel:certificate', 'Price') ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="certificate-order">
            <?php foreach ($resources as $resource) : ?>
                <?php $type = $resource->certificateType ?>
                <?php $features = implode(' ', $type->getFeatures()) ?>
                <div class="info-box <?= $type->brand ?> <?= $features ?>"
                     data-featuresCount="<?= count($type->getFeatures()) ?>">
                    <span class="info-box-icon">
                        <?php if ($type->logo) : ?>
                            <?= Html::img($type->logo) ?>
                        <?php else: ?>
                            <i class="fa fa fa-shield fa-fw"></i>
                        <?php endif; ?>
                    </span>
                    <div class="info-box-content">
                        <div class="sq"><a href="#"><b class="ca-name"><?= $type->name ?></b></a></div>
                        <div class="sq hidden-xs text-center">
                            <ul class="list-unstyled">
                                <?php foreach (explode(' ', $features) as $feature) : ?>
                                    <li>
                                        <span class="label label-info"><?= CertificateType::features()[$feature]['label'] ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="sq text-center">
                            <div class="btn-group">
                                <a class="btn btn-default btn-flat text-bold disabled cert-price-btn">
                                    <span class="ca-price">
                                    <?= $formatter->asCurrency($resource->getPriceForPeriod(1), $resource->getCurrency()) ?>
                                    </span>
                                    / <?= Yii::t('hipanel', 'year') ?>

                                </a>
                                <?= Html::a(Yii::t('hipanel:certificate', 'Order'), ['@certificate/order/add-to-cart-order', 'product_id' => $type->id], ['class' => 'btn btn-success btn-flat']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
