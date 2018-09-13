<H3>PT. INDOMO MULIA</H3>
<table width="100%">
    <tbody>
        <tr>
            <td style="text-align: center;" colspan="6" width="100%">
            <h3><strong>MUTASI AKTIVA TETAP</strong></h3>
            </td>
        </tr>
        <tr>
            <td width="15%">
                Nomor MAT
            </td>
            <td width="30%">
                : <?php echo $model->mutationNo; ?>
            </td>
            <td>
                &nbsp;
            </td>
            <td width="15%">
                Tanggal 
            </td>
            <td width="30%">
                 :<?php echo date("d-m-Y", strtotime($model->mutationDate)); ?>  
            </td>
        </tr>
        <tr>
            <td width="15%">
                Pemohon/User
            </td>
            <td width="30%">
               : <?php echo $model->fromPICName?>  
            </td>
             <td>
                &nbsp;
            </td>
            <td width="15%">
                Penerima/User 
            </td>
            <td width="30%">
                : <?php echo $model->toPICName?>  
            </td>
        </tr>
         <tr>
            <td width="15%">
                Dept. / Cabang 
            </td>
            <td width="30%">
               : <?php echo $model->fromDeptName?>
            </td>
             <td>
                &nbsp;
            </td>
            <td width="15%">
                Dept. / Cabang
            </td>
            <td width="30%">
                : <?php echo $model->toDeptName?>  
            </td>
        </tr>
        &nbsp;
    </tbody>
</table>&nbsp;&nbsp;
<table border="1" width="100%">
    <thead>
        <tr>

            <td align="center" width="20%">
                <strong>Nomor Asset</strong>
            </td>
            <td align="center">
                <strong>Deskripsi</strong>
            </td>
            <td align="center">
                <strong>Keterangan</strong>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php 
            
            foreach ($detail as $line=>$item) {
                
                echo "<tr>
                        
                        <td>
                            ".$item['assetNumber']."
                        </td>
                        <td>
                            ".Asset::model()->find("assetID=:assetID", array(":assetID"=>$item->assetID))->assetDesc."
                        </td>
                        <td>
                            ".$item['mutationDesc']."
                        </td>
                        

                    </tr>";
            }        
        ?>     
    </tbody>
</table>&nbsp;</br>
<table width="100%" border="1" >
    <tr align="center">
        <td align="center">Pemohon</td>
        <td align="center">Ka. Dept / BM</td>
        <td align="center">Div. Head</td>
        <td align="center">Penerima</td>
    </tr>
    <tr align="center">
        <td align="center">Dibuat Oleh,<br/><br/><?php echo date("d-m-Y", strtotime($approval['userDate'])); ?><br/><?php echo $approval['userName']; ?></td>
        <td align="center"><p class="boks">[SIGNED]</p><?php echo date("d-m-Y", strtotime($approval['deptHeadDate'])); ?><br/><?php echo $approval['deptHeadName']; ?></td>
                            <?php
                            
                            
                            
                            if(!is_null($approval['divHeadDate']))
                            {
                                echo '<td align="center"><p class="boks">[SIGNED]</p>'.date("d-m-Y", strtotime($approval["divHeadDate"])).'<br/>'.$approval["divHeadName"].'</td>';
                            } 
                            else
                            {
                                echo '<td>---</td>';
                            }
                            ?>                  
                                                
        <td>&nbsp;</td> 
    </tr>
</table>