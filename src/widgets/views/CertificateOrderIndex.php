<?php

/** @var array $resources */
/** @var array $brands */
/** @var array $secureProductFeatures */

/** @var array $amountProductFeatures */
?>
<div class="row">
    <div class="col-md-3 filters">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'SSL Products') ?></h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked filter-type filter" data-filter-group="secureType">
                    <?php foreach ($secureProductFeatures as $key => $filter) : ?>
                        <li data-filter=".<?= $key ?>">
                            <b><?= $filter['label'] ?></b>
                            <div class="icheck pull-left" style="margin-right: 1rem">
                                <input type="checkbox" name="<?= $key ?>">
                            </div>
                            <span><?= $filter['text'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'SSL Features') ?></h3>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-pills nav-stacked filter-type filter" data-filter-group="amountType">
                    <?php foreach ($amountProductFeatures as $key => $filter) : ?>
                        <li data-filter=".<?= $key ?>">
                            <b><?= $filter['label'] ?></b>
                            <div class="icheck pull-left" style="margin-right: 1rem">
                                <input type="checkbox" name="<?= $key ?>">
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
                    <?php foreach ($brands as $key => $brand) : ?>
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
                <?= $this->render('_orderRow', compact('resource')) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
