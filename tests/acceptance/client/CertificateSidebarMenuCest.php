<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\tests\acceptance\client;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Client;

class CertificateSidebarMenuCest
{
    public function ensureMenuIsOk(Client $I)
    {
        (new SidebarMenu($I))->ensureContains('SSL certificates', [
            'Certificates' => '@certificate/index',
            'Buy certificate' => '@certificate/order/index',
        ]);
    }
}
