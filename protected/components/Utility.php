<?php

class Utility {

    public static function getTradNo() {
        $count = Yii::app()->db->createCommand()
                ->select("case
                                when MAX(CAST(right(termNo, 6) as int)) is null then CAST(YEAR(getdate()) AS varchar(4))+'.000001'
                                else CAST(YEAR(getdate()) AS varchar(4)) + '.' + right('0000000' + cast(MAX(CAST(right(termNo, 6) as int))+1 as varchar(6)),6) end as termNo ")
                ->from("ms_tradingTerm ")
                ->where(" LEFT(termNo,4) = YEAR(GETDATE())")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['termNo'];
        }
    }

    public static function getDocID() {
        $count = Yii::app()->db->createCommand()
                ->select(" isnull(max(docID),0)+1 as docID")
                ->from("tr_docDetail ")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['docID'];
        }
    }

    public static function getFppNo() {
        $count = Yii::app()->db->createCommand()
                ->select("case
                                when MAX(CAST(right(fppNo, 5) as int)) is null then CAST(YEAR(getdate()) AS varchar(4))+'.000001'
                                else CAST(YEAR(getdate()) AS varchar(4)) + '.' + right('000000' + cast(MAX(CAST(right(fppNo, 5) as int))+1 as varchar(6)),6) end as fppNo ")
                ->from("tr_fppHeader ")
                ->where(" LEFT(fppNo,4) = YEAR(GETDATE())")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['fppNo'];
        }
    }
    
    public static function getBQClaimNo() {
        $count = Yii::app()->db->createCommand()
                ->select("case 
                            when MAX(CAST(right(bqClaimNo, 6) as int)) is null then 'BQTQ/CL/'+CAST(YEAR(getdate()) AS varchar(4))+'.000001'
                            else 'BQTQ/CL/'+CAST(YEAR(getdate()) AS varchar(4)) + '.' + right('000000' + cast(MAX(CAST(right(bqClaimNo, 6) as int))+1 as varchar(6)),6) end as claimNo  ")
                ->from("tr_bqClaim ")
                ->where(" substring(bqClaimNo,9,4) = YEAR(GETDATE()) ")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['claimNo'];
        }
    }
    
    public static function getBQUpload() {
        $count = Yii::app()->db->createCommand()
                ->select("case 
                            when MAX(CAST(right(bqUploadNo, 5) as int)) is null then 'BQTQ/UP/'+CAST(YEAR(getdate()) AS varchar(4))+'.000001'
                            else 'BQTQ/UP/'+CAST(YEAR(getdate()) AS varchar(4)) + '.' + right('000000' + cast(MAX(CAST(right(bqUploadNo, 5) as int))+1 as varchar(6)),6) end as claimNo  ")
                ->from("tr_bqUpload ")
                ->where(" substring(bqUploadNo,9,4) = YEAR(GETDATE()) ")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['claimNo'];
        }
    }
    
    public static function getReqNo() {
        $count = Yii::app()->db->createCommand()
                ->select("case 
	when MAX(CAST(right(reqNumber, 5) as int)) is null then CAST(YEAR(getdate()) AS varchar(4))+'/REQNP'+'/000001'
	else CAST(YEAR(getdate()) AS varchar(4)) +'/REQNP/'+ + right('000000' + cast(MAX(CAST(right(reqNumber, 5) as int))+1 as varchar(6)),6) end as reqNumber  ")
                ->from("tr_docRequest ")
                ->where(" LEFT(reqNumber,4) = YEAR(GETDATE()) ")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['reqNumber'];
        }
    }

    public static function getClaimNo() {
        $count = Yii::app()->db->createCommand()
                ->select("case
                                when MAX(CAST(right(claimNo, 5) as int)) is null then CAST(YEAR(getdate()) AS varchar(4))+'.claim.000001'
                                else CAST(YEAR(getdate()) AS varchar(4)) + '.claim.' + right('000000' + cast(MAX(CAST(right(claimNo, 5) as int))+1 as varchar(6)),6) end as claimNo ")
                ->from("tr_tradingClaim ")
                ->where(" LEFT(claimNo,4) = YEAR(GETDATE())")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['claimNo'];
        }
    }

    public static function getNoMutation() {
        $count = Yii::app()->db->createCommand()
                ->select("case
                                when MAX(CAST(right(mutationNo, 5) as int)) is null then CAST(YEAR(getdate()) AS varchar(4))+'.000001'
                                else CAST(YEAR(getdate()) AS varchar(4)) + '.' + right('000000' + cast(MAX(CAST(right(mutationNo, 5) as int))+1 as varchar(6)),6) end as mutationNo ")
                ->from("tr_assetMutation ")
                ->where(" LEFT(mutationNo,4) = YEAR(GETDATE())")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['mutationNo'];
        }
    }

    public static function getDisposalNo() {
        $count = Yii::app()->db->createCommand()
                ->select("case
                                when MAX(CAST(right(disposalNo, 5) as int)) is null then CAST(YEAR(getdate()) AS varchar(4))+'.000001'
                                else CAST(YEAR(getdate()) AS varchar(4)) + '.' + right('000000' + cast(MAX(CAST(right(disposalNo, 5) as int))+1 as varchar(6)),6) end as disposalNo ")
                ->from("tr_assetDisposal ")
                ->where(" LEFT(disposalNo,4) = YEAR(GETDATE())")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['disposalNo'];
        }
    }

    public static function getAssetNumber($id) {
        $count = Yii::app()->db->createCommand()
                ->select("case
                                when MAX(CAST(right(assetNumber, 5) as int)) is null then '" . $id . "00001'
                                else '" . $id . "' + right('00000' + cast(MAX(CAST(right(assetNumber, 5) as int))+1 as varchar(5)),5) end as assetNumber ")
                ->from("ms_asset ")
                ->where(" LEFT(assetNumber,3) = '" . $id . "'")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['assetNumber'];
        }
    }

    public static function getFppNoTR() {
        $count = Yii::app()->db->createCommand()
                ->select("case
                                when MAX(CAST(right(fppNo, 5) as int)) is null then CAST(2010 AS varchar(4))+'.000001'
                                else CAST(2010 AS varchar(4)) + '.' + right('000000' + cast(MAX(CAST(right(fppNo, 5) as int))+1 as varchar(6)),6) end as fppNo ")
                ->from("tr_fppHeader ")
                ->where(" LEFT(fppNo,4) = YEAR(GETDATE())")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['fppNo'];
        }
    }

    public static function getRecNo() {
        $count = Yii::app()->db->createCommand()
                ->select("case
                        when MAX(CAST(right(recNo, 5) as int)) is null then CAST(YEAR(getdate()) AS varchar(4))+'.000001'
                        else CAST(YEAR(getdate()) AS varchar(4)) + '.' + right('000000' + cast(MAX(CAST(right(recNo, 5) as int))+1 as varchar(6)),6) end as recNo ")
                ->from("tr_APInvoice ")
                ->where(" LEFT(recNo,4) = YEAR(GETDATE())")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['recNo'];
        }
    }

    public static function getInactiveEmployee($idcard) {
        $count = Yii::app()->db->createCommand()
                ->select(" kw_nama ")
                ->from(" ibm3650.modenaintranet.dbo.karyawan ")
                ->where(" kw_idcard = '" . $idcard . "'")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['kw_nama'];
        }
    }

    public static function getInvNo($date) {
        $count = Yii::app()->db->createCommand("select dbo.fnGetPINo('" . $date . "') nomor")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['nomor'];
        }
    }
    
    public static function getBQRev($fiscal, $idcust) {
        $count = Yii::app()->db->createCommand("select max(revNo)  nomor from tr_bqOpen where idCust = '".$idcust."' and fiscalPeriod = '".$fiscal."'")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['nomor'];
        }
    }      
    
    public static function getProducts() {
        $data = Yii::app()->db->createCommand(" 
                    select b.itemno itemNo, b.fmtitemno fmtItemNo, b.[desc] [desc], b.itembrkid itemBrkId,  c.[model], b.comment1 brand, b.comment2 category,
                    convert(int, e.unitprice) unitPrice --, 'http://www.modena.co.id/images/product/tn'+ltrim(rtrim(kode))+'.png' tnImage
                    from 
                    SGTDAT.dbo.ICITEM b 
                    inner join mesdb.dbo.tbl_icitem c on b.ITEMNO = c.ITEMNO
                    inner join SGTDAT.dbo.ICPRIC d on b.ITEMNO = d.ITEMNO 
                    left join SGTDAT.dbo.ICPRICP e on d.ITEMNO = e.ITEMNO and d.PRICELIST = e.PRICELIST and d.CURRENCY = e.CURRENCY 
                    left join mobilesales..tmp t on t.nama = b.fmtitemno
                    where 
                    c.MODEL is not null and b.ITEMBRKID in ('FG') and 
                    b.INACTIVE = 0 and b.[DESC] not like '%SAMPLE%' and
                    DPRICETYPE = 1 and e.CURRENCY = 'IDR' and d.pricelist='STD' --and 
                    --c.model like :model
                    order by c.model; ")

                ->queryAll();
       $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['itemNo']] = $rows['desc'];
        }
        return $app;
    } 
    
    public static function getBranchName($id) {
        $branch = Yii::app()->db->createCommand("select * from sgtdat..argro where idgrp = '" . $id . "'")
                ->queryRow();
        if ($branch === null) {
            return '';
        } else {
            return $branch['TEXTDESC'];
        }
    }
    
    public static function getPrintApproval($fppID) {
        $count = Yii::app()->db->createCommand("select * from fnGetApproval('" . $fppID . "')")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count;
        }
    }

    public static function getPrintApprovalMutation($mutationNo) {
        $count = Yii::app()->db->createCommand("select * from fnGetApprovalMutation('" . $mutationNo . "')")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count;
        }
    }

    public static function getPrintApprovalDisposal($disposalNo) {
        $count = Yii::app()->db->createCommand("select * from fnGetApprovalDisposal('" . $disposalNo . "')")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count;
        }
    }

    public static function getEndDate($date) {
        $count = Yii::app()->db->createCommand("select dbo.fnGetEndDate('" . $date . "') result")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['result'];
        }
    }
    
    public static function getSJDetail($docNumber) {
        $count = Yii::app()->db->createCommand("select * from FPP.dbo.fnGetDocumentLog('" . $docNumber . "') result")
                ->queryAll();
        if ($count === null) {
            return 0;
        } else {
            return $count;
        }
    }

    public static function getPIC($level) {
        switch ($level) {
            case "Marketing-Mgr":
                return "1501.1834";
                break;
            case "CMDiv":
                return "0207.0087";
                break;
            case "AMDiv":
                return "1501.1829";
                break;
            case "FinDeptHead":
                return "0502.0263";
                break;
            case "FinAdmin":
                return "0901.0848";
                break;
            case "FinAdmin2":
                return "1509.1895";
                break;
            case "AcctAdmin":
                return "5454.5454";
                break;
            //case "Acct I":
            //    return "9411.0022";
            //    break;
            case "Acct I":
                return "0601.0307";
                break;
            case "Acct II":
                return "1005.1114"; //"1409.1808";
                break;
            case "OMDiv": //Zulkarnaen Djohan
                return "1502.1845";
                break;
        }
    }
    
    public static function getDocPIC($dept) {
        switch ($dept) {
            case "Finance":
                return "siti.hadissyah@modena.co.id; jkt3.finance@modena.co.id; sarah.valeda@modena.co.id; jkt1.finance@modena.co.id";
                break;
            case "Admin":
                return "dewi.suryanti@modena.co.id; putri.anggraini@modena.co.id; anastasia.fabiola@modena.co.id; ";
                break;           
        }
    }

    public static function getDeptHead($idcard) {
        /* $count = Yii::app()->db->createCommand("select kw_idcard from ibm3650.modenaintranet.dbo.karyawan where pos_id = '16' and termination = 'N' 
          and cab_id <> '1' and cab_id = (select cab_id from ibm3650.modenaintranet.dbo.karyawan where kw_idcard = '".$idcard."')
          union
          select kw_idcard from ibm3650.modenaintranet.dbo.karyawan where pos_id = '23' and termination = 'N'
          and cab_id = '1' and div_id = (select div_id from ibm3650.modenaintranet.dbo.karyawan where kw_idcard  = '".$idcard."')")
         */
        $count = Yii::app()->db->createCommand("select dbo.getDeptHead('" . $idcard . "') as kw_idcard")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['kw_idcard'];
        }
    }

    public static function getToDeptHead($toDept) {

        $count = Yii::app()->db->createCommand("select PICDept as PICDept
                            from ms_kodeAsset where kodeAsset='" . $toDept . "'
                    ")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['PICDept'];
        }
    }
    
    
    public static function getAccess($id, $controller, $action) {
        $id = Yii::app()->user->getState('usrid');
        $count = Yii::app()->db->createCommand("select count(*) result from AuthAssignment where  "
                . "(itemname = '".$controller.'.'.$action."' and  userid = '".$id."')"
                . " or (itemname = '".$controller.".*' and   userid = '".$id."')")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['result'];
        }
    }

    public static function getItemDesc($model) {
        $count = Yii::app()->db->createCommand("select ltrim(rtrim(MODEL)) model, ltrim(rtrim([desc])) [desc]
                            from SGTDAT..ICITEM
                            left join mesdb..TBL_ICITEM on TBL_ICITEM.ITEMNO = ICITEM.ITEMNO
                            where MODEL = '" . $model . "'
 ")
                ->queryRow();
        if ($count === null) {
            return '';
        } else {
            return $count['desc'];
        }
    }

    public static function getDeptHeadHris($branch, $deptID) {
        /* $count = Yii::app()->db->createCommand("select kw_idcard from ibm3650.modenaintranet.dbo.karyawan where pos_id = '16' and termination = 'N' 
          and cab_id <> '1' and cab_id = (select cab_id from ibm3650.modenaintranet.dbo.karyawan where kw_idcard = '".$idcard."')
          union
          select kw_idcard from ibm3650.modenaintranet.dbo.karyawan where pos_id = '23' and termination = 'N'
          and cab_id = '1' and div_id = (select div_id from ibm3650.modenaintranet.dbo.karyawan where kw_idcard  = '".$idcard."')")
         */
        $count = Yii::app()->db->createCommand("select dbo.getDeptHeadHris('" . $branch . "','" . $deptID . "') as kw_idcard")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['kw_idcard'];
        }
    }
    
    public static function getDirectHead($branch, $deptID, $idPos) {
        /* $count = Yii::app()->db->createCommand("select kw_idcard from ibm3650.modenaintranet.dbo.karyawan where pos_id = '16' and termination = 'N' 
          and cab_id <> '1' and cab_id = (select cab_id from ibm3650.modenaintranet.dbo.karyawan where kw_idcard = '".$idcard."')
          union
          select kw_idcard from ibm3650.modenaintranet.dbo.karyawan where pos_id = '23' and termination = 'N'
          and cab_id = '1' and div_id = (select div_id from ibm3650.modenaintranet.dbo.karyawan where kw_idcard  = '".$idcard."')")
         */
        $count = Yii::app()->db->createCommand("select fpp.dbo.fnGetDirectHead('" . $branch . "','" . $deptID . "', '".$idPos."') as idCard")
                ->queryRow();
        if ($count === null) {
            return 0;
        } else {
            return $count['idCard'];
        }
    }
    
    public static function getDocEmailAddress($mode, $branch) {
        
        if($mode == "Sales"){ //Jika admin sales
            $count = Yii::app()->db->createCommand("select branchSalesAdminEmail as branchEmail from SGTDAT..MIS_Branch_Email where branchCode = '".$branch."'")
                ->queryRow();
        } else if ($mode == "Finance"){ //Jika admin finance
            $count = Yii::app()->db->createCommand("select branchFinAdminEmail as branchEmail from SGTDAT..MIS_Branch_Email where branchCode = '".$branch."'")
                ->queryRow();
        }
        
        if ($count === null) {
            return 0;
        } else {
            return $count['branchEmail'];
        }
    }
    
    public static function getDocEmailPst($mode, $invType) {
        
        if($mode == "Sales"){ //Jika admin sales
            $count = Yii::app()->db->createCommand("select branchSalesAdminEmail as branchEmail from SGTDAT..MIS_Branch_Email where branchCode = '".$invType."'")
                ->queryRow();
        } else if ($mode == "Finance"){ //Jika admin finance
            $count = Yii::app()->db->createCommand("select branchFinAdminEmail as branchEmail from SGTDAT..MIS_Branch_Email where branchCode = '".$invType."'")
                ->queryRow();
        }
        
        if ($count === null) {
            return 0;
        } else {
            return $count['branchEmail'];
        }
    }

    public static function getAccpacDate($value) {
        //20150123
        return substr($value, 0, 4) . '-' . substr($value, 4, 2) . '-' . substr($value, 6, 2);
    }

    public static function getAccpacTime($value) {
        //0911410
        return substr($value, 0, 2) . ':' . substr($value, 2, 2) . ':' . substr($value, 4, 2);
    }

    public static function setAccpacDate($value) {
        //01/27/2015
        return substr($value, 6, 4) . substr($value, 0, 2) . substr($value, 3, 2);
    }

    public static function setAccpacTime() {
        //093916000000
        return substr(date("Hisu"), 0, 8);
    }

    public static function getFiscalYear() {
        //20150127
        return substr(date('Ymd'), 0, 4);
    }

    public static function getFiscalPeriode() {
        //20150127
        return substr(date('Ymd'), 4, 2);
    }

    public static function getUserIP() {
        return Yii::app()->request->getUserHostAddress();
    }

    public static function getLongDate() {
        $day = (string) date('j');
        $month = date('n');
        $year = (string) date('Y');

        $tMonth = Utility::getMonth($month);

        return $day . " " . $tMonth . " " . $year;
    }

    public static function getLongDateParams($date) {
        $day = (string) date("d", strtotime($date));
        $month = date("n", strtotime($date));
        $year = (string) date("Y", strtotime($date));

        $tMonth = Utility::getMonth($month);

        return $day . " " . $tMonth . " " . $year;
    }

    protected static function getMonth($month) {
        $tMonth = '';
        switch ($month) {
            case 1:
                $tMonth = 'Januari';
                break;
            case 2:
                $tMonth = 'Februari';
                break;
            case 3:
                $tMonth = 'Maret';
                break;
            case 4:
                $tMonth = 'April';
                break;
            case 5:
                $tMonth = 'Mei';
                break;
            case 6:
                $tMonth = 'Juni';
                break;
            case 7:
                $tMonth = 'Juli';
                break;
            case 8:
                $tMonth = 'Agustus';
                break;
            case 9:
                $tMonth = 'September';
                break;
            case 10:
                $tMonth = 'Oktober';
                break;
            case 11:
                $tMonth = 'November';
                break;
            case 12:
                $tMonth = 'Desember';
                break;
        }

        return $tMonth;
    }

    public static function getSalesAcc() {
        $sql = "select accNo, accName
                from ms_salesAccount;";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['accNo']] = $rows['accName'];
        }
        return $app;
    }

    public static function getLineaItems() {
        //$sql = "select IDCUST, NAMECUST from SGTDAT..ARCUS where LEN(IDCUST) = 4 and SWACTV = 1 and IDGRP in ('Y') order by NAMECUST";
        $sql = "   
                    select distinct l.itemNo, i.[DESC]
                    from tr_lineaValue l
                    left join SGTDAT..ICITEM i on i.FMTITEMNO = l.itemNo 
                    union
                    select 'ALL', 'ALL'
                    ";
        
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['itemNo']] = $rows['DESC'];
        }
        return $app;
    }
    
    public static function getLineaYear() {
        $sql = " select distinct fiscalYear
                    from tr_lineaValue l
                    order by fiscalYear Desc
                    ";

        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['fiscalYear']] = $rows['fiscalYear'];
        }
        return $app;
    }
    
        public static function getLineaPeriod() {
        $sql = " select distinct fiscalPeriod
                    from tr_lineaValue l
                    order by fiscalP
                    ";

        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['fiscalPeriod']] = $rows['fiscalPeriod'];
        }
        return $app;
    }
    
    public static function getCustGroup() {
        //$sql = "select IDCUST, NAMECUST from SGTDAT..ARCUS where LEN(IDCUST) = 4 and SWACTV = 1 and IDGRP in ('Y') order by NAMECUST";
        $sql = "    select IDNATACCT IDCUST, NAMEACCT NAMECUST from SGTDAT..ARNAT where SWACTV = 1 and IDGRP in ('Y','Y1')  
                    order by NAMEACCT";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['IDCUST']] = $rows['NAMECUST'];
        }
        return $app;
    }
    
    public static function getCustGroup2() {
        //$sql = "select IDCUST, NAMECUST from SGTDAT..ARCUS where LEN(IDCUST) = 4 and SWACTV = 1 and IDGRP in ('Y') order by NAMECUST";
        $sql = "   select IDNATACCT IDCUST, NAMEACCT NAMECUST from SGTDAT..ARNAT where IDNATACCT in (
                        select distinct IDNATACCT from SGTDAT..ARCUS where  SWACTV = 1 and IDGRP in ('Y11','Y12','Y01','Y02')) union
						select IDCUST, NAMECUST from SGTDAT..ARCUS where idcust in ('OT01A11029B0')";
        
