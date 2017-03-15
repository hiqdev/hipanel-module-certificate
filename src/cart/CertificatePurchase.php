<?php

namespace hipanel\modules\certificate\cart;

class CertificatePurchase extends AbstractCertificatePurchase
{
    /** {@inheritdoc} */
    public static function operation()
    {
        return 'Buy';
    }
}
