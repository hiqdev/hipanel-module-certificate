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
use hipanel\modules\certificate\repositories\CertificateTariffRepository;
use hipanel\modules\finance\cart\AbstractCartPosition;
use hipanel\modules\finance\models\CertificateResource;
use Yii;

abstract class AbstractCertificateProduct extends AbstractCartPosition
{
    /**
     * @var CertificateType
     */
    protected $_model;

    /**
     * @var string operation name: certificate_purchase, certificate_renewal
     */
    protected $_operation;

    /** {@inheritdoc} */
    public function getIcon()
    {
        return '<i class="fa fa-shield fa-fw"></i>';
    }

    public function getResource()
    {
        return $this->getTariffRepository()->getResource(null, $this->_operation, $this->_model->id);
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
}
