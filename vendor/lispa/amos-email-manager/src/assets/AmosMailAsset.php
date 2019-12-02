<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\email
 * @category   CategoryName
 */

namespace lispa\amos\emailmanager\assets;

use yii\web\AssetBundle;

/**
 * Class AmosMailAsset
 * @package lispa\amos\emailmanager\assets
 */
class AmosMailAsset extends AssetBundle
{
    public $sourcePath = '@vendor/lispa/amos-email-manager/src/assets/web';

    public $css = [
        'css/less/amos_mail.less'
    ];

    public $depends = [
    ];

    public function init()
    {
        $moduleL = \Yii::$app->getModule('layout');
        if(!empty($moduleL))
        { $this->depends [] = 'lispa\amos\layout\assets\BaseAsset'; }
        else
        { $this->depends [] = 'lispa\amos\core\views\assets\AmosCoreAsset'; }
        parent::init(); // TODO: Change the autogenerated stub
    }

}