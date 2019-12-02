<?php
use lispa\amos\core\helpers\Html;
use lispa\amos\core\forms\ActiveForm;
use kartik\builder\Form;
use lispa\amos\core\forms\Tabs;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


$this->title = Yii::t('cruds', 'Aggiorna COMUNI');
$this->params['breadcrumbs'][] = ['label'=>'comuni', 'url'=>'/comuni'];
$this->params['breadcrumbs'][] = $this->title;
?>



<?php $form = ActiveForm::begin(); ?>
<?php $this->beginBlock('principale'); ?>

<?php $this->endBlock('principale'); ?>
<?php $itemsTab[] = [
    'label' => '',
    'content' => $this->blocks['principale'],
];
?>

<?= Tabs::widget(
    [
        'encodeLabels' => false,
        'items' => $itemsTab
    ]
);
?>

<?php echo Html::input('hidden', 'confirm', true); ?>

<legend>Dati che andrebbero aggiornati: (totale: <?= count($dati['update']);?>)</legend>

<div class="row">
    <div class="col-xs-3"><strong>ID</strong></div>
    <div class="col-xs-3"><strong>Comune Nome</strong></div>
    <div class="col-xs-3"><strong>Provincia</strong></div>
    <div class="col-xs-3"><strong>Regione</strong></div>
</div>


<?php
if( empty($dati['update'])): ?>
    <div class="row"><div class="col-xs-4">Nessun comune da variare in sospeso</div></div>
    <?php
else:

    foreach ( $dati['update'] as $k => $array_data ): ?>
        <div class="row">
            <div class="col-xs-3"><?= $array_data['comuneRecord']->id; ?></div>
            <div class="col-xs-3"><?= $array_data['comuneRecord']->nome; ?></div>
            <div class="col-xs-3"><?= $array_data['comuneRecord']->istatProvince->nome; ?></div>
            <div class="col-xs-3"><?= $array_data['comuneRecord']->istatRegioni->nome; ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>





<div class="m-t-30">

    <?php
    if( !empty($dati)):
        echo Html::submitButton('Genera', ['name'=> 'submit', 'value'=> true, 'class' => 'btn btn-primary'] );
    endif; ?>
<?php ActiveForm::end(); ?>

</div>

