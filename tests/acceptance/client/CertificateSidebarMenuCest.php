<?php

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
