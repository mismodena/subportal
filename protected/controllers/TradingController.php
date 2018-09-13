<?php

class TradingController extends Controller {

    public $layout = 'leftbar';

    function init() {
        parent::init();
        $this->leftPortlets['ptl.TradingMenu'] = array();
    }

    public function filters() {
        return array(
            'Rights',
        );
    }

    public function actionMasterIndex() {
        $model = new MsTrading('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MsTrading'])) {
            $model->attributes = $_GET['MsTrading'];
        }

        $this->render('masterIndex', array(
            'model' => $model,
        ));
    }

    public function actionMasterView($id) {
        $model = MsTrading::model()->findByAttributes(array('tradID' => $id));

        $this->render('masterView', array(
            'model' => $model,
        ));
    }

    public function actionMasterCreate() {
        $model = new MsTrading;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['MsTrading'])) {
            $model->attributes = $_POST['MsTrading'];
            if($model->isTT != 1){
                $model->isTT = 0;
            }
            $model->validate();

            if ($model->validate()) {
                if ($model->save()) {
                    $this->redirect(array('masterIndex'));
                }
            }
        }

        $this->render('masterCreate', array(
            'model' => $model,
        ));
    }

    public function actionMasterUpdate($id) {
        $model = MsTrading::model()->findByAttributes(array('tradID' => $id));

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['MsTrading'])) {
            $model->attributes = $_POST['MsTrading'];

            $model->validate();

            if ($model->validate()) {
                if ($model->save()) {
                    $this->redirect(array('masterIndex'));
                }
            }
        }

        $this->render('masterUpdate', array(
            'model' => $model,
        ));
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'master-trading-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionTermIndex() {
        $model = new MsTradingTerm('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MsTradingTerm'])) {
            $model->attributes = $_GET['MsTradingTerm'];
        }

        $this->render('termIndex', array(
            'model' => $model,
        ));
    }

    public function actionTermView($id) {
        $model = MsTradingTerm::model()->getTerm($id);
        $detail = MsTradingTermDetail::model()->getTradDetail($model->termNo);

        $this->render('termView', array(
            'model' => $model,
            'detail' => $detail,
        ));
    }

    public function actionTermCreate() {
        $model = new MsTradingTerm;
        $model->details = MsTrading::model()->findAll(array('order' => 'tradCode'));

        // Uncomment the following line if AJAX validation is needed
        //$this->performCustomerAjaxValidation($model);

        if (isset($_POST["MsTradingTerm"])) {
            $newModel = new MsTradingTerm;

            $newModel->attributes = $_POST["MsTradingTerm"];
            $newModel->termNo = Utility::getTradNo();
            $newModel->validate();

//            echo "<pre>";
//            print_r($model->details);
//            echo "</pre>";
//            exit();

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $isValid = $newModel->validate();
                if ($isValid) {
                    $newModel->save();
                }

                $rows = 0;
                if (isset($_POST["MsTrading"]) && is_array($_POST["MsTrading"])) {

                    foreach ($_POST["MsTrading"] as $line => $item) {
                        $rows = $rows + 1;
                        $detail = new MsTradingTermDetail;
                        $detail->termID = $newModel->termNo;
                        $detail->tradID = $item["tradID"];
                        $detail->tradCode = $item["tradCode"];
                        $detail->tradDesc = $item["tradDesc"];
                        $detail->tradSource = $item["tradSource"];
                        $detail->tradPeriod = $item["tradPeriod"];
                        $detail->tradValueFrom = $item["tradValueFrom"];
                        $detail->tradValueTo = $item["tradValueTo"];
                        $detail->tradPercentage = $item["tradPercentage"];
                        $detail->tradStatus = $item["tradStatus"];

                        $valid = $detail->validate();
                        if ($valid) {
                            if (!$detail->save()) {
                                $transaction->rollBack();
                                throw new Exception("Error Processing Request", $detail->getErrors());
                            }
                        } else {
                            $transaction->rollBack();
                            throw new CHttpException(404, 'Oops. Not found.');
                        }
                    }
                }

                $transaction->commit();
                $this->redirect(array("termIndex"));
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException("403", $e);
            }
        }

        $this->render('termCreate', array(
            'model' => $model,
        ));
    }

    public function actionTermUpdate($id) {
        $model = MsTradingTerm::model()->findByAttributes(array('termID' => $id));
        $model->details = MsTrading::model()->getTradingTerm($model->termNo);
        $termID = $model->termID;
        $termNo = $model->termNo;
        // Uncomment the following line if AJAX validation is needed
        //$this->performCustomerAjaxValidation($model);

        if (isset($_POST["MsTradingTerm"])) {
            $model->attributes = $_POST["MsTradingTerm"];
            $model->validate();

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $isValid = $model->validate();
                if ($isValid) {
                    $model->save();
                }

                $rows = 0;
                if (isset($_POST["MsTrading"]) && is_array($_POST["MsTrading"])) {
                    MsTradingTermDetail::model()->deleteAll('termID=:termID', array(':termID' => $model->termNo));
                    foreach ($_POST["MsTrading"] as $line => $item) {
                        $rows = $rows + 1;
                        $detail = new MsTradingTermDetail;
                        $detail->termID = $model->termNo;
                        $detail->tradID = $item["tradID"];
                        $detail->tradCode = $item["tradCode"];
                        $detail->tradDesc = $item["tradDesc"];
                        $detail->tradSource = $item["tradSource"];
                        $detail->tradPeriod = $item["tradPeriod"];
                        $detail->tradValueFrom = $item["tradValueFrom"];
                        $detail->tradValueTo = $item["tradValueTo"];
                        $detail->tradPercentage = $item["tradPercentage"];
                        $detail->tradStatus = $item["tradStatus"];
                        $detail->isPL = $item["isPL"];
                        
                        $valid = $detail->validate();
                        if ($valid) {
                            if (!$detail->save()) {
                                $transaction->rollBack();
                                throw new Exception("Error Processing Request", $detail->getErrors());
                            }
                        } else {
                            $transaction->rollBack();
                            throw new CHttpException(404, 'Oops. Not found.');
                        }
                    }
                }

                $transaction->commit();
                $this->redirect(array("termIndex"));
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException("403", $e);
            }
        }

        $this->render('termUpdate', array(
            'model' => $model,
        ));
    }

    protected function performCustomerAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-trading-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionClaimCreate() {
        ini_set("maximum_execution_time", 3600);
        
        $model = new TradingClaim();
        $model->details = msTradingClaim::model()->getClaimList();
        // Uncomment the following line if AJAX validation is needed
        $this->performClaimAjaxValidation($model);

        if (isset($_POST["TradingClaim"])) {
            $model->attributes = $_POST["TradingClaim"];
            $model->claimStatus = 0;
            $model->claimTotal = 0;
            $model->claimNo = Utility::getClaimNo();
            $model->isRevise = $_POST["TradingClaim"]["isRevise"];


            $transaction = Yii::app()->db->beginTransaction();
            try {

                //upload File
                $path = DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'tt' . DIRECTORY_SEPARATOR;
                $temp = CUploadedFile::getInstance($model, 'fileName');
                $formatName = time() . '-' . $model->claimNo . '.' . $temp->getExtensionName();

                $model->fileName = str_replace(DIRECTORY_SEPARATOR, '/', $path . $formatName);
                $model->save();
                $temp->saveAs(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . $path . $formatName);

                $rows = 0;
                if (isset($_POST["msTradingClaim"]) && is_array($_POST["msTradingClaim"])) {

                    foreach ($_POST["msTradingClaim"] as $line => $item) {
                        if ($item["value"] > 0) {
                            $rows = $rows + 1;
                            $detail = new TradingDetails();
                            $detail->claimNo = $model->claimNo;
                            $detail->tradCode = $item["tradCode"];
                            $detail->claim = $item["value"];
                            $detail->value = 0;
                            $detail->pocheck = 0;
                            $detail->status = 0;

                            $valid = $detail->validate();
                            if ($valid) {
                                if (!$detail->save()) {
                                    $transaction->rollBack();
                                    throw new Exception("Error Processing Request", $detail->getErrors());
                                }
                            } else {
                                $transaction->rollBack();
                                throw new Exception("Error Processing Request", $detail->getErrors());
                            }
                        }
                    }
                }

                //extract
                if (!$this->extractClaim($model->claimNo)) {
                    $transaction->rollBack();
                    throw new Exception("403", "Verifikasi Data gagal");
                }


                if ($model->isRevise == 0) {
                    $sql = " exec spVerifyTrading '" . $model->claimNo . "' ";
                } else {
                    $sql = " exec spVerifyTradingRev '" . $model->claimNo . "' ";
                    //$sql = " select getdate() ";
                }

                //verify

                $command = Yii::app()->db->createCommand($sql);
                $command->queryAll();

                $transaction->commit();

                $this->redirect(array('claimView', 'id' => $model->claimNo));
                //$this->redirect(array("claimIndex"));
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException("403", $e);
            }
        }

        $this->render('claimCreate', array(
            'model' => $model,
        ));
    }

    public function actionPrintclaim($id) {
        $this->layout = 'iframe';
        
        $model = TradingClaim::model()->getClaim($id);
        $detail = TradingDetails::model()->getDetails($id);
        $sum = TradingDetails::model()->getDetailSummary($id);

        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

        # render (full page)
        $mPDF1->WriteHTML($this->render('claimPrint', array(
            'model' => $model[0],
            'detail' => $detail,
            'sum' => $sum[0],
        ), true));
        	
        # Outputs ready PDF
	$mPDF1->Output($model->claimNo.'.pdf','I');
        
    }

    public function actionClaimIndex() {
        $model = new TradingClaim('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TradingClaim'])) {
            $model->attributes = $_GET['TradingClaim'];
        }

        $this->render('claimIndex', array(
            'model' => $model,
        ));
    }

    public function actionClaimView($id) {
        $model = TradingClaim::model()->getClaim($id);
        $detail = TradingDetails::model()->getDetails($id);
        $sum = TradingDetails::model()->getDetailSummary($id);
        
        $this->render('claimView', array(
            'model' => $model[0],
            'detail' => $detail,
            'sum' => $sum[0],
        ));
    }

    public function actionClaimDetail($id, $tradCode) {
        $model = TradingDetailsPO::model()->getDetailPO($id, $tradCode);
        $sum = TradingDetailsPO::model()->getTotal($id, $tradCode);
        $this->layout = '//layouts/iframex';

        $this->render('claimPO', array(
            'model' => $model,
           'sum' => $sum[0],
        ));
    }

    public function actionExportExcel($id, $tradCode)
    {
        $header = TradingClaim::model()->getClaim($id);

        $model= new TradingDetailsPO("getExport");
        $model->claimNo = $id;
        $model->tradCode = $tradCode;

        $this->widget('ext.EExcelView', array(
            'title'=>$header[0]->claimNo." - ".$header[0]->groupName,
            'dataProvider' => $model->getExport(),
            'grid_mode'=>'export',
            'columns'=>array(
                array(
                    'name' => 'Claim No', 
                    'value' => '$data->claimNo',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'Trading Term', 
                    'value' => '$data->tradCode." - ".$data->tradDesc',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'PO', 
                    'value' => '$data->poNo',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'Accpac', 
                    'value' => '$data->value',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'Klaim', 
                    'value' => '$data->claim',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'Deskripsi', 
                    'value' => '$data->description',
                    'htmlOptions' => array('width' => '60px'),
                ),
            ),
        ));
    
    }   
    
    public function actionApproval($id, $appr) {
        $model = TradingClaim::model()->findByAttributes(array("claimNo" => $id));

        if ($appr == 1) {

            $model->claimStatus = 1;
            $model->save(false);
        } else {
            TradingClaim::model()->deleteAll('claimNo=:claimNo', array(':claimNo' => $id));
            TradingDetails::model()->deleteAll('claimNo=:claimNo', array(':claimNo' => $id));
            TradingDetailsPO::model()->deleteAll('claimNo=:claimNo', array(':claimNo' => $id));
            TradingExtract::model()->deleteAll('claimNo=:claimNo', array(':claimNo' => $id));
            TradingRetur::model()->deleteAll('returNo=:claimNo', array(':claimNo' => $id));
        }
        $this->redirect(array('claimIndex'));
    }

    public function actionExtract($id){
        $this->extractClaim($id);
    }

    protected function extractClaim($id) {
        $model = TradingClaim::model()->findByAttributes(array("claimNo" => $id));
        $path = Yii::app()->basePath . '/../' . $model->fileName;

        try {
            error_reporting(E_ALL ^ E_NOTICE);
            require_once('excel_reader2.php');

            $data = new Spreadsheet_Excel_Reader($path);
            $cols = ($data->colcount($sheet_index = 0));
            $rows = ($data->rowcount($sheet_index = 0));
            $tradCode = "";
            $poNo = "";

            for ($i = 2; $i <= $cols; $i++) {
                $tradCode = $data->sheets[0]['cells'][1][$i];
                if (isset($tradCode) ) {
                    for ($j = 2; $j <= $rows; $j++) {
                        if(isset($data->sheets[0]['cells'][$j][1]) && trim($data->sheets[0]['cells'][$j][1]) != ""){
                            $detail = new TradingExtract();
                            $detail->claimNo = $model->claimNo;
                            $detail->poNo = $data->sheets[0]['cells'][$j][1];
                            $detail->tradCode = $tradCode;
                            $detail->value = 0;
                            $detail->status = 0;
                            $detail->claim = $data->sheets[0]['cells'][$j][$i];
                            print_r($detail);
                            exit();
                            $detail->save();
                        }
                        
                    }
                }
            }

            return true;
        } catch (Exception $ex) {
            //$transaction->rollBack();
            // echo "<pre>";
            // print_r($detail);
            // echo "</pre>";
            // exit();
            throw new CHttpException("403", $ex->getMessage());
            //exit(json_encode(array('result' => 'success', 'msg' => $ex->getMessage())));                    
        }
    }

    protected function performClaimAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'claim-trading-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionReturIndex() {
        $model = new TradingRetur('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TradingRetur'])) {
            $model->attributes = $_GET['TradingRetur'];
        }

        $this->render('returIndex', array(
            'model' => $model,
        ));
    }

    public function actionReturCreate() {
        $model = new TradingRetur;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['TradingRetur'])) {
            $groupCode = $_POST['TradingRetur']['groupCode'];
            $sql = " exec spGenerateRetur '" . $groupCode . "' ";
            $command = Yii::app()->db->createCommand($sql);
            $command->queryAll();
            $this->redirect(array('returIndex'));
        }

        $this->render('returCreate', array(
            'model' => $model,
        ));
    }

}
