<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LookupView
 *
 * @author fajar.pratama
 */
class LookupView {

    public static function getContractHistory($contractID) {
        $record = Yii::app()->db->createCommand()
                ->select('contractID, max(contractStartDate) startDate, max(contractEndDate) toDate')
                ->from('vwContractHistory')
                ->where('contractID=:contractID', array(':contractID' => $contractID))
                ->group('contractID')
                ->queryRow();
        return $record;
    }

    public static function getDepartment() {
        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('Department')
                ->order('deptName')
                ->queryAll();

        //echo $rights; 
        return CHtml::listData($record, 'idDept', 'deptName');
    }

    public static function getDeptAsset() {
        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('ms_kodeAsset')
                ->order('Department')
                ->queryAll();

        //echo $rights; 
        return CHtml::listData($record, 'kodeAsset', 'Department');
    }

    public static function getUserAsset() {

        $sql = " select * from ms_kodeAsset where kodeAsset in (select param from dbo.fn_MVParam('" . Yii::app()->user->getState('kodeasset') . "',','))";
        $data = Yii::app()->db->createCommand($sql)->queryAll();


        //echo $rights; 
        return CHtml::listData($data, 'kodeAsset', 'Department');
    }

    public static function getBranchs() {
        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('vwLookupBranch')
                ->order('branchName')
                ->queryAll();

        //echo $rights; 
        return CHtml::listData($record, 'branchID', 'branchName');
    }

    public static function getDepartmentName($deptID) {
        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('vwLookupDepartment')
                ->where('idDept=:idDept', array(':deptID' => $deptID))
                ->queryRow();

        //echo $rights; 
        return $record['deptName'];
    }

    public static function getPIC($deptID) {
        if (empty($deptID))
            $deptID = null;

        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('vwEmployee')
                ->where("idDept=:idDept or idDept='-'", array(':idDept' => $idDept))
                ->order('userName')
                ->queryAll();
        return $record;
    }

    public static function getPICActive($idDept) {
        if (empty($idDept))
            $idDept = null;

        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('vwEmployee')
                ->where("idDept=:idDept and idCard <> '-'", array(':idDept' => $idDept))
                ->order('userName')
                ->queryAll();
        return $record;
    }

    public static function getKodeAssetDept($idDept) {
        if (empty($idDept))
            $idDept = null;

        //echo $idDept . "\n";    
        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('ms_asset')
                ->where("idDept=:id and statusID='1'", array(':id' => $idDept))
                ->queryAll();
        //print_r($record);
        return $record;
    }

    public static function getPICName($PICNo) {
        if (empty($PICNo))
            $PICNo = null;
        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('vwLookupPIC')
                ->where('PICNo=:PICNo', array(':PICNo' => $PICNo))
                ->order('PICName')
                ->queryRow();
        return $record['PICName'];
    }

    public static function getPICDept($PICNo) {
        if (empty($PICNo))
            $PICNo = null;

        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('vwLookupPIC')
                ->where('PICNo=:PICNo', array(':PICNo' => $PICNo))
                ->order('PICName')
                ->queryRow();
        return $record['deptID'];
    }

    public static function getBranch() {
        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('vwLookupBranch')
                ->order('branchName')
                ->queryAll();

        //echo $rights; 
        return $record;
    }

    public static function getBranchName($branchID) {
        $record = Yii::app()->db->createCommand()
                ->select('*')
                ->from('vwLookupBranch')
                ->where('branchID=:branchID', array(':branchID' => $branchID))
                ->queryRow();

        //echo $rights; 
        //return $record['branchName'] ;     
        if ($record === null) {
            return '-';
        } else {
            return $record['branchName'];
        }
    }

