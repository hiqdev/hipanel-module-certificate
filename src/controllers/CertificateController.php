<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use yii\base\Event;

class CertificateController extends CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'on beforePerform' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('object');
                },
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
        ];
    }
}
