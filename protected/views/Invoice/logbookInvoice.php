
<?php
$this->breadcrumbs=array(
	'Daftar Serah Terima Invoice / FPP',
);
?>
<br/>
<h1>Status Invoice</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->
<br/>

<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>array(
        'Diterima'=> $this->renderPartial("_InvoiceTerima", array('model' => $model,), true, false), 
        'Ditolak' =>$this->renderPartial("_InvoiceTolak", array('model' => $model2, ), true, false),         
    ),
    // additional javascript options for the tabs plugin
    'options'=>array('collapsible'=>false,),
));

?>
</div>