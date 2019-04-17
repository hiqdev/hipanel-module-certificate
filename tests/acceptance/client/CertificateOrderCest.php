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

use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Client;

class CertificateOrderCest
{
    public function ensureIndexPageWorks(Client $I)
    {
        $I->login();
        $I->needPage(Url::to('@certificate/order'));
        $I->see('Get certificate', 'h1');
        $this->ensureICanSeeFilterBoxes($I);
        $this->ensureICanSeeSortBox($I);
    }

    private function ensureICanSeeFilterBoxes(Client $I)
    {
        $this->checkFilterBox($I, 'SSL Products', [
            'Domain Validation',
            'Organization Validation',
            'Extended Validation',
        ]);
        $this->checkFilterBox($I, 'SSL Features', [
            'Wildcard Certificates',
        ]);
        $this->checkFilterBox($I, 'SSL Brands', [
            'Thawte',
            'GeoTrust',
            'RapidSSL',
            'Comodo',
        ]);
    }

    /**
     * @param Client $I
     * @param string $title box title
     * @param string[] $items array of items
     */
    private function checkFilterBox(Client $I, string $title, array $items): void
    {
        $I->see($title, 'h3');
        foreach ($items as $item) {
            $I->see($item, "//h3[text()='$title']/../../div/ul/li");
        }
    }

    private function ensureICanSeeSortBox(Client $I)
    {
        $links = [
            'Certificate name',
            'Features',
            'Price',
        ];
        foreach ($links as $link) {
            $I->seeLink($link);
        }
    }
}
