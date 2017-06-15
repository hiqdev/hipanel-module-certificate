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

class CertificatePurchase extends AbstractCertificatePurchase
{
    /** {@inheritdoc} */
    public static function operation()
    {
        return 'Buy';
    }
}
