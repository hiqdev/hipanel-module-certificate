<?php

namespace hipanel\modules\certificate\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class AlternateDCVMethod extends Widget
{
    public $data;

    public function run()
    {
        if (!empty($this->data['crt_code'])) {
            return '';
        }

        if (empty($this->data['dcv_data_alternate']['validation'])) {
            return '';
        }

        return $this->render('AlternateDCVMethod', ['model' => $this->data]);

    }

}
