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
use hipanel\filters\EasyAccessControl;
use hipanel\filters\RedirectPanel;
use hipanel\models\Ref;
use hipanel\modules\certificate\forms\CsrGeneratorForm;
use hipanel\modules\certificate\models\Certificate;
use hipanel\modules\certificate\models\CertificateType;
use hipanel\modules\certificate\widgets\DataView;
use hipanel\modules\certificate\cart\CertificateRenewProduct;
use Yii;
use yii\base\Event;
use hipanel\actions\ViewAction;
use hipanel\actions\IndexAction;
use hipanel\base\CrudController;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\ValidateFormAction;
use hiqdev\yii2\cart\actions\AddToCartAction;
use yii\helpers\Html;

class CertificateController extends CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access-certificate' => [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create' => 'certificate.create',
                    'reissue,cancel' => 'certificate.update',
                    'add-to-cart-renew,bulk-renewal' => 'certificate.update',
                    'delete' => 'certificate.delete',
                    '*' => 'certificate.read',
                ],
            ],
            'redirect-panel' => [
                'class' => RedirectPanel::class,
                'actions' => '*',
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'on beforePerform' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('object')->addSelect('chain');
                },
                'data' => function ($action) {
                    return [
                        'stateOptions' => $action->controller->getStateOptions(),
                        'typeOptions' => $action->controller->getTypeOptions(),
                    ];
                },
            ],
            'view' => [
                'class' => ViewAction::class,
                'on beforePerform' => function ($event) {
                    $action = $event->sender;
                    $action->getDataProvider()->query->addSelect('chain');
                },
            ],
            'issue' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:certificate', 'Successfully issued'),
                'error' => Yii::t('hipanel:certificate', 'Error issuing'),
            ],
            'reissue' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:certificate', 'Certificate reissue process was initiated. Now you should confirm the domain ownership using the selected domain control validation method.'),
                'error' => Yii::t('hipanel:certificate', 'Error reissuing'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:certificate', 'Certificate deleted'),
                'error' => Yii::t('hipanel:certificate', 'Error deleting'),
            ],
            'cancel' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:certificate', 'Certificate canceled'),
                'error' => Yii::t('hipanel:certificate', 'Error canceling'),
            ],
            'add-to-cart-renew' => [
                'class' => AddToCartAction::class,
                'productClass' => CertificateRenewProduct::class,
            ],
            'bulk-renewal' => [
                'class' => AddToCartAction::class,
                'productClass' => CertificateRenewProduct::class,
                'bulkLoad' => true,
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

    public function actionGetData($id)
    {
        if (Yii::$app->request->isAjax) {
            $data = Certificate::perform('get-data', ['id' => $id]);

            return DataView::widget(compact('data'));
        }
    }

    public function getStateOptions()
    {
        return Ref::getList('state,certificate', 'hipanel:certificate');
    }

    public function getTypeOptions()
    {
        return Ref::getList('type,certificate', 'hipanel:certificate');
    }
}
