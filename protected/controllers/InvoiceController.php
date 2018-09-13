<?php

class InvoiceController extends Controller
{
    
    public $layout='leftbar';
    
    function init() {
        parent::init();
        $this->leftPortlets['ptl.InvMenu'] = array();
    }

    public function filters()
    {
        return array(
            'Rights',
        );
    }

    public function allowedActions()
    {
        return 'index, approval, sendMail, viewJT';
    }
    
    public function actionSendMail($id)
    {
        $invID = ProformaInvoice::model()->findByAttributes(array('invNo'=>$id))->invID;

        $kirim = $this->kirimEmail($invID);
        
        if($kirim)
        {
            echo "Email dikirim";
        }
        else
        {
            echo "Gagal kirim";
        }
    }
    public function actionIndex()
    {
        $model=new Invoice('search');
        
        $model->unsetAttributes(); 
        $model->keyWord = '--';
        if(isset($_GET['Invoice']))
        {
            $model->attributes=$_GET['Invoice'];
        }
            

        $this->render('index',array(
                'model'=>$model,
        ));
    }
    
    public function actionAlokasi()
    {
        $model = new PotKP;
        $pkp = array() ;
        $order = array();
        
        if(isset($_POST['PotKP']))
        {
            $model->idCust=$_POST['PotKP']['idCust'];
            $pkp = PotKP::model()->getSource($model->idCust);
            $order = Order::model()->getOrder($model->idCust);
        }
           
        $this->render('alokasi',array(
                'model'=>$model,
                'pkp' => $pkp,
                'order'=>$order,
        ));
    }
    
    public function actionExecalokasi($id){
        if(!empty($id)){
            $employee = Employee::model()->getActiveEmployee();
            $sql = " exec sgtdat..spPKPAllocateBranch '" . $id . "', '".$employee->userName."'";  
            $command = Yii::app()->db->createCommand($sql);
            $command->queryAll();

            $this->redirect(array('alokasi'));
        }       
    }


    public function actionIndexPI()
    {       
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.FinanceMenu'] = array();        
        
        $model=new ProformaInvoice('search');
        
        $model->unsetAttributes(); 
        if(isset($_GET['ProformaInvoice']))
        {
            $model->attributes=$_GET['ProformaInvoice'];
        }
            

        $this->render('indexPI',array(
                'model'=>$model,
        ));
    }
    
    public function actionInkuiri()
    {       
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array();        
        
        $model=new APInvoice('inkuiri');
        
        $model->unsetAttributes(); 
        if(isset($_GET['APInvoice']))
        {
            $model->attributes=$_GET['APInvoice'];
        }
            

        $this->render('inkuiri',array(
                'model'=>$model,
        ));
    }
    
    public function actionVerifyPI()
    {       
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.FinanceMenu'] = array();        
        
        $model=new ProformaInvoice('verify');
        
        $model->unsetAttributes(); 
        if(isset($_GET['ProformaInvoice']))
        {
            $model->attributes=$_GET['ProformaInvoice'];
        }
            

        $this->render('verifyPI',array(
                'model'=>$model,
        ));
    }
    
    public function actionDelegation()
    {       
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array();        
        
        $model=new APInvoice('delegation');
        
        $model->unsetAttributes(); 
        if(isset($_GET['APInvoice']))
        {
            $model->attributes=$_GET['APInvoice'];
        }
            
        $this->render('delegationAP',array(
                'model'=>$model,
        ));
    }
    
    public function actionLogbook()
    {       
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array();        
        
        $model=new APInvoice('logbook');
        $model2=new FppHeader('logbook');
        
        //$model->unsetAttributes(); 
        //if(isset($_GET['APInvoice']))
        //{
        //    $model->attributes=$_GET['APInvoice'];
        //}
            
        $this->render('logbook',array(
                'model'=>$model, 'model2' => $model2
        ));
    }
    
    public function actionPrintDelegation()
    {       
         $this->layout='iframe';;        
        
        $model=new APInvoice('delegation');
        
        $model->unsetAttributes(); 
        if(isset($_GET['APInvoice']))
        {
            $model->attributes=$_GET['APInvoice'];
        }
            

        $this->render('printDelegation',array(
                'model'=>$model,
        ));
    }
    
