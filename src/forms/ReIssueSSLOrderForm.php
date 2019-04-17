<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\forms;

use hipanel\base\Model;
use Yii;

class ReIssueSSLOrderForm extends Model
{
    public function rules()
    {
        return [
            [['id', 'remoteid', 'csr', 'webserver_type'], 'required'],

            // This parameters must be used only if dcv_method prameter value is 'email'.
            [['approver_email', 'approver_emails'], 'required'],

            // Value of this specifies DCV method to be used.
            [['dcv_method'], 'range', 'in' => ['email', 'http', 'https', 'dns']],

            // Required for SAN/UCC/Multi-Domain SSL, for the rest of products this parameter must not be provided.
            [['dns_names'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'csr' => Yii::t('hipanel:certificate', 'Certificate Signing Request (CSR)'),
        ];
    }
}
