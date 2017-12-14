<?php

namespace hipanel\modules\certificate\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class IssueButton extends Widget
{
    /**
     * @var integer
     */
    public $certificate_id;

    public function run()
    {
        $this->view->registerCss("
        .pulse {
            box-shadow: 0 0 0 rgba(204,169,44, 0.4);
            animation: pulse 2s infinite;
        }
        
        .blink {
            animation: blink-animation 2s steps(5, start) infinite;
            -webkit-animation: blink-animation 1s steps(5, start) infinite;
        }
        
        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
        @-webkit-keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
        
        @-webkit-keyframes pulse {
            0% {
                -webkit-box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
            }
            70% {
                -webkit-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
            }
            100% {
                -webkit-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
            }
        }
        @keyframes pulse {
            0% {
                -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
                box-shadow: 0 0 0 0 rgba(204,169,44, 0.4);
            }
            70% {
                -moz-box-shadow: 0 0 0 10px rgba(204,169,44, 0);
                box-shadow: 0 0 0 10px rgba(204,169,44, 0);
            }
            100% {
                -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
                box-shadow: 0 0 0 0 rgba(204,169,44, 0);
            }
        }
        ");
        $html = Html::beginTag('div');
        $html .= Html::a('<i class="fa fa-exclamation-triangle blink"></i>&nbsp;' . Yii::t('hipanel:certificate', 'Get certificate'), [
            '@certificate/issue',
            'id' => $this->certificate_id,
        ], ['class' => 'btn btn-warning btn-sm btn-flat pulse']);
        $html .= Html::tag('p', Yii::t('hipanel:certificate', 'To complete the purchase procedure, you need to issue a certificate'),
            ['class' => 'text-muted', 'style' => 'padding: .5rem 0 0']);
        $html .= Html::endTag('div');

        return $html;
    }
}
