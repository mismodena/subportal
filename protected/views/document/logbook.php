<?php
$this->breadcrumbs=array(
	'Daftar Serah Terima Faktur / eFaktur / Surat Jalan',
);
?>
<br/>
<h1>Log Book </h1>

<?php
//$this->widget('zii.widgets.jui.CJuiTabs', array(
//    'tabs'=>array(
//        'Faktur'=> $this->renderPartial("_faktur", array('model' => $faktur ,), true, false), 
//        'eFaktur' =>$this->renderPartial("_efaktur", array('model' => $efaktur, ), true, false), 
//        'SJ' =>$this->renderPartial("_sj", array('model' => $sj, ), true, false),         
//    ),
//    // additional javascript options for the tabs plugin
//    'options'=>array('collapsible'=>false,),
//));

?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

</div><!-- search-form -->

