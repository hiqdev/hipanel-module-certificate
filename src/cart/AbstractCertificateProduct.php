<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

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
