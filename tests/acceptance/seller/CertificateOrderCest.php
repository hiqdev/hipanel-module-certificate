<?php
namespace hipanel\modules\certificate\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Seller;

class CertificateOrderCest
{
    public function ensureIndexPageWorks(Seller $I)
    {
        $I->login();
        $I->needPage(Url::to('@certificate/order'));
        $I->see('Get certificate', 'h1');
        $this->ensureICanSeeFilterBoxes($I);
        $this->ensureICanSeeSortBox($I);
    }

    private function ensureICanSeeFilterBoxes(Seller $I)
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
     * @param Seller $I
     * @param string $title box title
     * @param string[] $items array of items
     */
    private function checkFilterBox(Seller $I, string $title, array $items): void
    {
        $I->see($title, 'h3');
        foreach ($items as $item) {
            $I->see($item, "//h3[text()='$title']/../../div/ul/li");
        }
    }

    private function ensureICanSeeSortBox(Seller $I)
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
