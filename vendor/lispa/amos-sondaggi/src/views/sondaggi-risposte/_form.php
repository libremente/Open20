<?php

use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\sondaggi\AmosSondaggi;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var lispa\amos\sondaggi\models\SondaggiRisposte $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="sondaggi-risposte-form">
    
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); ?>
    
    <?php $this->beginBlock('generale'); ?>

    <div class="col-lg-6 col-sm-6">
        
        <?= $form->field($model, 'risposta')->textarea(['rows' => 6]) ?>
    </div>

    <div class="col-lg-6 col-sm-6">
        
        <?=
        // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::activeField
        $form->field($model, 'sondaggi_domande_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(lispa\amos\sondaggi\models\SondaggiDomande::find()->all(), 'id', 'id'), ['prompt' => AmosSondaggi::t('amossondaggi', 'Select')]
        );
        ?>
    </div>

    <div class="col-lg-6 col-sm-6">
        
        <?=
        // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::activeField
        $form->field($model, 'pei_accessi_servizi_facilitazione_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(backend\modules\peipoint\models\PeiAccessiServiziFacilitazione::find()->all(), 'id', 'id'), ['prompt' => AmosSondaggi::t('amossondaggi', 'Select')]
        );
        ?>
    </div>

    <div class="col-lg-6 col-sm-6">
        
        <?=
        // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::activeField
        $form->field($model, 'sondaggi_risposte_sessioni_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(lispa\amos\sondaggi\models\SondaggiRisposteSessioni::find()->all(), 'id', 'id'), ['prompt' => AmosSondaggi::t('amossondaggi', 'Select')]
        );
        ?>
    </div>
    <div class="clearfix"></div>
    <?php $this->endBlock(); ?>
    
    <?php
    $itemsTab[] = [
        'label' => AmosSondaggi::tHtml('amossondaggi', 'generale '),
        'content' => $this->blocks['generale'],
    ];
    ?>
    
    <?= Tabs::widget(
        [
            'encodeLabels' => false,
            'items' => $itemsTab
        ]
    ); ?>
    <?= CreatedUpdatedWidget::widget(['model' => $model]) ?>
    <div id="form-actions" class="bk-btnFormContainer">
        <?= Html::a(AmosSondaggi::t('amossondaggi', 'Chiudi'), Url::previous(), [
            'class' => 'btn btn-warning'
        ]); ?>
        <?= Html::submitButton($model->isNewRecord ?
            AmosSondaggi::tHtml('amossondaggi', 'Inserisci') :
            AmosSondaggi::tHtml('amossondaggi', 'Salva'), [
            'class' => $model->isNewRecord ?
                'btn btn-success' :
                'btn btn-primary'
        ]); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>