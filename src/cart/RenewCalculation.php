<?php
/**
 * Certificate module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-cartificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\cart;

/**
 * Class RenewCalculation performs calculation for certificate renewal operation.
 */
class RenewCalculation extends \hipanel\modules\finance\cart\Calculation
{
    use \hipanel\base\ModelTrait;

    /** {@inheritdoc} */
    public function init()
    {
        parent::init();

        $this->client = $this->position->getCertificate()->client;
        $this->seller = $this->position->getCertificate()->seller;
        $this->object = 'certificate';
    }

    /** {@inheritdoc} */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'expires'], 'safe'],
            [['id', 'product_id'], 'integer'],
        ]);
    }
}
