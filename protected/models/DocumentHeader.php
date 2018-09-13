<?php

class DocumentHeader extends CActiveRecord {

    public $keyWord;
    public $fromDate;
    public $toDate;
    public $check;
    public $invTotal;
    public $customer;
    public $invDate;
    public $dealer;
    public $poNumber;
    public $nameCust;
    public $invNet;
    public $suratJalan;
    public $faktur;
    public $eFaktur;
    public $payment;
    public $detailID;
    public $pending;
    public $type;
    public $payDate;
    public $isExport;
    public $payment2;
    public $retNumber;
    public $tttfp;
    
    public function tableName() {
        return 'tr_docHeader';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('docNumber', 'required',),
            array('docNumber,', 'unique',),
            array('headerID, detailID, docNumber, isComplete, status, keyWord, invDate, pending, completeDate, collector, invTotal, customer, suratJalan, '
                . 'dealer, poNumber, payment, eFaktur, faktur, payDate, fromDate, toDate, isExport, type, payment2, retNumber, completeUser', 'safe', 'on' => 'search,financeReview, failedDoc, treview,searchtt'),
        );
    }

    public function attributeLabels() {
        return array(
            "docNumber" => "Doc. Number",
            "isComplete" => "Is Complete",
            "status" => "Status",
             "tttfp" => "Nomor TTF",
            "customer" => "Customer"
        );
    }

    public function search() {
        $this->attributeLabels();
        
        $branch = Yii::app()->user->getState('branch');
        $idgrp = Yii::app()->user->getState('idgrp');

        $criteria = new CDbCriteria;

        $criteria->compare('h.docNumber', $this->keyWord, true, 'OR');
        $criteria->compare('i.BILNAME', $this->keyWord, true, 'OR');
        if ($this->pending) {
            $criteria->addCondition(" h.status = 0 ");
        }
        $criteria->addCondition(" ( c.IDCUST in (select IDCUST from getDealer('".$branch."','".$idgrp."')) OR c.IDNATACCT in (select IDCUST from getDealer('".$branch."','".$idgrp."')) )");
        $criteria->alias = 'h';
        $criteria->select = "docNumber, isComplete, status, i.BILNAME customer, i.invnetwtx invTotal, SGTDAT.dbo.fnGetAccpacDate(i.invDate) invDate, collector, collectorRcv, collectorRcvDate, customerRcv, customerRcvDate  ";
        $criteria->join = " left join SGTDAT..OEINVH i on i.INVNUMBER = h.docNumber"
                . " left join sgtdat..arcus c on c.idcust = i.customer ";

        //$criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'invDate DESC',
            ),
            'pagination' => array(
                'pageSize' => 25,
            ),
        ));
    }

    public function searchtt() {
        $this->attributeLabels();
        
        $branch = Yii::app()->user->getState('branch');
        $idgrp = Yii::app()->user->getState('idgrp');

        $criteria = new CDbCriteria;

        $criteria->compare('h.docNumber', $this->keyWord, true, 'OR');
        $criteria->compare('i.BILNAME', $this->keyWord, true, 'OR');
        $criteria->addCondition(" h.status = 5 ");
        
        $criteria->addCondition(" ( c.IDCUST in (select IDCUST from getDealer('".$branch."','".$idgrp."')) OR c.IDNATACCT in (select IDCUST from getDealer('".$branch."','".$idgrp."')) )");
        $criteria->alias = 'h';
        $criteria->select = "docNumber, isComplete, status, i.BILNAME customer, i.invnetwtx invTotal, SGTDAT.dbo.fnGetAccpacDate(i.invDate) invDate, collector, collectorRcv, collectorRcvDate, customerRcv, customerRcvDate,"
                . " (select max(retNumber) from tr_docRequestDetail where retType = 'TT' and docNumber = h.docNumber) tttfp  ";
        $criteria->join = " left join SGTDAT..OEINVH i on i.INVNUMBER = h.docNumber"
                . " left join sgtdat..arcus c on c.idcust = i.customer  ";

        //$criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'invDate DESC',
            ),
            'pagination' => array(
                'pageSize' => 25,
            ),
        ));
    }

    
    public function getHeader($id) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        $criteria->compare('h.docNumber', $id, true);

        $criteria->alias = 'h';
        $criteria->select = "  docNumber, isComplete, status, dt.custName customer, i.invnetwtx invTotal, SGTDAT.dbo.fnGetAccpacDate(i.INVDATE) invDate ";
        $criteria->join = " left join SGTDAT..MIS_PAJAK_DETAIL dt on dt.invNumber = h.docNumber 
                            left join SGTDAT..OEINVH i on i.INVNUMBER = h.docNumber ";

        //$criteria->limit = 20;
        return $this->find($criteria);
    }

    public function faktur() {
        $this->attributeLabels();

        $idcard = Yii::app()->user->getState('idcard');
        $level = Yii::app()->user->getState('level');
        $deptID = Yii::app()->user->getState('deptid');

        $criteria = new CDbCriteria;

        $criteria->addCondition("d.docTYpe = 'FK'");

//        if($level == "Accounting" )
//        {                
//            $criteria->addCondition(" a.fppStatus = 2");
//        }
//        else if($level == "Finance" )
//        {                
//            $criteria->addCondition(" a.fppStatus in (4,10)");
//        }
//        else if($level == "General" )
//        {                
//            $criteria->addCondition(" a.fppStatus in (5,8)");
//        }
        if ($level == "Admin" || $level == "Finance") {
            $criteria->addCondition(" d.[status] in (0)");
        }

        $criteria->alias = 'h';
        $criteria->select = " d.docID detailID, h.docNumber, d.docType, dt.bilname customer, SGTDAT.dbo.fnGetAccpacDate(dt.INVDATE) invDate  ";
        $criteria->join = " left join tr_docDetail d on h.docNumber = d.docNumber
                            left join SGTDAT..OEINVH dt on dt.INVNUMBER = h.docNumber  ";

        $criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'docNumber DESC',
            )
        ));
    }

    public function efaktur() {
        $this->attributeLabels();

        $idcard = Yii::app()->user->getState('idcard');
        $level = Yii::app()->user->getState('level');
        $deptID = Yii::app()->user->getState('deptid');

        $criteria = new CDbCriteria;

        $criteria->addCondition("d.docTYpe = 'EF'");

//        if($level == "Accounting" )
//        {                
//            $criteria->addCondition(" a.fppStatus = 2");
//        }
//        else if($level == "Finance" )
//        {                
//            $criteria->addCondition(" a.fppStatus in (4,10)");
//        }

        if ($level == "Finance") {
            $criteria->addCondition(" d.[status] in (1)");
        } else if ($level == "Accounting") {
            $criteria->addCondition(" d.[status] in (0)");
        } else if ($level == "Admin") {
            $criteria->addCondition(" d.[status] in (0,1)");
        }

        $criteria->alias = 'h';
        $criteria->select = " h.headerID, h.docNumber, d.docID detailID, d.docType,  dt.bilname customer, SGTDAT.dbo.fnGetAccpacDate(dt.INVDATE) invDate  ";
        $criteria->join = " left join tr_docDetail d on h.docNumber = d.docNumber
                            left join SGTDAT..OEINVH dt on dt.INVNUMBER = h.docNumber  ";

        $criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'docNumber DESC',
            )
        ));
    }

    public function sj() {
        $this->attributeLabels();

        $idcard = Yii::app()->user->getState('idcard');
        $level = Yii::app()->user->getState('level');
        $deptID = Yii::app()->user->getState('deptid');

        $criteria = new CDbCriteria;

        $criteria->addCondition("d.docTYpe = 'SJ'");

        if ($level == "Warehouse") {
            $criteria->addCondition("  d.status in (1)");
        } else if ($level == "SA") {
            $criteria->addCondition("  d.status in (2) ");
        } else if ($level == "Finance") {
            $criteria->addCondition(" d.status in (3)");
        } else if ($level == "Admin") {
            $criteria->addCondition(" d.[status] in (0,1,2,3)");
        }

//        $criteria->addCondition( " docNumber in (select docNumber from tr_docDetail)");
        $criteria->alias = 'h';
        $criteria->select = " h.headerID, d.docID detailID,h.docNumber, d.docType,  dt.bilname customer, SGTDAT.dbo.fnGetAccpacDate(dt.INVDATE) invDate  ";
        $criteria->join = " left join tr_docDetail d on h.docNumber = d.docNumber
                            left join SGTDAT..OEINVH dt on dt.INVNUMBER = h.docNumber  ";

        $criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'docNumber DESC',
            )
        ));
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->inputTime = new CDbExpression('getdate()');
                $this->inputUN = Yii::app()->user->name;
                $this->modifTime = new CDbExpression('getdate()');
                $this->modifUN = Yii::app()->user->name;
            } else
                $this->modifTime = new CDbExpression('getdate()');
            $this->modifUN = Yii::app()->user->name;
            return true;
        } else
            return false;
    }
    
    public function financeReview() {
        $this->attributeLabels();

        $criteria = new CDbCriteria;       
       
        $criteria->addCondition(" h.isPBH = 0 ");
        
        if($this->type != "ALL" && !empty($this->type)){
             $criteria->addCondition( " c.IDGRP = '".$this->type."'");
        }       
        
        if($this->customer != "ALL" && !empty($this->customer)){
             $criteria->addCondition( " c.IDNATACCT = '".$this->customer."'");
        }  
        
        if(!empty($this->fromDate) && !empty($this->toDate)){
            $criteria->addCondition( " DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), '".$this->fromDate."' ) <= 0 "
                . "                     and DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), '".$this->toDate."') >= 0 and h.invType in ('Y01','Y02','Y11','Y12' )");
        }
        
        
        $criteria->alias = 'h';
        $criteria->select = " sgtdat.dbo.fnGetAccpacDate(ih.INVDATE) invDate, ih.invnumber docNumber, ih.PONUMBER poNumber, ih.CUSTOMER customer, c.NAMECUST nameCust, ih.INVNETWTX invTotal,
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), max(inputTime)) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'SJ' and logStatus = 3) 'suratJalan',
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), inputTime) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'FK' and logStatus = 1) 'faktur',
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), inputTime) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'EF' and logStatus = 1) 'eFaktur',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), collectorRcvDate) 'collector',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), customerRcvDate) 'dealer',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), dbo.fnGetaccpacdate(ph.DATERMIT)) 'payment',
                            DATEDIFF(d, customerRcvDate, dbo.fnGetaccpacdate(ph.DATERMIT)) 'payment2',  
                            DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), completeDate) 'isComplete', 
                            dbo.fnGetaccpacdate(ph.DATERMIT) payDate ";
        $criteria->join = " left join SGTDAT..oeinvh ih on ih.invnumber = h.docNumber
                            left join SGTDAT..ARCUS c on c.IDCUST = ih.CUSTOMER
                            left join SGTDAT.dbo.ARTCP pd on pd.IDINVC = ih.INVNUMBER
                            left join SGTDAT.dbo.ARTCR ph on ph.CNTBTCH = pd.CNTBTCH and ph.CNTITEM = pd.CNTITEM
                            left join SGTDAT.dbo.ARBTA pc on pc.CNTBTCH = ph.CNTBTCH 
                    ";
        
        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'docNumber ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function treview() {
        $this->attributeLabels();
        $branch = Yii::app()->user->getState('branch');
        $idgrp = Yii::app()->user->getState('idgrp');
        $criteria = new CDbCriteria;       
       
        $criteria->addCondition(" h.isPBH = 0 ");
        
        if($branch != "PST"){
            $criteria->addCondition("  ( c.IDCUST in (select IDCUST from getDealer('".$branch."','".$idgrp."')) OR c.IDNATACCT in (select IDCUST from getDealer('".$branch."','".$idgrp."')) )");
        }

        if($this->customer != "ALL" && !empty($this->customer)){
             $criteria->addCondition( " c.IDCUST = '".$this->customer."'");
        }  
        
        if(!empty($this->fromDate) && !empty($this->toDate)){
            $criteria->addCondition( " DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), '".$this->fromDate."' ) <= 0 "
                . "                     and DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), '".$this->toDate."') >= 0 and h.invType in (select param from dbo.fn_MVParam('".$idgrp."',','))");
        }
        
        
        $criteria->alias = 'h';
        $criteria->select = " sgtdat.dbo.fnGetAccpacDate(ih.INVDATE) invDate, ih.invnumber docNumber, ih.PONUMBER poNumber, ih.CUSTOMER customer, c.NAMECUST nameCust, ih.INVNETWTX invTotal,
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), max(inputTime)) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'SJ' and logStatus = 3) 'suratJalan',
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), inputTime) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'FK' and logStatus = 1) 'faktur',
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), inputTime) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'EF' and logStatus = 1) 'eFaktur',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), collectorRcvDate) 'collector',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), customerRcvDate) 'dealer',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), dbo.fnGetaccpacdate(ph.DATERMIT)) 'payment',
                            DATEDIFF(d, customerRcvDate, dbo.fnGetaccpacdate(ph.DATERMIT)) 'payment2',                            
                            dbo.fnGetaccpacdate(ph.DATERMIT) payDate ";
        $criteria->join = " left join SGTDAT..oeinvh ih on ih.invnumber = h.docNumber
                            left join SGTDAT..ARCUS c on c.IDCUST = ih.CUSTOMER
                            left join SGTDAT.dbo.ARTCP pd on pd.IDINVC = ih.INVNUMBER
                            left join SGTDAT.dbo.ARTCR ph on ph.CNTBTCH = pd.CNTBTCH and ph.CNTITEM = pd.CNTITEM
                            left join SGTDAT.dbo.ARBTA pc on pc.CNTBTCH = ph.CNTBTCH 
                    ";
        
        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'docNumber ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    
    public function financeExport() {

        $this->attributeLabels();

        $criteria = new CDbCriteria;       
       
        $criteria->addCondition(" h.isPBH = 0 ");
        
        if($this->type != "ALL" && !empty($this->type)){
             $criteria->addCondition( " c.IDGRP = '".$this->type."'");
        }       
        
        if($this->customer != "ALL" && !empty($this->customer)){
             $criteria->addCondition( " c.IDNATACCT = '".$this->customer."'");
        }  
        
        if(!empty($this->fromDate) && !empty($this->toDate)){
            $criteria->addCondition( " DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), '".$this->fromDate."' ) <= 0 "
                . "                     and DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), '".$this->toDate."') >= 0 and h.invType in ('Y01','Y02','Y11','Y12' )");
        }
        
        $criteria->alias = 'h';
        $criteria->select = " sgtdat.dbo.fnGetAccpacDate(ih.INVDATE) invDate, ih.invnumber docNumber, ih.PONUMBER poNumber, ih.CUSTOMER customer, c.NAMECUST nameCust, ih.INVNETWTX invTotal,
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), max(inputTime)) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'SJ' and logStatus = 3) 'suratJalan',
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), inputTime) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'FK' and logStatus = 1) 'faktur',
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), inputTime) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'EF' and logStatus = 1) 'eFaktur',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), collectorRcvDate) 'collector',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), customerRcvDate) 'dealer',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), dbo.fnGetaccpacdate(ph.DATERMIT)) 'payment',
                            DATEDIFF(d, customerRcvDate, dbo.fnGetaccpacdate(ph.DATERMIT)) 'payment2',      
                            DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), completeDate) 'isComplete', 
                            dbo.fnGetaccpacdate(ph.DATERMIT) payDate ";
        $criteria->join = " left join SGTDAT..oeinvh ih on ih.invnumber = h.docNumber
                            left join SGTDAT..ARCUS c on c.IDCUST = ih.CUSTOMER
                            left join SGTDAT.dbo.ARTCP pd on pd.IDINVC = ih.INVNUMBER
                            left join SGTDAT.dbo.ARTCR ph on ph.CNTBTCH = pd.CNTBTCH and ph.CNTITEM = pd.CNTITEM
                            left join SGTDAT.dbo.ARBTA pc on pc.CNTBTCH = ph.CNTBTCH 
                    ";
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'docNumber ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function trExport() {

        $this->attributeLabels();
        
        $branch = Yii::app()->user->getState('branch');
        $idgrp = Yii::app()->user->getState('idgrp');
        
        $criteria = new CDbCriteria;       
       
        $criteria->addCondition(" h.isPBH = 0 ");
                
        if($this->customer != "ALL" && !empty($this->customer)){
             $criteria->addCondition( " c.IDCUST = '".$this->customer."'");
        }  
        
        if($branch != "PST"){
            $criteria->addCondition("  ( c.IDCUST in (select IDCUST from getDealer('".$branch."','".$idgrp."')) OR c.IDNATACCT in (select IDCUST from getDealer('".$branch."','".$idgrp."')) )");
        }

        if(!empty($this->fromDate) && !empty($this->toDate)){
            $criteria->addCondition( " DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), '".$this->fromDate."' ) <= 0 "
                . "                     and DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), '".$this->toDate."') >= 0 and h.invType in (select param from dbo.fn_MVParam('".$idgrp."',','))");
        }
        
        $criteria->alias = 'h';
        $criteria->select = " sgtdat.dbo.fnGetAccpacDate(ih.INVDATE) invDate, ih.invnumber docNumber, ih.PONUMBER poNumber, ih.CUSTOMER customer, c.NAMECUST nameCust, ih.INVNETWTX invTotal,
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), max(inputTime)) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'SJ' and logStatus = 3) 'suratJalan',
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), inputTime) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'FK' and logStatus = 1) 'faktur',
                            (select DATEDIFF(d, sgtdat.dbo.fnGetAccpacDate(ih.INVDATE), inputTime) from tr_docLog where docNumber = ih.INVNUMBER and docType = 'EF' and logStatus = 1) 'eFaktur',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), collectorRcvDate) 'collector',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), customerRcvDate) 'dealer',
                            DATEDIFF(d, dbo.fnGetaccpacdate(ih.invdate), dbo.fnGetaccpacdate(ph.DATERMIT)) 'payment',
                            DATEDIFF(d, customerRcvDate, dbo.fnGetaccpacdate(ph.DATERMIT)) 'payment2',                            
                            dbo.fnGetaccpacdate(ph.DATERMIT) payDate ";
        $criteria->join = " left join SGTDAT..oeinvh ih on ih.invnumber = h.docNumber
                            left join SGTDAT..ARCUS c on c.IDCUST = ih.CUSTOMER
                            left join SGTDAT.dbo.ARTCP pd on pd.IDINVC = ih.INVNUMBER
                            left join SGTDAT.dbo.ARTCR ph on ph.CNTBTCH = pd.CNTBTCH and ph.CNTITEM = pd.CNTITEM                            
                    ";
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'docNumber ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function failedDoc() {

        $this->attributeLabels();
        $branch = Yii::app()->user->getState('branch');
        $idgrp = Yii::app()->user->getState('idgrp');
        $criteria = new CDbCriteria;       
       
        $criteria->addCondition(" h.isPBH = 0 and h.invType  in (select param from dbo.fn_MVParam('".$idgrp."',',')) and h.status <> 2 and dt.retType = 'FL'");       
        if($this->customer != "ALL" && !empty($this->customer)){
             $criteria->addCondition( " hh.customer = '".$this->customer."'");
        } 
        
        if($branch != "PST"){
            $criteria->addCondition("  ( c.IDCUST in (select IDCUST from getDealer('".$branch."','".$idgrp."')) OR c.IDNATACCT in (select IDCUST from getDealer('".$branch."','".$idgrp."')) )");
        }

        if(!empty($this->fromDate) && !empty($this->toDate)){
            $criteria->addCondition( " DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(hh.invDate), '".$this->fromDate."' ) <= 0 "
                . "                     and DATEDIFF(d,sgtdat.dbo.fnGetAccpacDate(hh.invDate), '".$this->toDate."') >= 0 and h.invType  in (select param from dbo.fn_MVParam('".$idgrp."',','))");
        }
        
        
        $criteria->alias = 'h';
        $criteria->select = " dbo.fnGetAccpacDate(hh.INVDATE) invDate, h.docNumber, hh.PONUMBER poNumber, ltrim(rtrim(hh.CUSTOMER))customer, ltrim(rtrim(hh.BILNAME)) nameCust, INVNETWTX invTotal, dt.retNumber ";
        $criteria->join = " left join tr_docRequestDetail dt on dt.docNumber = h.docNumber
                            left join SGTDAT..oeinvh hh on hh.INVNUMBER = h.docNumber
                            left join sgtdat..arcus c on c.idcust = hh.customer
                            ";
        
        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'docNumber ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function getUnpaid() {
        $this->attributeLabels();
        $employee = Employee::model()->getActiveEmployee();
        $criteria = new CDbCriteria;
        $criteria->addCondition(" status = 3 and salesPIC = '".$employee->idCard."'");

        $criteria->alias = 'h';
        $criteria->select = " ltrim(rtrim(docNumber)) docNumber,  ltrim(rtrim(hh.BILNAME))customer, dbo.fnGetAccpacDate(hh.INVDATE) unDate, 
		INVNETWTX - (select sum(isnull(revValue,0)) from tr_docRequestDetail where docNumber = h.docNumber) unAmount ";    
        $criteria->join = " left join SGTDAT..oeinvh hh on hh.INVNUMBER = h.docNumber ";

        return $this->findAll($criteria);
    }
    
    public $unDate;
    public $unAmount;
    
    public function afterFind() {
        $this->unDate = date("d-m-Y", strtotime($this->unDate));
        $this->unAmount = Yii::app()->format->number(($this->unAmount));
        return parent::afterFind();
    }
    
}
