<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use hipanel\models\Obj;
use Yii;

class Certificate extends Model
{
    use ModelTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['id', 'remoteid', 'type_id', 'state_id', 'object_id', 'client_id', 'seller_id'], 'integer'],
            [['name', 'type', 'state', 'client', 'seller', 'begins', 'expires', 'statuses', 'file'], 'safe'],

            [['id', 'remoteid', 'client_id'], 'integer', 'on' => ['reissue']],
            [['id', 'csr'], 'required', 'on' => 'reissue'],

            // Issue
            [['id', 'admin_id', 'tech_id', 'org_id'], 'integer', 'on' => 'issue'],
            [['dcv_method', 'webserver_type', 'dns_names', 'csr'], 'string', 'on' => 'issue'],

            [['approver_email'], 'email', 'on' => ['issue', 'reissue']],
            [['approver_email'], 'required', 'on' => ['issue', 'reissue']],

            [['approver_emails'], 'email', 'on' => 'issue'],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'begins' => Yii::t('hipanel:certificate', 'Valid from'),
            'expires' => Yii::t('hipanel:certificate', 'Expires'),
            'csr' => Yii::t('hipanel:certificate', 'CSR'),
            'dns_names' => Yii::t('hipanel:certificate', 'DNS names'),
            'dcv_method' => Yii::t('hipanel:certificate', 'Domain Control Validation method'),
            'approver_email' => Yii::t('hipanel:certificate', 'Approver email'),
            'approver_emails' => Yii::t('hipanel:certificate', 'Approver emails'),
            'admin_id' => Yii::t('hipanel:certificate', 'Admin contact'),
            'tech_id' => Yii::t('hipanel:certificate', 'Tech contact'),
            'org_id' => Yii::t('hipanel:certificate', 'Organization contact'),
        ]);
    }

    public function getObject()
    {
        return $this->hasOne(Obj::class, ['id' => 'object_id']);
    }

    public function getCertificateType()
    {
        return CertificateType::get($this->type_id);
    }

    public function dcvMethodOptions()
    {
        return [
            'email' => Yii::t('hipanel:certificate', 'Email'),
        ];
    }

    public function isActive()
    {
        return $this->state === 'ok';
    }

    /**
     * DNS names are needed for SAN/UCC/Multi-Domain certificates.
     * @return bool
     */
    public function needsDnsNames()
    {
        /// TODO check if SAN/UCC/Multi-Domain
        return false;
    }
}
