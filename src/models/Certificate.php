<?php

namespace hipanel\modules\certificate\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;

class Certificate extends Model
{
    use ModelTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['id', 'remoteid', 'type_id', 'state_id', 'object_id', 'client_id', 'seller_id'], 'integer'],
            [['type', 'state', 'client', 'seller', 'validity_start', 'validity_end', 'statuses', 'file', 'object'], 'safe'],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([

        ]);
    }
}
