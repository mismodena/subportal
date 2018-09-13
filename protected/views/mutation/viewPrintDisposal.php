<H3>PT. INDOMO MULIA</H3>
<table width="100%">
    <tbody>
        <tr>
            <td style="text-align: center;" colspan="6" width="100%">
            <h3><strong>FORM PENGAJUAN DISPOSAL</strong></h3>
            </td>
        </tr><br>
        <tr >
            <td width="20%">
                Nomor Disposal
            </td>
            <td width="20%">
                : <?php echo $model->disposalNo; ?>
            </td>
        </tr>
        <tr >
            <td >
                Tanggal Pengajuan
            </td>
            <td>
                : <?php echo date("d-m-Y", strtotime($model->disposalDate)); ?>  
            </td>
        </tr>
        <tr >
            <td >
                Pemohon / User
            </td>
            <td>
                : <?php echo $model->fromPICName; ?>  
            </td>
        </tr>
        <tr >
            <td >
                Dept./Cab.
            </td>
            <td>
                : <?php echo $model->fromDeptName; ?>  
            </td>
        </tr><br>
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
                <strong>Alasan Disposal</strong>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php 
            
            foreach ($detail as $line=>$item) {
                
                echo "<tr>
                        
                        <td>
                            ".Asset::model()->find("assetID=:assetID", array(":assetID"=>$item->assetID))->assetNumber."
                        </td>
                        <td>
                            ".Asset::model()->find("assetID=:assetID", array(":assetID"=>$item->assetID))->assetDesc."
                        </td>
                        <td>
                            ".$item['disposalDesc']."
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
        <td align="center">Accounting</td>
        <td align="center">Dept. Head IA</td>
        <td align="center">Div. Head</td>
        <td align="center">Direktur</td>
    </tr>
    <tr align="center">
        <td align="center">Dibuat Oleh,<br/><br/><?php echo date("d-m-Y", strtotime($approval['userDate'])); ?><br/><?php echo $approval['userName']; ?></td>
        <td align="center"><p class="boks">[SIGNED]</p><?php echo date("d-m-Y", strtotime($approval['deptHeadDate'])); ?><br/><?php echo $approval['deptHeadName']; ?></td>
                            <?php
                            
                            if(!is_null($approval['accountingDate']))
                            {
                                echo '<td align="center"><p class="boks">[SIGNED]</p>'.date("d-m-Y", strtotime($approval["accountingDate"])).'<br/>'.$approval["accountingName"].'</td>';
                            } 
                            else
                            {
                                echo '<td>---</td>';
                            }

                            if(!is_null($approval['internalAuditDate']))
                            {
                                echo '<td align="center"><p class="boks">[SIGNED]</p>'.date("d-m-Y", strtotime($approval["internalAuditDate"])).'<br/>'.$approval["internalAuditName"].'</td>';
                            } 
                            else
                            {
                                echo '<td>---</td>';
                            }
                            

                            if(!is_null($approval['divHeadDate']))
                            {
                                echo '<td align="center"><p class="boks">[SIGNED]</p>'.date("d-m-Y", strtotime($approval["divHeadDate"])).'<br/>'.$approval["divHeadName"].'</td>';
                            } 
                            else
                            {
                                echo '<td>---</td>';
                            }

                             if(!is_null($approval['direkturDate']))
                            {
                                echo '<td align="center"><p class="boks">[SIGNED]</p>'.date("d-m-Y", strtotime($approval["direkturDate"])).'<br/>'.$approval["direktur"].'</td>';
                            } 
                            else
                            {
                                echo '<td>---</td>';
                            }
                            ?>   
                            ?>   
    </tr>
</table>