//        $sql = "SET NOCOUNT ON;
//                DECLARE @MyTableVar table(  
//                IDCUST varchar(50),  
//                NAMECUST varchar(300)); 
//                insert into @MyTableVar
//                select IDNATACCT IDCUST, NAMEACCT NAMECUST from SGTDAT..ARNAT where IDNATACCT in (
//                    select distinct IDNATACCT from SGTDAT..ARCUS where  SWACTV = 1 and IDGRP in ('Y11','Y12','Y01','Y02'))
//
//                insert into @MyTableVar
//                select IDCUST, NAMECUST from SGTDAT..ARCUS where IDGRP in ('B','C','M') and SWACTV = 1 and len(IDCUST) > 4
//                and IDGRP not in (select IDCUST from @MyTableVar) and left(IDCUST,1) = 'D'
//
//                select * from @MyTableVar order by NAMECUST";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['IDCUST']] = $rows['NAMECUST'];
        }
        return $app;
    }
    
    public static function getCustGroup3($id) {
        
        $idgrp = Yii::app()->user->getState('idgrp');
        
        $sql = " select * from dbo.getDealer('".$id."','".$idgrp."') ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['IDCUST']] = $rows['NAMECUST'];
        }
        return $app;
    }
    
    public static function getPeriodeBQ() {
       $sql = " select distinct left(balanceReff,4) balanceReff from tr_bqBalance";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['balanceReff']] = $rows['balanceReff'];
        }
        return $app;
    }
    
    public static function getPeriodeQ($year) {
       $sql = " select distinct right(balanceReff,2) balanceReff from tr_bqBalance where Left(balanceReff, 4) = '".$year."'";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['balanceReff']] = $rows['balanceReff'];
        }
        return $app;
    }
    
    public static function getDealerBQTQ($id) {
        
        $idgrp = Yii::app()->user->getState('idgrp');
        
        $sql = " select * from dbo.getDealerBQTQ('".$id."','".$idgrp."') ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['IDCUST']] = $rows['NAMECUST'];
        }
        return $app;
    }
    
    public static function getBranch() {
        $idgrp = Yii::app()->user->getState('idgrp');
        $sql = "
                select IDGRP, TEXTDESC 
                from SGTDAT..ARGRO where idgrp in (select param from dbo.fn_MVParam('".$idgrp."',',')) order by TEXTDESC";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['IDGRP']] = $rows['TEXTDESC'];
        }
        return $app;
    }

    public static function getAPInv() {
        $sql = "select apDetailID, apInvNo
                from tr_apDetail where invStatus in (1,2,9) ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['apInvNo']] = $rows['apInvNo'];
        }
        return $app;
    }

    public static function checkInv($id) {
        $sql = "set nocount on;
            declare @invnet float, @inv float
            select @inv = 0, @invnet = 0

            select @invnet = INVNETWTX from sgtdat..oeinvh where INVNUMBER = '".$id."'
            select @inv = sum(ISNULL(revValue,0)) from fpp..tr_docRequestDetail where docNumber = '".$id."'

            if @inv > 0 -- Jika sudah ada pembayaran
            begin
                if @inv >= @invnet -- jika lunas
                begin
                    select 2 status -- close
                end
                else
                begin
                    select 3 status -- bisa dibuat NP baru hanya untuk sales tersebut
                end
            end
            else -- Jika belum ada pembayaran
            begin
                select 0 status -- bisa dibuat NP baru oleh semua sales
            end

            
           /* if @inv >= @invnet and @inv > 0 /* Jika lunas*/
            begin
                    select 2 status
            end
            else if @inv <= @invnet 
            begin
                    select 0 status
            end*/ ";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        return $data['status'];
    }
    
    public static function getMaxValue($value) {
        $sql = " select ([percentage]/100) * ".$value." as value
                from fpp..ms_bqtqTerm
                where termType = 'TQ' and  ".$value." between fromValue and toValue ";
        
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        
        return !isset($data['value']) ?  0 :  $data['value'];
    }
    
    public static function getCustGroupByID($idcust) {
        $sql = "select idgrp from sgtdat..arcus where idcust = '".$idcust."' ";
        
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        
        return !isset($data['idgrp']) ?  '' :  $data['idgrp'];
    }
    
    public static function getCustByGroup($idgrp) {
        //echo $idgrp;
        if($idgrp == 'A1' || $idgrp == 'PST'){
          $sql = "select idcust, namecust from sgtdat..arcus where swactv = 1 and len(idcust) > 4 and idcust like 'D%'";  
        }else if(trim($idgrp) == 'B' || trim($idgrp) == 'C' || trim($idgrp) == 'M'){
            $sql = "select idcust, namecust from sgtdat..arcus where swactv = 1 and idgrp in ('B','C','M')";  
        }else{
          $sql = "select idcust, namecust from sgtdat..arcus where idgrp = '".$idgrp."' and swactv = 1 and len(idcust) > 4";
        }
        
        
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        
        foreach ($data as $r => $rows) {
            $app[$rows['idcust']] = $rows['namecust'];
        }
        return $app;
    }
    
    public static function getBalance($dealerID,$branchID) {
        
        //$idgrp = Yii::app()->user->getState('branch');
        
        $query = "select * from dbo.getBQBalance('".$branchID."','".$dealerID."')";
        $command = Yii::app()->db->createCommand($query);
        $result = $command->queryAll();

        $ret = array_values($result[0]);

        return $ret;        
    }
    
    public static function getLastQ($dealerID) {
        
        //$idgrp = Yii::app()->user->getState('branch'); 
        $Q = self::getQuarterByMonth(date('m'));
        $month = "";
        $year = 0;
        
        switch ($Q) {
            case 1:
                $year = date('Y')-1;
                $month = $year.'01,'.$year.'02,'.$year.'03';
                break;
            case 2:
                $year = date('Y')-1;
                $month = $year.'04,'.$year.'05,'.$year.'06';
                break;
            case 3:
                $year = date('Y')-1;
                $month = $year.'07,'.$year.'08,'.$year.'09';
                break;
            case 4:
                $year = date('Y')-1;
                $month = $year.'10,'.$year.'11,'.$year.'12';
                break;
            default :
                $year = date('Y')-1;
                $month = "";
        }
        
        $query = "select isnull(( 
                    (select isnull(sum(fiscalValue),0) from ms_bqtqPeriod where fiscalPeriod in (select param from dbo.fn_MVParam('".$month."',',')) and idCust = '".$dealerID."' and fiscType = 'INV') - 
                    (select isnull(sum(fiscalValue),0) from ms_bqtqPeriod where fiscalPeriod in (select param from dbo.fn_MVParam('".$month."',',')) and idCust = '".$dealerID."'  and fiscType = 'RET')
                    ),0)";
        $command = Yii::app()->db->createCommand($query);
        $result = $command->queryAll();

        $ret = array_values($result[0]);

        /* or ...
          $ret = array();
          foreach ($models as $model) {
              $ret = array();
              foreach ($attributeNames as $name) {
                  $row[$name] = CHtml::value($model, $name);
              }
              $ret[] = $row;
          }
        */

        return $ret;        
    }
    
    public static function getQuarterByMonth($monthNumber) {
        return floor(($monthNumber - 1) / 3) + 1;
      }

    public static function getInvCategory() {
        $sql = "select invCatID, invCatName
                from ms_invCategory;";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['invCatID']] = $rows['invCatName'];
        }
        return $app;
    }        

    public static function getSupplier($keyword) {
        $sql = " select * from fpp.dbo.fnGetSupplier('" . $keyword . "') ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($data as $r => $rows) {
            $app[] = array(
                'id' => $rows['vendname'],
                'text' => $rows['vendname'],
            );
        }
        return $app;
    }

    public static function getItem() {
        //$sql = " select * from fpp.dbo.fnGetSupplier('".$keyword."') ";
        $sql = "    select ltrim(rtrim(MODEL)) model, ltrim(rtrim([desc])) [desc]
                            from SGTDAT..ICITEM
                            left join mesdb..TBL_ICITEM on TBL_ICITEM.ITEMNO = ICITEM.ITEMNO
                            where MODEL is not null and [desc] not like '%sample%' and icitem.ITEMBRKID = 'FG' and INACTIVE = 0
                        ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['model']] = $rows['desc'];
        };

        return $app;
    }
    
    public static function getInvSales() {
        $idgrp = Yii::app()->user->getState('idgrp');
        $branch = Yii::app()->user->getState('branch');
        //$sql = " select * from fpp.dbo.fnGetSupplier('".$keyword."') ";
        $sql = " select  a.docNumber, h.bilname, INVNETWTX invTotal, dbo.fnGetAccpacDate(invDate) invDate
                    from FPP..tr_docHeader a
                    left join SGTDAT..OEINVH h on h.invnumber = a.docNumber
                    left join sgtdat..arcus c on c.idcust = h.customer 
                    where a.isComplete = 1 and a.status = 0 and invType in (select param from fpp.dbo.fn_MVParam('".$idgrp."',',')) and docNumber not like 'A1%'
                        and (c.IDCUST in (select IDCUST from getDealer('".$branch."','".$idgrp."')) OR c.IDNATACCT in (select IDCUST from getDealer('".$branch."','".$idgrp."')) ) ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $app = array();
        foreach ($data as $r => $rows) {
            //$app[trim($rows['docNumber'])] = "=> ".trim($rows['docNumber'])." - ".date("d-m-Y", strtotime($rows["invDate"]))." - ".number_format($rows["invTotal"])." - ".trim($rows['bilname']) ;
            $app[trim($rows['docNumber'])."||".date("d-m-Y", strtotime($rows["invDate"]))."||".number_format($rows["invTotal"])."||".trim($rows['bilname'])] = trim($rows['docNumber']) ;
        };

        return $app;
    }
    
    public static function getInvSalesTT() {
        $idgrp = Yii::app()->user->getState('idgrp');
        $branch = Yii::app()->user->getState('branch');
        //$sql = " select * from fpp.dbo.fnGetSupplier('".$keyword."') ";
        $sql = " select  a.docNumber, h.bilname, INVNETWTX invTotal, dbo.fnGetAccpacDate(invDate) invDate
                    from FPP..tr_docHeader a
                    left join SGTDAT..OEINVH h on h.invnumber = a.docNumber
                    left join sgtdat..arcus c on c.idcust = h.customer 
                    where a.isComplete = 1 and a.status = 5 and invType in (select param from fpp.dbo.fn_MVParam('".$idgrp."',','))
                        and (c.IDCUST in (select IDCUST from getDealer('".$branch."','".$idgrp."')) OR c.IDNATACCT in (select IDCUST from getDealer('".$branch."','".$idgrp."')) ) ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $app = array();
        foreach ($data as $r => $rows) {
            //$app[trim($rows['docNumber'])] = "=> ".trim($rows['docNumber'])." - ".date("d-m-Y", strtotime($rows["invDate"]))." - ".number_format($rows["invTotal"])." - ".trim($rows['bilname']) ;
            $app[trim($rows['docNumber'])."||".date("d-m-Y", strtotime($rows["invDate"]))."||".number_format($rows["invTotal"])."||".trim($rows['bilname'])] = trim($rows['docNumber']) ;
        };

        return $app;
    }

    public static function getAsset() {
        //$sql = " select * from fpp.dbo.fnGetSupplier('".$keyword."') ";
        $deptID = Yii::app()->user->getState('kodeasset');
        $sql = "    select ltrim(rtrim(a.assetID)) [a.assetID], ltrim(rtrim(a.assetNumber)) [a.assetNumber], ltrim(rtrim(a.assetDesc)) [a.assetDesc], ltrim(rtrim(b.Department)) [b.Department]
                from ms_asset a
                    left join ms_kodeAsset b on a.idDept=b.kodeAsset
                where a.statusID='1' and b.kodeAsset='$deptID'
                       ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['a.assetID']] = $rows['a.assetNumber'] . '-|-' . $rows['a.assetDesc'];
        };

        return $app;
    }

    public static function getDocList() 
    {
         $catID = Yii::app()->user->getState('kodeasset');

            $sql = "select a.invCatID, invCatName, a.invDocID, invDocName, 0 docCheck
                                        from ms_docList a
                                left join ms_invCategory b on a.invCatID = b.invCatID
                                left join ms_docCategory c on a.invDocID = c.invDocID
                        where a.invCatID = '$catID'
                        order by invCatName, invDocOrder ";

            $models = Yii::app()->db->createCommand($sql)->queryAll();

            // echo "<pre>";
            // print_r($models);
            // echo "</pre>";

            if ($models !== null) {
                foreach ($models as $index => $data) {
                        /*
                        $model = new APDocument();
                        $model->docID = $data['invDocID'];
                        $model->docName = ($data['invDocName']);
                        $model->docValue = ($data['docCheck']);
                        $this->renderPartial('/site/extensions/_tabularAP', array(
                            'model' => $model,
                            'index' => $index,
                        ));*/
                    
                }
            }
        
    }

    /*public static function getNoPo()
    {
        $sql = "    select PONUMBER as ponumber, EXTRECEIVE as nilai, POSTDATE as tglFaktur from SGTDAT.dbo.POPORH1 where isprinted=0  and  [AUDTDATE] like '%2017%'  and   EXTRECEIVE != 0 
                        ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['ponumber']] = $rows['ponumber'];
        };

        return $app;
    }*/

    public static function getNoPo($keyword) {
        $sql = " select * from fpp.dbo.fnGetSupplierPO('" . $keyword . "') ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($data as $r => $rows) {
            $app[] = array(
                'id' => $rows['ponumber'],
                'text' => $rows['ponumber'],
            );
        }
        return $app;
    }

    public static function getPenagihan() 
    {
        $sql = "select b.apSupplier [apSupplier] , a.apInvoiceID [apInvoiceID],b.apInvTotal [Total], a.apInvNo [apInvNo], a.apInvTotal [apInvTotal], a.apInvDate [apInvDate] from tr_apDetail2 a left join tr_apInvoice2 b on b.recNo=a.apInvoiceID
                       ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['apInvNo']." -- ".$rows['apInvTotal']." -- ".$rows['apSupplier']." -- ".$rows['Total']." -- ".$rows['apInvoiceID']." -- ".$rows['apInvDate']] = $rows['apInvoiceID'] . ' | ' . $rows['apInvNo'];
        };

        return $app;
    }

    public static function getApInvoiceStatus($status) {
        $tStatus = '';
        switch ($status) {
            case 0:
                $tStatus = 'Dokumen diterima oleh bagian Finance';
                break;
            case 1:
                $tStatus = 'Dokumen diterima oleh User';
                break;
            case 2:
                $tStatus = 'Proses FPP';
                break;
            case 3:
                $tStatus = 'Dokumen diterima oleh bagian Accounting';
                break;
            case 4:
                $tStatus = 'Dokumen telah diverifikasi oleh bagian Accounting';
                break;
            case 5:
                $tStatus = 'Revisi dokumen';
                break;
            case 6:
                $tStatus = 'Persiapan pembayaran oleh bagian Finance';
                break;
            case 7:
                $tStatus = 'Pembayaran selesai';
                break;
            case 8:
                $tStatus = 'Revisi dokumen';
                break;
            case 9:
                $tStatus = 'Dokumen diterima oleh User';
                break;
            case 10:
                $tStatus = 'FPP';
                break;
        }

        return $tStatus;
    }

    public static function getDepartment() {
        $sql = "select idDept, deptName
                from fpp..department";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $app = array();
        foreach ($data as $r => $rows) {
            $app[$rows['idDept']] = $rows['deptName'];
        }
        return $app;
    }
    
    public static function checkDocRequest(){
        //fungsi untuk mengecek apakah sales tersebut memiliki penagihan yang belum terealisasi
        $idcard = Yii::app()->user->getState('idcard');
        $sql = "select count(*) status
                    from tr_docRequest 
                    where realisasi = 0
                        and reqdate > '2017-08-01'
                        and reqSales = '".$idcard."'
                ";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        return $data['status'];
    }
    
    public static function getWarehouse($branch) {
        if($branch=='PTK'){
            $branch="PTN";
        }
        $sql = "select [LOCATION] from SGTDAT..MIS_LOC_ACTIVE where CATEGORY = '".$branch."'";
        $data = Yii::app()->db->createCommand($sql)->queryRow();
        
        return $data["LOCATION"];
    }

}

?>
