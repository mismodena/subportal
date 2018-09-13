<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'bqClaimNo',
        array(
            'label' => 'Tanggal',
            'type' => 'raw',
            'value' => date("d-m-Y", strtotime($model->claimDate))
        ),
        array(
            'label' => 'Pemohon',
            'type' => 'raw',
            'value' => $model->userName),
        array(
            'label' => 'Dealer',
            'type' => 'raw',
            'value' => $model->idCust),
    ),
));
?>
<br/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'bq-detail-grid',
    'dataProvider' => $detail,
    'enableSorting' => false,
    'columns' => array(
//                array(                    
//                    'header'=>'No.',
//                    'value'=>'$row+1'
//                ),
        array(
            'name' => 'Keterangan',
            'type' => 'raw',
            'value' => '$data->nonItemDesc',
        ),
        array(
            "name" => "Nilai",
            "value" => '"Rp. ".number_format($data->nonItemValue)'
        ),
    ),
));
?>
<br/>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'master-open-form',
        'enableAjaxValidation' => true,
    ));
    
    Yii::app()->clientScript->registerScript('JQuery', "      

        $( document ).ready(function() {
            var bqUsed = $('#BQClaim_bqUsed').val();
            var tqUsed = $('#BQClaim_tqUsed').val();
            var bqAvail = $('#BQClaim_bqAvail').val();  
            var tqAvail = $('#BQClaim_tqAvail').val();
            var claimTotal = $('#BQClaim_claimTotal').val();
            var totalItems = $('#BQClaim_totalItems').val();
            
            $('#BQClaim_bqUsed').val(formatNumber(parseInt(bqUsed), 0,',','','','','-',''));
            $('#BQClaim_tqUsed').val(formatNumber(parseInt(tqUsed), 0,',','','','','-',''));
            $('#BQClaim_bqAvail').val(formatNumber(parseInt(bqAvail), 0,',','','','','-',''));
            $('#BQClaim_tqAvail').val(formatNumber(parseInt(tqAvail), 0,',','','','','-',''));
            $('#BQClaim_claimTotal').val(formatNumber(parseInt(claimTotal), 0,',','','','','-',''));
            $('#BQClaim_totalItems').val(formatNumber(parseInt(totalItems), 0,',','','','','-',''));


        })
        
        $('#BQClaim_tqAvail').live('blur', function() {            
            calcTotal();
        });
        
        $('#BQClaim_bqAvail').live('blur', function() {            
            calcTotal();
        });
        
        function calcTotal(){
            var bqUsed = parseFloat($('#BQClaim_bqUsed').val().replace(/,/gi,''));
            var tqUsed = parseFloat($('#BQClaim_tqUsed').val().replace(/,/gi,''))
            var bqAvail = parseFloat($('#BQClaim_bqAvail').val().replace(/,/gi,''))
            var tqAvail = parseFloat($('#BQClaim_tqAvail').val().replace(/,/gi,''))
            var claimTotal = parseFloat($('#BQClaim_claimTotal').val().replace(/,/gi,''))
            var totalItems = parseFloat($('#BQClaim_totalItems').val().replace(/,/gi,''))
            
            if(bqAvail > bqUsed){
                bqAvail = bqUsed;
            }
            if(tqAvail > tqUsed){
                tqAvail = tqUsed;
            }
            
            totalItems = bqAvail + tqAvail;
            $('#BQClaim_bqAvail').val(formatNumber(parseInt(bqAvail), 0,',','','','','-',''));
            $('#BQClaim_tqAvail').val(formatNumber(parseInt(tqAvail), 0,',','','','','-',''));
            $('#BQClaim_totalItems').val(formatNumber(parseInt(totalItems), 0,',','','','','-',''));
        }
        
        function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {
            num=String(num).replace(/,/gi,'');
            var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;
        };
    ", CClientScript::POS_END);
    ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="group">    
        <?php
//            echo "<pre>";
//            print_r($header);
//            echo "</pre>";
//            exit();
        if ($model->isNewRecord) {
            echo Yii::t('ui', 'Realisasi');
        } else {
            echo Yii::t('ui', 'Realisasi');
        }
        ?>
    </div>
    <div>
        <table> 
            <tr>
                <td>
                    <div class="simple">
                        &nbsp;
                    </div>                               
                </td>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($header, 'voucher'); ?>
                        <?php echo $form->textField($header, 'voucher', array('size' => 25, 'maxlength' => 30,  ));?> 
                        <?php echo $form->error($header, 'voucher'); ?>
                    </div>                           
                </td>  
                
            </tr> 
            <tr>
                <td>
                    <div class="simple">
                        &nbsp;
                    </div>                               
                </td>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($header, 'tqUsed'); ?>
                        <?php 
                            echo $form->textField($header, 'tqUsed', array('size' => 25, 'maxlength' => 30, 'readonly' => true, 'class' => 'tqavail','style' => 'text-align: right', ));?> - <?php
                            echo $form->textField($header, 'tqAvail', array('size' => 25, 'maxlength' => 30,  'class' => 'tqused','style' => 'text-align: right', ));
                            ?>
                        <?php echo $form->error($header, 'tqUsed'); ?>
                    </div>                               
                </td>                      
            </tr> 
            <tr>
                <td>
                    <div class="simple">
                        &nbsp;
                    </div>                               
                </td>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($header, 'bqUsed'); ?>
                        <?php 
                            echo $form->textField($header, 'bqUsed', array('size' => 25, 'maxlength' => 30, 'readonly' => true, 'style' => 'text-align: right', )); ?> - <?php
                            echo $form->textField($header, 'bqAvail', array('size' => 25, 'maxlength' => 30, 'style' => 'text-align: right', ));
                        ?>
                        <?php echo $form->error($header, 'bqUsed'); ?>
                    </div>                               
                </td>                      
            </tr>                 
            <tr>
                <td>
                    <div class="simple">
                        &nbsp;
                    </div>                               
                </td>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($header, 'totalAll'); ?>
                        <?php echo $form->textField($header, 'claimTotal', array('size' => 25, 'maxlength' => 30, 'readonly' => true, 'style' => 'text-align: right', ));?> - <?php 
                                echo $form->textField($header, 'totalItems', array('size' => 25, 'maxlength' => 30, 'readonly' => true, 'style' => 'text-align: right', ));
                        ?>
                        
                            <?php echo $form->error($header, 'totalAll'); ?>
                        
                    </div>                               
                </td>                      
            </tr> 
        </table>
    </div>

    <div class="row buttons">
        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Save!' : 'Simpan', array('class' => 'btn btn-sm')); ?>
        <?php echo CHtml::link('Simpan', "javascript:execForm();", array('confirm'=>'Submit realisasi?', 'class' => 'btn btn-sm', ));  ?>  
    </div>

<?php $this->endWidget();
?>

</div><!-- form -->