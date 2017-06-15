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
    public $cn;
    public $o;
    public $ou;
    public $l;
    public $st;
    public $c;
    public $email;
    public $productId;

    public function rules()
    {
        return [
            [['cn', 'o', 'ou', 'l', 'st', 'c', 'email'], 'required'],
            ['productId', 'integer'],
//            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'cn' => Yii::t('hipanel:certificate', 'Common Name'),
            'o' => Yii::t('hipanel:certificate', 'Organization'),
            'ou' => Yii::t('hipanel:certificate', 'Department'),
            'l' => Yii::t('hipanel:certificate', 'City'),
            'st' => Yii::t('hipanel:certificate', 'State'),
            'c' => Yii::t('hipanel:certificate', 'Country'),
            'email' => Yii::t('hipanel:certificate', 'Email'),
        ];
    }
}
