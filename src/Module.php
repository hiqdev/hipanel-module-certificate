<?php

namespace hipanel\modules\certificate;

use Yii;

/**
 * Class Module.
 */
class Module extends \hipanel\base\Module
{
    /**
     * Returns Cart component from Cart module.
     * @return \hiqdev\yii2\cart\ShoppingCart
     */
    public function getCart()
    {
        /** @var \hiqdev\yii2\cart\Module $module */
        $module = Yii::$app->getModule('cart');
        return $module->getCart();
    }

    /**
     * Returns Merchant module.
     * @return \yii\base\Module
     */
    public function getMerchant()
    {
        return Yii::$app->getModule('merchant');
    }
}
