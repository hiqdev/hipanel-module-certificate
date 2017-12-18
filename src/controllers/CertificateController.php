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

use Exception;
use hipanel\models\Ref;
use hipanel\modules\certificate\forms\CsrGeneratorForm;
use hipanel\modules\certificate\models\Certificate;
use Yii;
use yii\base\Event;
use hipanel\actions\ViewAction;
use hipanel\actions\IndexAction;
use hipanel\base\CrudController;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use yii\helpers\Html;

class CertificateController extends CrudController
{
    public function actions()
    {
        return array_merge(parent::actions(), [
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
            'issue' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:client', 'Successfully issued'),
                'error' => Yii::t('hipanel:client', 'Error issuing'),
                'data' => function ($action) {
                    return [
                        'webserverTypes' => $action->controller->getWebserverTypes(),
                    ];
                },
            ],
            'reissue' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:client', 'Successfully reissued'),
                'error' => Yii::t('hipanel:client', 'Error reissuing'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
        ]);
    }

    public function actionCsrGenerateForm($client = null, $fqdn = null)
    {
        $request = Yii::$app->request;
        $model = new CsrGeneratorForm();

        if ($request->isAjax) {
            if ($request->isPost) {
                if ($model->load($request->post()) && $model->validate()) {
                    $result = [];
                    try {
                        $result['status'] = 'success';
                        $result['csr'] = Certificate::perform('generate-CSR', $model->getAttributes());
                    } catch (Exception $e) {
                        $result['status'] = 'fail';
                        if (!Yii::getAlias('@ticket', false)) {
                            $result['message'] = Yii::t('hipanel:certificate', 'An error occurred during the CSR generation. Please inform the website administration about this.');
                        } else {
                            $result['message'] = Yii::t('hipanel:certificate', 'An error occurred during the CSR generation. Please {inform} the website administration about this.', [
                                'inform' => Html::a(Yii::t('hipanel:certificate', 'inform'), ['@ticket/create']),
                            ]);
                        }
                        Yii::warning("CSR Generate is failed, {$e->getMessage()}", __METHOD__);
                    }

                    return $this->renderJson($result);
                }
            } else {
                $model->client = $client;

                return $this->renderAjax('_csrGenerate', [
                    'model' => $model,
                    'countries' => array_change_key_case(Ref::getList('country_code'), CASE_UPPER),
                    'fqdn' => $fqdn,
                ]);
            }
        }
    }

    public function getWebserverTypes()
    {
        return [];
    }

    public function actionGetApproverEmails()
    {
        $csr = Yii::$app->request->post('csr');
        $result = [
            'success' => true,
            'message' => Yii::t('hipanel:certificate', 'Approver emails received, please choose a email.'),
            'emails' => [],
        ];
        if ($csr) {
            try {
                $apiData = Certificate::perform('get-domain-emails', ['csr' => $csr]);

                $result['emails'] = $apiData;
            } catch (\Exception $e) {
                $result['success'] = false;
                $result['message'] = ucfirst($e->getMessage());
            }
        }

        return $this->asJson($result);
    }
}
