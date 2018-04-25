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
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class Certificate
 *
 * @property int $id
 * @property string $name
 */
class Certificate extends Model
{
    use ModelTrait;

    const STATE_OK = 'ok';
    const STATE_EXPIRED = 'expired';
    const STATE_PENDING = 'pending';
    const STATE_DELETED = 'deleted';
    const STATE_CANCELLED = 'cancelled';
    const STATE_ERROR = 'error';


    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['id', 'remoteid', 'type_id', 'state_id', 'object_id', 'client_id', 'seller_id'], 'integer'],
            [['name', 'type', 'state', 'client', 'seller', 'begins', 'expires', 'statuses', 'file', 'type_label', 'reason'], 'string'],

            [['dcv_method', 'webserver_type'], 'required', 'on' => ['reissue', 'issue']],
            // Reissue
            [['id', 'remoteid', 'client_id'], 'integer', 'on' => ['reissue']],
            [['id', 'csr'], 'required', 'on' => 'reissue'],

            // Delete
            [['id'], 'required', 'on' => ['delete', 'cancel']],

            // Cancel
            [['reason'], 'required', 'on' => ['cancel']],

            // Issue
            [['id', 'admin_id', 'tech_id', 'org_id'], 'integer', 'on' => 'issue'],
            [['webserver_type', 'dns_names', 'csr'], 'string', 'on' => 'issue'],

            [['approver_email'], 'email', 'on' => ['issue', 'reissue']],
            [
                ['approver_email'],
                'required',
                'on' => ['issue', 'reissue'],
                'when' => function ($model) {
                    return $model->dcv_method === 'email';
                },
                'whenClient' => new JsExpression('function (attribute, value) {
                    return $(\'#certificate-dcv_method\').val() === \'email\';
                }'),
            ],

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
            'webserver_type' => Yii::t('hipanel:certificate', 'Webserver type'),
            'reason' => Yii::t('hipanel', 'Comment'),
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
            'dns' => Yii::t('hipanel:certificate', 'DNS'),
        ];
    }

    public function isActive()
    {
        return $this->state === self::STATE_OK;
    }

    public function isDisabled()
    {
        return !in_array($this->state, [self::STATE_OK, self::STATE_EXPIRED, self::STATE_PENDING], true);
    }

    public function isRenewable()
    {
        return in_array($this->state, [self::STATE_OK, self::STATE_EXPIRED], true);
    }

    public function isReissuable()
    {
        return in_array($this->state, [self::STATE_OK, self::STATE_PENDING], true);
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

    /**
     * @return \Generator
     */
    public function getWebserverTypeOptions()
    {
        $supplier = $this->certificateType->brand;
        $data = Yii::$app->cache->getOrSet(['get-webserver-types', $supplier], function () use ($supplier) {
            return static::perform('get-webserver-types', ['supplier' => $supplier]);
        }, 10 * 60);
        foreach ($data as $option) {
            yield $option['id'] => $option['software'];
        }
    }
}
