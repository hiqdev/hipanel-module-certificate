<?php

namespace hipanel\modules\certificate\tests\acceptance\client;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Seller;

class CertificateSidebarMenuCest
{
    public function ensureMenuIsOk(Seller $I)
    {
        (new SidebarMenu($I))->ensureContains('SSL certificates', [
            'Certificates' => '@certificate/index',
            'Buy certificate' => '@certificate/order/index',
        ]);
    }
}
