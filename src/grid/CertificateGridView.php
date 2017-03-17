<?php

namespace hipanel\modules\certificate\grid;

use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;

class CertificateGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'id' => [
                'class' => MainColumn::class,
                'attribute' => 'id',
            ],
        ];
    }
}