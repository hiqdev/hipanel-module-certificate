<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use hipanel\models\Obj;
use Yii;
use yii\web\JsExpression;

/**
 * Class Certificate.
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
    const STATE_INCOMPLETE = 'incomplete';
    const STATE_ERROR = 'error';

    const SUPPLIER_CERTUM = 'certum';
    const SUPPLIER_RAPIDSSL = 'rapidssl';
    const SUPPLIER_SYMANTEC = 'symantec';
    const SUPPLIER_GOGETSSL = 'ggssl';
    const SUPPLIER_THAWTE = 'thawte';
    const SUPPLIER_GEOTRUST = 'geotrust';
    const SUPPLIER_SECTIGO = 'sectigo';

    public $issueData = null;

    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['id', 'remoteid', 'type_id', 'state_id', 'object_id', 'client_id', 'seller_id', 'product_id'], 'integer'],
            [['name', 'type', 'state', 'client', 'seller', 'begins', 'expires', 'statuses', 'file', 'type_label', 'reason'], 'string'],
            [['is_parent'], 'boolean'],
            // All Operations
            [['id'], 'required', 'on' => ['issue', 'reissue', 'cancel', 'delete', 'change-validation', 'revalidate', 'send-notifications']],
            // Issue And ReIssue
            [['csr', 'webserver_type'], 'required', 'on' => ['issue', 'reissue']],
            [['dcv_method'], 'required', 'on' => ['issue', 'reissue', 'change-validation']],
            [['admin_id', 'tech_id', 'org_id'], 'integer', 'on' => ['issue', 'reissue']],
            [['webserver_type', 'dns_names', 'csr'], 'string', 'on' => ['issue', 'reissue']],
            [['approver_email'], 'email', 'on' => ['issue', 'reissue', 'change-validation']],
            [
                ['approver_email'],
                'required',
                'on' => ['issue', 'reissue', 'change-validation'],
                'when' => function ($model) {
                    return $model->dcv_method === 'email';
                },
                'whenClient' => new JsExpression('function (attribute, value) {
                    return $(\'#certificate-dcv_method\').val() === \'email\';
                }'),
            ],

            [['approver_emails'], 'email', 'on' => ['issue', 'reissue']],

            // Cancel
            [['reason'], 'required', 'on' => ['cancel']],
            [['data'], 'safe'],
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

    /** @return \stdClass **/
    public function getIssueData(): \stdClass
    {
        if ($this->issueData !== null) {
            return $this->issueData;
        }

        if ($this->data === null) {
            return new \stdClass();
        }

        $obj = json_decode($this->data);
        $this->issueData = json_last_error() === 0 ? $obj : new \stdClass();

        return $this->issueData;
    }

    public function getObject()
    {
        return $this->hasOne(Obj::class, ['id' => 'object_id']);
    }

    public function getCertificateType()
    {
        return CertificateType::get($this->type_id, $this->client ?? null);
    }

    public function dcvMethodOptions()
    {
        return array_filter([
            'email' => $this->supportsEmailValidation() ? Yii::t('hipanel:certificate', 'Email') : null,
            'dns' => $this->supportsDNSValidation() ? Yii::t('hipanel:certificate', 'DNS') : null,
            'file' => $this->supportsFileValidation() ? Yii::t('hipanel:certificate', 'File') : null,
            'http' => $this->supportsHTTPValidation() ? Yii::t('hipanel:certificate', 'HTTP') : null,
            'https' => $this->supportsHTTPValidation() ? Yii::t('hipanel:certificate', 'HTTPS') : null,
        ]);
    }

    public function supportsEmailValidation()
    {
        return true;
    }

    public function supportsFileValidation()
    {
        return $this->certificateType->brand === self::SUPPLIER_CERTUM;
    }

    public function supportsDNSValidation()
    {
        return in_array($this->certificateType->brand, [self::SUPPLIER_CERTUM, self::SUPPLIER_GOGETSSL, self::SUPPLIER_SECTIGO], true);
    }

    public function supportsHTTPValidation()
    {
        return in_array($this->certificateType->brand, [self::SUPPLIER_GOGETSSL, self::SUPPLIER_SECTIGO], true);
    }

    public function isReValidateable()
    {
        return $this->isPending() && $this->certificateType->brand !== self::SUPPLIER_CERTUM && $this->getIssueData()->dcv_method !== 'email';
    }

    public function isValidationResendable()
    {
        return $this->isPending() && ($this->certificateType->brand === self::SUPPLIER_CERTUM || $this->getIssueData()->dcv_method === 'email');
    }

    public function isChangeValidationable()
    {
        return $this->isPending() && count($this->dcvMethodOptions()) > 1;
    }

    public function isActive()
    {
        return $this->state === self::STATE_OK;
    }

    public function isDisabled()
    {
        return !in_array($this->state, [self::STATE_OK, self::STATE_EXPIRED, self::STATE_PENDING], true);
    }

    public function isDeleteable()
    {
        return in_array($this->state, [self::STATE_DELETED, self::STATE_ERROR, self::STATE_CANCELLED, self::STATE_INCOMPLETE], true);
    }

    public function isRenewable()
    {
        return in_array($this->state, [self::STATE_OK, self::STATE_EXPIRED], true) && !$this->isParent();
    }

    public function isCancelable()
    {
        return in_array($this->state, [self::STATE_OK, self::STATE_PENDING], true) && !$this->isParent();
    }

    public function isReissuable()
    {
        return in_array($this->state, [self::STATE_OK, self::STATE_PENDING], true) && !$this->isParent();
    }

    public function isParent()
    {
        return (bool) $this->is_parent;
    }

    public function isPending()
    {
        return $this->state === self::STATE_PENDING;
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
