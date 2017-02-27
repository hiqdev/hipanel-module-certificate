<?php

use hipanel\assets\IsotopeAsset;
use hipanel\modules\certificate\Asset;
use hipanel\modules\certificate\models\CertificateType;
use yii\helpers\Html;
use yii\web\View;

Asset::register($this);
IsotopeAsset::register($this);

$this->title = Yii::t('hipanel:certificate', 'Get certificate');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
    $('[data-toggle=\"popover\"]').popover();
    
    // init Isotope
    var grid = $('.certificate-order').isotope({
        itemSelector: '.info-box',
        layout: 'vertical',
        isInitLayout: false
    });
    grid.isotope();
    var filters = {};
    var filterDisplay = $('#filter-display');
    
    $('.filter').on( 'click', 'a, button', function( event ) {
        var target = $( event.currentTarget );
        target.toggleClass('active');
        var isChecked = target.hasClass('active');
        var group = target.parents('.filter').attr('data-filter-group');
        var filterGroup = filters[ group ];
        var filter = target.attr('data-filter');
        if ( !filterGroup ) {
            filterGroup = filters[ group ] = [];
        }
        
        // add/remove filter
        if ( isChecked ) {
            // add filter
            filterGroup.push( filter );
        } else {
            // remove filter
            var index = filterGroup.indexOf( filter );
            filterGroup.splice( index, 1 );
        }
        
        var comboFilter = getComboFilter();
        grid.isotope({ filter: comboFilter });
        filterDisplay.text( comboFilter );
    });
    
    function getComboFilter() {
        var combo = [];
        for ( var prop in filters ) {
            var group = filters[ prop ];
            if ( !group.length ) {
                // no filters in group, carry on
                continue;
            }
            // add first group
            if ( !combo.length ) {
                combo = group.slice(0);
                continue;
            }
            // add additional groups
            var nextCombo = [];
            // split group into combo: [ A, B ] & [ 1, 2 ] => [ A1, A2, B1, B2 ]
            for ( var i=0; i < combo.length; i++ ) {
                for ( var j=0; j < group.length; j++ ) {
                    var item = combo[i] + group[j];
                    nextCombo.push( item );
                }
            }
            combo = nextCombo;
        }
        var comboFilter = combo.join(', ');
        return comboFilter;
    }
    
    
    
", View::POS_END);
$this->registerCss(".popover {width: 300px;}");

?>
<div class="row">
    <div class="col-md-3 filters">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'SSL Products') ?></h3>
            </div>
            <div class="box-body no-padding">
                <div class="btn-group type-buttons filter-type filter" data-filter-group="type">
                    <?php foreach (CertificateType::types() as $key => $filter) : ?>
                        <button data-filter=".<?= $key ?>">
                            <b><?= $filter['label'] ?></b>
                            <span><?= $filter['text'] ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:certificate', 'SSL Brands') ?></h3>
            </div>
            <div class="box-body no-padding">
                <div class="btn-group type-buttons filter-brand filter" data-filter-group="brand">
                    <?php foreach (CertificateType::brands() as $key => $brand) : ?>
                        <button data-filter=".<?= $key ?>">
                            <b><?= $brand['label'] ?></b>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div id="filter-display" style="display: none"></div>
        <div class="info-box hidden-xs">
            <div class="info-box-content header">
                <div class="sq"><?= Yii::t('hipanel:certificate', 'Название сертификата') ?></div>
                <div class="sq text-center">Подходит для</div>
                <div class="sq text-center">Гарантия&nbsp;&nbsp;<span class="label label-info"><i class="fa fa-info"></i></span></div>
                <div class="sq text-center">Стоимость сертификата</div>
            </div>
        </div>
        <div class="certificate-order">
            <?php foreach ($models as $model) : ?>
                <?php $type = $model->type; ?>
                <div class="info-box <?= $model->brand ?> <?= $type ?>">
                    <span class="info-box-icon">
                        <?= Html::img($model->logo) ?>
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
                            <span class="price">46 400 грн. / год</span>
                            &nbsp;
                            <a href="#" class="btn btn-success">Заказать</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

