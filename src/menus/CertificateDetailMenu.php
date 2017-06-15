<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\menus;

use hipanel\menus\AbstractDetailMenu;
use hipanel\widgets\ModalButton;
use Yii;
use yii\bootstrap\Html;

class CertificateDetailMenu extends AbstractDetailMenu
{
    public $model;

    public function items()
    {
        $actions = CertificateActionsMenu::create(['model' => $this->model])->items();
        $items = array_merge($actions, [
            [
                'label' => ModalButton::widget([
                    'model' => $this->model,
                    'scenario' => 'delete',
                    'button' => [
                        'label' => '<i class="fa fa-fw fa-trash-o"></i> ' . Yii::t('hipanel', 'Delete'),
                    ],
                    'modal' => [
                        'header' => Html::tag('h4', Yii::t('hipanel:certificate', 'Confirm certificate deleting')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer' => [
                            'label' => Yii::t('hipanel:certificate', 'Delete certificate'),
                            'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                            'class' => 'btn btn-danger btn-flat',
                        ],
                    ],
                    'body' => Yii::t('hipanel:certificate',
                        'Are you sure to delete certificate {name}? All files under domain root on the server will stay untouched. You can delete them manually later.',
                        ['name' => $this->model->id]
                    ),
                ]),
                'encode' => false,
            ],
        ]);
        unset($items['view']);

        return $items;
    }
}
