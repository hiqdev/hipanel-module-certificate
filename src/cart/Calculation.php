<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\cart;

class Calculation extends \hipanel\modules\finance\cart\Calculation
{
    use \hipanel\base\ModelTrait;

    /** {@inheritdoc} */
    public function init()
    {
        parent::init();

        $this->object = 'certificate';
    }

    /** {@inheritdoc} */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['product_id'], 'integer'],
        ]);
    }
}
