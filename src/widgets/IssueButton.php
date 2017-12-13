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
        $html = Html::beginTag('div');
        $html .= Html::a(Yii::t('hipanel:certificate', 'Issue certificate'), [
            '@certificate/issue',
            'id' => $this->certificate_id,
        ], ['class' => 'btn btn-warning btn-sm btn-flat']);
        $html .= Html::tag('p', Yii::t('hipanel:certificate', 'To complete the purchase procedure, you need to issue a certificate'),
            ['class' => 'text-muted', 'style' => 'padding: .5rem 0 0']);
        $html .= Html::endTag('div');

        return $html;
    }
}
