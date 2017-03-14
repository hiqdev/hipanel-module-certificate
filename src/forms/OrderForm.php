<?php

namespace hipanel\modules\certificate\forms;

use hipanel\base\Model;
use Yii;

class OrderForm extends Model
{
    public $csr;
    public $productId;
    public $email;

    public function rules()
    {
        return [
            [['csr', 'productId', 'email'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'csr' => Yii::t('hipanel:certificate', 'Certificate Signing Request (CSR)'),
            'email' => Yii::t('hipanel:certificate', 'Email'),
        ];
    }
}
