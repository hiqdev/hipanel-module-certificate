<?php

namespace hipanel\modules\certificate\repositories;

use hipanel\modules\certificate\models\CertificateType;
use Yii;
use yii\helpers\Json;

class CertRepository
{
    private static $inst;

    private $key = [
        'auth_key' => '',
    ];

    public static function create()
    {
        if (self::$inst === null) {
            self::$inst = new self();
        }

        return self::$inst;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function getTypes()
    {
        $data = $this->makeRequest('products');

        return $this->makeModels($data['products']);
    }

    public function getTypeDetail($id)
    {
        $data = $this->makeRequest('details');

        return new CertificateType($data);
    }

    private function makeRequest($route)
    {
        $params = http_build_query($this->key);
//        return Json::decode(file_get_contents(sprintf('https://any.server.com/api%s?%s', $route, $params)));
        $path = Yii::getAlias(sprintf('@vendor/hiqdev/hipanel-module-certificate/src/repositories/%s.json', $route));
        return Json::decode(file_get_contents($path));
    }

    private function makeModels($data = [])
    {
        $models = [];
        foreach ($data as $item) {
            $models[] = new CertificateType($item);
        }

        return $models;
    }
}