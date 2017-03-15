<?php

namespace hipanel\modules\certificate\cart;

use hipanel\base\ModelTrait;
use hipanel\modules\finance\cart\AbstractPurchase;

abstract class AbstractCertificatePurchase extends AbstractPurchase
{
    use ModelTrait;

    /** {@inheritdoc} */
    public static function tableName()
    {
        return 'certificate';
    }
}
