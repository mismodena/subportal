<?php
$this->breadcrumbs=array(
	'Daftar Asset',
);


Yii::app()->clientScript->registerScript('searchAsset', "
 
$('.search-form form').submit(function(){
	$('#asset-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar Asset</h1>

<div class="search-form">
<?php
 $this->renderPartial('_search',array(
	'model'=>$model,
)); 
?>
</div><!-- search-form -->
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New Asset")), Yii::app()->createUrl("asset/create")); ?>&nbsp;
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/excel.png","Export",array("title"=>"Export to Excel")), Yii::app()->createUrl("asset/exportExcel")); ?>&nbsp;
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/download1.png","Manual",array("title"=>"Manual Book")), Yii::app()->baseUrl."/images/upload/ManualBookAsset.pdf");?>&nbsp;
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'asset-grid',
    	'dataProvider'=>$model->search(),
      // 'enablePagination'=>true,
      // 'ajaxUpdate'=>true,
      // 'enableSorting'=>true,
    	'filter'=>$model,
    	'columns'=>array(
    			array(
               'header'=>'Asset Number',                   
               'type'=>'raw',
               'value'=>'(CHtml::link($data["assetNumber"], Yii::app()->createUrl("asset/view",array("id"=>$data["assetID"]))))',                
              ), 
    		 array(
              'header'=>'Tipe Asset',
              'value'=>'$data["TypeName"]'
              ),
         array(
              'header'=>'Aktiva Tetap/Deskripsi',
              'value'=>'$data["assetDesc"]'
              ),
         array(
              'header'=>'Department',
              'value'=>'$data["Department"]'
              ),
         array(
              'header'=>'PIC',
              'value'=>'$data["modenaPIC"]'
              ),
         // array(
         //      'header'=>'Status',
         //      'value'=>'$data["statusName"]'
         //      ),
         array(
              'header'=>'Keterangan',
              'value'=>'$data["assetRemarks"]'
              ),
         array(
              'header'=>'No. MAT',
              'type'=>'raw',
               'value'=>'(CHtml::link($data["mutationNo"], Yii::app()->createUrl("mutation/view",array("id"=>$data["mutationNo"]))))',                
              ),
         // array(
         //      'header'=>'No Asset Lama',
         //      'value'=>'Asset::model()->find("assetID=:assetID", array(":assetID"=>$data->assetID))->assetNumber'
         //      ),

    		 array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{update} -- {delete}',
                    'buttons'=>array(                    
                        'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("asset/update", array("id"=>$data["assetID"]))',                            
                        ),
                         'delete'=>array(
                                'url'=>'$this->grid->controller->createUrl("asset/delete", array("id"=>$data["assetID"]))',                            
                        ),
                    ),    
                ),

    		// array(
    		// 	'class'=>'CButtonColumn',
    		// ),
	),
    )); 
?>

<?php echo CHtml::beginForm(array('asset/exportExcel'));  ?>

<input name="AssetUnion[assetNumber]" id="keyWord" maxlength="15" value="" type="hidden">
<!-- <input name="asset[TypeName]" id="TypeName" value="" type="hidden">
<input name="asset[assetDesc]" id="assetDesc" maxlength="255" value="" type="hidden">
<input name="asset[deptName]" id="deptName" maxlength="200" value="" type="hidden">
<input name="asset[userName]" id="userName" maxlength="200" value="" type="hidden">
<input name="asset[assetCondition]" id="assetCondition" maxlength="200" value="" type="hidden">
<input name="asset[assetLocation]" id="assetLocation" maxlength="200" value="" type="hidden">
<input name="asset[statusName]" id="statusName" maxlength="255" value="" type="hidden"> -->
<input type="submit" value="Export" id="exportExcel"  /> 
<?php echo CHtml::endForm(); ?>

 
<script type="text/javascript">

  $( document ).ajaxComplete(function() {
    /*console.log("Test Complete");*/
    
    var asset_grid = document.getElementById("asset-grid");
    var input_grid = asset_grid.getElementsByTagName("input");
    for(var i = 0; i < input_grid.length; i++){
      var name_input = input_grid[i].getAttribute("name");
      
      if(name_input !== ""){
        var explode = name_input.split("AssetUnion[");
        //console.log(explode[1].substr(0,(explode[1].length - 1)));
        var id_input = explode[1].substr(0,(explode[1].length - 1));
        console.log(input_grid[i].value);
        document.getElementById(id_input).value = input_grid[i].value;
        document.getElementById("exportExcel").removeAttribute("style");
      }
    } 
  }); 
 </script>

