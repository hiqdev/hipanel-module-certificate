<?php

namespace hipanel\modules\certificate\widgets;

use yii\base\Widget;
use yii\helpers\Url;

class DVCMethod extends Widget
{
    public $model;

    public $form;

    public $requestUrl = '@certificate/get-approver-emails';

    public $changeDVC = false;

    protected $baseJS;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->requestUrl = Url::to($this->requestUrl);
        $this->baseJS = "
             // DCV
            showDCVInfo(document.getElementById('certificate-dcv_method').value);

            $('#{$this->form->id} #certificate-dcv_method').on('change', function (event) {
                var state = event.target.value;
                showDCVInfo(state);
            });

            function showDCVInfo(state) {
                $('.method').each(function(index, value) {
                    if ($(value).hasClass(state)) {
                        $(value).show();
                    } else {
                        $(value).hide();
                    }
                });
            }
       ";
    }

    public function run()
    {
        $this->registerCSS();
        $this->registerJS();
        return $this->render('DVCMethod', [
            'model' => $this->model,
            'form' => $this->form,
        ]);
    }

    public function registerCSS()
    {
        $this->getView()->registerCss('.method { display: none; }');
    }

    public function registerJS()
    {
        if ($this->changeDVC === false) {
            $this->registerIssueJS();
        } else {
            $this->registerChangeJS();
        }
    }

    public function registerIssueJS()
    {
        $this->getView()->registerJs(<<<heredoc
            $(document).on('change', '#certificate-csr', function(e) {
                var dropdown = $("#certificate-approver_email");
                var csr = e.target.value;
                dropdown.find('option').remove().end().append($('<option />').val(null).text('--'));
                if (document.getElementById('certificate-dcv_method').value === 'email') {
                    $.post('{$this->requestUrl}', {'csr': csr}).done(function(data) {
                        if (data.success == true) {
                            hipanel.notify.success(data.message);
                            $.each(data.emails, function() {
                                dropdown.append($('<option />').val(this).text(this));
                            });
                            dropdown.removeAttr('readonly');
                        } else {
                            hipanel.notify.error(data.message);
                            dropdown.attr({readonly: true});
                        }
                    });
                }
            });
            $('#{$this->form->id}').submit(function () {
                $('#select-csr .btn-success').click();
            });
            {$this->baseJS}
heredoc
        );
    }

    public function registerChangeJS()
    {
        $this->getView()->registerJs(<<<heredoc
            var modelId = {$this->model->id};
            var dropdown = $("#certificate-approver_email");
            dropdown.find('option').remove().end().append($('<option />').val(null).text('--'));
            $.post('{$this->requestUrl}', {'id': modelId}).done(function(data) {
                if (data.success == true) {
                    hipanel.notify.success(data.message);
                    $.each(data.emails, function() {
                        dropdown.append($('<option />').val(this).text(this));
                    });
                    dropdown.removeAttr('readonly');
                } else {
                    hipanel.notify.error(data.message);
                    dropdown.attr({readonly: true});
                }
            });

            {$this->baseJS}
heredoc
        );
    }
}
