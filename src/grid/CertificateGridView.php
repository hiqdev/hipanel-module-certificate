<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

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