    public function kirimEmail($id)
    {
        $ret =false;

        $model = ProformaInvoice::model()->getInvHeader($id);
        $detail = ProformaDetail::model()->findAllByAttributes(array('invID'=>$model->invNo));        
        
        //print_r($detail);
        
        //$to[0] =  Employee::model()->findByAttributes(array("idCard"=>Utility::getPIC($model->deptHead)))->email;             
        //$to = array("fajar.pratama@modena.co.id");
        $cc = "";
        $bcc = array('fajar.pratama@modena.co.id');

        if($model->status == 0)
        {
            $subject ="Informasi Pengajuan Proforma Invoice :: ".$model->invNo;                                                     
            $link = $this->createAbsoluteUrl('invoice/viewPI',array("id"=>$model->invID)) ;
            $text = "[klik untuk melihat detail]";
            //$to = array("fajar.pratama@modena.co.id");
            $to[0] = 'gema.ramadhona@modena.co.id';
        }
        elseif ($model->status == 1)
        {
            $subject ="Persetujuan Proforma Invoice :: ".$model->invNo;                                                                 
            $link = $this->createAbsoluteUrl('invoice/approval',array("invID"=>$model->invID, "status" => "signed")) ;
            $text = "[signed]";
            //$to = array("fajar.pratama@modena.co.id");
            $to[0] = 'reynold@modena.co.id';
        }
        else
        {
            $subject ="Proforma Invoice :: ".$model->invNo." telah ditanda-tangani";     
            $link = $this->createAbsoluteUrl('invoice/viewPI',array("id"=>$model->invID)) ;
            $text = "[klik untuk melihat detail]";
            $to[0] =  Employee::model()->findByAttributes(array("idCard"=>$model->picNo))->email;   
        }
        
        $content = '';
        
        //
        //template Kontrak
        $message = $this->mailTemplate(6);                            
        
        $message = str_replace("##link##", $link, $message);
        
        $message = str_replace("##nomor##", $model->invNo, $message);
        $message = str_replace("##nama##", $model->accName, $message);
        $message = str_replace("##tanggal##", date("d-m-Y", strtotime($model->invDate)), $message);
        $message = str_replace("##nomor po##", $model->poNo, $message);
        $message = str_replace("##pembeli##", $model->poName, $message);
        $message = str_replace("##text##", $text, $message);
        $message = str_replace("##subTotal##", number_format($model->grand), $message);
        $message = str_replace("##diskon##", number_format($model->invDisc), $message);
        $message = str_replace("##DP##", number_format($model->invDP), $message);
        $message = str_replace("##total##", number_format($model->invTotal - $model->invDisc - $model->invDP), $message);
        $message = str_replace("##ppn##", number_format(($model->invTotal - $model->invDisc - $model->invDP)*0.1), $message);
        $message = str_replace("##grandTotal##", number_format($model->invTotalWtx), $message);
                        
        $attachment = array();
            
        $sDetail = "";        
        foreach($detail as $line => $item) { 
            
            $unitprice = number_format($item['unitPrice'],0);
            $qty = number_format($item['unitQty'],0);
            $total = number_format(($item['unitQty'] * $item['unitPrice']),0);
            
            $sDetail .= '<tr ><td align="center">'.$item['itemModel'].'</td><td align="left">'.$item['itemDesc'].'</td>'
                    . '  <td align="right">'.$unitprice.'</td><td align="right">'.$qty.'</td><td align="right">'.$total.'</td></tr>' ;             
            
        }
        
        $message = str_replace("##isi##", $sDetail, $message);  

        $this->mailsend($to,$cc,$bcc,$subject,$message,$attachment);       
        
        $ret = true;
        
        return $ret;
    }
    
    public function actionIndexAP()
    {       
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array();        
        
        $model=new APInvoice('search');
        
        $model->unsetAttributes(); 
        if(isset($_GET['APInvoice']))
        {
            $model->attributes=$_GET['APInvoice'];
        }
            

        $this->render('indexAP',array(
                'model'=>$model,
        ));
    }
    
    public function actionRetur()
    {
        $model=new pkpAllocated('search');
        
        $model->unsetAttributes();         
        if(isset($_GET['pkpAllocated']))
        {
            $model->attributes=$_GET['pkpAllocated'];
        }
            

        $this->render('retur',array(
                'model'=>$model,
        ));
    }
    
    public function actionCancel()
    {
        $model=new PotKP('search');
        
        $model->unsetAttributes(); 
        if(isset($_GET['PotKP']))
        {
            $model->attributes=$_GET['PotKP'];
        }
            

        $this->render('batal',array(
                'model'=>$model,
        ));
    }
    
    public function actionViewPI($id)
    {      
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.FinanceMenu'] = array();  
        
        $model = ProformaInvoice::model()->getInvHeader($id);
        $detail = ProformaDetail::model()->getInvDetail($model->invNo);
        
        $this->render('viewPI',array(
                'model'=>$model,
                'detail'=>$detail,
        ));
    }
    
    public function actionViewAP($id)
    {      
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array();  
        
        $model = APInvoice::model()->getInvHeader($id);
        $detail = APDocument::model()->getInvDetail($model->recNo);
        $detailInv = APDetail::model()->GetInvDetail($model->recNo);
        
        $this->render('viewAP',array(
                'model'=>$model,
                'detail'=>$detail,
                'detailInv'=>$detailInv
        ));
    }
    
    public function actionPrintPI($id)
    {      
        $this->layout='iframe';;
        
        $model = ProformaInvoice::model()->getInvHeader($id);
        $detail = ProformaDetail::model()->findAllByAttributes(array('invID'=>$model->invNo));

        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

        # render (full page)
        $mPDF1->WriteHTML($this->render('printPI', array('model'=>$model,'detail'=>$detail), true));
        	
        # Outputs ready PDF
	$mPDF1->Output($model->invNo.'.pdf','I');
        
        //$this->render('printPI',array(
        //        'model'=>$model,
        //        'detail'=>$detail,
        //));
    }
    
    public function actionPrintAP($id)
    {      
        $this->layout='iframe';
                
        $model = APInvoice::model()->getInvHeader($id);                
        $detail = Yii::app()->db->createCommand("exec spPrintReceiptAP '$model->recNo'")->queryAll();
        $invNo = APDetail::model()->getInvNo($model->recNo);

        $this->render('printAP',array(
                'model'=>$model,
                'detail'=>$detail,
                'invNo'=>$invNo
        ));        
    }

