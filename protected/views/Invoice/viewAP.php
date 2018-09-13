<?php

$this->breadcrumbs=array(
	'Daftar Penerimaan Faktur'=>array('indexAP'),
	$model->apInvNo,
);

?>

<h1>Penerimaan Dokumen No. #<?php echo $model->recNo; ?></h1>
<td>
<?php echo $model->status == 0 ? CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/up.png"), array('invoice/updateAP', 'id'=>$model->apInvID)) : "Invoice Telah Diterima"; ?> &nbsp; &nbsp; &nbsp;
<?php  echo $model->status == 0 ? CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/cek.png"), array('invoice/verified', 'id'=>$model->apInvID)) : ""; ?> &nbsp;
<?php // echo $model->status == 1 ? CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/index.jpg"), array('invoice/printAPFinance', 'id'=>$model->apInvID), array('target'=>'_blank')) : ""; ?> 
  
</td><br/><br/>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
                'apSupplier',               
                array(
                    'name'=>'recDate',
                    'value' =>$model->recDate == NULL ? ""  : date('d-m-Y', strtotime($model->recDate)),  
                ),
                array(
                    'name'=>'recDateInvoice',
                    'value' =>$model->recDateInvoice == NULL ? ""  : date('d-m-Y', strtotime($model->recDateInvoice)), 
                     
                ),
                array(
                    'name'=>'apInvTotal',
                    'value'=>  number_format($model->apInvTotal),  
                ), 
                /*array(
                    'name'=>'Total Invoice diterima',
                    'value'=>  number_format($model->apInvTotalDetail),  
                ),*/            
                'apDesc',
                
                //'docCategory',
                //array(
                //    'name'=>'status',
                //    'value'=>  Utility::getApInvoiceStatus($model->status),  
                //),
        ),
)); ?>
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inv-detail2-grid',
	'dataProvider'=>$detailInv,	
	'columns'=>array(
                array(
                   'name'=>'Nomor Invoice',                   
                   'type'=>'raw',
                   'value'=>'$data->apInvNo',
                   'footer'=>"Total Invoice diterima: " .number_format($model->apInvTotalDetail,0),
                    'footerHtmlOptions'=>array('style' => 'text-align: left;')                      
                ),
                array(
                       'name'=>'Tanggal Invoice',                   
                       'type'=>'raw',
                       'value'=>'date("d-m-Y", strtotime($data->apInvDate))', 
                       'htmlOptions'=>array('style' => 'width:20%;'),                    
                    ),
                /*array(
                       'name'=>'Tanggal Jatuh Tempo',                   
                       'type'=>'raw',
                       'value'=>'date("d-m-Y", strtotime($data->apDueDate))',   
                        
                    ),*/
                array(
                        'name'=>'Total',                   
                        'type'=>'raw',
                        'value'=>'number_format($data->apInvTotal,0)',                     
                        //'footer'=>number_format($model->apInvTotal,0),
                        'htmlOptions'=>array('style' => 'width:10%; '),
                        'footerHtmlOptions'=>array('style' => 'text-align: right;')
                    ),
                
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   //'value'=>'$data->rejected',
                   'value'=>'$data->rejected == 1  ? "Diterima" : "$data->apInvDetDesc"', 
                   'headerHtmlOptions' => array('style'=>'width:15%; text-align: right;'), 
                                      
                ),
                array(
                   'name'=>'',                   
                   'type'=>'raw',
                   //'value'=>'$data->rejected',
                   'value'=>'$data->rejected ? CHtml::checkBox("check", $data->rejected, array("disabled"=>"disabled")) : ""', 
                   'headerHtmlOptions' => array('style'=>'width:2%;'), 
                                      
                ),

	),
)); ?>
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inv-detail-grid',
	'dataProvider'=>$detail,
	//'filter'=>$model,
	'columns'=>array(
                array(
                   'name'=>'Kelengkapan Dokumen',                   
                   'type'=>'raw',
                   'value'=>'CHtml::checkBox("check", $data->docValue, array("disabled"=>"disabled"))." ".$data->docName',  
                   'headerHtmlOptions' => array('style'=>'width:20px;'),
                ),
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw', 
                   'value' =>'$data->descDoc',
                   'headerHtmlOptions' => array('style'=>'width:20px;'),
                ),
                
	),
)); ?>



