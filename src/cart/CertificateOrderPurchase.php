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

class CertificateOrderPurchase extends AbstractCertificatePurchase
{
    public $product_id;

    /** {@inheritdoc} */
    public static function operation()
    {
        return 'Purchase';
    }

    public function init()
    {
        parent::init();

        $this->product_id = $this->position->product_id;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['product_id'], 'integer'],
        ]);
    }
}
