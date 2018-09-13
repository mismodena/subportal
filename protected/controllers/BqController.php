<?php

class BQController extends Controller {

    public $layout = 'leftbar';

    function init() {
        parent::init();
        $this->leftPortlets['ptl.BQMenu'] = array();
    }

    public function filters() {
        return array(
            'Rights',
        );
    }

    public function allowedActions() {
        return 'getMaxValue, getQ, getCustByGroups, getBalance';
    }

    public function actionGetMaxValue($value) {
//        print_r(Utility::getMaxValue($value)); 
//        exit();
        echo Utility::getMaxValue($value);
    }

    public function actionGetBalance($dealerID, $branchID) {
//        print_r(Utility::getMaxValue($value)); 
//        exit();
        echo CJSON::encode(Utility::getBalance($dealerID, $branchID));
    }
    
     public function actionGetCustByGroups($idgrp) {
//        print_r(Utility::getMaxValue($value)); 
//        exit();
        echo CJSON::encode(Utility::getCustByGroup($idgrp));
    }
    
    public function actionGetLastQ($dealerID) {
//        print_r(Utility::getMaxValue($value)); 
//        exit();
        echo CJSON::encode(Utility::getLastQ($dealerID));
    }
            
    public function actionGetQ($year) {
//        print_r(Utility::getMaxValue($value)); 
//        exit();
        echo CJSON::encode(Utility::getPeriodeQ($year));
    }

