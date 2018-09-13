<?php
/*
Yii::app()->clientScript->registerCss('mycss', '
    <style>
    table.excel {
        border-style:ridge;
        border-width:1;
        border-collapse:collapse;
        font-family:sans-serif;
        font-size:12px;
    }
    table.excel thead th, table.excel tbody th {
        background:#CCCCCC;
        border-style:ridge;
        border-width:1;
        text-align: center;
        vertical-align:bottom;
    }
    table.excel tbody th {
        text-align:center;
        width:20px;
    }
    table.excel tbody td {
        vertical-align:bottom;
    }
    table.excel tbody td {
        padding: 0 3px;
        border: 1px solid #EEEEEE;
    }
    </style>
');*/

$this->breadcrumbs=array(
	'Daftar Promo'=>array('index'),
	$model->campaignNo,
);
?>

<h1>Detail Persetujuan Promo #<?php echo $model->campaignNo; ?></h1>

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
$this->renderPartial('_formApproval', array('approval'=>$model,));

?>

