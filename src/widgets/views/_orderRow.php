<?php

/** @var \hipanel\modules\finance\models\CertificateResource $resource */

use hipanel\modules\certificate\models\CertificateType;
use yii\helpers\Html;

$features = implode(' ', $resource->certificateType->getFeatures());
$formatter = Yii::$app->formatter;

?>
<div class="info-box <?= $resource->certificateType->brand ?> <?= $features ?>"
     data-featuresCount="<?= count($resource->certificateType->getFeatures()) ?>">
                    <span class="info-box-icon">
                        <?php if ($resource->certificateType->logo) : ?>
                            <?= Html::img($resource->certificateType->logo) ?>
                        <?php else: ?>
                            <i class="fa fa fa-shield fa-fw"></i>
                        <?php endif; ?>
                    </span>
    <div class="info-box-content">
        <div class="sq"><b class="ca-name"><?= $resource->certificateType->name ?></b></div>
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
                                    <span class="ca-raw-price"
                                          style="display: none"><?= $resource->getPriceForPeriod(1) ?></span>
                    <span class="ca-price">
                                    <?= $formatter->asCurrency($resource->getPriceForPeriod(1), $resource->getCurrency()) ?>
                                    </span>
                    / <?= Yii::t('hipanel', 'year') ?>

                </a>
                <?= Html::a(Yii::t('hipanel:certificate', 'Order'), [
                    '@certificate/order/add-to-cart-order',
                    'product_id' => $resource->certificateType->id,
                ], ['class' => 'btn btn-success btn-flat']) ?>
            </div>
        </div>
    </div>
</div>
