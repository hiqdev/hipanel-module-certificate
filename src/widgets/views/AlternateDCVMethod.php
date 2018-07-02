<?php

/** @var array $model */
?>

<table class="table table-striped table-bordered detail-view">
    <thead>
        <tr>
            <th><?= Yii::t('hipanel:certificate', 'Method') ?></th>
            <th><?= Yii::t('hipanel:certificate', 'Values') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model['dcv_data_alternate']['validation'] as $dcv_method => $value) : ?>
            <tr>
                <th><?= mb_strtoupper($dcv_method) ?></th>
                <td>
                    <table class="table table-striped table-bordered detail-view">
                        <tbody>
                            <?php foreach ($value[$dcv_method] as $k => $v) : ?>
                                <tr>
                                    <th><?= mb_strtoupper($k) ?></th>
                                    <td><?=  nl2br($v) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

