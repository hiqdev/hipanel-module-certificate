<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\cart;

use hipanel\modules\certificate\widgets\IssueButton;
use Yii;

class CertificateOrderPurchase extends AbstractCertificatePurchase
{
    public $product_id;

    /** {@inheritdoc} */
    public static function operation()
    {
        return 'Purchase';
    }

    public function init()
    {
        parent::init();

        $this->product_id = $this->position->product_id;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['product_id'], 'integer'],
        ]);
    }

    /** {@inheritdoc} */
    public function renderNotes()
    {
        $certificate_id = $this->_result['id'];

        return Yii::t('hipanel:certificate', 'The certificate has been ordered successfully.') . '<br>' . IssueButton::widget(compact('certificate_id'));
    }
}
