<?php

class DocumentController extends Controller {

    public $layout = 'leftbar';

    function init() {
        parent::init();
        $this->leftPortlets['ptl.DocumentMenu'] = array();
    }
    
    public function actionTest(){
        $branch = 'BDG';
        $emailAddr = explode(';', Utility::getDocEmailAddress("Finance", $branch));
        for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
            $to[$x] = $emailAddr[$x];
        }
        $to[sizeof($emailAddr)] = "aaaaaaa";
        print_r($to);
        exit();
    }

    public function filters() {
        return array(
            'Rights',
        );
    }

    public function actionIndexgiro() {
        $model = new DocumentReqGiro('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DocumentReqGiro'])) {
            $model->attributes = $_GET['DocumentReqGiro'];
        }

        $this->render('indexgiro', array(
            'model' => $model,
        ));
    }

    public function actionIndex() {
        $model = new DocumentHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DocumentHeader'])) {
            $model->attributes = $_GET['DocumentHeader'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }
    
    public function actionIndextt() {
        $model = new DocumentHeader('searchtt');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DocumentHeader'])) {
            $model->attributes = $_GET['DocumentHeader'];
        }

        $this->render('indextt', array(
            'model' => $model,
        ));
    }

    public function actionRequest() {
        $model = new DocumentRequest('search');
        $check = Utility::checkDocRequest();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DocumentRequest'])) {
            $model->attributes = $_GET['DocumentRequest'];
        }

        $this->render('request', array(
            'model' => $model,
            'check'=>$check,
        ));
    }
    
    public function actionReqcreateTTT() {
        $model = new DocumentRequest('search');
        $check = Utility::checkDocRequest();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DocumentRequest'])) {
            $model->attributes = $_GET['DocumentRequest'];
        }

        $this->render('request', array(
            'model' => $model,
            'check'=>$check,
        ));
    }

    public function actionApproval($id, $appr) {
        $model = DocumentRequest::model()->findByAttributes(array("reqID" => $id));
        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");

        $transaction = Yii::app()->db->beginTransaction();
        try {
            if ($appr == 1) {
                $model->finRcv = $employee->idCard;
                $model->finRcvDate = $now;
                $model->save(false);
                $email = $this->kirimEmail2($model->reqID, 2);
            }else{
                $model->finRcv = $employee->idCard;
                $model->finRcvDate = $now;
                $model->realisasi = 9; // realisasi 9: ditolak
                $model->save(false);      

                // update docHeader, mengembalikan status faktur
                $sql = "
                        update tr_docHeader set [status] = 0 
                            where docNumber in (select docNumber from tr_docRequestDetail where reqID = '".$model->reqNumber."')
                       ";
                $data = Yii::app()->db->createCommand($sql)->execute();

                $email = $this->kirimEmail2($model->reqID, 3);
            }
            $transaction->commit();
            $this->redirect(array('document/reqview', 'id' => $id));
        }
            
        catch (Exception $e) {
            throw new CHttpException(403, $e);
            $transaction->rollBack();
            //$this->redirect(array('formPP/index'));                            
        }

        $this->redirect(array('document/reqview', 'id' => $id));
    }

    public function actionApproval2($id, $appr) {
        $model = DocumentRequest::model()->findByAttributes(array("reqID" => $id));
        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");

        if ($appr == 1) {
            $model->finRet = $employee->idCard;
            $model->finRetDate = $now;
            $model->save(false);
        }

        $this->redirect(array('document/reqview', 'id' => $id));
    }

    public function actionReqcreate() {
        
        $check = Utility::checkDocRequest();
        if ($check != 0) {
            throw new CHttpException(403, 'Maaf, Anda masih memiliki tagihan yang belum diselesaikan');
        }
        $model = new DocumentRequest;
        $model->unpaid = DocumentHeader::model()->getUnpaid();
        $model->items[] = new DocumentReqDetail();    
        $model->tttfp[] = new DocumentTTTDetail();
        
        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDate();

        $model->fmtDate = $longDate;
        $model->salesName = $employee->userName;
        $model->reqSales = $employee->idCard;
        $model->reqDate = $now;
        $model->salesRcvDate = $now;
        $model->salesRcv = $employee->idCard;

        $this->performAjaxValidation($model);

        if (isset($_POST['DocumentRequest'])) {

            $model->attributes = $_POST['DocumentRequest'];
            $model->reqNumber = Utility::getReqNo($model->reqDate);
            $model->invValue = str_replace(",", "", $_POST['DocumentRequest']['invValue']);
            $model->invCount = str_replace(",", "", $_POST['DocumentRequest']['invCount']);
            if($model->invCount == 0){
                exit();
            }
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $isValid = $model->validate();

                $model->save();
                
                if (isset($_POST['DocumentHeader']) && is_array($_POST['DocumentHeader'])) {

                    foreach ($_POST['DocumentHeader'] as $line => $item) {
                        if (!empty($item['unAmount']) || $item['unAmount'] != "") {
                            $detail = new DocumentReqDetail;
                            $docNumber = $item["docNumber"];
                            $detail->reqID = $model->reqNumber;
                            $detail->docNumber = $docNumber;
                            $detail->isModena = 0;
                            $detail->invValue = str_replace(",", "", $item["unAmount"]);
//                            echo "<pre>";
//                            print_r($detail);
//                            echo "</pre>";
//                            exit();  
                            $valid = $detail->validate();
                            if ($valid) {
                                if (!$detail->save()) {
                                    $transaction->rollBack();
                                }
                            } else {
                                $transaction->rollBack();
                            }

                            $trDoc = DocumentHeader::model()->findByAttributes(array("docNumber" => $docNumber));
                            $trDoc->collector = $employee->userName;
                            $trDoc->collectorRcv = 1;
                            $trDoc->collectorRcvDate = $now;
                            $trDoc->status = 1; // 1. Dibuatkan nota penagihan, 2. Lunas, 0. Bisa digunakan
                            $trDoc->save();
                        }
                    }
                }

                if (isset($_POST['DocumentReqDetail']) && is_array($_POST['DocumentReqDetail'])) {

                    foreach ($_POST['DocumentReqDetail'] as $line => $item) {
                        if (!empty($item['invTotal']) || $item['invTotal'] != "") {
                            $detail = new DocumentReqDetail;
                            $docNumber = explode("||", $item['docNumber']);
                            $detail->reqID = $model->reqNumber;
                            $detail->docNumber = $docNumber[0];
                            $detail->isModena = 0;
                            $detail->invValue = str_replace(",", "", $item["invTotal"]);
//                            echo "<pre>";
//                            print_r($detail);
//                            echo "</pre>";
//                            exit();  
                            $valid = $detail->validate();
                            if ($valid) {
                                if (!$detail->save()) {
                                    $transaction->rollBack();
                                }
                            } else {
                                $transaction->rollBack();
                            }

                            $trDoc = DocumentHeader::model()->findByAttributes(array("docNumber" => $docNumber));
                            $trDoc->collector = $employee->userName;
                            $trDoc->collectorRcv = 1;
                            $trDoc->collectorRcvDate = $now;
                            $trDoc->status = 1; // 1. Dibuatkan nota penagihan, 2. Lunas, 3. Bisa digunakan, 4 dibuatkan Tanda Terima
                            $trDoc->save();
                        }
                    }
                }
                
                if (isset($_POST['DocumentTTTDetail']) && is_array($_POST['DocumentTTTDetail'])) {

                    foreach ($_POST['DocumentTTTDetail'] as $line => $item) {
                        if (!empty($item['invTotal']) || $item['invTotal'] != "") {
                            $detail = new DocumentTTTDetail;
                            $docNumber = explode("||", $item['docNumber']);
                            $detail->reqID = $model->reqNumber;
                            $detail->docNumber = $docNumber[0];
                            $detail->isModena = 0;
                            $detail->invValue = str_replace(",", "", $item["invTotal"]);

                              
                            $valid = $detail->validate();
                            if ($valid) {
                                if (!$detail->save()) {
                                    $transaction->rollBack();
                                }
                            } else {
                                $transaction->rollBack();
                            }
                            
                            $trDoc = DocumentHeader::model()->findByAttributes(array("docNumber" => $docNumber));
                            $trDoc->collector = $employee->userName;
                            $trDoc->collectorRcv = 1;
                            $trDoc->collectorRcvDate = $now;
                           // $trDoc->status = 1; // 1. Dibuatkan nota penagihan, 2. Lunas, 3. Bisa digunakan, 4 dibuatkan Tanda Terima
                            $trDoc->save();
                        }
                    }
                }

                $newID = DocumentRequest::model()->findByAttributes(array('reqNumber' => $model->reqNumber))->reqID;
                $email = $this->kirimEmail2($newID, 1);
                $transaction->commit();
                $this->redirect(array('request',));
            } catch (Exception $e) {
                throw new CHttpException(403, $e);
                $transaction->rollBack();
                //$this->redirect(array('formPP/index'));                            
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }
    
//    public function actionReqcreateTTT() {
//        
////        $check = Utility::checkDocRequest();
////        if ($check != 0) {
////            throw new CHttpException(403, 'Maaf, Anda masih memiliki tagihan yang belum diselesaikan');
////        }
//        $model = new DocumentRequest;
//        $model->unpaid = DocumentHeader::model()->getUnpaid();
//        $model->items[] = new DocumentReqDetail();        
//        $employee = Employee::model()->getActiveEmployee();
//        $now = date("Y-m-d H:i:s");
//        $longDate = Utility::getLongDate();
//
//        $model->fmtDate = $longDate;
//        $model->salesName = $employee->userName;
//        $model->reqSales = $employee->idCard;
//        $model->reqDate = $now;
//        $model->salesRcvDate = $now;
//        $model->salesRcv = $employee->idCard;
//
//        $this->performAjaxValidation($model);
//
//        if (isset($_POST['DocumentRequest'])) {
//            $model->attributes = $_POST['DocumentRequest'];
//            $model->reqNumber = Utility::getReqNo($model->reqDate);
//            $model->invValue = str_replace(",", "", $_POST['DocumentRequest']['invValue']);
//            $model->invCount = str_replace(",", "", $_POST['DocumentRequest']['invCount']);
//            if($model->invCount == 0){
//                exit();
//            }
//            
//            $transaction = Yii::app()->db->beginTransaction();
//            try {
//                $isValid = $model->validate();
//
//                $model->save();
//
//                if (isset($_POST['DocumentHeader']) && is_array($_POST['DocumentHeader'])) {
//
//                    foreach ($_POST['DocumentHeader'] as $line => $item) {
//                        if (!empty($item['unAmount']) || $item['unAmount'] != "") {
//                            $detail = new DocumentReqDetail;
//                            $docNumber = $item["docNumber"];
//                            $detail->reqID = $model->reqNumber;
//                            $detail->docNumber = $docNumber;
//                            $detail->isModena = 0;
//                            $detail->invValue = str_replace(",", "", $item["unAmount"]);
////                            echo "<pre>";
////                            print_r($detail);
////                            echo "</pre>";
////                            exit();  
//                            $valid = $detail->validate();
//                            if ($valid) {
//                                if (!$detail->save()) {
//                                    $transaction->rollBack();
//                                }
//                            } else {
//                                $transaction->rollBack();
//                            }
//
//                            $trDoc = DocumentHeader::model()->findByAttributes(array("docNumber" => $docNumber));
//                            $trDoc->collector = $employee->userName;
//                            $trDoc->collectorRcv = 1;
//                            $trDoc->collectorRcvDate = $now;
//                            $trDoc->status = 1; // 1. Dibuatkan nota penagihan, 2. Lunas, 0. Bisa digunakan
//                            $trDoc->save();
//                        }
//                    }
//                }
//
//                if (isset($_POST['DocumentReqDetail']) && is_array($_POST['DocumentReqDetail'])) {
//
//                    foreach ($_POST['DocumentReqDetail'] as $line => $item) {
//                        if (!empty($item['invTotal']) || $item['invTotal'] != "") {
//                            $detail = new DocumentReqDetail;
//                            $docNumber = explode("||", $item['docNumber']);
//                            $detail->reqID = $model->reqNumber;
//                            $detail->docNumber = $docNumber[0];
//                            $detail->isModena = 0;
//                            $detail->invValue = str_replace(",", "", $item["invTotal"]);
////                            echo "<pre>";
////                            print_r($detail);
////                            echo "</pre>";
////                            exit();  
//                            $valid = $detail->validate();
//                            if ($valid) {
//                                if (!$detail->save()) {
//                                    $transaction->rollBack();
//                                }
//                            } else {
//                                $transaction->rollBack();
//                            }
//
//                            $trDoc = DocumentHeader::model()->findByAttributes(array("docNumber" => $docNumber));
//                            $trDoc->collector = $employee->userName;
//                            $trDoc->collectorRcv = 1;
//                            $trDoc->collectorRcvDate = $now;
//                            //$trDoc->status = 1; // 1. Dibuatkan nota penagihan, 2. Lunas, 3. Bisa digunakan, 4 dibuatkan Tanda Terima
//                            $trDoc->save();
//                        }
//                    }
//                }
//
//                $newID = DocumentRequest::model()->findByAttributes(array('reqNumber' => $model->reqNumber))->reqID;
//                $email = $this->kirimEmail2($newID, 1);
//
//                $transaction->commit();
//                $this->redirect(array('request',));
//            } catch (Exception $e) {
//                throw new CHttpException(403, $e);
//                $transaction->rollBack();
//                //$this->redirect(array('formPP/index'));                            
//            }
//        }
//
//        $this->render('createTTT', array(
//            'model' => $model,
//        ));
//    }

    public function actionRetcreate($id) {


        $model = DocumentRequest::model()->findByAttributes(array("reqID" => $id));
        $model->items = DocumentReqDetail::model()->getDetailD($model->reqNumber);
        $model->attachment[]  = new DocumentReqFile();
//        echo '<pre>';
//        print_r($model->items);
//        echo '</pre>';
//        exit();

        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDate();
        $fmt2 = Utility::getLongDateParams($model->reqDate);

        $model->fmtDate = $longDate;
        $model->fmt2Date = $fmt2;
        $model->salesName = $employee->userName;
        $model->returnDate = $now;
        $model->fmtAmount = number_format($model->invValue);

        $this->performAjaxValidation($model);
        if ($model->realisasi == 1) {
            throw new CHttpException(403, 'Penagihan nomor: ' . $model->reqNumber . ' sudah dibuatkan realisasi');
        }

        if (isset($_POST['DocumentRequest'])) {
            $model->attributes = $_POST['DocumentRequest'];
            $model->retValue = str_replace(",", "", $_POST['DocumentRequest']['retValue']);
            $model->retCount = str_replace(",", "", $_POST['DocumentRequest']['retCount']);
            $model->realisasi = 1;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->save();

                if (isset($_POST['DocumentReqDetail']) && is_array($_POST['DocumentReqDetail'])) {

                    foreach ($_POST['DocumentReqDetail'] as $line => $item) {
                        // if (!empty($item['retValue'])|| $item['retValue'] != ""){                            
                        $detail = DocumentReqDetail::model()->findByAttributes(array("detID" => $item["detID"]));
//                            $value = 0;
//                            $value = str_replace(",", "", $item["retValue"]);

                        $detail->retValue = empty($item['retValue']) || $item['retValue'] == "" ? 0 : str_replace(",", "", $item["retValue"]);
                        
                        if ($detail->retValue == 0) {
                            if($item["retType"] == "TT"){
                                $detail->retType = "TT";
                                $detail->retDate = empty($item['retDate']) ? $now : $item["retDate"];                           
                                $detail->isModena = empty($item['isModena']) ? 0 : $item["isModena"];
                                $detail->retNumber = empty($item['retNumber']) ? "" : $item["retNumber"];
                                $detail->retDesc = empty($item['retDesc']) ? "" : $item["retDesc"];
                            }
                            else {
                                $detail->retType = "FL";
                                $detail->retDate = $now;
                                $detail->isModena = 0;
                                $detail->retNumber = empty($item['retNumber']) ? "" : $item["retNumber"];
                                $detail->retDesc = empty($item['retDesc']) ? "" : $item["retDesc"];
                            }                            
                        } else {
                            $detail->retType = empty($item['retType']) ? "TR" : $item["retType"];
                            $detail->retDate = empty($item['retDate']) ? $now : $item["retDate"];                           
                            $detail->isModena = empty($item['isModena']) ? 0 : $item["isModena"];
                            $detail->retNumber = empty($item['retNumber']) ? "" : $item["retNumber"];
                            $detail->retDesc = empty($item['retDesc']) ? "" : $item["retDesc"];
                        }

                        $valid = $detail->validate();

                        if ($valid) {
                            if (!$detail->save()) {
                                $transaction->rollBack();
                            }
                        } else {
                            $transaction->rollBack();
                        }

                        
                        
                        $trDoc = DocumentHeader::model()->findByAttributes(array("docNumber" => $detail->docNumber));
//                            $isComplete = Utility::checkInv($detail->docNumber);
//                            $status = 0;
//                            if($isComplete == 1){
//                                $status = 2;                              
//                            }else{
//                                $status = 0;
//                            }
//                            $trDoc->status = $status; // 1. Dibuatkan nota penagihan, 2. Lunas, 0. Bisa digunakan
                        if ($detail->retType != "FL") {
                            $trDoc->customerRcv = 1;
                            $trDoc->customerRcvDate = $now;
                        } else {
                            $trDoc->customerRcv = new CDbExpression('NULL');
                            $trDoc->customerRcvDate = new CDbExpression('NULL');
                        }

                        $trDoc->save();
                        //}  
                    }
                    
                    // attachment
                    $file_attach = array();
                    if (isset($_POST['DocumentReqFile']) && is_array($_POST['DocumentReqFile']))
                    {           
                        if(isset($_FILES['DocumentReqFile']))
                        {
                            $explode_script_filename = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
                            $tmp_name = $_FILES['DocumentReqFile']['tmp_name'];
                            $name = $_FILES['DocumentReqFile']['name'];

                            for($i = 0; $i < sizeof($tmp_name); $i++){
                                if (!empty($name[$i]['filePath']) || $name[$i]['filePath'] != "") {
                                    $name_explode = explode(".",$name[$i]['filePath']);
                                    $new_name = time().'-'. substr($model->reqNumber, 12, 6)."-".$i.".".$name_explode[(sizeof($name_explode) - 1)];                               
                                    $row = new DocumentReqFile;
                                    $row->reqID=$model->reqNumber;
                                    $row->fileName = $new_name;
                                    $row->filePath="/upload/docflow/".$new_name;
                                    $row->save();
                                    $file_attach[] = $explode_script_filename[0]."upload/docflow/".$new_name;
                                    move_uploaded_file($tmp_name[$i]['filePath'], $explode_script_filename[0]."upload/docflow/".$new_name);
                                }                                
                            }
                        }

                    }
                }

                $newID = DocumentRequest::model()->findByAttributes(array('reqNumber' => $model->reqNumber))->reqID;
                $email = $this->kirimEmail3($newID, 1);

                $transaction->commit();
                $this->redirect(array('request',));
            } catch (Exception $e) {
                throw new CHttpException(403, $e);
                $transaction->rollBack();
                //$this->redirect(array('formPP/index'));                            
            }
        }

        $this->render('realisasi', array(
            'model' => $model,
        ));
    }

    public function actionVerifikasi($id) {

        $model = DocumentRequest::model()->findByAttributes(array("reqID" => $id));
        $model->items = DocumentReqDetail::model()->getDetailR($model->reqNumber);

//        echo '<pre>';
//        print_r($model->items);
//        echo '</pre>';
//        exit();

        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDateParams($model->returnDate);
        $fmt2 = Utility::getLongDateParams($model->reqDate);
        $salesName = Employee::model()->findByAttributes(array("idCard"=>$model->reqSales))->userName;
       
        $model->fmtDate = $longDate;
        $model->fmt2Date = $fmt2;
        $model->salesName = $salesName;
        $model->fmtAmount = number_format($model->invValue);
        $model->fmt2Amount = number_format($model->retValue);
//        
        $this->performAjaxValidation($model);
//        if($model->realisasi == 1){
//            throw new CHttpException(403, 'Penagihan nomor: '.$model->reqNumber.' sudah dibuatkan realisasi');
//        }

        if (isset($_POST['DocumentRequest'])) {
            $model->attributes = $_POST['DocumentRequest'];
            $model->revValue = str_replace(",", "", $_POST['DocumentRequest']['revValue']);
            $model->revCount = str_replace(",", "", $_POST['DocumentRequest']['revCount']);
            $model->verifikasi = 1;
            $model->finRet = $employee->idCard;
            $model->finRetDate = $now;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->save();

                if (isset($_POST['DocumentReqDetail']) && is_array($_POST['DocumentReqDetail'])) {

                    foreach ($_POST['DocumentReqDetail'] as $line => $item) {
                        // if (!empty($item['retValue'])|| $item['retValue'] != ""){                            
                        $detail = DocumentReqDetail::model()->findByAttributes(array("detID" => $item["detID"]));
//                            $value = 0;
//                            $value = str_replace(",", "", $item["retValue"]);

                        $detail->revValue = empty($item['revValue']) || $item['revValue'] == "" ? 0 : str_replace(",", "", $item["revValue"]);
                        $detail->revNumber = $item["finance"];
                        $detail->retNumber = $item["retNumber"];
                        $valid = $detail->validate();

                        if ($valid) {
                            if (!$detail->save()) {
                                $transaction->rollBack();
                            }
                        } else {
                            $transaction->rollBack();
                        }

                        $trDoc = DocumentHeader::model()->findByAttributes(array("docNumber" => $detail->docNumber));
                        if($detail->retType == "TT"){
                            $status = "5";
                        }else{
                            $status = Utility::checkInv($detail->docNumber);
                        }
                        
                        if($trDoc->status == 5){
                            if($detail->retType == "TR" || $detail->retType == "CK" || $detail->retType == "GR"){                                
                                $trDoc->status = $status;                                                                
                            }
                        }else
                        {
                            $trDoc->status = $status; 
                        }
                            
                        // 1. Dibuatkan nota penagihan, 2. Lunas, 0. Bisa digunakan, 3. kekurangan bayar, 4. Transfer checking, 5. TTTFP  
                        $trDoc->salesPIC = $model->reqSales;
                        $trDoc->save();

                        //}  
                    }
                }

//                $newID = DocumentRequest::model()->findByAttributes(array('reqNumber'=>$model->reqNumber))->reqID; 
//                $email = $this->kirimEmail3($newID);
                $email = $this->kirimEmail3($model->reqID, 2);
                $transaction->commit();
                $this->redirect(array('request',));
            } catch (Exception $e) {
                throw new CHttpException(403, $e);
                $transaction->rollBack();
                //$this->redirect(array('formPP/index'));                            
            }
        }

        $this->render('verifikasi', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        $model = new DocumentHeader;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DocumentHeader'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (isset($_POST['DocumentHeader']) && is_array($_POST['DocumentHeader'])) {

                    foreach ($_POST['DocumentHeader'] as $line => $item) {

                        if ($item['check'] == 1) {

                            $header = new DocumentHeader;
                            $header->docNumber = trim($item['docNumber']);
                            $header->isComplete = 0;
                            $header->status = 0;


                            if (!$header->save()) {
                                $transaction->rollBack();
                            }

                            //insert doc SJ
                            $detail = new DocumentDetail;
                            $detail->docNumber = trim($item['docNumber']);
                            $detail->docType = 'SJ';
                            $detail->nextStep = '4';
                            $detail->status = 0;

                            if (!$detail->save()) {
                                $transaction->rollBack();
                            }

                            $log = new DocumentLog;
                            $log->docNumber = trim($item['docNumber']);
                            $log->logStatus = 0;
                            $log->logDesc = 'Generated By SA';
                            $log->docType = 'SJ';

                            if (!$log->save()) {
                                $transaction->rollBack();
                            }


                            //insert doc FK
                            $detail = new DocumentDetail;
                            $detail->docNumber = trim($item['docNumber']);
                            $detail->docType = 'FK';
                            $detail->nextStep = '7';
                            $detail->status = 0;

                            if (!$detail->save()) {
                                $transaction->rollBack();
                            }

                            $log = new DocumentLog;
                            $log->docNumber = trim($item['docNumber']);
                            $log->logStatus = 0;
                            $log->logDesc = 'Generated By SA';
                            $log->docType = 'FK';

                            if (!$log->save()) {
                                $transaction->rollBack();
                            }

                            //insert doc EF
                            $detail = new DocumentDetail;
                            $detail->docNumber = trim($item['docNumber']);
                            $detail->docType = 'EF';
                            $detail->nextStep = '3';
                            $detail->status = 0;

                            if (!$detail->save()) {
                                $transaction->rollBack();
                            }

                            $log = new DocumentLog;
                            $log->docNumber = trim($item['docNumber']);
                            $log->logStatus = 0;
                            $log->logDesc = 'Generated By SA';
                            $log->docType = 'EF';

                            if (!$log->save()) {
                                $transaction->rollBack();
                            }
                        }
                    }
                }
                $transaction->commit();
                $this->redirect(array("index"));
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException("403", $e);
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    public function actionLogbook() {

        $model = new DocumentLog();
        $user = Yii::app()->user->name;


        if (isset($_POST['DocumentLog'])) {
            $data = array();
            $data2 = array(); //pengelompokan Faktur
            $count = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (isset($_POST['DocumentLog']) && is_array($_POST['DocumentLog'])) {

                    foreach ($_POST['DocumentLog'] as $line => $item) {
                        if (isset($item['check']) && $item['check'] == 1) {
                            if ($_POST['DocumentLog']['type'] == "FK") {
                                $detail = DocumentDetail::model()->findByAttributes(array("docNumber" => $item['invNumber'], "docType" => "FK"));
                                if ($detail == NULL) {
                                    $detail = new DocumentDetail();
                                    $detail->docID = Utility::getDocID();
                                    $detail->docNumber = $item["invNumber"];
                                    $detail->docType = 'FK';
                                    $detail->status = 0;
                                    $detail->nextStep = 0;
                                    //$detail->save();

                                    $log = new DocumentLog();
                                    $log->docID = $detail->docID;
                                    $log->docType = 'FK';
                                    $log->docNumber = $detail->docNumber;
                                    $log->logStatus = 0;
                                    $log->logDesc = 'Diproses oleh Sales Admin';
                                    //$log->save();
                                } else if ($detail->status == 0 && $user != $detail->modifUN) {
                                    $detail->status = 1;
                                    //$detail->save();

                                    $log = new DocumentLog();
                                    $log->docType = 'FK';
                                    $log->docID = $detail->docID;
                                    $log->docNumber = $detail->docNumber;
                                    $log->logStatus = 1;
                                    $log->logDesc = 'Diterima oleh Finance';
                                    //$log->save();
                                }
                            }
                            if ($_POST['DocumentLog']['type'] == "EF") {
                                $detail = DocumentDetail::model()->findByAttributes(array("docNumber" => $item['invNumber'], "docType" => "EF"));
                                if ($detail == NULL) {
                                    $detail = new DocumentDetail();
                                    $detail->docID = Utility::getDocID();
                                    $detail->docNumber = $item["invNumber"];
                                    $detail->docType = 'EF';
                                    $detail->status = 0;
                                    $detail->nextStep = 0;
                                    //$detail->save();

                                    $log = new DocumentLog();
                                    $log->docID = $detail->docID;
                                    $log->docType = 'EF';
                                    $log->docNumber = $detail->docNumber;
                                    $log->logStatus = 0;
                                    $log->logDesc = 'Diproses oleh Accounting';
                                    //$log->save();
                                } else if ($detail->status == 0 && $user != $detail->modifUN) {
                                    $detail->status = 1;
                                    //$detail->save();

                                    $log = new DocumentLog();
                                    $log->docType = 'EF';
                                    $log->docID = $detail->docID;
                                    $log->docNumber = $detail->docNumber;
                                    $log->logStatus = 1;
                                    $log->logDesc = 'Diterima oleh Finance';
                                    //$log->save();
                                }
                            }
                            if ($_POST['DocumentLog']['type'] == "SJ") {

                                //$detail = DocumentDetail::model()->findByAttributes(array("docNumber" => $item['invNumber'], "docType" => "SJ"));
                                $detail = DocumentDetail::model()->findByAttributes(array("docID" => $item['docID'], "docType" => "SJ"));

                                if ($detail->status == 0 && $user != $detail->modifUN) {
                                    $detail->status = 1;
                                    //$detail->save();

                                    $log = new DocumentLog();
                                    $log->docType = 'SJ';
                                    $log->docID = $detail->docID;
                                    $log->docNumber = $detail->docNumber;
                                    $log->logStatus = 1;
                                    $log->docTTSJ = $item['rcvNote'];
                                    $log->docAdds = $item['adds'];
                                    $log->logDesc = 'Dikirim oleh Warehouse';
                                    //$log->save();
                                } else if ($detail->status == 1 && $user != $detail->modifUN) {
                                    $detail->status = 2;
                                    //$detail->save();

                                    $log = new DocumentLog();
                                    $log->docType = 'SJ';
                                    $log->docID = $detail->docID;
                                    $log->docNumber = $detail->docNumber;
                                    $log->logStatus = 2;
                                    $log->docTTSJ = $item['rcvNote'];
                                    $log->docAdds = $item['adds'];
                                    $log->logDesc = 'Diterima oleh Sales Admin';
                                    //$log->save();
                                } else if ($detail->status == 2 && $user != $detail->modifUN) {
                                    $detail->status = 3;
                                    //$detail->save();

                                    $log = new DocumentLog();
                                    $log->docType = 'SJ';
                                    $log->docID = $detail->docID;
                                    $log->docNumber = $detail->docNumber;
                                    $log->logStatus = 3;
                                    $log->docTTSJ = $item['rcvNote'];
                                    $log->docAdds = $item['adds'];
                                    $log->logDesc = 'Diterima oleh Finance';
                                    //$log->save();
                                }
                            }
                            $header = "";
                            $header = DocumentHeader::model()->findByAttributes(array("docNumber"=>$item["invNumber"]))->invType;
                            $data2[$count] = $header;
                            
                            $data[$count] = array(
                                "docNumber" => $item["invNumber"],
                                "invDate" => $item["invDate"],
                                "customer" => $item["customer"],
                                "invType" => $header,
                            );
                            $count ++;
                        }
                    }
                }
                
                $invType = array();
                $invType = array_unique($data2);

                foreach ($invType as $value) {
                    unset($dataSend); 
                    $dataSend = array();
                    $i = 0;
                    for ($j = 0; $j <= sizeof($data) - 1; $j++) {
                        if ($data[$j]["invType"] == $value) {
                            $dataSend[$i] = array(
                                "docNumber" => $data[$j]["docNumber"],
                                "invDate" => $data[$j]["invDate"],
                                "customer" => $data[$j]["customer"],
                                "invType" => $data[$j]["invType"],
                            );
                            $i++;
                        }
                    }
                    
                    $this->kirimEmail($_POST['DocumentLog']['type'], $detail->status, $dataSend, $value);
                }
                
                
                $transaction->commit();
                $this->redirect(array("index"));
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException("403", $e);
            }
        }

        $this->render('logbook', array(
            'model' => $model,
        ));
    }

    public function actionGiro() {
        $model = new DocumentReqDetail();
        $user = Yii::app()->user->name;
        if (isset($_POST['DocumentReqDetail'])) {
            $data = array();
            $count = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (isset($_POST['DocumentReqDetail']) && is_array($_POST['DocumentReqDetail'])) {
                    foreach ($_POST['DocumentReqDetail'] as $line => $item) {
                        if (isset($item['check']) && $item['check'] == 1) {
                            $detail = new DocumentReqGiro();
                            $detail->docNumber = $item["docNumber"];
                            $detail->logStatus = $item["revDesc"];
                            $detail->retType = $item["retType"];
                            $detail->save();
                        }
                    }
                }

//                $this->kirimEmail($_POST['DocumentLog']['type'], $detail->status, $data);
                $transaction->commit();
                $this->redirect(array("indexgiro"));
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException("403", $e);
            }
        }

        $this->render('giro', array(
            'model' => $model,
        ));
    }

    public function actionFollowup() {

        $model = new DocumentHeader();
        $user = Yii::app()->user->name;

        if (isset($_POST['DocumentHeader'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (isset($_POST['DocumentHeader']) && is_array($_POST['DocumentHeader'])) {

                    foreach ($_POST['DocumentHeader'] as $line => $item) {
                        if (isset($item['check']) && $item['check'] == 1) {
                            if ($_POST['DocumentHeader']['type'] == "IN") {
                                $head = DocumentHeader::model()->findByAttributes(array("docNumber" => $item['docNumber']));
                                if ($head->collectorRcv == NULL) {
                                    $head->collectorRcv = 1;
                                    $head->collectorRcvDate = date("Y-m-d H:i:s");
//                                    $head->collectorRcvDate = $item['fromDate'];
                                    $head->collector = $user;

                                    $head->save();
                                }
                            } else {
                                $head = DocumentHeader::model()->findByAttributes(array("docNumber" => $item['docNumber']));
                                if ($head->customerRcv == NULL) {
                                    $head->customerRcv = 1;
//                                    $head->customerRcvDate = date("Y-m-d H:i:s");
                                    $head->customerRcvDate = $item['fromDate'];

                                    $head->save();
                                }
                            }
                        }
                    }
                }
                $transaction->commit();
                $this->redirect(array("index"));
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException("403", $e);
            }
        }

        $this->render('followup', array(
            'model' => $model,
        ));
    }

    public function actionComplete($id) {

        $model = DocumentHeader::model()->findByAttributes(array("docNumber" => $id));
        $model->isComplete = 1;
        $model->completeDate = date("Y-m-d H:i:s");
        $model->completeUser = $user = Yii::app()->user->name;
        $model->save();

        $this->redirect(array('document/index'));
    }

    public function actionView($id) {
        $model = DocumentHeader::model()->getHeader($id);
        $faktur = DocumentLog::model()->getFaktur($model->docNumber);
        $efaktur = DocumentLog::model()->getEfaktur($model->docNumber);
        //$sj = DocumentLog::model()->getSJ($model->docNumber);
        $sj = Utility::getSJDetail($model->docNumber);
        $item = Invoice::model()->getInvoiceItem($model->docNumber);

        $this->render('view', array(
            'model' => $model,
            'faktur' => $faktur,
            'efaktur' => $efaktur,
            'sj' => $sj,
            'item' => $item,
        ));
    }

    public function actionReqview($id) {
        $model = DocumentRequest::model()->getRequest($id);
        $detail = DocumentReqDetail::model()->getDetail($model->reqNumber);
        $file = DocumentReqFile::model()->getFile($model->reqNumber);
//        echo "<pre>";
//        print_r($detail);
//        echo "</pre>";
//        exit();
        $this->render('reqview', array(
            'model' => $model,
            'detail' => $detail,
            'file'=>$file
        ));
    }

    public function actionViewlog($id, $doc) {
        $model = DocumentLog::model()->getSJ($id, $doc);
        $this->layout = '//layouts/iframex';
        $this->render('_viewlog', array(
            'model' => $model,
        ));
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'document-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionExportExcel() {
        $header = new DocumentHeader();

        if (isset($_POST['DocumentHeader'])) {
            $fromDate = $_POST['DocumentHeader']['fromDate'];
            $toDate = $_POST['DocumentHeader']['toDate'];
            $type = $_POST['DocumentHeader']['type'];
            
            $idgrp = Yii::app()->user->getState('idgrp');
            $branch = Yii::app()->user->getState('branch');
            
            $sql = " exec spGetDocumentDetail '" . $fromDate . "','" . $toDate . "','" . $type . "', '".$branch."', '".$idgrp."'";
            $command = Yii::app()->db->createCommand($sql);
            $rawData = $command->queryAll();

            $count = Yii::app()->db->createCommand("select  COUNT(*)
		from tr_docHeader h
		inner join tr_docDetail l on h.docNumber = l.docNumber
		left join SGTDAT..OEINVH ih on ih.INVNUMBER = h.docNumber
		left join SGTDAT..ARCUS c on c.IDCUST = ih.CUSTOMER
		where DATEDIFF(d, sgtdat.dbo.fngetAccpacDate(ih.INVDATE), '" . $fromDate . "') <= 0 and DATEDIFF(d, sgtdat.dbo.fngetAccpacDate(ih.INVDATE), '" . $toDate . "') >= 0
			and ( '" . $type . "' = 'ALL' or docType = '" . $type . "') and h.invType in (select param from dbo.fn_MVParam('".$idgrp."',',')) and (c.IDCUST in (select IDCUST from getDealer('".$branch."','".$idgrp."')) OR c.IDNATACCT in (select IDCUST from getDealer('".$branch."','".$idgrp."')) )")->queryScalar();


            $data = new CArrayDataProvider($rawData, array(
                'id' => 'docID',
                'pagination' => array(
                    'pageSize' => intval($count),
                )
            ));

//            echo '<pre>';
//            print_r($data->getData());
//            echo '</pre>';
//            exit();

            $this->widget('ext.EExcelView', array(
                'title' => "Document Detail",
                'dataProvider' => $data,
                'disablePaging' => true,
                'grid_mode' => 'export',
                'columns' => array(
//                    array(
//                        'name' => 'Doc. No.', 
//                        'value' => '$data->docNumber',
//                        'htmlOptions' => array('width' => '60px'),
//                    ),
//                    array(
//                        'name' => 'Customer', 
//                        'value' => '$data->customer',
//                        'htmlOptions' => array('width' => '60px'),
//                    ),
//                    array(
//                        'name' => 'Tanggal', 
//                        'value' => '$data->invdate',
//                        'htmlOptions' => array('width' => '60px'),
//                    ),
//                    array(
//                        'name' => 'Type', 
//                        'value' => '$data->type',
//                        'htmlOptions' => array('width' => '60px'),
//                    ),
//                    array(
//                        'name' => 'Terima Dealer', 
//                        'value' => '$data->dealerUser',
//                        'htmlOptions' => array('width' => '60px'),
//                    ),
                ),
            ));

            exit();
        }

        $this->render('getExcel', array(
            'model' => $header,
        ));
    }

    public function actionExportall() {

        $fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
        $toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';

        $type = isset($_GET['type']) ? $_GET['type'] : 'ALL';
        $customer = isset($_GET['customer']) ? $_GET['customer'] : 'ALL';

        $model = new DocumentHeader("financeExport");
        $model->fromDate = $fromDate;
        $model->toDate = $toDate;
        $model->type = $type;
        $model->customer = $customer;
//        echo("<pre>");
//        print_r($model);
//        echo("</pre>");
//        exit();
        $this->widget('ext.EExcelView', array(
            'title' => "AR Modern Review",
            'dataProvider' => $model->financeExport(),
            'grid_mode' => 'export',
            'columns' => array(
                array(
                    'name' => 'Tanggal',
                    'type' => 'raw',
                    'value' => 'date("d-m-Y", strtotime($data->invDate))',
                ),
                array(
                    "name" => "Invoice",
                    "type" => "raw",
                    "value" => 'trim($data->docNumber)',
                ),
                array(
                    "name" => "PO",
                    "value" => 'trim($data->poNumber)',
                ),
                array(
                    "name" => "ID Store",
                    "type" => "raw",
                    "value" => 'trim($data->customer)',
                ),
                array(
                    "name" => "Store",
                    "type" => "raw",
                    "value" => 'trim($data->nameCust)',
                ),
                array(
                    'name' => 'Nilai',
                    'type' => 'raw',
                    'value' => 'number_format($data->invTotal)',
                ),
                array(
                    'name' => 'SJ',
                    'type' => 'raw',
                    'value' => 'is_null($data->suratJalan) ? " - " : number_format($data->suratJalan)',
                ),
                array(
                    'name' => 'FK',
                    'type' => 'raw',
                    'value' => 'is_null($data->faktur) ? " - " : number_format($data->faktur)',
                ),
                array(
                    'name' => 'EF',
                    'type' => 'raw',
                    'value' => 'is_null($data->eFaktur) ? " - " : number_format($data->eFaktur)',
                ),
                array(
                    'name' => 'Complete',
                    'type' => 'raw',
                    'value' => 'is_null($data->isComplete) ? " - " : number_format($data->isComplete)',
                ),
                array(
                    'name' => 'Collector',
                    'type' => 'raw',
                    'value' => 'is_null($data->collector) ? " - " : number_format($data->collector)',
                ),
                array(
                    'name' => 'Dealer',
                    'type' => 'raw',
                    'value' => 'is_null($data->dealer) ? " - " : number_format($data->dealer)',
                ),
                array(
                    'name' => 'Tg Bayar',
                    'type' => 'raw',
                    'value' => 'is_null($data->payDate) ? " - " :  date("d-m-Y", strtotime($data->payDate))',
                ),
                array(
                    'name' => 'Lm Bayar',
                    'type' => 'raw',
                    'value' => 'is_null($data->payDate) ? " - " :   number_format($data->payment)',
                ),
                array(
                    'name' => 'Lm Faktur',
                    'type' => 'raw',
                    'value' => 'is_null($data->payment2) ? " - " :   number_format($data->payment2)',
                ),
            ),
        ));
    }

    public function actionExporttr() {

        $fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
        $toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';

        $type = isset($_GET['type']) ? $_GET['type'] : 'ALL';
        $customer = isset($_GET['customer']) ? $_GET['customer'] : 'ALL';

        $model = new DocumentHeader("trExport");
        $model->fromDate = $fromDate;
        $model->toDate = $toDate;
        $model->type = $type;
        $model->customer = $customer;
        echo("<pre>");
        print_r($model);
        echo("</pre>");
//        exit();
        $this->widget('ext.EExcelView', array(
            'title' => "AR Traditional Review",
            'dataProvider' => $model->trExport(),
            'grid_mode' => 'export',
            'columns' => array(
                array(
                    'name' => 'Tanggal',
                    'type' => 'raw',
                    'value' => 'date("d-m-Y", strtotime($data->invDate))',
                ),
                array(
                    "name" => "Invoice",
                    "type" => "raw",
                    "value" => 'trim($data->docNumber)',
                ),
                array(
                    "name" => "PO",
                    "value" => 'trim($data->poNumber)',
                ),
                array(
                    "name" => "ID Store",
                    "type" => "raw",
                    "value" => 'trim($data->customer)',
                ),
                array(
                    "name" => "Store",
                    "type" => "raw",
                    "value" => 'trim($data->nameCust)',
                ),
                array(
                    'name' => 'Nilai',
                    'type' => 'raw',
                    'value' => 'number_format($data->invTotal)',
                ),
                array(
                    'name' => 'TT SJ',
                    'type' => 'raw',
                    'value' => 'is_null($data->suratJalan) ? " - " : number_format($data->suratJalan)',
                ),
                array(
                    'name' => 'TT Faktur',
                    'type' => 'raw',
                    'value' => 'is_null($data->faktur) ? " - " : number_format($data->faktur)',
                ),
                array(
                    'name' => 'TT eFaktur',
                    'type' => 'raw',
                    'value' => 'is_null($data->eFaktur) ? " - " : number_format($data->eFaktur)',
                ),
                array(
                    'name' => 'TT Collector',
                    'type' => 'raw',
                    'value' => 'is_null($data->collector) ? " - " : number_format($data->collector)',
                ),
                array(
                    'name' => 'TT Dealer',
                    'type' => 'raw',
                    'value' => 'is_null($data->dealer) ? " - " : number_format($data->dealer)',
                ),
                array(
                    'name' => 'Tg Bayar',
                    'type' => 'raw',
                    'value' => 'is_null($data->payDate) ? " - " :  date("d-m-Y", strtotime($data->payDate))',
                ),
                array(
                    'name' => 'Lm Bayar',
                    'type' => 'raw',
                    'value' => 'is_null($data->payDate) ? " - " :   number_format($data->payment)',
                ),
                array(
                    'name' => 'Lm Faktur',
                    'type' => 'raw',
                    'value' => 'is_null($data->payment2) ? " - " :   number_format($data->payment2)',
                ),
            ),
        ));
    }

    public function actionReview() {
        $model = new DocumentHeader('financeReview');
        $model->unsetAttributes();  // clear any default values
        $model->fromDate = date('Y-m-d');
        $model->toDate = date('Y-m-d');

        if (isset($_GET['DocumentHeader'])) {
            $model->attributes = $_GET['DocumentHeader'];
        }

        $this->render('review', array(
            'model' => $model,
        ));
    }

    public function actionTreview() {
        $model = new DocumentHeader('treview');
        $model->unsetAttributes();  // clear any default values
        $model->fromDate = date('Y-m-d');
        $model->toDate = date('Y-m-d');

        if (isset($_GET['DocumentHeader'])) {
            $model->attributes = $_GET['DocumentHeader'];
        }

        $this->render('treview', array(
            'model' => $model,
        ));
    }

    public function actionFailed() {
        $model = new DocumentHeader('failedDoc');
        $model->unsetAttributes();  // clear any default values
        $fromDate = date("Y") . '-01-01';
        $model->fromDate = $fromDate; // date('Y-m-d');
        $model->toDate = date('Y-m-d');

        if (isset($_GET['DocumentHeader'])) {
            $model->attributes = $_GET['DocumentHeader'];
        }

        $this->render('failed', array(
            'model' => $model,
        ));
    }

    public function actionSendmail() {

        $data = array(
//            0 => array(
//                "docNumber" => "A10001",
//                "invDate" => "2017-01-01",
//                "customer" => "TEST",
//            ),
//            
//            2 => array(
//                "docNumber" => "A10001",
//                "invDate" => "2017-01-01",
//                "customer" => "TEST",
//            ),
//            3 => array(
//                "docNumber" => "A10001",
//                "invDate" => "2017-01-01",
//                "customer" => "TEST",
//            ),
//            4 => array(
//                "docNumber" => "A10001",
//                "invDate" => "2017-01-01",
//                "customer" => "TEST",
//            ),
//            5 => array(
//                "docNumber" => "A10001",
//                "invDate" => "2017-01-01",
//                "customer" => "TEST",
//            ),
//            6 => array(
//                "docNumber" => "A10001",
//                "invDate" => "2017-01-01",
//                "customer" => "TEST",
//            ),
        );

        $data[0] = "PROF";
        $data[1] = "PROJ";
        $data[2] = "PROJ";
        $data[3] = "ESHP";
        $data[4] = "ESHP";
        $data[5] = "ESHP";
        $data[6] = "ESHP";
        $data[7] = "KARY";
        $data[8] = "KARY";
        $data[9] = "PROJ";
        
        
        $data = array_unique($data);
        
        $sample = array();
        $sample[0] = array(
            "docNumber" => "A10001",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
            "invType" => "PROF",
        );
        $sample[1] = array(
            "docNumber" => "A10002",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
             "invType" => "PROJ",
        );
        $sample[2] = array(
            "docNumber" => "A10003",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
             "invType" => "PROJ",
        );
        $sample[3] = array(
            "docNumber" => "A10004",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
             "invType" => "PROF",
        );
        $sample[4] = array(
            "docNumber" => "A10005",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
             "invType" => "ESHP",
        );
        $sample[5] = array(
            "docNumber" => "A10006",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
            "invType" => "ESHP",
        );
        $sample[6] = array(
            "docNumber" => "A10007",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
            "invType" => "ESHP",
        );
        $sample[7] = array(
            "docNumber" => "A10008",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
            "invType" => "KARY",
        );
        $sample[8] = array(
            "docNumber" => "A10009",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
            "invType" => "KARY",
        );
        $sample[9] = array(
            "docNumber" => "A10010",
            "invDate" => "2017-01-01",
            "customer" => "TEST",
            "invType" => "PROF",
        );
       $i = 0;
       
       foreach ($data as $value) {
            unset($result); // $foo is gone
            $result = array();
            $i = 0;
            for ($j = 0; $j <= sizeof($sample) - 1; $j++) {
                if ($sample[$j]["invType"] == $value) {
                    $result[$i] = array(
                        "docNumber" => $sample[$j]["docNumber"],
                        "invDate" => $sample[$j]["invDate"],
                        "customer" => $sample[$j]["customer"],
                        "invType" => $sample[$j]["invType"],
                    );
                    $i++;
                }
            }
            echo "<pre>";
            print_r($result);
            print_r(explode(';', Utility::getDocEmailPST("Finance", $value)));
            echo "</pre>";
        }

        //$this->kirimEmail("SJ", 3, $data);
    }

    public function actionSendmail2() {

        $this->kirimEmail3('EE75C211-ADBA-4B83-95FD-F4E8C3B8852C');
        echo "mail sent!";
    }

    public function kirimEmail($type, $status, $listDocument, $invType) {
        $ret = false;        
        $branch = Yii::app()->user->getState('branch');
        $judul = '';
        $emailAddr = array();
        
        if ($type == 'EF') {
            $judul = 'e-Faktur';
        } else if ($type == 'FK') {
            $judul = 'Faktur';
        } else if ($type == 'SJ') {
            $judul = 'Surat Jalan';
        }

        //$to[0] = ''; //array("fajar.pratama@modena.co.id");
        //$cc[0] = '';
//        unset($to);
        $to = array();
//        unset($cc);
        $cc = array();
        $bcc[0] = '';
        if ($type == 'FK') {
            if ($status == 0 && strlen($invType) > 1) { 
                //1$to = array("jkt3.finance@modena.co.id", "jkt1.finance@modena.co.id", "sarah.vania@modena.co.id", "ratna.komalasari@modena.co.id");
                $to = explode(';', Utility::getDocEmailPst("Finance", $invType));
//                for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
//                    $to[$x] = $emailAddr[$x];
//                }
            } else if ($status == 0 && strlen($invType) == 1) {
                $to = explode(';', Utility::getDocEmailAddress("Finance", $branch));
//                for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
//                    $to[$x] = $emailAddr[$x];
//                }
            }
        } else if ($type == 'EF' ) {
            if ($status == 0 && strlen($invType) > 1) {
//                $to = array("jkt3.finance@modena.co.id", "jkt1.finance@modena.co.id", "sarah.vania@modena.co.id", "ratna.komalasari@modena.co.id");
                $to = explode(';', Utility::getDocEmailPst("Finance", $invType));
//                for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
//                    $to[$x] = $emailAddr[$x];
//                }
            } else if ($status == 0 && strlen($invType) == 1) {
                $to = explode(';', Utility::getDocEmailAddress("Finance", $branch));
//                for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
//                    $to[$x] = $emailAddr[$x];
//                }
            }
        } else if ($type == 'SJ') {
            if ($status == 1 && strlen($invType) > 1 ) {
                //$to = array("dewi.suryanti@modena.co.id", "putri.anggraini@modena.co.id", "anastasia.fabiola@modena.co.id");
                $to = explode(';', Utility::getDocEmailPst("Sales", $invType));
//                for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
//                    $to[$x] = $emailAddr[$x];
//                }
            } else if ($status == 2 && strlen($invType) > 1) {
                //$to = array("jkt3.finance@modena.co.id", "jkt1.finance@modena.co.id", "sarah.vania@modena.co.id", "ratna.komalasari@modena.co.id");
                $to = explode(';', Utility::getDocEmailPst("Finance", $invType));
//                for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
//                    $to[$x] = $emailAddr[$x];
//                }
            } else if ($status == 1 && strlen($invType) == 1) {
                $to = explode(';', Utility::getDocEmailAddress("Sales", $branch));
//                for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
//                    $to[$x] = $emailAddr[$x];
//                }
            } else if ($status == 2 && strlen($invType) == 1) {
                $to = explode(';', Utility::getDocEmailAddress("Finance", $branch));
//                for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
//                    $to[$x] = $emailAddr[$x];
//                }
            }
        }

        //$to[0] = "irfan.dadi@modena.co.id"; 
        $nik = Yii::app()->user->getState('idcard'); //Employee::model()->findByAttributes(array("idCard"=>Yii::app()->user->getState('idcard')))->email;
        $userid = Yii::app()->user->getState('usrid');
        if ($nik == '') {
            $cc[0] = User::model()->findByAttributes(array("userid" => $userid))->email;
        } else {
            $cc[0] = Employee::model()->findByAttributes(array("idCard" => Yii::app()->user->getState('idcard')))->email;
        }
        //$cc[0] = '';
        $bcc = array('fajar.pratama@modena.co.id', 'irfan.dadi@modena.co.id');

        $content = '';

        //
        //template Kontrak
        $message = $this->mailTemplate(12);

        $message = str_replace("##document##", $judul, $message);
        $subject = "Logbook :: Daftar " . $judul;
        $attachment = array();

        $sDetail = "";
        for ($i = 0; $i <= sizeof($listDocument) - 1; $i++) {
            $sDetail .= '<tr><td align="left">' . $listDocument[$i]['docNumber'] . '</td><td align="left">' . date("d-m-Y", strtotime($listDocument[$i]['invDate'])) . '</td><td align="left">' . $listDocument[$i]['customer'] . '</td></tr>';
        }

        $message = str_replace("##isi##", $sDetail, $message);

        if (isset($to[0]) && !empty($to[0]) && $to[0] != '') {

            // echo $to . "<br/>";
            // echo $cc . "<br/>";
            // echo $bcc . "<br/>";
            $this->mailsend($to, $cc, $bcc, $subject, $message, $attachment);
            echo "Mail sent!";
        }

        $ret = true;

        return $ret;
    }

    public function kirimEmail2($id, $mode) {
        $ret = false;
        $branch = Yii::app()->user->getState('branch');
        $emailAddr = array();
        $model = DocumentRequest::model()->findByAttributes(array('reqID' => $id));
        $details = DocumentReqDetail::model()->getDetailD($model->reqNumber);

        $userName = Employee::model()->findByAttributes(array("idCard" => $model->reqSales));
        $greeting = '';
        $greeting2 = '';
        if ($mode == 1) { // Dari Sales Ke Finance
            $emailAddr = explode(';', Utility::getDocEmailAddress("Finance", $branch));
            for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
                $to[$x] = $emailAddr[$x];
            }
            //$to = array('jkt3.finance@modena.co.id','annisa.istiqomah@Modena.co.id');  
            $greeting = 'Finance';
            $greeting2 = 'Berikut adalah pengajuan Nota Penagihan';
            //$to = array("fajar.pratama@modena.co.id");
            $cc[0] = $userName->email;
            //$cc[1] = 'siti.hadissyah@modena.co.id';
        } else if ($mode == 2) { // dari finance ke sales
            $to[0] = $userName->email;      
            $greeting = $userName->userName;
            $greeting2 = 'Nota Penagihan berikut <b>telah diproses</b> oleh Finance';
            //$to = array("fajar.pratama@modena.co.id");
            $emailAddr = explode(';', Utility::getDocEmailAddress("Finance", $branch));
            for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
                $cc[$x] = $emailAddr[$x];
            }
//            $cc[0] ='jkt3.finance@modena.co.id';  
//            $cc[1] ='annisa.istiqomah@Modena.co.id'; 
//            $cc[2] = 'siti.hadissyah@modena.co.id';
        } else if ($mode == 3){ // dari finance ke sales jika permohonan ditolak
            $to[0] = $userName->email;      
            $greeting = $userName->userName;
            $greeting2 = 'Nota Penagihan berikut <b>ditolak</b> oleh Finance';
            //$to = array("fajar.pratama@modena.co.id");
            $emailAddr = explode(';', Utility::getDocEmailAddress("Finance", $branch));
            for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
                $cc[$x] = $emailAddr[$x];
            }
//            $cc[0] ='jkt3.finance@modena.co.id';  
//            $cc[1] ='annisa.istiqomah@Modena.co.id'; 
//            $cc[2] = 'siti.hadissyah@modena.co.id';
        }

        $bcc = array('fajar.pratama@modena.co.id', 'irfan.dadi@modena.co.id', 'ahmad.mustain@modena.co.id');
