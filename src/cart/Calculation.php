<?php

namespace hipanel\modules\certificate\cart;

class Calculation extends \hipanel\modules\finance\cart\Calculation
{
    use \hipanel\base\ModelTrait;

    /** {@inheritdoc} */
    public function init()
    {
        parent::init();

        $this->object = 'certificate';
        $this->type = 'dregistration';
        $this->tariff_id = 2013590;
    }

    /** {@inheritdoc} */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['product_id'], 'integer'],
        ]);
    }
}
