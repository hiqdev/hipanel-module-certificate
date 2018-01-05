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
use hipanel\modules\finance\models\CertificateResource;
use Yii;

class CertificateOrderProduct extends AbstractCertificateProduct
{
    /** {@inheritdoc} */
    protected $_calculationModel = Calculation::class;

    /** {@inheritdoc} */
    protected $_purchaseModel = CertificateOrderPurchase::class;

    /** {@inheritdoc} */
    protected $_operation = CertificateResource::TYPE_CERT_PURCHASE;

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
            $this->description = Yii::t('hipanel:certificate', 'Ordering');
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
        $quantityOptions = $this->getResource()->getAvailablePeriods();

        return CertificateCartQuantity::widget([
            'model' => $this,
            'quantityOptions' => $quantityOptions,
            'product_id' => $this->product_id
        ]);
    }

    /** {@inheritdoc} */
    public function getCalculationModel($options = [])
    {
        return parent::getCalculationModel(array_merge([
            'type' => $this->_operation,
            'product_id' => $this->product_id,
        ], $options));
    }

    protected function serializationMap()
    {
        $parent = parent::serializationMap();
        $parent['product_id'] = $this->product_id;
        return $parent;
    }
}
