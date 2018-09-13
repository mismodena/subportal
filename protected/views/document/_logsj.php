<div id="sj-grid" class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th id="sj-grid_c0">Surat  Jalan</th><th id="sj-grid_c1">Model</th><th id="sj-grid_c2">Desc</th><th id="sj-grid_c3">Qty</th></tr>
        </thead>
        <tbody>
            <?php 
                $cls = "even";
                $mdl = $model;
                $cnr = 0;
                foreach ($model as $data){
                    if($data['docNumber']){
                        $cls = ($cls == "even") ? "odd" : "even";
                        $cnt = 0;
                        $cnd = 0;
                        $chk = 0;
                        foreach ($mdl as $dt){
                            if($dt['docNumber'] && $chk == $cnr){
                                $cnd++;
                                if($cnd == 2){
                                    break;
                                }
                            }
                            if($chk == $cnr){
                                $cnt++;
                            }
                            if($chk < $cnr){
                                $chk++;
                            }
                        }
                    } 
                    if($data['docNumber']){
                        ?>
                        <tr class="<?php echo $cls; ?>">
                            <td rowspan="<?php echo $cnt; ?>">
                                <?php //echo $data['docNumber']; 
                                   echo CHtml::link($data['docNumber'], "#", array("onClick"=>"openDialog('".Yii::app()->createUrl('document/viewlog', array('id' =>$data['docNumber'], 'doc' =>$data['docID']))."');"))?>
                            </td>
                            <td><?php echo $data['itemNo']; ?></td>
                            <td><?php echo $data['itemName']; ?></td>
                            <td><?php echo $data['qtyShipment']; ?></td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr class="<?php echo $cls; ?>">
                            <td><?php echo $data['itemNo']; ?></td>
                            <td><?php echo $data['itemName']; ?></td>
                            <td><?php echo $data['qtyShipment']; ?></td>
                        </tr>
                        <?php
                    }
                    $cnr++;                 
                }
            
            ?>
        </tbody>
    </table>
</div>
<style type="text/css">
    #cru-dialog {
        overflow: hidden;
    }
</style>
<?php 

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dialog',
    'options'=>array(
        'title'=>'Log Book',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>780,
        'height'=>200,
        'resizable' => false
    ),
    ));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget();

Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerScript('openLog', '
            
            function openDialog(url){
               
               $("#cru-frame").attr("src", url); 
               $("#cru-dialog").dialog("open");  return false;
            }
        ', CClientScript::POS_END);
    
    
    ?>

