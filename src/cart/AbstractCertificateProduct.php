<?php

namespace hipanel\modules\certificate\cart;

use hipanel\modules\certificate\models\CertificateType;
use hipanel\modules\finance\cart\AbstractCartPosition;

abstract class AbstractCertificateProduct extends AbstractCartPosition
{
    /**
     * @var CertificateType
     */
    protected $_model;

    /** {@inheritdoc} */
    public function getIcon()
    {
        return '<i class="fa fa-shield fa-fw"></i>';
    }
}
