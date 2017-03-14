<?php
use hipanel\modules\certificate\models\CertificateType;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-3 filters">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'SSL Products') ?></h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked filter-type filter" data-filter-group="type">
                    <?php foreach (CertificateType::types() as $key => $filter) : ?>
                        <li data-filter=".<?= $key ?>">
                            <b><?= $filter['label'] ?></b>
                            <div class="icheck pull-left" style="margin-right: 1rem">
                                <input type="checkbox" name="quux[2]" id="baz[2]">
                            </div>
                            <span><?= $filter['text'] ?></span>
                        </li>
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
                                <input type="checkbox" name="quux[2]" id="baz[2]">
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
            <div class="info-box-content header">
                <div class="sq"><?= Yii::t('hipanel:certificate', 'Certificate name') ?></div>
                <div class="sq text-center"><?= Yii::t('hipanel:certificate', 'Fit to') ?></div>
                <div class="sq text-center"><?= Yii::t('hipanel:certificate', 'Warranty') ?>
                    &nbsp;
                    <span class="label label-info"
                          data-toggle="popover"
                          title="<?= Yii::t('hipanel:certificate', 'Warranty') ?>"
                          data-content="<?= Yii::t('hipanel:certificate', 'This parameter indicates the amount that the Certification Authority guarantees to pay the end-user site, a secure SSL-certificate, in case of loss of their money. This amount will be paid if the money had been lost as a result of the issuance of a certificate for a non-existent company or a domain that does not belong to the user.') ?>"
                          data-trigger="hover"
                          data-placement="bottom"
                    >
                        <i class="fa fa-info"></i>
                    </span>
                </div>
                <div class="sq text-center"><?= Yii::t('hipanel:certificate', 'Price') ?></div>
            </div>
        </div>
        <div class="certificate-order">
            <?php foreach ($models as $model) : ?>
                <?php $type = $model->type; ?>
                <div class="info-box <?= $model->brand ?> <?= $type ?>">
                    <span class="info-box-icon">
                        <?php if ($model->logo) : ?>
                            <?= Html::img($model->logo) ?>
                        <?php else: ?>
                            <i class="fa fa fa-shield fa-fw"></i>
                        <?php endif; ?>
                    </span>
                    <div class="info-box-content">
                        <div class="sq"><a href="#"><b><?= $model->name ?></b></a></div>
                        <div class="sq hidden-xs text-center">
                            <ul class="list-unstyled">
                                <li>Крупный интернет-магазин</li>
                                <li>Финансовая организация</li>
                            </ul>
                        </div>
                        <div class="sq hidden-xs text-center">$1,750,000</div>
                        <div class="sq text-center">
                            <div class="btn-group">
                                <a class="btn btn-default btn-flat text-bold disabled cert-price-btn">
                                    46 400 грн. / год
                                </a>
                                <a class="btn btn-success btn-flat cert-make-order" data-product-id="<?= $model->id ?>">
                                    <i class="fa fa-cart-plus"></i>&nbsp;&nbsp;
                                    <?= Yii::t('hipanel:certificate', 'Order') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
