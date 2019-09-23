<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\repositories;

use hipanel\helpers\ArrayHelper;
use hipanel\modules\certificate\models\CertificateType;
use hipanel\modules\finance\models\CertificateResource;
use hipanel\modules\finance\models\Resource;
use hipanel\modules\finance\models\Tariff;
use yii\base\Application;

class CertificateTariffRepository
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Returns the tariff for the certificate operations
     * Caches the API request for 3600 seconds and depends on client id and seller login.
     * @return Tariff|null The certificate tariff or boolean `false` when no tariff was found
     */
    public function getTariff()
    {
        if ($this->app->user->isGuest) {
            $seller = $this->app->user->seller;
            $client_id = null;
        } else {
            $seller = $this->app->user->identity->seller;
            $client_id = $this->app->user->id;
        }

        return $this->app->get('cache')->getOrSet([__METHOD__, $seller, $client_id ?: ''], function () use ($seller) {
            $res = Tariff::find()
                ->action('get-available-info')
                ->joinWith('resources')
                ->andFilterWhere(['type' => 'certificate'])
                ->andFilterWhere(['seller' => $seller])
                ->andWhere(['with_resources' => true])
                ->all();

            if (is_array($res) && !empty($res)) {
                return reset($res);
            }

            return null;
        }, 1); /// TODO change to 3600 XXX
    }

    /**
     * @param Tariff $tariff
     * @param string $type
     * @param bool $orderByDefault whether to order prices by name
     * @see orderResources
     * @return resource[]
     */
    public function getResources(Tariff $tariff = null, $type = CertificateResource::TYPE_CERT_PURCHASE, $orderByDefault = true)
    {
        if ($tariff === null) {
            $tariff = $this->getTariff();
        }

        $resources = array_filter((array) $tariff->resources, function ($resource) use ($type) {
            return $resource->type === $type;
        });
        foreach ($resources as $key => &$resource) {
            $resource->certificateType = CertificateType::get($resource->object_id);
            if (!$resource->certificateType) {
                unset($resources[$key]);
            }
            /** @var CertificateResource $resource */
            if (!$resource->hasPriceForPeriod(1)) {
                unset($resources[$key]);
            }
        }

        if ($orderByDefault) {
            return $this->orderResources($resources);
        }

        return $resources;
    }

    /**
     * @param Tariff|null $tariff
     * @param $type
     * @param $object_id
     * @return Resource|CertificateResource
     */
    public function getResource(Tariff $tariff = null, $type, $object_id)
    {
        if ($tariff === null) {
            $tariff = $this->getTariff();
        }

        $resources = array_filter((array) $tariff->resources, function ($resource) use ($type, $object_id) {
            return $resource->type === $type && ((string) $resource->object_id === (string) $object_id);
        });

        return reset($resources);
    }

    /**
     * @param resource[] $resources array of resources to be sorted
     * @return resource[] sorted by name
     */
    public function orderResources($resources)
    {
        ArrayHelper::multisort($resources, 'certificateType.name');

        return $resources;
    }
}
