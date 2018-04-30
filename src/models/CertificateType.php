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

use hipanel\helpers\StringHelper;
use Yii;

class CertificateType extends \hiqdev\hiart\ActiveRecord
{
    public $id;
    public $name;
    public $expires;
    public $unlimited_servers;
    public $domain_validation;
    public $extended_validation;
    public $organization_validation;
    public $wildcard;
    public $code_signing;
    public $personal;
    public $multidomain;
    public $multidomains_included;
    public $multidomains_maximum;

    protected $_features = [];

    public function init()
    {
        parent::init();
        $known = static::get($this->id);
        foreach (array_keys(get_object_vars($this)) as $key) {
            if ($this->{$key} === null) {
                $this->{$key} = $known->{$key};
            }
        }
    }

    protected static $knownTypes;

    public static function features()
    {
        return [
            'dv' => [
                'label' => Yii::t('hipanel:certificate', 'Domain Validation'),
                'text' => Yii::t('hipanel:certificate', 'Get no-frills, industry standard encryption for a cheap price with our DV SSL Certificates'),
            ],
            'ov' => [
                'label' => Yii::t('hipanel:certificate', 'Organization Validation'),
                'text' => Yii::t('hipanel:certificate', 'Get light business authentication at an extremely cheap price with our OV SSL Certificates'),
            ],
            'ev' => [
                'label' => Yii::t('hipanel:certificate', 'Extended Validation'),
                'text' => Yii::t('hipanel:certificate', 'Inspire maximum trust at an unbeatable price with an Extended Validation SSL'),
            ],
            'cs' => [
                'label' => Yii::t('hipanel:certificate', 'Code Signing'),
                'text' => Yii::t('hipanel:certificate', 'Allows publishers to sign their files with own signature to proof their identity'),
            ],
            'san' => [
                'label' => Yii::t('hipanel:certificate', 'Multi-Domain / SAN'),
                'text' => Yii::t('hipanel:certificate', 'Secure multiple domains on a single certificate for a cheap price with Multi-Domain SSL'),
            ],
            'wc' => [
                'label' => Yii::t('hipanel:certificate', 'Wildcard Certificates'),
                'text' => Yii::t('hipanel:certificate', 'Secure unlimited Sub-Domains for one cheap price with these Wildcard SSL Certificates'),
            ],
        ];
    }

    public static function brands()
    {
        return [
            'symantec' => [
                'label' => Yii::t('hipanel:certificate', 'Symantec'),
                'img' => 'symantec_vendor.png',
            ],
            'ggssl' => [
                'label' => Yii::t('hipanel:certificate', 'GoGetSSL'),
                'img' => 'gogetssl_vendor.png',
            ],
            'thawte' => [
                'label' => Yii::t('hipanel:certificate', 'Thawte'),
                'img' => 'thawte_vendor.png',
            ],
            'geotrust' => [
                'label' => Yii::t('hipanel:certificate', 'GeoTrust'),
                'img' => 'geotrust_vendor.png',
            ],
            'rapidssl' => [
                'label' => Yii::t('hipanel:certificate', 'RapidSSL'),
                'img' => 'rapidssl_vendor.png',
            ],
            'comodo' => [
                'label' => Yii::t('hipanel:certificate', 'Comodo'),
                'img' => 'comodo_vendor.png',
            ],
            'certum' => [
                'label' => Yii::t('hipanel:certificate', 'Certum'),
                'img' => 'certum_vendor.png',
            ],
        ];
    }

    public static function get($key)
    {
        $types = static::getKnownTypes();
        if (isset($types[$key])) {
            return $types[$key];
        }
        foreach ($types as $type) {
            if ($type->name === $key) {
                return $type;
            }
        }

        return null;
    }

    public static function getKnownTypes()
    {
        if (static::$knownTypes === null) {
            static::$knownTypes = static::fetchKnownTypes();
        }

        return static::$knownTypes;
    }

    protected static function fetchKnownTypes()
    {
        /// prevent infinit recursion loop
        static $already = 0;
        if ($already>0) {
            return [];
        }
        $already++;

        $res = Yii::$app->get('cache')->getOrSet([__METHOD__], function () use ($seller, $client_id) {
            return static::find()->indexBy('id')->all();
        }, 10); /// TODO change to 3600*24 XXX

        return $res;
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

    public function getFeatures()
    {
        if (!$this->_features) {
            $this->_features = $this->detectFeatures();
        }

        return $this->_features;
    }

    public function detectFeatures()
    {
        $res = ['dv' => 'dv'];
        if ($this->organization_validation) {
            $res['ov'] = 'ov';
            unset($res['dv']);
        }
        if ($this->extended_validation) {
            $res['ev'] = 'ev';
            unset($res['dv']);
        }
        if ($this->code_signing) {
            $res['cs'] = 'cs';
            unset($res['dv']);
        }
        if ($this->wildcard) {
            $res['wc'] = 'wc';
        }
        if ($this->multidomain) {
            $res['san'] = 'san';
        }

        return $res;
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
    public function __toString()
    {
        return $this->name;
    }
}
