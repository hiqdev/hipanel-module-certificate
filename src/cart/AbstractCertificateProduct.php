<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\cart;

use hipanel\modules\certificate\models\CertificateType;
use hipanel\modules\certificate\repositories\CertificateTariffRepository;
use hipanel\modules\certificate\widgets\CertificateCartQuantity;
use hipanel\modules\finance\cart\AbstractCartPosition;
use hiqdev\yii2\cart\DontIncrementQuantityWhenAlreadyInCart;
use Yii;

abstract class AbstractCertificateProduct extends AbstractCartPosition implements DontIncrementQuantityWhenAlreadyInCart
{
    /**
     * @var CertificateType
     */
    protected $_model;

    /**
     * @var string operation name: certificate_purchase, certificate_renewal
     */
    protected $_operation;

    /**
     * @var integer
     */
    public $product_id;

    /**
     * @var string
     */
    public $scenario = null;

    /** {@inheritdoc} */
    public function getIcon()
    {
        return '<i class="fa fa-shield fa-fw"></i>';
    }

    public function getResource()
    {
        return $this->getTariffRepository()->getResource(null, $this->_operation, $this->_model->id);
    }

    /** {@inheritdoc} */
    public function load($data, $formName = null)
    {
        if ($result = parent::load($data, '')) {
            $this->ensureRelatedData();
        }

        return $result;
    }

    /**
     * @return CertificateTariffRepository
     */
    public function getTariffRepository()
    {
        /** @var CertificateTariffRepository $repository */
        static $repository;
        if ($repository === null) {
            $repository = Yii::$container->get(CertificateTariffRepository::class);
        }

        return $repository;
    }

    /**
     * {@inheritdoc}
     */
    protected function serializationMap()
    {
        $parent = parent::serializationMap();
        $parent['_operation'] = $this->_operation;
        $parent['_model'] = $this->_model;

        return $parent;
    }

    /** {@inheritdoc} */
    public function getQuantityOptions()
    {
        $quantityOptions = $this->getResource()->getAvailablePeriods();

        return CertificateCartQuantity::widget([
            'model' => $this,
            'quantityOptions' => $quantityOptions,
            'product_id' => $this->product_id,
            'scenario' => $this->scenario,
        ]);
    }
}
