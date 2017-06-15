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