    public function actionPrintAPFinance($id)
    {      
        /*$this->layout='iframe';
                
        $model = APInvoice::model()->getInvHeaderPrint($id);                
        $detail = APDocument::model()->findAllByAttributes(array('recNo'=>$model->recNo));
        $detailInv =  APDetail::model()->findAllByAttributes(array('apInvoiceID'=>$model->recNo));

        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

            # render (full page)
        $mPDF1->WriteHTML($this->render('printAPFinance', array(
            'model'=>$model,
            'detailInv'=>$detailInv,
            'detail'=>$detail,
            ), true));
            
        # Outputs ready PDF
        $mPDF1->Output($model->recNo.'.pdf','I');*/
        $this->layout='iframe';
                
        $model = APInvoice::model()->getInvHeader($id);                
        $detail = APDocument::model()->findAllByAttributes(array('recNo'=>$model->recNo));
        $detailInv =  APDetail::model()->findAllByAttributes(array('apInvoiceID'=>$model->recNo));

        $this->render('printAPFinance',array(
                'model'=>$model,
                'detail'=>$detail,
                'detailInv'=>$detailInv,
        ));      
    }
    
    public function actionCreatePI()
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.FinanceMenu'] = array(); 
        
        $model=new ProformaInvoice;
        $model->items[] = new ProformaDetail();
        
        $this->performAjaxValidation($model);

