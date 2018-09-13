<?php
$this->breadcrumbs = array(
    ' Persetujuan Pengajuan Claim',
);
?>

<h1> Persetujuan Pengajuan Claim</h1>

<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                "name" => "Nomor",
                "value" => $model->bqClaimNo,
                "type" => "raw"
            ),
            array(
                "name" => "Tanggal",
                "value" => date("d-m-Y", strtotime($model->claimDate)),
                "type" => "raw"
            ),
            array(
                "name" => "Pemohon",
                "value" => $model->userName,
                "type" => "raw"
            ),
            array(
                "name" => "Cabang",
                "value" => $model->deptName,
                "type" => "raw"
            ),
            array(
                "name" => "Dealer",
                "value" => $model->idCust,
                "type" => "raw"
            ),
        ),
    ));
?>
<br/>
<?php
//print_r($detail);
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'master-trading-grid',
        'dataProvider' => $detail,
        'enableSorting' => false,
        //'filter'=>$model,
        'columns' => array(
            array(
                'name' => 'Keterangan',
                'type' => 'raw',
                'value' => '$data->nonItemDesc',
            ),
            array(
                'name' => 'Nilai',
                'type' => 'raw',
                'value' => 'number_format($data->nonItemValue, 0)',
            ),
        ),
    ));
?>
<br/>
<?php

    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                "name" => "Sub Total",
                "value" =>  number_format($model->totalNonItems, 0),
                "type" => "raw"
            ),
            array(
                "name" => "BQ",
                "value" =>  number_format($model->bqUsed, 0),
                "type" => "raw"
            ),
            array(
                "name" => "TQ",
                "value" =>  number_format($model->tqUsed, 0),
                "type" => "raw"
            ),
            array(
                "name" => "Total Claim",
                "value" =>  number_format($model->claimTotal, 0),
                "type" => "raw"
            ),
        ),
    ));

?>
<br/>
<div class="form">
         
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'bq-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true,
        'action' => Yii::app()->createUrl('bq/execClaim'),  //<- your form action here
    )); ?>

        <div class="group">
            <?php echo Yii::t('ui', 'Persetujuan'); ?>
        </div>
        <div>
        <table>
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'statusDesc'); ?>
                        <?php echo $form->textArea($model, 'statusDesc', array('cols'=>80,'rows'=>8, 'placeholder' => 'keterangan')); ?>
                        <?php echo $form->error($model, 'statusDesc'); ?>
                    </div>                               
                </td>
            </tr>
        </table>
        </div>
        <br/>        
        <div>
            <table border="0" width="50%">
                <tr>
                    <td width="40%" align="center">                                                   
                        <?php
                            echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/ok.png", "Setujui", array("title" => "Setujui", 'width' => 50, 'height' => 50)), "#", array('onclick'=>'approve(1)'));     
                            echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/notok.png", "Tidak Setujui", array("title" => "Tidak Setujui", 'width' => 50, 'height' => 50)), "#", array('onclick'=>'approve(0)'));                               
                        ?>                                                                                                   
                    </td>   
                </tr>   
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->hiddenField($model, 'bqClaimID', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                           
                        </div>                               
                    </td>
                </tr>                
            </table>
        </div>                  

<?php $this->endWidget(); 
    
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerScript('list', "
            
            function approve(nilai)
            {                
                console.log('masuk');
                var mode = nilai;
                var id = $('#BQClaim_bqClaimID').val();
                var desc = $('#BQClaim_statusDesc').val();
                
                if(desc.trim() == ''){
                    alert('Keterangan harus diisi.');
                    return;
                }
                else {                   
                    link = '" . $this->createUrl('/bq/clappr') . "?id='+id+'&mode='+mode+'&desc='+desc 
                    console.log(link);
                    window.location = link;
                }
                
            }
        ", CClientScript::POS_END);

?>
 
</div><!-- form -->

<div id="mydiv"  style="display: none "> <iframe id="frame" src="" width="100%" height="300">  </iframe></div>