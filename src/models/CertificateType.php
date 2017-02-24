<?php

namespace hipanel\modules\certificate\models;

use Yii;
use yii\base\Model;

class CertificateType extends Model
{
    public $id;
    public $name;
    public $periods;
    public $organization;
    public $wildcard;
    public $unlimited_servers;
    public $is_multidomain;
    public $multidomains_included;
    public $multidomains_maximum;

    public static function types()
    {
        return [
            'dv' => [
                'label' => Yii::t('hipanel:certificate', 'Domain Validation'),
                'text' => Yii::t('hipanel:certificate', ''),
            ],
            'mdc' => [
                'label' => Yii::t('hipanel:certificate', 'Multi-Domain Certs'),
                'text' => Yii::t('hipanel:certificate', ''),
            ],
            'ov' => [
                'label' => Yii::t('hipanel:certificate', 'Organization Validation'),
                'text' => Yii::t('hipanel:certificate', ''),
            ],
            'wc' => [
                'label' => Yii::t('hipanel:certificate', 'Wildcard Certificates'),
                'text' => Yii::t('hipanel:certificate', ''),
            ],
            'wv' => [
                'label' => Yii::t('hipanel:certificate', 'Extended Validation'),
                'text' => Yii::t('hipanel:certificate', ''),
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('hipanel:certificate', 'Name'),
        ];
    }
}
