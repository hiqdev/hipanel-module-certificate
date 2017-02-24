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

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('hiqdev:certificate', 'Name'),
        ];
    }
}
