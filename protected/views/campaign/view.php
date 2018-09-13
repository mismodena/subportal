<?php
/* @var $this CampaignController */
/* @var $model Campaign */

$this->breadcrumbs=array(
	'Daftar Promo'=>array('index'),
	$model->campaignNo,
);
?>

<h1>Detail Promo #<?php echo $model->campaignNo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'campaignNo',
		'campaignName',
		array(
                    'label'=>'Periode',
                    'value'=>date("d-m-Y", strtotime($model->campaignFrom))." s/d ".date("d-m-Y", strtotime($model->campaignTo)) ,
                ),
                array(
                    'label'=>'Mulai Berlaku',
                    'value'=>date("d-m-Y", strtotime($model->CNStartDate)),
                ),
                'campaignCategory',
		'campaignDesc',            
                array(
                    'label'=>'File',
                    'value'=>str_replace("/upload/cn/","",$model->excelFiles),
                ),
	),
)); 

echo '<br/>';
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'campaign-grid',
	'dataProvider'=>$excel,
	'columns'=>array(                
                array(
                   'name'=>'Kode Dealer',                   
                   'type'=>'raw',
                    'value' => 'CHtml::encode($data["idcust"])',
                    //'headerHtmlOptions' => array('style'=>'width:45%;'),
                ),
                array(
                   'name'=>'Nama Dealer',                   
                   'type'=>'raw',
                    'value' => 'CHtml::encode($data["namecust"])',
                    //'headerHtmlOptions' => array('style'=>'width:45%;'),
                ),
                array(
                   'name'=>'Nilai CN',                   
                   'type'=>'raw',
                    'value' => 'number_format(CHtml::encode($data["cnvalue"]))',
                    'headerHtmlOptions' => array('style'=>'width:25%; text-align: right'),
                    'htmlOptions' => array('style'=>'width:25%; text-align: right'),
                ),
	),
    )); 
 echo '<br/>';


?>


<div style="display: block" id="containerTotal">
    <table width="100%" border="0">
        <tr>
            <td style="text-align: right">
                <h3>TOTAL</h3>
            </td>
            <td width="18%" style="text-align: center">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($total); ?></h3>
            </td>
        </tr>                  
    </table>
</div>

<?php
echo '<br/>';
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'approval-grid',
	'dataProvider'=>$approval,
	'columns'=>array(                
                array(
                   'name'=>'Melalui Persetujuan:',                   
                   'type'=>'raw',
                    'value' => '$data->persetujuan',
                ),
	),
    )); 
 echo '<br/>';


?>
