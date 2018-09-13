<?php

class FppHeader extends CActiveRecord
{
        public $fppCategoryValueDesc;
        public $fppCategoryDesc;
        public $total;
        public $fppUserName;
        public $fppUserDeptName;
        public $fppUserDateLong;
        public $nameBranch;
        public $nameDiv;
        public $keyWord;
        public $TOTAL;
        public $orderDate;
        public $approvePIC;
        public $fppTotal;
        public $adjType;
        public $adjValue;
        public $limit;
        public $approval;
        public $batch ;
        public $print ;
        public $printCabang ;
        public $approveFinance ;
        public $items;
        public $mode;
        public $desc;
        public $recNo;
        public $apSupplier;
        public $apInvNo;
        public $visible;
        public $optVeri;
        public $reason;
            
	public function tableName()
	{
            return 'tr_fppHeader';
	}

	public function rules()
	{
            return array(
                array('fppToName, fppToBank, fppToDate, fppCash, fppSaldo, fppLimit, fppOutstanding, fppCategoryValue', 'required',),
                array('fppNo', 'unique',),
                array('fppID, fppNo, fppUserDept, fppToBank, fppToBankAcc, fppFinBank, fppFinCheque, fppFinVoucher, fppCategory, fppCategoryValue, inputUN, modifUN', 'length', 'max'=>50),
                array('fppUser', 'length', 'max'=>25),                
                array('fppCash, fppSaldo, fppOutstanding', 'numerical', ),
                array('fppToName, fppCategoryValueDesc, adjustmentType', 'length', 'max'=>100),
                array('fppUserDate, fppToDate, inputTime, modifTime', 'safe'),
                array('fppID, fppNo, fppUser, fppUserDept, fppUserDate, fppToName, fppToBank, fppToBankAcc, fppToDate, fppFinBank, fppFinCheque, fppFinVoucher, fppCategory, fppCategoryValue, inputUN, inputTime, modifUN, modifTime,  
                       fppCategoryValueDesc, fppUserDateLong, fppCategoryDesc, keyWord, nameBranch, nameDiv, TOTAL, orderDate, approvePIC, adjustmentValue, adjustmentDesc, fppLimit, fppCash, fppSaldo, fppTotal, adjustmentType, adjValue, limit, approval, print, batch, fppOutstanding, approveFinance, mode, desc, apInvNo, apSupplier, recNo, visible, fppStatus, optVeri, reason', 'safe', 'on'=>'search, searchAccounting, searchFinance, searchFPP'),
            );
	}

	public function relations()
	{
            return array(
            );
	}

	public function attributeLabels()
	{
            return array(
                    'fppID' => 'ID',
                    'fppNo' => 'Nomor',
                    'fppUser' => 'Pemohon',
                    'fppUserDept' => 'Departemen',
                    'fppUserDate' => 'Tanggal Pengajuan',
                    'fppToName' => 'Nama Penerima',
                    'fppToBank' => 'Bank Penerima',
                    'fppToBankAcc' => 'No. Rekening',
                    'fppToDate' => 'Tanggal Pembayaran',
                    'fppFinBank' => 'Kas / Bank*',
                    'fppFinCheque' => 'No. Cheque / Giro',
                    'fppFinVoucher' => 'No. Voucher',
                    'fppCategory' => 'Kategori',
                    'fppCategoryValue' => 'Batch',
                    'fppUserName'=> 'Pemohon',
                    'fppUserDeptName'=>'Dept-Div/Cabang',
                    'fppCategoryDesc'=>'Kategori',
                    'fppLimit'=>'Limit',
                    'fppSaldo'=>'Saldo',
                    'fppCash'=>'Saldo Fisik',
                    'fppTotal'=>'Total',
                    'adjustmentType'=>'Tipe Koreksi',
                    'inputUN' => 'Dibuat Oleh',
                    'inputTime' => 'Dibuat Tanggal',
                    'modifUN' => 'Dirubah Oleh',
                    'modifTime' => 'Diruban Oleh',
                    'fppOutstanding'=>'Bon Gantung',
                    'apSupplier'=>'Supplier',
                    'desc'=>'Keterangan',
                    'recNo'=>'No. Penerimaan',
                    'fppStatus'=>'Status',
                    'optVeri'=>'Status FPP',
                    'reason'=>'Alasan'
                    
            );
	}

	public function search()
	{
            $this->attributeLabels();
            
            $idcard = Yii::app()->user->getState('idcard');
            $level = Yii::app()->user->getState('level');
            $idgrp = Yii::app()->user->getState('idgrp');
            $user = Yii::app()->user->name;
            
            $criteria=new CDbCriteria;                                   
            
            $criteria->compare('fppNo',$this->keyWord,true, 'OR');
            $criteria->compare('b.userName',$this->keyWord,true, 'OR');
            $criteria->compare('b.nameDiv',$this->keyWord,true, 'OR');
            $criteria->compare('c.categoryDesc',$this->keyWord,true, 'OR');
            $criteria->compare('fppToName',$this->keyWord,true, 'OR');
            $criteria->compare('fppToBank',$this->keyWord,true, 'OR');
            $criteria->compare('fppCategory',"KK",true);
            
            if($level != "Admin" && $level != "FIN-ALL" )
            {
                $criteria->addCondition(" fppUser = '".$idcard."'");
            }
            if($level == "FIN-ALL"  )
            {
                $criteria->addCondition(" persetujuan is null ");
            }
            
            
            $criteria->alias = 'a';                            
            $criteria->select=' a.fppID, a.fppNo, a.fppUser, b.userName fppUserName, a.fppUserDept, b.nameDept, a.fppCategory, c.categoryDesc, a.fppToName, a.fppToBank, dbo.getLongDate(a.fppUserDate) fppUserDate , '
                    . '         b.nameDept fppUserDeptName, b.nameBranch, b.nameDiv, (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo) TOTAL, fppUserDate orderDate, '
                    . "         (select 1 from tr_fppApproval where fppID = a.fppNo and keterangan = 'DIVHEAD' and persetujuan = 1) 'print',"
                    . "         (select 1 from tr_fppApproval where fppID = a.fppNo and keterangan = 'DEPTHEAD-BM' and persetujuan = 1) 'printCabang' ,"
                    . "         d.persetujuan 'approveFinance'";
            $criteria->join = " left join vwEmployee b on a.fppUser = b.idCard
                    left join ms_category c on a.fppCategory = c.categoryID
                    left join tr_fppApproval d on a.fppNo = d.fppID and keterangan = 'Finance I'";

            return new ActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                            'defaultOrder'=>'fppNo DESC',
                        )
            ));
	}
        
    public function searchFPP()
	{
            $this->attributeLabels();
            
            $idcard = Yii::app()->user->getState('idcard');
            $level = Yii::app()->user->getState('level');
            $user = Yii::app()->user->name;
            
            $criteria=new CDbCriteria;                                   
            
            $criteria->compare('fppNo',$this->keyWord,true, 'OR');
            $criteria->compare('b.userName',$this->keyWord,true, 'OR');
            $criteria->compare('b.nameDiv',$this->keyWord,true, 'OR');
            $criteria->compare('c.categoryDesc',$this->keyWord,true, 'OR');
            $criteria->compare('fppToName',$this->keyWord,true, 'OR');
            $criteria->compare('fppToBank',$this->keyWord,true, 'OR');
            $criteria->compare('fppCategory',"AP",true);
            if($level !== "Admin" AND $level !== "Finance"  )
            {
                $criteria->addCondition(" fppUser = '".$idcard."'");
            }
            if($this->mode == 'verifikasi'){
                $criteria->addCondition(" fppStatus = 6 ");
            }
            
            
            
            $criteria->alias = 'a';                            
            $criteria->select=' a.fppID, a.fppNo, a.fppUser, b.userName fppUserName, a.fppUserDept, b.nameDept, a.fppCategory, c.categoryDesc, a.fppToName, a.fppToBank, dbo.getLongDate(a.fppUserDate) fppUserDate , '
                    . '         b.nameDept fppUserDeptName, b.nameBranch, b.nameDiv, (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo) TOTAL, fppUserDate orderDate, fppStatus '                   
                    ;
            $criteria->join = " left join vwEmployee b on a.fppUser = b.idCard
                    left join ms_category c on a.fppCategory = c.categoryID
                    ";

            return new ActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                            'defaultOrder'=>'fppNo DESC',
                        )
            ));
	}
        
        public function veriAcct(){
            $this->attributeLabels();
            
            $idcard = Yii::app()->user->getState('idcard');
            $level = Yii::app()->user->getState('level');
            $user = Yii::app()->user->name;
            
            $criteria=new CDbCriteria;                                   
            
            $criteria->compare('fppNo',$this->keyWord,true, 'OR');
            $criteria->compare('b.userName',$this->keyWord,true, 'OR');
            $criteria->compare('b.nameDiv',$this->keyWord,true, 'OR');
            $criteria->compare('c.categoryDesc',$this->keyWord,true, 'OR');
            $criteria->compare('fppToName',$this->keyWord,true, 'OR');
            $criteria->compare('fppToBank',$this->keyWord,true, 'OR');
            $criteria->compare('fppCategory',"AP",true);
            $criteria->addCondition(" a.fppStatus = 3 ");
            
            $criteria->alias = 'a';                            
            $criteria->select=' a.fppID, a.fppNo, a.fppUser, b.userName fppUserName, a.fppUserDept, b.nameDept, a.fppCategory, c.categoryDesc, a.fppToName, a.fppToBank, dbo.getLongDate(a.fppUserDate) fppUserDate , '
                    . '         b.nameDept fppUserDeptName, b.nameBranch, b.nameDiv, (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo) TOTAL, fppUserDate orderDate '                   
                    ;
            $criteria->join = " left join vwEmployee b on a.fppUser = b.idCard
                    left join ms_category c on a.fppCategory = c.categoryID
                    ";

            return new ActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                            'defaultOrder'=>'fppNo DESC',
                        )
            ));
        }
        public function searchApproval()
	{
            $this->attributeLabels();
            
            $idcard = Yii::app()->user->getState('idcard');
            $user = Yii::app()->user->name;
            
            $criteria=new CDbCriteria;
                                                                                
            $criteria->compare('fppNo',$this->keyWord,true, 'OR');
            $criteria->compare('b.name',$this->keyWord,true, 'OR');
            $criteria->compare('b.divName',$this->keyWord,true, 'OR');
            $criteria->compare('c.categoryDesc',$this->keyWord,true, 'OR');
            $criteria->compare('fppToName',$this->keyWord,true, 'OR');
            $criteria->compare('fppToBank',$this->keyWord,true, 'OR');
            $criteria->addCondition("d.pic = '".$idcard."'"); 
            $criteria->addCondition('d.persetujuan is null');
            $criteria->addCondition('d.aktif = 1');
            $criteria->addCondition("fppCategory = 'KK'");
            
            $criteria->alias = 'a';                            
            $criteria->select=' a.fppID, a.fppNo, a.fppUser, b.userName fppUserName, a.fppUserDept, b.nameDept, a.fppCategory, c.categoryDesc, a.fppToName, a.fppToBank, dbo.getLongDate(a.fppUserDate) fppUserDate , '
                    . '         b.nameDept fppUserDeptName, b.nameBranch, b.nameDiv, (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo) TOTAL, fppUserDate orderDate ';
            $criteria->join = ' left join vwEmployee b on a.fppUser = b.idCard
                    left join ms_category c on a.fppCategory = c.categoryID 
                    left join tr_fppApproval d on a.fppNo = d.fppID and d.persetujuan is null and d.aktif = 1';
            
            
            return new ActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                            'defaultOrder'=>'orderDate DESC',
                        )
            ));
	}
        
        public function searchAccounting()
	{
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;
            
            $criteria->compare('fppNo',$this->keyWord,true, 'OR');
            $criteria->compare('b.userName',$this->keyWord,true, 'OR');
            $criteria->compare('b.nameDiv',$this->keyWord,true, 'OR');
            $criteria->compare('c.categoryDesc',$this->keyWord,true, 'OR');
            
            
            $criteria->addCondition("d.keterangan = 'Accounting'");           
            $criteria->addCondition("fppCategory = 'KK'");
            
            $criteria->alias = 'a';                            
            $criteria->select=" a.fppID, a.fppNo, a.fppUser, b.userName fppUserName, a.fppUserDept, b.nameDept, a.fppCategory, c.categoryDesc, a.fppToName, a.fppToBank, dbo.getLongDate(a.fppUserDate) fppUserDate , "
                    . "         b.nameDept fppUserDeptName, b.nameBranch, b.nameDiv, (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo) TOTAL, fppUserDate orderDate , "
                    . "         case d.persetujuan"
                    . "             when 0 then 'Tidak Disetujui'"
                    . "             when 1 then 'Disetujui'"
                    . "             else 'Menunggu persetujuan' end as approval ,"
                    . " case when  a.adjustmentType = '++' then (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo)+adjustmentValue "
                    . " else (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo)-adjustmentValue end as adjustmentValue, a.fppOutstanding"  ;
            $criteria->join = " left join vwEmployee b on a.fppUser = b.idCard
                    left join ms_category c on a.fppCategory = c.categoryID 
                    left join tr_fppApproval d on a.fppNo = d.fppID ";
            
            
            return new ActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                            'defaultOrder'=>'fppNo DESC',
                        )
            ));
	}        
        
        public function searchFinance()
	{
            $this->attributeLabels();
            
            $idcard = Yii::app()->user->getState('idcard');
            $user = Yii::app()->user->name;
            
            $criteria=new CDbCriteria;         
            
            $criteria->compare('fppNo',$this->keyWord,true, 'OR');
            $criteria->compare('b.userName',$this->keyWord,true, 'OR');
            $criteria->compare('b.nameDiv',$this->keyWord,true, 'OR');
            $criteria->compare('c.categoryDesc',$this->keyWord,true, 'OR');
            $criteria->compare('fppToName',$this->keyWord,true, 'OR');
            $criteria->compare('fppToBank',$this->keyWord,true, 'OR');            
            $criteria->addCondition(" d.keterangan = 'Finance I' "); 
            $criteria->addCondition(" d.persetujuan is not null ");
            $criteria->addCondition("fppCategory = 'KK'");
            
            $criteria->alias = 'a';                            
            $criteria->select=" a.fppID, a.fppNo, a.fppUser, b.userName fppUserName, a.fppUserDept, b.nameDept, a.fppCategory, c.categoryDesc, a.fppToName, a.fppToBank, dbo.getLongDate(a.fppUserDate) fppUserDate , "
                    . "         b.nameDept fppUserDeptName, b.nameBranch, b.nameDiv, (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo) TOTAL, fppUserDate orderDate, a.fppToBankAcc ,"
                    . "         dbo.getPaidAppr(a.fppNo) 'approval', a.fppCategoryValue batch,"
                    . "         (select 1 from tr_fppApproval where fppID = a.fppNo and keterangan = 'DIVHEAD' and persetujuan = 1) 'print',"
                    . " case when  a.adjustmentType = '++' then (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo)+adjustmentValue "
                    . " else (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo)-adjustmentValue end as adjustmentValue "  ;
            $criteria->join = ' left join vwEmployee b on a.fppUser = b.idCard
                        left join ms_category c on a.fppCategory = c.categoryID
                        left join tr_fppApproval d on d.fppID = a.fppNo ';
   
            return new ActiveDataProvider($this, array(
                'criteria' => $criteria,
                  'sort'=>array(
                    'defaultOrder'=>'fppNo DESC',
                  )
                
            ));
	}
        
        public function getHeader($fppID)
	{   
            $criteria=new CDbCriteria;
                        
            $criteria->compare('fppID',$fppID,true);
            $criteria->addCondition("fppCategory = 'KK'");
            
            $criteria->alias = 'a';                            
            $criteria->select=" a.fppID, a.fppNo, a.fppUser, b.userName fppUserName, a.fppUserDept, b.nameDept, a.fppCategory, c.categoryDesc fppCategoryDesc, a.fppToName, a.fppToBank, dbo.getLongDate(a.fppUserDate) fppUserDate , "
                    . "         b.nameDept + ' - ' + b.nameDiv + ' / ' + b.nameBranch fppUserDeptName, b.nameDiv, (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo) TOTAL, a.fppCategoryValue ,"
                    . "         a.fppToBankAcc,  dbo.getLongDate(a.fppToDate) fppToDate, a.adjustmentDesc, fppCash, fppSaldo, fppLimit, adjustmentValue adjValue, adjustmentType adjType, " 
                    . "         (select 1 from tr_fppApproval where fppID = a.fppNo and keterangan = 'Finance II' and persetujuan is null) 'approval'  , "
                    . "         case "
                    . "             when a.adjustmentType = '++' then '+'"
                    . "         else '-' end as adjustmentType,"
                    . " case when  a.adjustmentType = '++' then (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo)+adjustmentValue
                        else (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo)-adjustmentValue end as adjustmentValue, fppOutstanding" ;
                    
            $criteria->join = ' left join vwEmployee b on a.fppUser = b.idCard
                    left join ms_category c on a.fppCategory = c.categoryID
                    ';

            return  $this->find($criteria);
	}
        
        public function getHeaderFPP($fppID)
	{   
            $criteria=new CDbCriteria;
                        
            $criteria->compare('fppID',$fppID,true);
            $criteria->addCondition("fppCategory = 'AP'");
            
            $criteria->alias = 'a';                            
            $criteria->select=" a.fppID, a.fppNo, a.fppUser, b.userName fppUserName, a.fppUserDept, b.nameDept, a.fppCategory, c.categoryDesc fppCategoryDesc, a.fppToName, a.fppToBank, dbo.getLongDate(a.fppUserDate) fppUserDate , "
                    . "         b.nameDept + ' - ' + b.nameDiv + ' / ' + b.nameBranch fppUserDeptName, b.nameDiv, (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo) TOTAL, (select recNo from tr_apInvoice where apInvID = a.fppCategoryValue ) fppCategoryValue ,"
                    . "         a.fppToBankAcc,  dbo.getLongDate(a.fppToDate) fppToDate, a.adjustmentDesc, fppCash, fppSaldo, fppLimit, adjustmentValue adjValue, adjustmentType adjType, '' reason, fppCategoryValue "                    ;
            $criteria->join = ' left join vwEmployee b on a.fppUser = b.idCard
                    left join ms_category c on a.fppCategory = c.categoryID 
                   ';

            return  $this->find($criteria);
	}
        
        public function logbook()
        {
            $this->attributeLabels();

            $idcard = Yii::app()->user->getState('idcard');
            $level = Yii::app()->user->getState('level');
            $deptID = Yii::app()->user->getState('deptid');

            $criteria=new CDbCriteria;

            $criteria->compare('d.apInvNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.apSupplier',$this->keyWord,true,'OR');
            $criteria->addCondition("fppCategory = 'AP'");
            
            if($level == "Accounting" )
            {                
                $criteria->addCondition(" a.fppStatus = 2");
            }
            else if($level == "Finance" )
            {                
                $criteria->addCondition(" a.fppStatus in (4,10)");
            }
            else if($level == "General" )
            {                
                $criteria->addCondition(" a.fppStatus in (5,8)");
            }
            else if($level == "Admin" )
            {                
                $criteria->addCondition(" a.fppStatus in (2,4,5,8,10)");
            }
            
            $criteria->alias = 'a';                            
            $criteria->select=' a.fppID, a.fppNo, a.fppUser, b.userName fppUserName, a.fppUserDept, b.nameDept, a.fppCategory, c.categoryDesc, a.fppToName, a.fppToBank, dbo.getLongDate(a.fppUserDate) fppUserDate , '
                    . '         b.nameDept fppUserDeptName, b.nameBranch, b.nameDiv, (select abs(SUM(fppDetailValue)) from tr_fppDetail d where d.fppID = a.fppNo) TOTAL, fppUserDate orderDate  '                   
                    ;
            $criteria->join = " left join vwEmployee b on a.fppUser = b.idCard
                    left join ms_category c on a.fppCategory = c.categoryID
                    ";

            $criteria->limit = 20;

            return new ActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                            'defaultOrder'=>'fppNo DESC',
                        )
            ));
        }

	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
        
        protected function beforeSave()
        {            
            if(parent::beforeSave())
            {
                if($this->isNewRecord)
                {
                        $this->inputTime=new CDbExpression('getdate()');
                        $this->inputUN=Yii::app()->user->name;
                        $this->modifTime=new CDbExpression('getdate()');
                        $this->modifUN=Yii::app()->user->name;
                }
                else
                        $this->modifTime=new CDbExpression('getdate()');
                        $this->modifUN=Yii::app()->user->name;
                return true;
            }
            else
                    return false;
        }
}