        if(isset($_POST['ProformaInvoice']))
        {
            $model->attributes=$_POST['ProformaInvoice'];
            $model->invNo = Utility::getInvNo($model->invDate);
            $model->invTotal = str_replace(",","",$_POST['ProformaInvoice']['grandTotal']);
            $model->invDisc = str_replace(",","",$_POST['ProformaInvoice']['invDisc']);
            $model->invTotalWtx = str_replace(",","",$_POST['ProformaInvoice']['grand']);
            $model->invTempDP = str_replace(",","",$_POST['ProformaInvoice']['invTempDP']);
            $model->invDP = str_replace(",","",$_POST['ProformaInvoice']['invDP']);
            $model->invRetensi = str_replace(",","",$_POST['ProformaInvoice']['invRetensi']);
            $model->picNo = Yii::app()->user->getState('idcard');
            $model->status = 0;
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $isValid = $model->validate();    
                $model->save(); 
                
                if (isset($_POST['ProformaDetail']) && is_array($_POST['ProformaDetail'])) {
                                             
                    foreach ($_POST['ProformaDetail'] as $line=>$item) {
                        if (!empty($item['itemModel'])){                            
                            $detail = new ProformaDetail;
                            $detail->invID = $model->invNo;
                            $detail->itemModel = $item['itemModel'];
                            $detail->itemDesc = $item['itemDesc'];
                            $detail->unitPrice = $item['unitPrice'];
                            $detail->unitQty = $item['unitQty'];

                            $valid = $detail->validate();
                            if ($valid) {
                                if (!$detail->save()){
                                    $transaction->rollBack();                        
                                }                                        
                            } else {
                                $transaction->rollBack();                            
                            }
                        }  
                    }                              
                }
                
                $newID = ProformaInvoice::model()->findByAttributes(array('invNo'=>$model->invNo))->invID; 
                $email = $this->kirimEmail($newID);
                
                $transaction->commit();
                $this->redirect(array('indexPI',));
            }catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException(403, $e);
                Yii::app()->user->setFlash('Error', $e);
                //$this->redirect(array('formPP/index'));                            
            } 
        }

        $this->render('createPI',array(
                'model'=>$model,
        ));
    }
    
    public function actionCreatePIItem()
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.FinanceMenu'] = array(); 
        
        $model=new ProformaInvoice;
        $model->items[] = new ProformaDetail();
        
        $this->performAjaxValidation($model);

        if(isset($_POST['ProformaInvoice']))
        {
            $model->attributes=$_POST['ProformaInvoice'];
            $model->invNo = Utility::getInvNo($model->invDate);
            $model->invTotal = str_replace(",","",$_POST['ProformaInvoice']['grandTotal']);
            $model->invDisc = str_replace(",","",$_POST['ProformaInvoice']['invDisc']);
            $model->invTotalWtx = str_replace(",","",$_POST['ProformaInvoice']['grand']);
            $model->invTempDP = str_replace(",","",$_POST['ProformaInvoice']['invTempDP']);
            $model->invDP = str_replace(",","",$_POST['ProformaInvoice']['invDP']);
            $model->invRetensi = str_replace(",","",$_POST['ProformaInvoice']['invRetensi']);
            $model->picNo = Yii::app()->user->getState('idcard');
            $model->status = 0;
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $isValid = $model->validate();    
                $model->save(); 
                
                if (isset($_POST['ProformaDetail']) && is_array($_POST['ProformaDetail'])) {
                                             
                    foreach ($_POST['ProformaDetail'] as $line=>$item) {
                        if (!empty($item['itemModel'])){                            
                            $detail = new ProformaDetail;
                            $detail->invID = $model->invNo;
                            $detail->itemModel = $item['itemModel'];
                            //$detail->itemDesc = $item['itemDesc'];
                            $detail->itemDesc = Utility::getItemDesc($item['itemModel']);
                            $detail->unitPrice = $item['unitPrice'];
                            $detail->unitQty = $item['unitQty'];

                            $valid = $detail->validate();
                            if ($valid) {
                                if (!$detail->save()){
                                    $transaction->rollBack();                        
                                }                                        
                            } else {
                                $transaction->rollBack();                            
                            }
                        }  
                    }                              
                }
                
                $newID = ProformaInvoice::model()->findByAttributes(array('invNo'=>$model->invNo))->invID; 
                $email = $this->kirimEmail($newID);
                
                $transaction->commit();
                $this->redirect(array('indexPI',));
            }catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException(403, $e);
                Yii::app()->user->setFlash('Error', $e);
                //$this->redirect(array('formPP/index'));                            
            } 
        }

        $this->render('createPIItem',array(
                'model'=>$model,
        ));
    }
    
    public function actionUpdatePI($id)
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.FinanceMenu'] = array(); 
        
        $model = ProformaInvoice::model()->findByAttributes(array('invID'=>$id));
        
        $model->items = ProformaDetail::model()->findAllByAttributes(array('invID'=>$model->invNo));
        
        $this->performAjaxValidation($model);

        if(isset($_POST['ProformaInvoice']))
        {
            $model->attributes=$_POST['ProformaInvoice'];
            //$model->invNo = Utility::getInvNo($model->invDate);
            $model->invTotal = str_replace(",","",$_POST['ProformaInvoice']['grandTotal']);
            $model->invDisc = str_replace(",","",$_POST['ProformaInvoice']['invDisc']);
            $model->invTotalWtx = str_replace(",","",$_POST['ProformaInvoice']['grand']);
            $model->invTempDP = str_replace(",","",$_POST['ProformaInvoice']['invTempDP']);
            $model->invDP = str_replace(",","",$_POST['ProformaInvoice']['invDP']);

            $isValid = $model->validate();    
             
            $transaction = Yii::app()->db->beginTransaction();
            
            try {
                
                $model->save();   
                
                if (isset($_POST['ProformaDetail']) && is_array($_POST['ProformaDetail'])) {
                    
                    ProformaDetail::model()->deleteAll('invID=:invID', array(':invID'=>$model->invNo));
                    
                    foreach ($_POST['ProformaDetail'] as $line=>$item) {
                        if (!empty($item['itemModel'])){                            
                            $detail = new ProformaDetail;
                            $detail->invID = $model->invNo;
                            $detail->itemModel = $item['itemModel'];
                            $detail->itemDesc = $item['itemDesc'];
                            $detail->unitPrice = $item['unitPrice'];
                            $detail->unitQty = $item['unitQty'];

                            $valid = $detail->validate();
                            if ($valid) {
                                if (!$detail->save()){
                                    $transaction->rollBack();                        
                                }                                        
                            } else {
                                $transaction->rollBack();                            
                            }
                        }  
                    }                              
                }

                $transaction->commit();
            
            }catch (Exception $e) {
                $transaction->rollBack();
                throw new CHttpException(403, $e);
                Yii::app()->user->setFlash('Error', $e);
                //$this->redirect(array('formPP/index'));                            
            } 
            $this->redirect(array('indexPI',));
        }

        $this->render('createPI',array(
                'model'=>$model,
        ));
    }
    
    public function actionCreateAP()
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array(); 
        
        $model=new APInvoice;
        $model->items[] = new APDocument();
        $model->details[] = new APDetail();
        
        $this->performAjaxValidation($model);

        if(isset($_POST['APInvoice']))
        {
            $model->attributes=$_POST['APInvoice'];
            $model->recNo = Utility::getRecNo(); 
            $model->apSupplier=  $_POST['APInvoice']['apSupplier'];  
            $model->apDesc = $_POST['APInvoice']['apDesc'];
            $model->apInvTotal = str_replace(",","",$_POST['APInvoice']['apInvTotal']);
            $model->apInvTotalDetail=str_replace(",","",$_POST['APInvoice']['apInvTotalDetail']);
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();*/
            $isValid = $model->validate();    
               
            $transaction = Yii::app()->db->beginTransaction();
             
            try {                
               
                if ($isValid) {
                    if (!$model->save()){
                        $transaction->rollBack();                        
                    }                                        
                } else {
                    $transaction->rollBack();                            
                }
                
                if (isset($_POST['APDocument']) && is_array($_POST['APDocument'])) {                                             
                    foreach ($_POST['APDocument'] as $line=>$item) {
                        if (!empty($item['docID'])){                            
                            $detail = new APDocument;
                            $detail->recNo = $model->recNo;
                            $detail->docID = $item['docID'];
                            $detail->catID = $model->apInvCategory;
                            $detail->docValue = $item['docValue'];
                            $detail->descDoc = $item['descDoc'];
                            $valid = $detail->validate();
                            if ($valid) {
                                if (!$detail->save()){
                                    $transaction->rollBack();                        
                                }                                        
                            } else {
                                $transaction->rollBack();                            
                            }
                        }  
                    }                              
                }
                
                if (isset($_POST['APDetail']) && is_array($_POST['APDetail'])) {                                             
                    foreach ($_POST['APDetail'] as $line=>$item) {
                        if (!empty($item['apInvNo']))
                        {                            
                            $detail = new APDetail;
                            $detail->apInvoiceID = $model->recNo;
                            $detail->apInvNo = $item['apInvNo'];
                            $detail->apInvDate = $item['apInvDate'];
                            //$detail->apDueDate = $item['apDueDate'];
                            $detail->apInvTotal = str_replace(",","",$item['apInvTotal']);
                            $detail->rejected = $item['rejected'];
                            $detail->apInvDetDesc = $item['apInvDetDesc'];
                            $detail->poNo = '';
                            $detail->invStatus = 0;
                            $valid = $detail->validate();
                            
                            $log = new APLog();
                            $log->apInvNo = $item['apInvNo'];
                            $log->apLogDesc = 'Invoice diterima Finance';
                            $log->apLogNo = 0;
                            $valid = $log->validate();
                            $log->save();
                            
                            if ($valid) {
                                if (!$detail->save()){
                                    $transaction->rollBack();                        
                                }                                        
                            } else {

                                $transaction->rollBack();                            
                            }
                        }  
                    }                              
                }
                //exit();
                $transaction->commit();
            
            }catch (Exception $e) {
                
                throw new CHttpException(403, $e);
                $transaction->rollBack();
                //Yii::app()->user->setFlash('Error', $e);
                //$this->redirect(array('formPP/index'));                            
            } 
            $this->redirect(array('indexAP',));
        }

        $this->render('createAP',array(
                'model'=>$model,
        ));
    }

    public function actionAjax()
    {

        $id = isset($_GET['id']) ? $_GET['id'] : "";

        $connection=Yii::app()->db;

        $strCommand=" select rejected, apInvNo from  tr_apDetail where apInvNo='".$_GET['id']."' ";
        $command = $connection->createCommand($strCommand);
        $result = $command->queryAll();
        if (isset($result[0]) && $result[0]['rejected'] == '0'){
            echo "noalert";
        }
        else{
            if (sizeof($result)>0){

            echo "alert";
            
            }
        }
    }

    public function actionExportExcel()
    {
        $model=new APInvoice('search');
        $model->inputTime = new CDbExpression('getdate()');
        $model->attributes = $_POST['APInvoice'];
     

        $this->widget('ext.EExcelView', array(
            'title'=>'Daftar Project',
            'dataProvider' => $model->inkuiri("Debug"),
            //'filter'=>$model,
            'grid_mode'=>'export',
            'columns'=>array(
                array(
                    'header'=>'No. Invoice',                    
                    'value'=>'$data->dtApInvNo', 
                ),
                array(
                    'header'=>'Supplier',                    
                    'value'=>'$data->apSupplier', 
                ),
                array(
                    'header'=>'Tanggal Terima',              
                    'value'=>'date("d-m-Y",strtotime($data->recDateInvoice))',

                ),
                array(
                    'header'=>'Tanggal Invoice',                    
                    'value'=>'date("d-m-Y",strtotime($data->dtApInvDate))', 
                ),
                array(                    
                    'header'=>'No. Serah Terima',                    
                    'value'=>'$data->recNo',                    
                ),
                array(                    
                        'header'=>'No. FPP',                    
                        'value'=>'$data->fppID',                    
                    ), 
                array(                    
                        'header'=>'Status',
                        'value'=>'Utility::getApInvoiceStatus($data->fppStatus)',                    
                        //'value'=>'$data->fppStatus',                    
                    ), 
                array(
                    'name'=>'Total',
                    'type'=>'raw',
                    'value'=>'number_format($data->dtApInvTotal,0)',
                ),
                
            ),
        ));
    
    }

    public function actionCreateAPP()
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array(); 

        
        $model=new APInvoice;
        $model->items[] = new APDocument();
        $model->details[] = new APDetail();

        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDate();
        $model->recDateLong = $longDate;
        $model->recDate = $now;
        
        $this->performAjaxValidation($model);

        if(isset($_POST['APInvoice']))
        {
            $model->attributes=$_POST['APInvoice'];
            $model->recNo = Utility::getRecNo();     
            $model->apDesc = $_POST['APInvoice']['apDesc'];
           
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();*/
            
            //$model->apInvTotal = str_replace(",","",$_POST['APInvoice']['apInvTotal']);
            $isValid = $model->validate(); 


            $transaction = Yii::app()->db->beginTransaction();
             
            try {                
               
                if ($isValid) {
                    if (!$model->save()){
                        $transaction->rollBack();                        
                    }                                        
                } else {
                    $transaction->rollBack();                            
                }
                
                if (isset($_POST['APDocument']) && is_array($_POST['APDocument'])) {                                             
                    foreach ($_POST['APDocument'] as $line=>$item) {
                        if (!empty($item['docID'])){                            
                            $detail = new APDocument;
                            $detail->recNo = $model->recNo;
                            $detail->docID = $item['docID'];
                            $detail->catID = $model->apInvCategory;
                            $detail->docValue = $item['docValue'];
                            $valid = $detail->validate();
                            if ($valid) {
                                if (!$detail->save()){
                                    $transaction->rollBack();                        
                                }                                        
                            } else {
                                $transaction->rollBack();                            
                            }
                        }  
                    }                              
                }
                $connection=Yii::app()->db;
                if (isset($_POST['APDetail']) && count($_POST["APDetail"]) > 0) {                                             
                    foreach ($_POST['APDetail'] as $line=>$item) {
                        if (!empty($item['apInvNo'])){  

                            $value = explode(" -- " , $item['apInvNo']);                          
                            /*$detail = new APDetail;
                            $detail->apInvoiceID = $model->recNo;
                            $detail->apInvNo = $item['apInvNo'];
                            /*$detail->apInvDate = $item['apInvDate'];
                            $detail->apDueDate = $item['apDueDate'];
                            $detail->apInvTotal = $item['apInvTotal'];
                            $detail->poNo = '';
                            $detail->invStatus = 0;
                            $valid = $detail->validate();*/

                            $strCommand =" insert into tr_apDetail (apInvoiceID, apInvNo,apInvTotal, InvStatus, poNo, apInvDate) values ('".$model->recNo."','".$value[0]."','".$value[1]."','0','','".$value[5]."')
                                    ";

                            $command = $connection->createCommand($strCommand);
                            $command->execute();

                            $strCommand="update tr_apInvoice set apSupplier='".$value[2]."', apInvTotal='".$value[3]."' , recNoReff='".$value[4]."' where recNo='".$model->recNo."'";

                            $command = $connection->createCommand($strCommand);
                            $command->execute();

                            $strCommand="update tr_apInvoice2 set [status]='1' where recNo=(select recNoReff from tr_apInvoice where recNo='".$model->recNo."')";

                            $command = $connection->createCommand($strCommand);
                            $command->execute();
                            
                            $log = new APLog();
                            $log->apInvNo = $value[0];
                            $log->apLogDesc = 'Invoice diterima Finance';
                            $log->apLogNo = 0;
                            $valid = $log->validate();
                            $log->save();

                            /*echo "<pre>";
                            print_r($_POST);
                            echo "</pre>";
                            exit();*/
                            
                            if ($valid) {
                                if (!$detail->save()){
                                    $transaction->rollBack();                        
                                }                                        
                            } else {

                                $transaction->rollBack();                            
                            }
                        }  
                    }                              
                }
                //exit();
                $transaction->commit();
            
            }catch (Exception $e) {
                
                throw new CHttpException(403, $e);
                $transaction->rollBack();
                //Yii::app()->user->setFlash('Error', $e);
                //$this->redirect(array('formPP/index'));                            
            } 
            $this->redirect(array('indexAP',));
        }

        $this->render('createAPP',array(
                'model'=>$model,
        ));
    }
    
    
    public function actionUpdateAP($id)
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array(); 
        
        $model = APInvoice::model()->findByAttributes(array('apInvID'=>$id));        
        $model->items = APDocument::model()->findAllByAttributes(array('recNo'=>$model->recNo));
        $model->details = APDetail::model()->findAllByAttributes(array('apInvoiceID'=>$model->recNo));
        $this->performAjaxValidation($model);

        if(isset($_POST['APInvoice']))
        {
            $model->attributes=$_POST['APInvoice'];
            //$model->recNo = Utility::getRecNo();       
            $model->apDesc = $_POST['APInvoice']['apDesc'];
            $model->apInvTotal = str_replace(",","",$_POST['APInvoice']['apInvTotal']);
            $model->apInvTotalDetail=str_replace(",","",$_POST['APInvoice']['apInvTotalDetail']);

            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();*/
            $isValid = $model->validate();    
               
            $transaction = Yii::app()->db->beginTransaction();
             
            try {                
               
                $model->save();                        

                if (isset($_POST['APDocument']) && is_array($_POST['APDocument'])) {                                                                 
                    APDocument::model()->deleteAll('recNo=:recNo', array(':recNo'=>$model->recNo));                    
                    foreach ($_POST['APDocument'] as $line=>$item) {
                        if (!empty($item['docID'])){                            
                            $detail = new APDocument;
                            $detail->recNo = $model->recNo;
                            $detail->docID = $item['docID'];
                            $detail->catID = $model->apInvCategory;
                            $detail->docValue = $item['docValue'];
                            $detail->descDoc = $item['descDoc'];
                           
                            $valid = $detail->validate();
                            $detail->save();
                        }  
                    }                              
                }
                
                if (isset($_POST['APDetail']) && is_array($_POST['APDetail'])) {                     
                    APDetail::model()->deleteAll('apInvoiceID=:recNo', array(':recNo'=>$model->recNo));                                        
                    foreach ($_POST['APDetail'] as $line=>$item) {
                        if (!empty($item['apInvNo'])){                            
                            $detail = new APDetail;
                            $detail->apInvoiceID = $model->recNo;
                            $detail->apInvNo = $item['apInvNo'];
                            $detail->apInvDate = $item['apInvDate'];
                            //$detail->apDueDate = $item['apDueDate'];
                            $detail->apInvTotal = str_replace(",","",$item['apInvTotal']);
                            $detail->rejected = $item['rejected'];
                            $detail->apInvDetDesc = $item['apInvDetDesc'];
                            $detail->poNo = '';
                            $detail->invStatus = 0;
                            $valid = $detail->validate();
                           
                            $detail->save();
                            
                            $log = new APLog();
                            $log->apInvNo = $item['apInvNo'];
                            $log->apLogDesc = 'Invoice diterima Finance';
                            $log->apLogNo = 0;
                            $valid = $log->validate();
                            $log->save();
                        }  
                    }                              
                }
                
                //exit();
                $transaction->commit();
            
            }catch (Exception $e) {
                
                throw new CHttpException(403, $e);
                $transaction->rollBack();
                //Yii::app()->user->setFlash('Error', $e);
                //$this->redirect(array('formPP/index'));                            
            } 
            $this->redirect(array('viewAP','id'=>$model->apInvID));
        }

        $this->render('createAP',array(
                'model'=>$model,
        ));
    }

    public function actionVerified($id)
    {
        $connection=Yii::app()->db;

        $detail = APInvoice::model()->findByAttributes(array('apInvID'=>$id));
        $strCommand=" update tr_apInvoice set [status]=1 where apInvID='".$id."' ";
        $command = $connection->createCommand($strCommand);
        $command->execute();

        $this->redirect(array('invoice/indexAP'));
    }
    
    public function actionApproval()                               
    {   
        $mode = '';
        if(isset($_POST['ProformaInvoice']))
        {
            $invID = $_POST['ProformaInvoice']['invID'];
            $status = $_POST['ProformaInvoice']['status'];
            $mode = 'ajax';
        } else
        {
            $invID = Yii::app()->getRequest()->getQuery('invID');
            $status = Yii::app()->getRequest()->getQuery('status');
            $mode = 'non-ajax';
        }
        
        if(isset($invID))
        {
            if($status === "verified")
            {
                // cari yang statusnya entry
                $model = ProformaInvoice::model()->findByAttributes(array('invID'=>$invID ,'status'=>0));                
                $model->status = 1;
                if($model->save())
                {
                    $this->kirimEmail($invID);
                    if($mode==='ajax')
                    {
                        exit(json_encode(array('result' => 'success', 'msg' => "Verified", "invNo" => $model->invNo)));
                    }else
                    {
                        $this->render('approval',array(
                            'model'=>$model,
                        ));
                        exit();
                    }                    
                }                               
            }
            elseif($status === "signed")
            {
                // cari yang statusnya verified
                $model = ProformaInvoice::model()->findByAttributes(array('invID'=>$invID ,'status'=>1));
                $model->status = 2;
                if($model->save())
                {
                    $this->kirimEmail($invID);
                    if($mode==='ajax')
                    {
                        exit(json_encode(array('result' => 'success', 'msg' => "Signed", "invNo" => $model->invNo)));
                    }else
                    {
                        $this->render('approval',array(
                            'model'=>$model,
                        ));
                        exit();
                    }
                    //exit(json_encode(array('result' => 'success', 'msg' => "Signed", "invNo" => $model->invNo)));
                }   
            }
        }
    }  
        
    public function actionUpdateDelegation($id)
    {
        $detail = APDetail::model()->findByAttributes(array('apDetailID'=>$id ));
        $log = new APLog;
        
        $approval = APLog::model()->findBySql("select top 1 *
                    from FPP..tr_apLog 
                    where apInvNo = '".$detail->apInvNo."'
                    order by inputTime desc ");  
        
        if($approval->apLogNo == 0) //
        {
            $detail->invStatus = 1;
            $log->apInvNo = $detail->apInvNo;
            $log->apLogNo = 1;
            $log->apLogDesc = 'Invoice diterima User';
            $log->apLogReason = '';
            
        }
        if($approval->apLogNo == 2)
        {
            $detail->invStatus = 3;
            $log->apInvNo = $detail->apInvNo;
            $log->apLogNo = 3;
            $log->apLogDesc = 'Invoice diterima Accounting';
            $log->apLogReason = '';
        }
        if($approval->apLogNo == 4)
        {
            $detail->invStatus = 6;
            $log->apInvNo = $detail->apInvNo;
            $log->apLogNo = 6;
            $log->apLogDesc = 'Pembayaran oleh Finance';
            $log->apLogReason = '';
        }
        if($approval->apLogNo == 5)
        {
            $detail->invStatus = 1;
            $log->apInvNo = $detail->apInvNo;
            $log->apLogNo = 1;
            $log->apLogDesc = 'Invoice diterima User';
            $log->apLogReason = '';
        }
        
        $log->save();
        $detail->save();
        
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
       
        $this->redirect(array('invoice/logbook'));
    }
        
    public function actionCancelPKP($id)
    {                                          
        $model = PotKP::model()->getPKP($id);
        
        $model->pkpValue = number_format($model->pkpValue,0);
        
        if(isset($_POST['PotKP']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $update = PotKP::model()->findByAttributes(array('id'=>$id));
                $update->tmpPKPValue = $update->pkpValue;
                $update->tmpPKPValueWtx = $update->pkpValueWtx ;
                $update->pkpValue = 0;
                $update->pkpValueWtx = 0;
                $update->cancelReason = $_POST['PotKP']['cancelReason'];
                $update->save();
                        
                $transaction->commit();
                if (!empty($_GET['asDialog']))
                {                       
                    echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
                    Yii::app()->end();
                }
                else                        
                $this->redirect(array('index'));
            }
            catch(Exception $e) 
            { 
               $transaction->rollBack(); 
               throw new CHttpException(403,$e);
            }
        }

        if (!empty($_GET['asDialog']))
        {
            $this->layout = '//layouts/iframex';
            $this->render('cancelPKP',array('model'=>$model,));
        }
        else
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

    }
    
    public function actionReturPKP($id)
    {                                          
        $model = pkpAllocated::model()->getAllocated($id);
        
        $model->value = number_format($model->value,0);
        if(isset($_POST['pkpAllocated']))
        {
            $transaction = Yii::app()->dbAccpac->beginTransaction();
            try
            {
                $connection=Yii::app()->dbAccpac;                
                $strCommand = "update SGTDAT..MIS_PKP_ALLOCATE set pkpAllocated = 0 where invNumber = '".$id."'";
                
                $command = $connection->createCommand($strCommand);
                $command->execute();
                
                $transaction->commit();
                if (!empty($_GET['asDialog']))
                {                       
                    echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
                    Yii::app()->end();
                }
                else                        
                $this->redirect(array('index'));
            }
            catch(Exception $e) 
            { 
               $transaction->rollBack(); 
               throw new CHttpException(403,$e);
            }
        }

        if (!empty($_GET['asDialog']))
        {
            $this->layout = '//layouts/iframex';
            $this->render('returPKP',array('model'=>$model,));
        }
        else
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionUpdateDept($id)
    {                                          
        $model = APDetail::model()->findByAttributes(array('apDetailID'=>$id));

        if(isset($_POST['APDetail']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $model->deptID = $_POST['APDetail']['deptID'];
                $model->save();
                
                $transaction->commit();
                if (!empty($_GET['asDialog']))
                {                       
                    echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
                    Yii::app()->end();
                }
            }
            catch(Exception $e) 
            { 
               $transaction->rollBack(); 
               throw new CHttpException(403,$e);
            }
        }

        if (!empty($_GET['asDialog']))
        {
            $this->layout = '//layouts/iframex';
            $this->render('updateDept',array('model'=>$model,false,true));
        }
        else
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionViewLogbook($id)
    {                                          
        $model = new apLog('search');
        $this->layout = '//layouts/iframex';
        
        $model->unsetAttributes(); 
        $model->apInvNo = $id;
        if(isset($_GET['apLog']))
        {
            $model->attributes=$_GET['apLog'];
        }
            
        
        $this->render('viewLogbook',array(
                'model'=>$model,
        ));
    }

    public function actionLogbookInvoice()
    {       
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array();        
        
        $model=new APInvoice('invoice_terima');
        $model2=new APInvoice('invoice_tolak');
        
        $this->render('logbookInvoice',array(
                'model'=>$model, 'model2' => $model2
        ));
    }

    //untuk modul jatuh tempo
    public function actionIndexJT()
    {       
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array();        
        
        $model=new APJatuhTempo('search');
        
        $model->unsetAttributes(); 
        if(isset($_GET['APJatuhTempo']))
        {
            $model->attributes=$_GET['APJatuhTempo'];
        }
            

        $this->render('indexJT',array(
                'model'=>$model,
        ));
    }

    public function convert_to_number($rupiah)
    {
           return floatval(preg_replace('/,.*|[^0-9]/', '', $rupiah));

    }

    public function actionCreateJT()
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array(); 
        
        $model = new APJatuhTempo;        

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['APJatuhTempo']))
        {
            $model->attributes=$_POST['APJatuhTempo'];
            $model->utang_nilai=$this->convert_to_number($model->utang_nilai);
            $model->utang_outstanding=$this->convert_to_number($model->utang_outstanding);

            $model->validate();

            /*echo "<pre>";
            print_r($model);
            echo "</pre>";
            exit(); */

            if($model->validate())
            {
                if($model->save())
                {
                    $this->redirect(array('indexJT'));
                }
            }                
        }

        $this->render('createJT',array(
            'model'=>$model,
        ));

    }

    public function convert_dots($angka)
    {
            return strrev(implode('.',str_split(strrev($angka),3)));
            //return str_replace(".", "", $angka);
    }



    public function actionUpdateJT ($id)
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array(); 

        $model = APJatuhTempo::model()->findByAttributes(array('utang_id'=>$id)); 
        $model->utang_nilai=$this->convert_dots($model->utang_nilai); 
        $model->utang_outstanding=$this->convert_dots($model->utang_outstanding); 

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['APJatuhTempo']))
        {

            $model->attributes=$_POST['APJatuhTempo'];
            $model->utang_nilai=$this->convert_to_number($model->utang_nilai);
            $model->utang_outstanding=$this->convert_to_number($model->utang_outstanding);
            $model->validate();

            /*echo "<pre>";
            print_r($model);
            echo "</pre>";
            exit(); */
 
            if($model->validate())
            {
                if($model->save())
                {
                    $this->redirect(array('indexJT'));
                }
            }                
        }

        $this->render('updateJT',array(
            'model'=>$model,
        ));

    }

    public function actionViewJT($id)
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.APMenu'] = array();

        $model = APJatuhTempo::model()->findByAttributes(array('utang_id'=>$id));
        
        $this->render('viewJT',array(
                    'model'=>$model,
        ));
    }

    public function actionDelete($id)
    {
        
        $this->loadModel($id)->delete();

        if(!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
       
    }

    public function loadModel($id)
    {
        $model=APJatuhTempo::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
    protected function performAjaxValidation($model)
    {
            if(isset($_POST['ajax']) && $_POST['ajax']==='inv-header-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }
}