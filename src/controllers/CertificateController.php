<?php

namespace hipanel\modules\certificate\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;

class CertificateController extends CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
        ];
    }
}
