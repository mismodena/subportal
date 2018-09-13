<?php
$this->breadcrumbs = array(
    'Nota Penagihan' => array('index'),
    $model->reqNumber,
);
?>

<h1>Nota Penagihan No. #<?php echo $model->reqNumber; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        "reqNumber",
        "salesName",
        array(
            "name" => "Tanggal Penagihan",
            "type" => "raw",
            "value" => date("d-m-Y", strtotime($model->reqDate)),
        ),       
        array(
            "name" => "Penagihan",
            "type" => "raw",
            "value" => number_format($model->invCount)." faktur, senilai Rp. ".number_format($model->invValue),
        ),      
        array(
            "name" => "Tanggal Realisasi",
            "type" => "raw",
            "value" => is_null($model->returnDate) ? "-" : date("d-m-Y", strtotime($model->returnDate)),
        ),
        array(
            "name" => "Realisasi",
            "type" => "raw",
            "value" =>is_null($model->returnDate) ? " - " :  number_format($model->retCount)." faktur, senilai Rp. ".number_format($model->retValue),
        ),
    ),
));
?>
<br/>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-grid',
	'dataProvider'=>$detail,
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
               'name'=>'Customer',                   
               'type'=>'raw',
               'value'=>'$data->customer',          
            ), 
            array(
               'name'=>'Faktur',                   
               'type'=>'raw',
               'value'=>'$data->docNumber',          
            ), 
            array(
                'name'=>'Tanggal',                   
                'type'=>'raw',
                'value'=>'date("d-m-Y", strtotime($data->invDate))',          
            ), 
            array(
                'name'=>'Nilai',                   
                'type'=>'raw',
                'value'=>'"Rp. " . number_format($data->invTotal)',     
                "htmlOptions" => array("style" => "text-align: right;"),
                "footer" => "Rp. ".number_format($model->invValue, 0),
                "footerHtmlOptions" => array("style" => "text-align: right;")
            ), 
            array(
                'name'=>'Penagihan',                   
                'type'=>'raw',
                'value'=>'is_null($data->retDate) ? " - " : $data->retType."<br />".$data->retNumber."<br />".$data->retDesc."<br/>".date("d-m-Y", strtotime($data->retDate))',  
            ), 
            
            array(
                'name'=>'Tertagih',                   
                'type'=>'raw',
                'value'=>'"Rp. " . number_format($data->retValue)',     
                "htmlOptions" => array("style" => "text-align: right;"),
                "footer" => "Rp. ".number_format($model->retValue, 0),
                "footerHtmlOptions" => array("style" => "text-align: right;")
            ), 
            array(
                'name'=>'Verifikasi',                   
                'type'=>'raw',
                'value'=>'$data->revNumber ',          
            ), 
            array(
                'name'=>'Terverifikasi',                   
                'type'=>'raw',
                'value'=>'"Rp. " . number_format($data->revValue)',     
                "htmlOptions" => array("style" => "text-align: right;"),
                "footer" => "Rp. ".number_format($model->revValue, 0),
                "footerHtmlOptions" => array("style" => "text-align: right;")
            ), 
            
             
	),
)); ?>
<br/>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'file-grid',
	'dataProvider'=>$file,
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
               'name'=>'Lampiran',                   
               'type'=>'raw',
               'value'=>'CHtml::link(CHtml::encode($data->fileName), Yii::app()->baseUrl.$data->filePath, array("target"=>"_blank"))',          
            ), 
	),
)); ?>
<br/>
<div class="group">
    <?php echo Yii::t('ui', 'Action'); ?>
</div>
<table>
    <tr>
        <td width="40%" align="center">                                                   
            <?php
                $level = Yii::app()->user->getState('level');
                if(($level == "Admin" || $level == "Finance") && $model->finRcv == "" && $model->realisasi == 0){
                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/ok.png", "Proses", array("title" => "Proses", 'width' => 50, 'height' => 50)), Yii::app()->createUrl("document/approval", array("id" => $model->reqID, "appr" => 1)));     
                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/notok.png", "Reject", array("title" => "Tolak", 'width' => 50, 'height' => 50)), Yii::app()->createUrl("document/approval", array("id" => $model->reqID, "appr" => 0)));
                }       
                if(($level == "Admin" || $level == "Finance") && $model->finRet == "" && $model->realisasi == 1){
                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/ok.png", "Proses", array("title" => "Proses", 'width' => 50, 'height' => 50)), Yii::app()->createUrl("document/verifikasi", array("id" => $model->reqID, "appr" => 1)));
                }   
            ?>                                                                                                   
        </td>  
        <td width="40%" align="center">                                                   
                                                                                                            
        </td>   
    </tr>   
</table>  
