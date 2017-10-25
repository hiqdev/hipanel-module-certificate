<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\forms;

use Yii;
use yii\base\Model;

class CsrGeneratorForm extends Model
{
    public $csr_commonname;
    public $csr_organization;
    public $csr_department;
    public $csr_city;
    public $csr_state;
    public $csr_country;
    public $csr_email;
    public $copy_to_email = true;
    public $client;
    public $client_id;

    public function rules()
    {
        return [
            [
                [
                    'csr_commonname',
                    'csr_organization',
                    'csr_department',
                    'csr_city',
                    'csr_state',
                    'csr_country',
                    'csr_email',
                    'client_id',
                    'client',
                    'copy_to_email',
                ],
                'required',
            ],
            ['csr_email', 'email'],
            ['copy_to_email', 'boolean'],
            ['client_id', 'integer'],
            ['client', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'csr_commonname' => Yii::t('hipanel:certificate', 'Common Name'),
            'csr_organization' => Yii::t('hipanel:certificate', 'Organization'),
            'csr_department' => Yii::t('hipanel:certificate', 'Department'),
            'csr_city' => Yii::t('hipanel:certificate', 'City'),
            'csr_state' => Yii::t('hipanel:certificate', 'State'),
            'csr_country' => Yii::t('hipanel:certificate', 'Country'),
            'csr_email' => Yii::t('hipanel:certificate', 'Email'),
            'copy_to_email' => Yii::t('hipanel:certificate', 'Copy to email'),
        ];
    }
}
