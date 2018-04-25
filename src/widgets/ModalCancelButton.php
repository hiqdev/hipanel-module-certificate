<?php
/**
 * SSL certificates module for HiPanel.
 *
 * @link      https://hipanel.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\widgets;

use hipanel\widgets\ModalButton;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * Class ModalCancelButton.
 *
 * Renders [[Modal]] widget in form with custom toggle button.
 */
class ModalCancelButton extends ModalButton
{
    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     */
    public function init()
    {
        $this->initOptions();

        if ($this->button['position'] === static::BUTTON_OUTSIDE && isset($this->button['label'])) {
            $this->renderButton();
        }

        if ($this->form !== false) {
            $this->beginForm();
        }

        $this->beginModal();

        if (isset($this->body)) {
            if ($this->body instanceof \Closure) {
                echo call_user_func($this->body, $this->model);
            } else {
                echo $this->body;
                echo $this->form->field($this->model, 'reason');
            }
        }
    }
}