    public function actionTermIndex() {
        $model = new BQTerm('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BQTerm'])) {
            $model->attributes = $_GET['BQTerm'];
        }

        $this->render('termIndex', array(
            'model' => $model,
        ));
    }

    public function actionTermCreate() {
        $model = new BQTerm;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, 1);

        if (isset($_POST['BQTerm'])) {
            $model->attributes = $_POST['BQTerm'];
            $model->validate();

            if ($model->validate()) {
                if ($model->save()) {
                    $this->redirect(array('termIndex'));
                }
            }
        }

        $this->render('termCreate', array(
            'model' => $model,
        ));
    }
    
    
    public function actionTermUpdate($type, $classDealer) {
        $model = BQTerm::model()->findByAttributes(array('termType' => $type, 'classDealer' => $classDealer));

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, 1);

        if (isset($_POST['BQTerm'])) {
            $model->attributes = $_POST['BQTerm'];

            $model->validate();

            if ($model->validate()) {
                if ($model->save()) {
                    $this->redirect(array('termIndex'));
                }
            }
        }

        $this->render('termUpdate', array(
            'model' => $model,
        ));
    }

    public function actionOpenIndex() {
        $model = new BQOpen('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BQOpen'])) {
            $model->attributes = $_GET['BQOpen'];
        }

        $this->render('openIndex', array(
            'model' => $model,
        ));
    }
    
    public function actionRptQ() {
        $model = new BQBalance('rptQ');
        $model->unsetAttributes();  // clear any default values
//        $model->year = date("Y");
//        $model->keyWord = "Q".Utility::getQuarterByMonth(date("m"))-1;       

        if (isset($_GET['BQBalance'])) {
            $model->attributes = $_GET['BQBalance'];
        }
        $this->render('rptQ', array(
            'model' => $model,
        ));
    }
    
    public function actionRptRealisasi() {
        $model = new BQBalance('rptRealisasi');
        $model->unsetAttributes();  // clear any default values
        $model->keyWord = date("Y");

        if (isset($_GET['BQBalance'])) {
            $model->attributes = $_GET['BQBalance'];
        }
        $this->render('rptRealisasi', array(
            'model' => $model,
        ));
    }
    
    public function actionExpRealisasi() {

        $period = isset($_GET['period']) ? $_GET['period'] : date("Y");
        
        
        $model = new BQBalance('rptRealisasi');
        $model->unsetAttributes();  // clear any default values
        $model->keyWord = $period;
                
        $this->widget('ext.EExcelView', array(
            'title' => "Laporan Realisasi",
            'dataProvider' => $model->rptRealisasi(),
            'grid_mode' => 'export',
            'columns' => array(
//                array(
//                    "name" => "Cabang",
//                    "value" => '$data["nameCust"]',
//                    "type" => "raw",
//                ),
//                array(
//                    "name" => "BQ-Q1",
//                    "value" => '"$data["Q1"]',
//                    'htmlOptions' => array('style' => 'text-align:right;'),
//                    "type" => "raw",
//                ),
//                array(
//                    "name" => "TQ-Q1",
//                    "value" => '"$data["T1"]',
//                    'htmlOptions' => array('style' => 'text-align:right;'),
//                    "type" => "raw",
//                ),                
//                array(
//                    "name" => "BQ-Q2",
//                    "value" => '"$data["Q2"]',
//                    'htmlOptions' => array('style' => 'text-align:right;'),
//                    "type" => "raw",
//                ),
//                array(
//                    "name" => "TQ-Q2",
//                    "value" => '"$data["2"]',
//                    'htmlOptions' => array('style' => 'text-align:right;'),
//                    "type" => "raw",
//                ),
//                array(
//                    "name" => "BQ-Q3",
//                    "value" => '"$data["Q3"]',
//                    'htmlOptions' => array('style' => 'text-align:right;'),
//                    "type" => "raw",
//                ),
//                array(
//                    "name" => "TQ-Q3",
//                    "value" => '"$data["T3"]',
//                    'htmlOptions' => array('style' => 'text-align:right;'),
//                    "type" => "raw",
//                ),
//                array(
//                    "name" => "BQ-Q4",
//                    "value" => '"$data["Q4"]',
//                    'htmlOptions' => array('style' => 'text-align:right;'),
//                    "type" => "raw",
//                ),
//                array(
//                    "name" => "TQ-Q4",
//                    "value" => '"$data["T4"]',
//                    'htmlOptions' => array('style' => 'text-align:right;'),
//                    "type" => "raw",
//                ),
            ),
        ));
    }
    
    public function actionExpQ() {
        
        $model = new BQBalance('expBQ');
        $model->unsetAttributes();  // clear any default values
        $model->balanceReff = $_GET["id"];
        $model->idBranch = $_GET["branch"];
        $title = "Laporan Cabang ".$_GET["nameC"]. " Periode " . $model->balanceReff;
        $this->widget('ext.EExcelView', array(
            'title' => $title,
            'dataProvider' => $model->expBQ(),
            'grid_mode' => 'export',
            'columns' => array(
                array(
                    'name' => 'Referensi',
                    'type' => 'raw',
                    'value' => '$data->balanceReff',
                ), 
                array(
                    'name' => 'Tanggal',
                    'type' => 'raw',
                    'value' => 'date("d-m-Y", strtotime($data->balanceDate))',
                ),
                array(
                    'header' => 'Nomor',
                    'value' => '$data->linkReff',
                ),
                array(
                    'header' => 'Deskripsi',
                    'value' => '$data->balanceDesc',
                ),
                array(
                    'header' => 'idCust',
                    'value' => '$data->idCust',
                ),
                array(
                    'header' => 'nameCust',
                    'value' => '$data->nameCust',
                ),
                array(
                    'header' => 'claimDesc',
                    'value' => '$data->claimDesc',
                ),
                array(
                    'header' => 'BQ In',
                    'value' => '$data->bqIn',
                    'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
                ),
                array(
                    'header' => 'BQ Out',
                    'value' => '$data->bqOut',
                    'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
                ),
//                array(
//                    'header' => 'TQ In',
//                    'value' => '$data->tqIn',
//                    'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
//                ),
//                array(
//                    'header' => 'TQ Out',
//                    'value' => '$data->tqOut',
//                    'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
//                ),

            ),
        ));
    }

    
    public function actionUploadIndex() {
        $model = new BQUpload('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BQUpload'])) {
            $model->attributes = $_GET['BQUpload'];
        }

        $this->render('upload', array(
            'model' => $model,
        ));
    }

    public function actionOpendetail($id) {
        $this->layout = '//layouts/iframex';
        $model = BQOpen::model()->findByAttributes(array("openID" => $id));

        $result = BQOpen::model()->getDetail($model->fiscalPeriod, $model->idCust);


        $this->render('openDetail', array(
            'model' => $result,
        ));
    }
    
    public function actionClaimdetail($id) {
        $this->layout = '//layouts/iframex';
        $model = BQClaim::model()->getHeader($id);
        $detail = BQClaimDetail::model()->getDetail($model->bqClaimNo);
                
        $this->render('claimDetail', array(
            'model'=>$model,
            'detail' => $detail,
        ));
    }

    public function actionOpenCreate() {

        $model = new BQOpen();
        $model->fiscalPeriod = date('Y') . '-Q' . Utility::getQuarterByMonth(date('m'));
        $isOpen = BQFiscal::model()->findByAttributes(array("fiscalPeriod" => $model->fiscalPeriod))->openTQ;
        if ($isOpen == 0) {
            throw new CHttpException(404, 'Pengajuan Open TQ-TT untuk tahun ini sudah di tutup.  Maksimal 31 Maret setiap tahunnya');
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, 2);

        if (isset($_POST['BQOpen'])) {
            $userid = Yii::app()->user->getState('idcard');
            $lastQ = Utility::getLastQ($model->idCust);
            $model->attributes = $_POST['BQOpen'];
            $revNo = Utility::getBQRev($model->fiscalPeriod, $model->idCust);
            $model->salesTarget = str_replace(",", "", $_POST['BQOpen']['salesTarget']);
            $model->openTarget = str_replace(",", "", $_POST['BQOpen']['openTarget']);
            $model->openBonus = str_replace(",", "", $_POST['BQOpen']['openBonus']);
            $model->revNo = $revNo + 1;
            $model->visible = 1;
            $model->status = 0;
            $model->lastQ = $lastQ[0];
            $model->openUser = $userid;
            $model->openID = new CDbExpression('newID()');
            $model->validate();

            if ($model->validate()) {
                if ($model->save()) {
                    $command = Yii::app()->db->createCommand("update tr_bqOpen set visible = 0 where idCust = '" . $model->idCust . "' and fiscalPeriod = '" . $model->fiscalPeriod . "' and revNo <> " . $model->revNo);
                    $command->execute();
                    $this->kirimEmail($model->fiscalPeriod, $model->idCust, $model->revNo,0);
                    $this->redirect(array('openIndex'));
                }
            }
        }

        $this->render('openCreate', array(
            'model' => $model,
        ));
    }
    
    public function actionUploadCreate() {

        $model = new BQUpload();
        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDate();

        $model->fmtDate = $longDate;
        $model->uploadDate = $now;
        $model->PIC = $employee->idCard;
        $model->userName = $employee->userName;
        $model->deptID = $employee->idDept;
        $model->deptName = $employee->nameDept . ' - ' . $employee->nameBranch;
        $model->branchName = $employee->nameBranch;
        $model->branchID = $employee->idBranch;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, 2);

        if (isset($_POST['BQUpload'])) {
            $model->attributes = $_POST['BQUpload'];
            $model->bqUploadNo = Utility::getBQUpload();
            $model->uploadTotal = $model->bqValue + $model->tqValue;
            $model->uploadBranch = $_POST['BQUpload']['uploadBranch'];
            $model->idCust = $_POST['BQUpload']['idCust'];
            $model->validate();

            if ($model->validate()) {
                if ($model->save()) {
                    $this->kirimEmail3($model->bqUploadNo,0);
                    $this->redirect(array('uploadIndex'));
                }
            }
        }

        $this->render('uploadCreate', array(
            'model' => $model,
        ));
    }

    public function actionBalanceIndex() {
        $model = new BQBalance('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BQBalance'])) {
            $model->attributes = $_GET['BQBalance'];
        }

        $this->render('balanceIndex', array(
            'model' => $model,
        ));
    }

    public function actionBalanceView($id, $name) {
        $BQ = BQBalance::model()->getBQ($id);
        $TQ = BQBalance::model()->getTQ($id);
        $nameBranch = $name;
//        echo "<pre>";
//        print_r($detail);
//        echo "</pre>";
//        exit();
        $this->render('balanceView', array(
            'BQ' => $BQ,
            'TQ' => $TQ,
            'id' => $id,
            'name' => $name,
        ));
    }

    public function actionSourceDetail($reff, $id, $name) {
        $model = BQSource::model()->getSourceDetail($reff, $id);
        $arr = array("reff" => $reff, "id" => $id, "name" => $name);
        $this->render('sourceDetail', array(
            'model' => $model,
            'arr' => $arr,
        ));
    }

    public function actionBalanceDetail($type, $reff, $idBranch, $idCust) {
        $this->layout = '//layouts/iframex';
        if ($type == "bq") {
            $result = BQBalance::model()->getBQDetail($reff, $idBranch);
        } else {
            $result = BQBalance::model()->getTQDetail($reff, $idBranch, $idCust);
        }

        $this->render('balanceDetail', array(
            'model' => $result,
        ));
    }

    protected function performAjaxValidation($model, $index) {
        if ($index == 1) {
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'master-term-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        } else if ($index == 2) {
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'master-open-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
    }

    public function actionSetupIndex() {
        $model = new BQSetup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BQSetup'])) {
            $model->attributes = $_GET['BQSetup'];
        }

        $this->render('setupIndex', array(
            'model' => $model,
        ));
    }

    public function actionSetupUpdate($fiscal) {

        $model = BQSetup::model()->findByAttributes(array("fiscalPeriod" => $fiscal));

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, 2);

        if (isset($_POST['BQSetup'])) {
            $model->attributes = $_POST['BQSetup'];
            $model->validate();

            if ($model->validate()) {
                if ($model->save()) {
                    $this->redirect(array('setupIndex'));
                }
            }
        }

        $this->render('setupUpdate', array(
            'model' => $model,
        ));
    }

    public function actionClaim() {
        $model = new BQClaim('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BQClaim'])) {
            $model->attributes = $_GET['BQClaim'];
        }

        $this->render('claim', array(
            'model' => $model,
        ));
    }
    
    public function actionVerify() {
        $model = new BQClaim('verify');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BQClaim'])) {
            $model->attributes = $_GET['BQClaim'];
        }

        $this->render('verify', array(
            'model' => $model,
        ));
    }

    public function actionClaimCreate() {

        $model = new BQClaim;
        $model->nonItems[] = new BQNonItem();

        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDate();

        $model->fmtDate = $longDate;
        $model->claimDate = $now;
        $model->PIC = $employee->idCard;
        $model->userName = $employee->userName;
        $model->deptID = $employee->idDept;
        $model->deptName = $employee->nameDept . ' - ' . $employee->nameBranch;
        $model->branchName = $employee->nameBranch;
        $model->branchID = $employee->idBranch;
        $model->voucher = Yii::app()->user->getState('branch');
        $model->claimType2 = 'non';

//        $this->performAjaxValidation($model);

        if (isset($_POST['BQClaim'])) {
            $transaction = Yii::app()->db->beginTransaction();
            //$idgrp = Yii::app()->user->getState('branch');
            $idgrp = $_POST['BQClaim']['branchID'];
            $model->attributes = $_POST['BQClaim'];
            $model->bqClaimNo = Utility::getBQClaimNo();
            $model->totalItems = 0;
            $model->totalNonItems = str_replace(",", "", $_POST['BQClaim']['claimTotal']);
            $model->bqUsed = str_replace(",", "", $_POST['BQClaim']['bqUsed']);
            $model->tqUsed = str_replace(",", "", $_POST['BQClaim']['tqUsed']);
            $model->claimTotal = str_replace(",", "", $_POST['BQClaim']['totalAll']);
            $model->status = 0;
            $model->claimType = 0;
            $model->branchBudget = $idgrp;

            try {
                $isValid = $model->validate();             
                //$model->save();
                                                
                $path = DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'bqtq'.DIRECTORY_SEPARATOR;                       
                $temp=CUploadedFile::getInstance($model,'attachment');

                $formatName=time().'-'. str_replace("/", "-",  $model->bqClaimNo).'.'.  is_object( $temp) && method_exists( $temp, "getExtensionName" ) ? $temp->getExtensionName() : "";

                $model->attachment = $path.$formatName;
                //echo "<pre>";
                //print_r($model->attachment);
                //echo "</pre>";
                //exit();   
                $model->save();
				if( is_object( $temp) && method_exists( $temp, "saveAs" ) )
                $temp->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.$path.$formatName); 

                
                if (isset($_POST['BQNonItem']) && is_array($_POST['BQNonItem'])) {

                    foreach ($_POST['BQNonItem'] as $line => $item) {
                        if (!empty($item['nonItemDesc']) || $item['nonItemDesc'] != "") {
                            $detail = new BQNonItem();
                            $detail->bqClaimNo = $model->bqClaimNo;
                            $detail->nonItemDesc = $item["nonItemDesc"];
                            $detail->nonItemValue = str_replace(",", "", $item["nonItemValue"]);

                            $detail->nonItemTotal = str_replace(",", "", $item["nonItemTotal"]);
                            $detail->itemNo = '';
                            $detail->itemQty = 0;
                            $detail->itemPrice = 0;
                            $detail->itemTotal = 0;

                            $valid = $detail->validate();

                            if ($valid) {
                                if (!$detail->save()) {
                                    $transaction->rollBack();
                                }
                            } else {
                                $transaction->rollBack();
                            }
                        }
                    }
                }
                
                if($idgrp == 'PST'){
                    $idgrp = 'A1';
                }

                $sql = " exec spBQAllocated '" . $model->PIC . "', '" . $model->bqClaimNo . "','','" . $idgrp . "','" . $model->idCust . "', " . $model->bqUsed . ", 0";
                $command = Yii::app()->db->createCommand($sql);
                $command->execute();


                $sql = " exec spTQAllocated_mzf '" . $model->PIC . "', '" . $model->bqClaimNo . "','','" . $idgrp . "','" . $model->idCust . "', " . $model->tqUsed . ", 0";
                $command = Yii::app()->db->createCommand($sql);
                $command->execute();
                
                $transaction->commit();
                $this->kirimEmail2($model->bqClaimNo,0);
                
                $this->redirect(array('claim',));
            } catch (Exception $e) {
                throw new CHttpException(403, $e);
                $transaction->rollBack();
                //$this->redirect(array('formPP/index'));                            
            }
        }

        $this->render('claimCreate', array(
            'model' => $model,
        ));
    }
    
    public function actionClaimCreateItem() {

        $model = new BQClaim;
        $model->nonItems[] = new BQNonItem();

        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDate();

        $model->fmtDate = $longDate;
        $model->claimDate = $now;
        $model->PIC = $employee->idCard;
        $model->userName = $employee->userName;
        $model->deptID = $employee->idDept;
        $model->deptName = $employee->nameDept . ' - ' . $employee->nameBranch;
        $model->branchName = $employee->nameBranch;
        $model->branchID = $employee->idBranch;
        $model->voucher = Yii::app()->user->getState('branch');

//        $this->performAjaxValidation($model);

        if (isset($_POST['BQClaim'])) {
            $transaction = Yii::app()->db->beginTransaction();
            //$idgrp = Yii::app()->user->getState('branch');
            $idgrp = $_POST['BQClaim']['branchID'];
            $model->attributes = $_POST['BQClaim'];
            $model->bqClaimNo = Utility::getBQClaimNo();
            $model->totalItems = 0;
            $model->totalNonItems = str_replace(",", "", $_POST['BQClaim']['claimTotal']);
            $model->bqUsed = str_replace(",", "", $_POST['BQClaim']['bqUsed']);
            $model->tqUsed = str_replace(",", "", $_POST['BQClaim']['tqUsed']);
            $model->claimTotal = str_replace(",", "", $_POST['BQClaim']['totalAll']);
            $model->status = 0;
            $model->claimType = 0;
            $model->branchBudget = $idgrp;

            try {
                $isValid = $model->validate();
                $model->save();

                if (isset($_POST['BQNonItem']) && is_array($_POST['BQNonItem'])) {

                    foreach ($_POST['BQNonItem'] as $line => $item) {
                        if (!empty($item['nonItemDesc']) || $item['nonItemDesc'] != "") {
                            $detail = new BQNonItem();
                            $detail->bqClaimNo = $model->bqClaimNo;
                            $detail->nonItemDesc = $item["nonItemDesc"];
                            $detail->nonItemValue = str_replace(",", "", $item["nonItemValue"]);

                            $detail->nonItemTotal = str_replace(",", "", $item["nonItemTotal"]);
                            $detail->itemNo = '';
                            $detail->itemQty = 0;
                            $detail->itemPrice = 0;
                            $detail->itemTotal = 0;

                            $valid = $detail->validate();

                            if ($valid) {
                                if (!$detail->save()) {
                                    $transaction->rollBack();
                                }
                            } else {
                                $transaction->rollBack();
                            }
                        }
                    }
                }
                
                if($idgrp == 'PST'){
                    $idgrp = 'A1';
                }

                $sql = " exec spBQAllocated '" . $model->PIC . "', '" . $model->bqClaimNo . "','','" . $idgrp . "','" . $model->idCust . "', " . $model->bqUsed . ", 0";
                $command = Yii::app()->db->createCommand($sql);
                $command->execute();


                $sql = " exec spTQAllocated_mzf '" . $model->PIC . "', '" . $model->bqClaimNo . "','','" . $idgrp . "','" . $model->idCust . "', " . $model->tqUsed . ", 0";
                $command = Yii::app()->db->createCommand($sql);
                $command->execute();
                
                $this->kirimEmail2($model->bqClaimNo,0);
                $transaction->commit();
                $this->redirect(array('claim',));
            } catch (Exception $e) {
                throw new CHttpException(403, $e);
                $transaction->rollBack();
                //$this->redirect(array('formPP/index'));                            
            }
        }

        $this->render('claimCreateItem', array(
            'model' => $model,
        ));
    }

    public function actionVerifyclaim($id) {

        $this->layout = '//layouts/iframex';
        $model = BQClaim::model()->getHeader($id);
        $detail = BQClaimDetail::model()->getDetail($model->bqClaimNo);
        $header = BQClaim::model()->findByAttributes(array("bqClaimID"=>$id));
        
        $header->tqAvail = $model->tqUsed;
        $header->bqAvail = $model->bqUsed;
        $header->totalItems = $model->claimTotal;
        
        $this->render('verifyDetail', array(
            'model'=>$model,
            'detail' => $detail,
            'header'=>$header
        ));
    }

    
    public function kirimEmail($fiscal, $idcust, $revNo, $mode) {
        $ret = false;

        $model = BQOpen::model()->findByAttributes(array('fiscalPeriod' => $fiscal, 'idCust' => $idcust, "revNo" => $revNo));

        $users = Employee::model()->findByAttributes(array('idCard' => $model->openUser));

        $dept = BQOpen::model()->findBySql("select nameDept + ' - ' + nameDiv + ' / ' + nameBranch deptName
                                                from vwEmployee where idCard = '" . $model->openUser . "'");

        $cust = BQOpen::model()->findBySql("select ltrim(rtrim(NAMECUST)) nameCust from sgtdat..arcus where idCust = '" . $model->idCust . "'");

        //$to = array("fajar.pratama@modena.co.id");
        $cc = '';
        $bcc = array('fajar.pratama@modena.co.id','emmanuela.kristina@modena.co.id');

        $modeyes = $this->createAbsoluteUrl("bq/openAppr", array("id" => $model->openID));
        $modeno = $this->createAbsoluteUrl("bq/opappr", array("id" => $model->openID, "mode" => 0));

        if($model->status == 1){
            $status = 'disetujui';
        }else{
            $status = 'ditolak';
        }
        $greeting = '';
        
        if($mode == 1){ // persetujuan
            $to[0] = $users->email; //'fajar.pratama@modena.co.id';
            //$to[1] = 'emmanuela.kristina@modena.co.id';
            $greeting = $users->userName;
            $approval = '<table cellpadding="0" cellspacing="0" border="0" style="font-family:verdana, arial, tahoma; font-size:12px; line-height:25px" width="100%">
                            <tr><td width="49%">telah <strong>'.$status.'</strong></td></tr>			
                        </table> ';
        }else{
            $to[0] = 'miftahur.rohman@modena.co.id';
            //$to[1] = 'emmanuela.kristina@modena.co.id';
            $greeting = "Bapak Miftahur Rohman";
            $approval = '<table cellpadding="0" cellspacing="0" border="0" style="font-family:verdana, arial, tahoma; font-size:12px; line-height:25px" width="100%">
                            <tr><td width="49%" align="right"><strong><a href="'.$modeyes.'">[SETUJUI]</a></strong></td><td>&nbsp;</td><td width="49%"align="left"><strong><a href="'.$modeno.'">[TIDAK SETUJUI]</a></strong></td></tr>			
                        </table>';
            $approval = '<table cellpadding="0" cellspacing="0" border="0" style="font-family:verdana, arial, tahoma; font-size:12px; line-height:25px" width="100%">
                            <tr><td width="49%" align="right"><strong><a href="'.$modeyes.'">[Tindaklanjuti]</a></strong></td><td>&nbsp;</td><td>&nbsp;</td></tr>			
                        </table>';
        }
        
        if ($revNo == 0) {
            $subject = "[BQ-TQ :: Pengajuan Open TQ] :: " . $cust['nameCust'];
        } else if ($revNo != 0) {
            $subject = "[BQ-TQ :: Pengajuan Open TQ] :: " . $cust['nameCust'] . " Rev: " . $revNo;
        }

        $content = '';
        $lastQ = Utility::getLastQ($model->idCust);
        
        $message = $this->mailTemplate(15);
        $message = str_replace("##APPROVAL##", $approval, $message);
        $message = str_replace("##PERIODE##", $model->fiscalPeriod, $message);
        $message = str_replace("##TO##", $greeting, $message);
        $message = str_replace("##PEMOHON##", $users->userName, $message);
        $message = str_replace("##CABANG##", $dept['deptName'], $message);
        $message = str_replace("##DEALER##", $cust['nameCust'], $message);
        $message = str_replace("##REVISI##", $model->revNo, $message);
        $message = str_replace("##MAX##",  number_format(Utility::getMaxValue($model->salesTarget)), $message);
        $message = str_replace("##TARGET##", "Rp.  " . number_format($model->salesTarget, 0), $message);
        $message = str_replace("##TARGET##", "Rp.  " . number_format($model->salesTarget, 0), $message);
        $message = str_replace("##LASTQ##", "Rp.  " . number_format($model->lastQ, 0), $message);
        $message = str_replace("##OPENTQ##", "Rp.  " . number_format($model->openTarget, 0), $message);
        $message = str_replace("##BONUS##", "Rp.  " . number_format($model->openBonus, 0), $message);
        $message = str_replace("##TOTAL##", "Rp.  " . number_format($model->openTarget + $model->openBonus, 0), $message);
;
        $attachment = array();
        $this->mailsend($to, $cc, $bcc, $subject, $message, $attachment);
        return $ret;
    }
    
    public function kirimEmail3($uploadNo, $mode) { // upload saldo
        $ret = false;

        $model = BQUpload::model()->findByAttributes(array('bqUploadNo'=>$uploadNo));
        
        $users = Employee::model()->findByAttributes(array('idCard' => $model->PIC));

        $dept = BQOpen::model()->findBySql("select nameDept + ' - ' + nameDiv + ' / ' + nameBranch deptName
                                                from vwEmployee where idCard = '" . $model->PIC . "'");

        $cust = BQOpen::model()->findBySql("select ltrim(rtrim(NAMECUST)) nameCust from sgtdat..arcus where idCust = '" . $model->idCust . "'");
        $branch = BQOpen::model()->findBySql("select ltrim(rtrim(TEXTDESC)) nameCust from sgtdat..argro where idgrp = '" . $model->uploadBranch . "'");
        
        $modeyes = $this->createAbsoluteUrl("bq/uploadappr", array("id" => $model->bqUploadID, "mode" => 1));
        $modeno = $this->createAbsoluteUrl("bq/uploadappr", array("id" => $model->bqUploadID, "mode" => 0));
        
        if($model->status == 1){
            $status = 'disetujui';
        }else{
            $status = 'ditolak';
        }
        
        if($mode == 1){ // persetujuan
            $to[0] = $users->email; //'fajar.pratama@modena.co.id';
            
            $greeting = $users->userName;
            $approval = '<table cellpadding="0" cellspacing="0" border="0" style="font-family:verdana, arial, tahoma; font-size:12px; line-height:25px" width="100%">
                            <tr><td width="49%">telah <strong>'.$status.'</strong></td></tr>			
                        </table>  ';
        }else{
           $to[0] = 'miftahur.rohman@modena.co.id';
            $greeting = "Bapak Miftahur Rohman";
            $approval = '<table cellpadding="0" cellspacing="0" border="0" style="font-family:verdana, arial, tahoma; font-size:12px; line-height:25px" width="100%">
                       <tr><td width="49%" align="right"><strong><a href="'.$modeyes.'">[SETUJUI]</a></strong></td><td>&nbsp;</td><td width="49%"align="left"><strong><a href="'.$modeno.'">[TIDAK SETUJUI]</a></strong></td></tr>			
                   </table>';
        }
        
        $cc = '';
        $bcc = array('fajar.pratama@modena.co.id','emmanuela.kristina@modena.co.id');
        $subject = "[BQ-TQ :: Pengajuan Penambahan Saldo] :: " . $model->bqUploadNo;       

        $content = '';
        
        $message = $this->mailTemplate(17);
        $message = str_replace("##APPROVAL##", $approval, $message);
        $message = str_replace("##PERIODE##", date("d-m-Y", strtotime($model->uploadDate)), $message);
        $message = str_replace("##TO##", "Bapak Miftahur Rohman", $message);
        $message = str_replace("##PEMOHON##", $users->userName, $message);
        $message = str_replace("##CABANG##", $dept['deptName'], $message);        
        $message = str_replace("##KETERANGAN##", $model->uploadDesc, $message);
        
        $message = str_replace("##DEALER##", $cust['nameCust'], $message);
        $message = str_replace("##BRANCH##", $branch['nameCust'], $message);
        
        $message = str_replace("##TQ##", "Rp.  " . number_format($model->tqValue, 0), $message);
        $message = str_replace("##BQ##", "Rp.  " . number_format($model->bqValue, 0), $message);
        $message = str_replace("##TOTAL##", "Rp.  " . number_format($model->uploadTotal, 0), $message);

        $attachment = array();
        $this->mailsend($to, $cc, $bcc, $subject, $message, $attachment);
        return $ret;
    }

    public function kirimEmail2($claimNo, $mode) {
        $ret = false;

        $model = BQClaim::model()->findByAttributes(array('bqClaimNo' => $claimNo));

        $detail = BQClaimDetail::model()->findAllByAttributes(array('bqClaimNo' => $model->bqClaimNo));

        $users = Employee::model()->findByAttributes(array('idCard' => $model->PIC));

        $dept = BQClaim::model()->findBySql("select nameDept + ' - ' + nameDiv + ' / ' + nameBranch deptName
                                                from vwEmployee where idCard = '" . $model->PIC . "'");

        $cust = BQClaim::model()->findBySql("select ltrim(rtrim(NAMECUST)) nameCust from sgtdat..arcus where idCust = '" . $model->idCust . "'");

        //$to = array("fajar.pratama@modena.co.id");
        $cc = '';
        $bcc = array('fajar.pratama@modena.co.id','emmanuela.kristina@modena.co.id');

        $modeyes = $this->createAbsoluteUrl("bq/claimAppr", array("id" => $model->bqClaimID));
        $modeno = $this->createAbsoluteUrl("bq/clappr", array("id" => $model->bqClaimID, "mode" => 0));
        
        //$model->attachment = str_replace("/", ".",  $model->attachment);
        $path = '';
        $attachment = array();
        
        if(isset($model->attachment)){
            $path = Yii::app()->basePath.'/../'.$model->attachment ;  
            $attachment = array($path);
        }
        
        
        if($model->status == 1){
            $status = 'disetujui';
        }else{
            $status = 'ditolak';
        }
        
        if($mode == 1){ // persetujuan
            $to[0] = $users->email; //'fajar.pratama@modena.co.id';
            //$to[1] = 'emmanuela.kristina@modena.co.id';
            $greeting = $users->userName;
            $approval = '<table cellpadding="0" cellspacing="0" border="0" style="font-family:verdana, arial, tahoma; font-size:12px; line-height:25px" width="100%">
                            <tr><td width="49%">telah <strong>'.$status.'</strong></td></tr>			
                        </table> ';
        }else{
            $to[0] = 'miftahur.rohman@modena.co.id';       
            $greeting = "Bapak Miftahur Rohman";
            $approval = '<table cellpadding="0" cellspacing="0" border="0" style="font-family:verdana, arial, tahoma; font-size:12px; line-height:25px" width="100%">
                            <tr><td width="49%" align="center"><strong><a href="'.$modeyes.'">[Tindaklanjuti]</a></strong></td></tr>			
                        </table>';
        }
        
        $subject = "[BQ-TQ :: Pengajuan Claim] :: No. " . $model->bqClaimNo;
        $saldo = Utility::getBalance($model->idCust, $model->branchBudget);
        $saldoBQ = $saldo[2];
        $saldoTQ = $saldo[3];
        
        $content = '';

        $message = $this->mailTemplate(16);
        $message = str_replace("##APPROVAL##", $approval, $message);
        $message = str_replace("##NOMOR##", $model->bqClaimNo, $message);
        $message = str_replace("##TANGGAL##", date("d-m-Y", strtotime($model->claimDate)), $message);

        $message = str_replace("##TO##", $greeting, $message);
        $message = str_replace("##PEMOHON##", $users->userName, $message);
        $message = str_replace("##CABANG##", $dept['deptName'], $message);
        $message = str_replace("##DEALER##", $cust['nameCust'], $message);
        $message = str_replace("##SUBTOTAL##", "Rp.  " . number_format($model->totalNonItems, 0), $message);
        $message = str_replace("##BQ##", "Rp.  " . number_format($model->bqUsed, 0), $message);
        $message = str_replace("##TQ##", "Rp.  " . number_format($model->tqUsed, 0), $message);
        $message = str_replace("##saldoBQ##", "Rp.  " . number_format($saldoBQ, 0), $message);
        $message = str_replace("##saldoTQ##", "Rp.  " . number_format($saldoTQ, 0), $message);
        $message = str_replace("##TOTAL##", "Rp.  " . number_format($model->claimTotal, 0), $message);

        $rowNum = 0;
        $sDetail = "";

        foreach ($detail as $row => $detail) {
            $rowNum = (int) $rowNum + 1;
            $sDetail .= "<tr><td align=center>" . $rowNum . "</td>";
            $sDetail .= '<td align=left>' . $detail['nonItemDesc'] . '</td><td align=right> Rp. ' . number_format($detail['nonItemValue'], 0) . '</td></tr>';
        }
        $message = str_replace("#sInput_#", $sDetail, $message);

        $this->mailsend($to, $cc, $bcc, $subject, $message, $attachment);
        return $ret;
    }

    public function actionSendMail($id) {
        //$id = 'BQTQ/CL/2017.000028';
        $this->kirimEmail2($id,0);
        
        echo "Mail Sent";
    }

    public function actionClappr() {
        $id = Yii::app()->getRequest()->getQuery('id');
        $mode = Yii::app()->getRequest()->getQuery('mode');
        $desc = Yii::app()->getRequest()->getQuery('desc');

        if (isset($id)) {
            $openTQ = BQClaim::model()->findByAttributes(array('bqClaimID' => $id));
            $cust = BQClaim::model()->findBySql("select ltrim(rtrim(NAMECUST)) nameCust from sgtdat..arcus where idCust = '" . $openTQ->idCust . "'");

            if ($openTQ->status == 0) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if($mode == 1){
                        $openTQ->status = $mode ;                      
                    }else{
                        $openTQ->status = 3; // 1 disetujui, 3 ditolak 
                        $command = Yii::app()->db->createCommand("update tr_bqBalance set isCancel = 1 where linkReff = '" . $openTQ->bqClaimNo . "'");
                        $command->execute();
                    }
                    
                    
                    $openTQ->save();
                    $transaction->commit();
                    
                    $openTQ = BQClaim::model()->findByAttributes(array('bqClaimID' => $id));
                    $this->kirimEmail2($openTQ->bqClaimNo,1);
                    $this->render('approval2', array(
                        'model' => $openTQ, 'dealer' => $cust["nameCust"],
                    ));

                    
                } catch (Exception $ex) {
                    $transaction->rollBack();
                    throw new CHttpException(403, $ex);
                    Yii::app()->user->setFlash('Error', $ex);
                    $this->redirect(array('bq/openIndex'));
                }
            } else {
                
                $this->render('approval2', array(
                    'model' => $openTQ, 'dealer' => $cust["nameCust"],
                ));
            }
        }
    }
    
    public function actionOpappr() {
        $id = Yii::app()->getRequest()->getQuery('id');
        $mode = Yii::app()->getRequest()->getQuery('mode');
        $desc = Yii::app()->getRequest()->getQuery('desc');

        if (isset($id)) {
            $openTQ = BQOpen::model()->findByAttributes(array('openID' => $id));
            $cust = BQOpen::model()->findBySql("select ltrim(rtrim(NAMECUST)) nameCust from sgtdat..arcus where idCust = '" . $openTQ->idCust . "'");

            if ($openTQ->status == 0) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $openTQ->status = $mode == 1 ? 1 : 3;
                    $openTQ->openDesc = $desc;
                    $openTQ->save();

                    $openTQ = BQOpen::model()->findByAttributes(array('openID' => $id));
                    $this->kirimEmail($openTQ->fiscalPeriod, $openTQ->idCust, $openTQ->revNo,1);
                    $this->render('approval', array(
                        'model' => $openTQ, 'dealer' => $cust["nameCust"],
                    ));

                    $transaction->commit();
                } catch (Exception $ex) {
                    $transaction->rollBack();
                    throw new CHttpException(403, $ex);
                    Yii::app()->user->setFlash('Error', $ex);                    
                    $this->redirect(array('bq/openIndex'));
                }
            } else {
                $this->render('approval', array(
                    'model' => $openTQ, 'dealer' => $cust["nameCust"],
                ));
            }
        }
    }
    
    public function actionOpenAppr($id){
            $model = BQOpen::model()->getBQOpen($id);
            
            $this->render('openAppr', array(
                'model' => $model,
            ));
            
    }
    
    public function actionClaimAppr($id){
            $model = BQClaim::model()->getHeader($id);
            
            $dept = BQClaim::model()->findBySql("select nameDept + ' - ' + nameDiv + ' / ' + nameBranch deptName
                                                from vwEmployee where idCard = '" . $model->PIC . "'");
            
            $model->deptName = $dept->deptName;
            
            $detail = BQClaimDetail::model()->getDetail($model->bqClaimNo);                      
            
//            echo "<pre>";
//            print_r($detail);
//            echo "</pre>";
//            exit();
            
            $this->render('claimAppr', array(
                'model' => $model, 'detail'=>$detail
            ));
            
    }
    
    public function actionUploadappr() {
        $id = Yii::app()->getRequest()->getQuery('id');
        $mode = Yii::app()->getRequest()->getQuery('mode');

        if (isset($id)) {
            $model = BQUpload::model()->findByAttributes(array('bqUploadID' => $id));            

            if ($model->status == 0) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $model->status = $mode == 1 ? 1 : 3;
                    $model->save();

                    if($model->status == 1){
                        if($model->bqValue > 0){
                            $balance = new BQBalance();
                            $balance->balanceReff = date('Y') . '-Q' . (Utility::getQuarterByMonth(date('m'))-1);
                            $balance->balanceDate = date("Y-m-d H:i:s");
                            $balance->balanceType = 'UP';
                            $balance->idBranch = $model->uploadBranch;
                            $balance->idCust = '';
                            $balance->bqValue = $model->bqValue;
                            $balance->tqValue = 0;
                            $balance->bbtValue = 0;
                            $balance->balanceDesc = 'Permintaan Penambahan Saldo';
                            $balance->isExpired = 0;
                            $balance->isCancel = 0;
                            $balance->isItem = 0;
                            $balance->linkReff = $model->bqUploadNo;
                            $balance->linkIndex = '';

                            $balance->save();                        
                        }

                        if($model->tqValue > 0){
                            $balance = new BQBalance();
                            $balance->balanceReff = date('Y') . '-Q' . (Utility::getQuarterByMonth(date('m'))-1);
                            $balance->balanceDate = date("Y-m-d H:i:s");
                            $balance->balanceType = 'UP';
                            $balance->idBranch = Utility::getCustGroupByID($model->idCust);
                            $balance->idCust = $model->idCust;
                            $balance->bqValue = 0;
                            $balance->tqValue = $model->tqValue;
                            $balance->bbtValue = 0;
                            $balance->balanceDesc = 'Permintaan Penambahan Saldo';
                            $balance->isExpired = 0;
                            $balance->isCancel = 0;
                            $balance->isItem = 0;
                            $balance->linkReff = $model->bqUploadNo;
                            $balance->linkIndex = '';

                            $balance->save();                        
                        }  
                    }
                                        
                    $model = BQUpload::model()->findByAttributes(array('bqUploadID' => $id));
                    $this->kirimEmail3($model->bqUploadNo,1);
                    
                    $this->render('approval3', array(
                        'model' => $model,
                    ));

                    $transaction->commit();
                } catch (Exception $ex) {
                    $transaction->rollBack();
                    throw new CHttpException(403, $ex);
                    Yii::app()->user->setFlash('Error', $ex);
                    $this->redirect(array('bq/approval2'));
                }
            } else {
                $this->render('approval3', array(
                    'model' => $model, 
                ));
            }
        }
    }

}
