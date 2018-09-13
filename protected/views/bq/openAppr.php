<?php
$this->breadcrumbs = array(
    ' Persetujuan Pengajuan Target Dealer',
);
?>

<h1> Persetujuan Pengajuan Target Dealer</h1>

<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                "name" => "Pemohon",
                "value" => $model->userName,
                "type" => "raw"
            ),
            array(
                "name" => "Periode",
                "value" => $model->fiscalPeriod,
                "type" => "raw"
            ),
            array(
                "name" => "Cabang",
                "value" => $model->deptName,
                "type" => "raw"
            ),
            array(
                "name" => "Dealer",
                "value" => $model->nameCust,
                "type" => "raw"
            ),
            array(
                "name" => "Revisi",
                "value" => $model->revNo,
                "type" => "raw"
            ),
            array(
                "name" => "Target",
                "value" =>  number_format($model->salesTarget, 0). " / ".number_format($model->lastQ, 0),
                "type" => "raw"
            ),
            array(
                "name" => "Open TQ",
                "value" =>  number_format($model->openTarget, 0). " / ".number_format(Utility::getMaxValue($model->salesTarget), 0),
                "type" => "raw"
            ),
            array(
                "name" => "Bonus BQ",
                "value" =>  number_format($model->openBonus, 0),
                "type" => "raw"
            ),
        ),
    ));
?>

<div class="form">
         
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'bq-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true,
        'action' => Yii::app()->createUrl('bq/execOpen'),  //<- your form action here
    )); ?>

        <div class="group">
            <?php echo Yii::t('ui', 'Persetujuan'); ?>
        </div>
        <div>
        <table>
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'openDesc'); ?>
                        <?php echo $form->textArea($model, 'openDesc', array('cols'=>80,'rows'=>8, 'placeholder' => 'keterangan')); ?>
                        <?php echo $form->error($model, 'openDesc'); ?>
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
                            <?php echo $form->hiddenField($model, 'openID', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>
                            <?php echo $form->hiddenField($model, 'status', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                              
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
                var id = $('#BQOpen_openID').val();
                var desc = $('#BQOpen_openDesc').val();
                
                if(desc.trim() == ''){
                    alert('Keterangan harus diisi.');
                    return;
                }
                else {
                    link = '" . $this->createUrl('/bq/opappr') . "?id='+id+'&mode='+mode+'&desc='+desc 
                    window.location = link;
                }
                
            }
        ", CClientScript::POS_END);

?>
 
</div><!-- form -->

<div id="mydiv"  style="display: none "> <iframe id="frame" src="" width="100%" height="300">  </iframe></div>