<?php
/**
 * SSL certificates module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-certificate
 * @package   hipanel-module-certificate
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\widgets;

class CertificateState extends \hipanel\widgets\Type
{
    /** {@inheritdoc} */
    public $model         = [];
    public $values        = [];
    public $defaultValues = [
        'none'    => ['ok'],
        'danger'  => ['blocked'],
        'default' => ['deleted', 'cancelled'],
        'warning' => ['expired'],
    ];
    public $field = 'state';
    public $i18nDictionary = 'hipanel:certificate';
}
