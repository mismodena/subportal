<?php
$this->breadcrumbs=array(
	'Daftar Serah Terima Faktur / FPP',
);
?>
<br/>
<h1>Log Book FPP / Faktur</h1>

<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>array(
        'Faktur'=> $this->renderPartial("_TTFaktur", array('model' => $model,), true, false), 
        'FPP' =>$this->renderPartial("_TTFPP", array('model' => $model2, ), true, false),         
    ),
    // additional javascript options for the tabs plugin
    'options'=>array('collapsible'=>false,),
));

?>
</div><!-- search-form -->

