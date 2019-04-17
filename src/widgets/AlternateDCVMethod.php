<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\widgets;

use yii\base\Widget;

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
