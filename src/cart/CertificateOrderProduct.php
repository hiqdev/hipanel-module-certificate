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
use hipanel\modules\certificate\widgets\CertificateCartQuantity;
use Yii;

class CertificateOrderProduct extends AbstractCertificateProduct
{
    /** {@inheritdoc} */
    protected $_calculationModel = Calculation::class;

    /** {@inheritdoc} */
    protected $_purchaseModel = CertificatePurchase::class;

    /**
     * @var integer
     */
    public $product_id;

    /** {@inheritdoc} */
    public function getId()
    {
        if ($this->_id === null) {
            $this->_id = hash('crc32b', implode('_', ['certificate', 'order', $this->product_id, mt_rand()]));
        }

        return $this->_id;
    }

    /** {@inheritdoc} */
    public function load($data, $formName = null)
    {
        if ($result = parent::load($data, '')) {
            $this->_model = new CertificateType(['id' => $this->product_id]);
            $this->name = $this->_model->name;
            $this->description = Yii::t('hipanel:certificate', 'Order');
        }

        return $result;
    }

    /** {@inheritdoc} */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['product_id'], 'integer'],
        ]);
    }

    public function getQuantityOptions()
    {
        $quantityOptions = [
            '1' => Yii::t('hipanel:certificate', '{0, plural, one{# year} other{# years}}', 1),
            '2' => Yii::t('hipanel:certificate', '{0, plural, one{# year} other{# years}}', 2),
            '3' => Yii::t('hipanel:certificate', '{0, plural, one{# year} other{# years}}', 3),
        ];

        return CertificateCartQuantity::widget(['model' => $this, 'quantityOptions' => $quantityOptions, 'product_id' => $this->product_id]);
    }
}