//      $cc = '';
//      $bcc = '';

        $subject = "[Pengajuan Nota Penagihan] :: No. " . $model->reqNumber . " a/n " . $userName->userName;

        $content = '';
        $link = $this->createAbsoluteUrl('document/reqview', array("id" => $model->reqID));
        //template accounting 1
        $message = $this->mailTemplate(13);

        $message = str_replace("#reqNumber#", $model->reqNumber, $message);
        $message = str_replace("#greeting#", $greeting, $message);
        $message = str_replace("#greeting2#", $greeting2, $message);
        $message = str_replace("#link#", $link, $message);
        $message = str_replace("#tanggal#", date("d-m-Y", strtotime($model->reqDate)), $message);
        $message = str_replace("#sales#", $userName->userName, $message);
        $message = str_replace("#jumlahFaktur#", number_format($model->invCount, 0), $message);
        $message = str_replace("#nilaiFaktur#", number_format($model->invValue, 0), $message);

        $attachment = array();

        $sDetail = "";
        $rowNum = 0;
        foreach ($details as $row => $detail) {
            $rowNum = (int) $rowNum + 1;
            $sDetail .= "<tr><td align=center>" . $rowNum . "</td>";
            $sDetail .= '<td>' . $detail['bilname'] . '</td>
                            <td>' . $detail['docNumber'] . '</td>
                            <td>' . date("d-m-Y", strtotime($detail['invDate'])) . '</td>
                            <td>' . number_format($detail['invTotal']) . '</td></tr>	';
        }

        $message = str_replace("#detail#", $sDetail, $message);

        $this->mailsend($to, $cc, $bcc, $subject, $message, $attachment);
        //$this->redirect(array('index' ,));          
    }

    public function kirimEmail3($id, $mode) { // 1 realisasi, 2 verifikasi
        $ret = false;
        $branch = Yii::app()->user->getState('branch');
        $emailAddr = array();
        $model = DocumentRequest::model()->findByAttributes(array('reqID' => $id));
        $details = DocumentReqDetail::model()->getDetailD($model->reqNumber);

        $userName = Employee::model()->findByAttributes(array("idCard" => $model->reqSales));
        $directHead = Utility::getDirectHead($userName->idBranch, $userName->idDept, $userName->idPos);

        $greeting = '';
        $greeting2 = '';
        if ($mode == 1) { // Dari Sales Ke Finance                
            $greeting = 'Finance';
            $greeting2 = 'Berikut adalah realisasi Nota Penagihan';
            //$to = array("fajar.pratama@modena.co.id");
            $emailAddr = explode(';', Utility::getDocEmailAddress("Finance", $branch));
            for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
                $to[$x] = $emailAddr[$x];
            }
//            $to = array('jkt3.finance@modena.co.id','annisa.istiqomah@Modena.co.id');  
            $cc[0] = $userName->email;
//            $cc[1] = 'siti.hadissyah@modena.co.id';
        } else if ($mode == 2) { // dari finance ke sales
            $greeting = $userName->userName;
            $greeting2 = 'Realisasi Nota Penagihan berikut telah diverifikasi oleh Finance';
            //$to = array("fajar.pratama@modena.co.id");
            $to[0] = $userName->email;  
            $emailAddr = explode(';', Utility::getDocEmailAddress("Finance", $branch));
            for ($x = 0; $x <= sizeof($emailAddr)-1; $x++) {
                $cc[$x] = $emailAddr[$x];
            }
//            $cc[0] = 'jkt3.finance@modena.co.id';
//            $cc[1] = 'annisa.istiqomah@Modena.co.id';
//            $cc[2] = 'siti.hadissyah@modena.co.id';
            $cc[sizeof($emailAddr)] = Employee::model()->findByAttributes(array("idCard"=>$directHead))->email;
        }
        $bcc = array('fajar.pratama@modena.co.id', 'irfan.dadi@modena.co.id', 'ahmad.mustain@modena.co.id');
