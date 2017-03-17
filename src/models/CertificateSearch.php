<?php

namespace hipanel\modules\certificate\models;

use hipanel\base\SearchModelTrait;
use hipanel\helpers\ArrayHelper;

class CertificateSearch extends Certificate
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    public function searchAttributes()
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(), []);
    }
}
