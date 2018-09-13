<?php

$this->breadcrumbs=array(
	'Daftar PI'=>array('indexPI'),
	$model->invNo,
);

?>

<h1>Proforma Invoice No. #<?php echo $model->invNo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'invNo',		
                array(
                    'name'=>'invDate',
                    'value'=>date("d-m-Y", strtotime($model->invDate)),  
                ),
                'poNo',
                'poName',
                'accName'
	),
)); ?>
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inv-detail-grid',
	'dataProvider'=>$detail,
	//'filter'=>$model,
	'columns'=>array(
                array(
                   'name'=>'Model',                   
                   'type'=>'raw',
                   'value'=>'$data->itemModel',  
                   'headerHtmlOptions' => array('style'=>'width:130px;'),
                ),
                array(
                   'name'=>'Deskripsi',                   
                   'type'=>'raw',
                   'value'=>'$data->itemDesc',                   
                ),
                array(                    
                    'header'=>'Unit Price',
                    'value'=>'"Rp. ".number_format($data->unitPrice)',
                    'htmlOptions' => array('style'=>'text-align:right;'),
                    'headerHtmlOptions' => array('style'=>'width:100px;text-align:right;'),
                ),
                array(                    
                    'header'=>'Qty',
                    'value'=>'number_format($data->unitQty)',
                    'htmlOptions' => array('style'=>'text-align:right;'),
                    'headerHtmlOptions' => array('style'=>'width:40px;text-align:right;'),
                ),
                array(                    
                    'header'=>'Total',
                    'value'=>'"Rp. ".number_format($data->unitQty * $data->unitPrice)',
                    'htmlOptions' => array('style'=>'text-align:right;'),
                    'headerHtmlOptions' => array('style'=>'width:180px;text-align:right;'),
                ),
	),
)); ?>
<br />
<div style="display: block" id="containerTotal">
    <table width="100%" border="0">      
        <tr>
            <td style="text-align: right">
                <h3>Sub Total</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->grand); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>Diskon</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->invDisc); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>DP</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->invDP); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>Retensi</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->invRetensi); ?></h3>
            </td>
        </tr>
        <tr>
            <td style="text-align: right">
                <h3>Total</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->invTotal - $model->invDisc - $model->invDP - $model->invRetensi); ?></h3>
            </td>
        </tr> 
        <tr>
            <td style="text-align: right">
                <h3>PPn</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format(($model->invTotal - $model->invDisc - $model->invDP  - $model->invRetensi) * 0.1); ?></h3>
            </td>
        </tr> 
        <tr>
            <td style="text-align: right">
                <h3>Grand Total</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->invTotalWtx); ?></h3>
            </td>
        </tr> 
        <?php
            if($model->invTempDP > 0){
                echo '<tr>
                        <td style="text-align: right">
                            <h3>DP '. number_format($model->invTempDP).' %</h3>
                        </td>
                        <td width="18%" style="text-align: right">
                            <h3 id="subTotal">'. number_format(($model->invTempDP/100)*$model->invTotalWtx).'</h3>
                        </td>
                    </tr> ';
            }
        ?>
    </table>
</div>


<?php 

    if($model->status==0)
    {
        $this->renderPartial('_formVerify', array('model'=>$model,));
    }
 ?>