//      $cc = '';
//      $bcc = '';
        $subject = "[Realisasi Nota Penagihan] :: No. " . $model->reqNumber . " a/n " . $userName->userName;
        $content = '';

        //template accounting 1
        $message = $this->mailTemplate(14);

        $message = str_replace("#reqNumber#", $model->reqNumber, $message);
        $message = str_replace("#greeting#", $greeting, $message);
        $message = str_replace("#greeting2#", $greeting2, $message);
        $message = str_replace("#tanggal#", date("d-m-Y", strtotime($model->reqDate)), $message);
        $message = str_replace("#sales#", $userName->userName, $message);
        $message = str_replace("#jumlahFaktur#", number_format($model->invCount, 0), $message);
        $message = str_replace("#nilaiFaktur#", number_format($model->invValue, 0), $message);
        $message = str_replace("#jumlahRealisasi#", number_format($model->retCount, 0), $message);
        $message = str_replace("#nilaiRealisasi#", number_format($model->retValue, 0), $message);
        $message = str_replace("#jumlahVerifikasi#", number_format($model->revCount, 0), $message);
        $message = str_replace("#nilaiVerifikasi#", number_format($model->revValue, 0), $message);

        $attachment = array();

        $sDetail = "";
        $rowNum = 0;
        foreach ($details as $row => $detail) {
            $rowNum = (int) $rowNum + 1;
            $tanggal = "";
            $tanggal = is_null($detail["retDate"]) ? " -" : date("d-m-Y", strtotime($detail['retDate']));
            $sDetail .= "<tr><td align=center>" . $rowNum . "</td>";
            $sDetail .= '<td>' . $detail['bilname'] . '</td>
                            <td>' . $detail['docNumber'] . '</td>
                            <td>' . date("d-m-Y", strtotime($detail['invDate'])) . '</td>
                            <td>' . number_format($detail['invTotal']) . '</td>'
                    . '<td>' . $detail['retType'] . '<br/>' . $detail['retNumber'] . '<br/>' . $detail['retDesc'] . '</td>'
                    . '<td>' . $tanggal . '</td>'
                    . '<td>' . number_format($detail['retValue']) . '</td>	'
                    . '<td>' . number_format($detail['revValue']) . '</td>'
                    . '<td>' . $detail['revNumber']. '</td></tr>	';
        }

        $message = str_replace("#detail#", $sDetail, $message);

        $this->mailsend($to, $cc, $bcc, $subject, $message, $attachment);
        //$this->redirect(array('index' ,));          
    }

}