    public static function getAssetNo($deptID) {
        $deptID = '11';
        $intYear = date('Y');
        $intMonth = date('m');

        $row = SysCounter::model()->count('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType' => 'asset', ':deptID' => $deptID, ':intYear' => $intYear));
        if ($row == 0) {
            $number = 1;
        } else {
            $record = SysCounter::model()->find('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType' => 'asset', ':deptID' => $deptID, ':intYear' => $intYear));
            ;
            $number = $record['intCount'];
        }

        $number = substr('000000' . $number, -6);

        $assetNo = $intYear . '/' . self::getRoman($intMonth) . '/MIS/' . $number;
        return $assetNo;
    }

    public static function getContractRefNo($contractID) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(contractLineNo),0)+1 as count')
                ->from('tr_contractDetail')
                ->where("contractID='" . $contractID . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getContractHistRefNo($contractID) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(contractHistLineNo),0)+1 as count')
                ->from('tr_contractHistory')
                ->where("contractID='" . $contractID . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getContractNotifNo($contractID) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(contractNotifNo),0)+1 as count')
                ->from('tr_contractNotification')
                ->where("contractID='" . $contractID . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getContractAttachNo($contractID) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(contractAttachNo),0)+1 as count')
                ->from('tr_contractAttachment')
                ->where("contractID='" . $contractID . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getAktaAttachNo($no_akta) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(aktaAttachNo),0)+1 as count')
                ->from('tr_aktaAttachment')
                ->where("no_akta='" . $no_akta . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getStnkAttachNo($id_number) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(stnkAttachNo),0)+1 as count')
                ->from('tr_stnkAttachment')
                ->where("id_number='" . $id_number . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getLicenseAttachNo($licenseID) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(licenseAttachNo),0)+1 as count')
                ->from('tr_licenseAttachment')
                ->where("licenseID='" . $licenseID . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getBrandsAttachNo($brandID) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(brandAttachNo),0)+1 as count')
                ->from('tr_brandAttachment')
                ->where("brandID='" . $brandID . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getRequestAttachNo($requestID) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(requestAttachNo),0)+1 as count')
                ->from('tr_requestAttachment')
                ->where("requestID='" . $requestID . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getContractBillingNo($contractID) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(contractBillingNo),0)+1 as count')
                ->from('tr_contractBilling')
                ->where("contractID='" . $contractID . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getDisposalAttach($disposalNo) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(disposalAttachNo),0)+1 as count')
                ->from('tr_assetDisposalAttachment')
                ->where("disposalNo='" . $disposalNo . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getLogRefNo($assetID) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(logLineNo),0)+1 as count')
                ->from('tr_assetLog')
                ->where("assetID='" . $assetID . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getActivityRefNo($id) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(activityLogNo),0)+1 as count')
                ->from('tr_requestLogActivity')
                ->where("activityNo=" . $id)
                //->where("requestID='".$requestID."'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    public static function getRequestID($id) {
        $requestID = Yii::app()->db->createCommand()
                ->select('requestID')
                ->from('tr_requestActivity')
                ->where("activityNo=" . $id)
                //->where("requestID='".$requestID."'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($requestID === null) {
            return 0;
        } else {
            return $requestID['requestID'];
        }
    }

    public static function getMutationNo($deptID) {
        $deptID = '11';
        $intYear = date('Y');
        $intMonth = date('m');

        $row = SysCounter::model()->count('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType' => 'mutation', ':deptID' => $deptID, ':intYear' => $intYear));
        if ($row == 0) {
            $number = 1;
        } else {
            $record = SysCounterMutation::model()->find('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType' => 'mutation', ':deptID' => $deptID, ':intYear' => $intYear));
            ;
            $number = $record['intCount'];
        }

        $number = substr('000000' . $number, -6);

        $mutationNo = $intYear . '/' . self::getRoman($intMonth) . '/MAT/MIS/' . $number;
        return $mutationNo;
    }

    public static function getMutationRefNo($mutationNo) {
        $count = Yii::app()->db->createCommand()
                ->select('isnull(max(mutationLineNo),0)+1 as count')
                ->from('tr_assetMutationDetail')
                ->where("mutationNo='" . $mutationNo . "'")
                //->queryRow(true);
                ->queryRow();
        //echo $rights;
        if ($count === null) {
            return 0;
        } else {
            return $count['count'];
        }
    }

    /* public static function getRequestNo($deptID)
      {
      $deptID = '11';
      $intYear = date('Y');
      $intMonth = date('m');

      $row = SysCounter::model()->count('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType'=>'request',':deptID'=>$deptID,':intYear'=>$intYear));
      if($row == 0)
      {
      $number = 1;
      }
      else
      {
      $record = SysCounter::model()->find('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType'=>'request',':deptID'=>$deptID,':intYear'=>$intYear));;
      $number = $record['intCount'];
      }

      $number = substr('000000'.$number, -6) ;

      $requestNo = $intYear.'/'.self::getRoman($intMonth).'/REQ/MIS/'.$number;
      return $requestNo;
      } */

    public static function getRequestNo($deptID) {
        $deptID = '11';
        $intYear = date('Y');
        $intMonth = date('m');

        $row = SysCounter::model()->count('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType' => 'request', ':deptID' => $deptID, ':intYear' => $intYear));
        if ($row == 0) {
            $number = 1;
        } else {
            $record = SysCounter::model()->find('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType' => 'request', ':deptID' => $deptID, ':intYear' => $intYear));
            ;
            $number = $record['intCount'];
        }

        $number = substr('000000' . $number, -6);

        $requestNo = $intYear . '/' . self::getRoman($intMonth) . '/REQ/MIS/' . $number;
        return $requestNo;
    }

    public static function getContractNo($deptID) {
        //$deptID = '11';
        $intYear = date('Y');
        $intMonth = date('m');

        $row = SysCounter::model()->count('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType' => 'contract', ':deptID' => $deptID, ':intYear' => $intYear));
        if ($row == 0) {
            $number = 1;
        } else {
            $record = SysCounter::model()->find('counterType=:counterType and deptID=:deptID and intYear=:intYear', array('counterType' => 'contract', ':deptID' => $deptID, ':intYear' => $intYear));
            ;
            $number = $record['intCount'];
        }

        $number = substr('000000' . $number, -6);

        $requestNo = $intYear . '/' . self::getRoman($intMonth) . '/CONTRACT/' . $deptID . '/' . $number;
        return $requestNo;
    }

    public static function getIP() {
        //return CHttpRequest::getUserHostAddress();
        return Yii::app()->request->getUserHostAddress();
    }

    public static function getHistory($contractReffID) {
        //$db = Yii::app()->db;
        //$command = $db->createCommand('exec spGetContractHistory :contractID');
        //$command->bindParam(':contractID', $contractID, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 50);
        //$command = "exec spGetContractHistory '".$contractID."'";        
        /*
          $sql = "    SET NOCOUNT ON;
          declare @id varchar(50)
          declare @number varchar(50)
          declare @reff varchar(50)
          declare @name varchar(200)
          declare @StartDate datetime
          declare @EndDate datetime
          declare @order int
          set @order  = 0
          create table #temp (
          id varchar(50),
          number varchar(50),
          refference varchar(50),
          [name] varchar(200),
          StartDate datetime,
          endDate datetime,
          [order] int
          )
          set @reff = '".$contractReffID."'
          WHILE @reff <> ''
          BEGIN
          SELECT @id = contractID, @number = contractNumber, @reff = contractReffID, @name = contractName,
          @StartDate = contractStartDate, @EndDate = contractEndDate
          FROM tr_contract
          WHERE contractID = @reff
          set @order = @order + 1
          insert into #temp values (@id, @number, @reff, @name, @StartDate, @EndDate, @order)
          END
          "; */
        $sql = " SET NOCOUNT ON;
                    select arah [order], b.contractid [id], b.contractnumber [number], b.contractname [name], contractstartdate [startDate], contractenddate [endDate], levelnya
                    into #temp
                    from dbo.ufnx_Legal_HistoryPerjanjian('" . $contractReffID . "') a, tr_contract b 
                    where a.contractnumber=b.contractnumber 
               ";
        $command = $sql . " select id, number, name, startDate, endDate from #temp order by [order], levelnya 
                    drop table #temp ";
        $count = Yii::app()->db->createCommand($sql . " select count(id) [counter] from #temp
                                                drop table #temp")->queryScalar();

        $dataProvider = new CSqlDataProvider($command, array(
            'totalItemCount' => $count,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        return $dataProvider;
    }
    
    protected static function getRoman($int) {
        $roman = '';
        switch ($int) {
            case 1:
                $roman = 'I';
                break;
            case 2:
                $roman = 'II';
                break;
            case 3:
                $roman = 'III';
                break;
            case 4:
                $roman = 'IV';
                break;
            case 5:
                $roman = 'V';
                break;
            case 6:
                $roman = 'VI';
                break;
            case 7:
                $roman = 'VII';
                break;
            case 8:
                $roman = 'VIII';
                break;
            case 9:
                $roman = 'IX';
                break;
            case 10:
                $roman = 'X';
                break;
            case 11:
                $roman = 'XI';
                break;
            case 12:
                $roman = 'XII';
                break;
        }
        return $roman;
    }

    public static function getInactiveAgreement() {
//         $sql = "  SET NOCOUNT ON;
//                    declare @id varchar(50)
//                    declare @number varchar(50)
//                    declare @reff varchar(50)
//                    declare @parentID varchar(50), @parentReff varchar(50), @parentReffID varchar(50)
//
//                    create table #temp (
//                            id varchar(50),
//                            number varchar(50),
//                            refference varchar(50)        
//                            )
//
//                    DECLARE contractCursor CURSOR  
//                        FOR select contractID, contractReff, contractReffID from tr_contract where isActive = 1 and contractReffID <> ''
//                    OPEN contractCursor
//
//                    FETCH NEXT FROM contractCursor
//                    INTO @parentID, @parentReff, @parentReffID
//
//                    WHILE @@FETCH_STATUS = 0  
//                    BEGIN  	
//                        SET @reff = @parentReffID
//                        WHILE @reff <> ''
//                        BEGIN
//                            declare @count int 
//                            set @count = 0
//                            select @count = COUNT(*) from IMASSET..tr_contract where contractID = @reff
//                            if @count > 0
//                            begin
//                                    SELECT @id = contractID, @number = contractReff, @reff = isnull(contractReffID,'')
//                                            FROM tr_contract
//                                            WHERE contractID = @reff		
//                                    insert into #temp values (@id, @number, @reff)				
//                            end
//                            else
//                            begin
//                                    set @reff = ''
//                            end
//
//                        END 
//
//                        FETCH NEXT FROM contractCursor
//                        INTO @parentID, @parentReff, @parentReffID
//
//                    END
//                    CLOSE contractCursor;  
//                    DEALLOCATE contractCursor;  
//
//                    ";
//        $command = $sql." select * from tr_contract where contractID not in (select id from #temp) and isActive = 0
//                            drop table #temp ";
//        $count = Yii::app()->db->createCommand($sql." select count(contractID) [counter] from #temp
//                                                drop table #temp")->queryScalar();  
//        
        $command = "select row_number() OVER ( order by contractID ) id, contractNumber, contractID, t.deptID, d.deptName, contractName, vendorID, vendorPIC, contractStartDate, contractEndDate, isActive, contractReff, contractReffID, inputTime "
                . "from IMASSET.dbo.fnGetInactiveAgreement() t "
                . "left join vwLookupDepartment d on d.deptID = t.deptID ";
        $count = Yii::app()->db->createCommand(" select count(contractID) from IMASSET.dbo.fnGetInactiveAgreement() ")->queryScalar();

        $dataProvider = new CSqlDataProvider($command, array(
            'totalItemCount' => $count,
            'keyField' => 'contractID',
            'pagination' => array(
                'pageSize' => 30,
            ),
        ));
        return $dataProvider;
    }
    

}

?>
