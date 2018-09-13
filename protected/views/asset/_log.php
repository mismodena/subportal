<?php 
    echo "<br>";
    echo "<b>LOGBOOK Asset</b>";
    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'asset-grid',
    'dataProvider'=>$history,
    'columns'=>array(
                array(                    
                    'header'=>'No.',
                    'value'=>'$row+1',
                    'headerHtmlOptions' => array('style'=>'width:5%;'),
                ),
                array(                    
                    'header'=>'Nomor MAT',
                    'value'=> 'MutationDetail::model()->find("assetID=:assetID", array(":assetID"=>$data->assetID))->mutationNo',
                    'headerHtmlOptions' => array('style'=>'width:25%;'),
                ),
                array(                    
                    'header'=>'History Asset',
                    //'value'=> 'Asset::model()->find("assetID=:assetID", array(":assetID"=>$data->assetID))->assetNumber',
                    'value'=> 'MutationDetail::model()->find("assetID=:assetID", array(":assetID"=>$data->assetID))->assetNumber',
                    'headerHtmlOptions' => array('style'=>'width:25%;'),
                ),    
        ),
    )); 

?>