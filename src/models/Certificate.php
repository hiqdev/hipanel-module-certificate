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

class Certificate extends Model
{
    use ModelTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['id', 'remoteid', 'type_id', 'state_id', 'object_id', 'client_id', 'seller_id'], 'integer'],
            [['name', 'type', 'state', 'client', 'seller', 'begins', 'expires', 'statuses', 'file'], 'safe'],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
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
}
