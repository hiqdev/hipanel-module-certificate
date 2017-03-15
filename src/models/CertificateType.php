<?php

namespace hipanel\modules\certificate\models;

use hipanel\helpers\StringHelper;
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

    public $product_id;
    public $product_name;
    public $product_brand;
    public $product_description;
    public $product_agreement;
    public $product_organization;
    public $product_wildcard;
    public $product_unlimited_servers;
    public $product_is_multidomain;
    public $product_multidomains_included;
    public $product_multidomains_maximum;
    public $product_prices;
    public $success;


    public static function types()
    {
        return [
            'dv' => [
                'label' => Yii::t('hipanel:certificate', 'Domain Validation'),
                'text' => Yii::t('hipanel:certificate', 'Get no-frills, industry standard encryption for a cheap price with our DV SSL Certificates'),
            ],
            'sun' => [
                'label' => Yii::t('hipanel:certificate', 'Multi-Domain Certs'),
                'text' => Yii::t('hipanel:certificate', 'Secure multiple domains on a single certificate for a cheap price with Multi-Domain SSL'),
            ],
            'ov' => [
                'label' => Yii::t('hipanel:certificate', 'Organization Validation'),
                'text' => Yii::t('hipanel:certificate', 'Get light business authentication at an extremely cheap price with our OV SSL Certificates'),
            ],
            'wc' => [
                'label' => Yii::t('hipanel:certificate', 'Wildcard Certificates'),
                'text' => Yii::t('hipanel:certificate', 'Secure unlimited Sub-Domains for one cheap price with these Wildcard SSL Certificates'),
            ],
            'ev' => [
                'label' => Yii::t('hipanel:certificate', 'Extended Validation'),
                'text' => Yii::t('hipanel:certificate', 'Inspire maximum trust at an unbeatable price with an Extended Validation SSL'),
            ],
        ];
    }

    public static function brands()
    {
        return [
            'symantec' => [
                'label' => Yii::t('hipanel:certificate', 'Symantec SSL Certificates'),
                'img' => 'symantec_vendor.png',
            ],
            'ukrnames' => [
                'label' => Yii::t('hipanel:certificate', 'Ukrnames SSL Certificates')
            ],
            'ggssl' => [
                'label' => Yii::t('hipanel:certificate', 'GoGetSSL SSL Certificates'),
            ],
            'thawte' => [
                'label' => Yii::t('hipanel:certificate', 'Thawte SSL Certificates'),
                'img' => 'thawte_vendor.png',
            ],
            'geotrust' => [
                'label' => Yii::t('hipanel:certificate', 'GeoTrust SSL Certificates'),
                'img' => 'geotrust_vendor.png',
            ],
            'rapidssl' => [
                'label' => Yii::t('hipanel:certificate', 'RapidSSL Certificates'),
                'img' => 'rapidssl_vendor.png',
            ],
            'comodo' => [
                'label' => Yii::t('hipanel:certificate', 'Comodo SSL Certificates'),
                'img' => 'comodo_vendor.png',
            ]
        ];
    }

    public function getLogo()
    {
        $brands = static::brands();
        $img = $brands[$this->brand]['img'];
        if ($img !== null) {
            $pathToImage = Yii::getAlias(sprintf('@hipanel/modules/certificate/assets/img/%s', $img));
            if (is_file($pathToImage)) {
                Yii::$app->assetManager->publish($pathToImage);
                $img = Yii::$app->assetManager->getPublishedUrl($pathToImage);
            }
        }

        return $img;
    }

    public function getType()
    {
        $data = array_keys(static::types());
        $v = array_rand(array_flip($data), 2);

        return implode(' ', $v);
    }

    public function getBrand()
    {
        return strtolower(StringHelper::truncateWords($this->name, 1, ''));
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('hipanel:certificate', 'Name'),
        ];
    }
}
