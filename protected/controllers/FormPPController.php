<?php

class FormPPController extends Controller
{
    
	public $layout='leftbar';
        public $pathEmail = 'http://apache-indomo/dev/fpp/index.php/en/site/approval?';
        public $pathView = 'http://apache-indomo/dev/fpp/index.php/en/formPP/viewAccounting?';
        
        function init() {
            parent::init();
            $this->leftPortlets['ptl.FPPMenu'] = array();
        }
    
        public function filters()
	{
            return array(
                'Rights',
            );
	}
  
        public function allowedActions()
        {
            return 'approval, viewFinance, sendMail, viewDetail';
        }
        
	public function actionView($id)
	{
            $model = FppHeader::model()->getHeader($id);                                          
            $detail = FppDetail::model()->getFppDetail($model->fppNo);  
            $total = FppDetail::model()->getDetailTotal($model->fppNo);
            $approval = FppApproval::model()->getApprovalList($model->fppNo);
            
            $this->render('view',array(
                    'model'=>$model,
                    'detail'=>$detail,
                    'total'=>$total,
                    'approval'=>$approval,
            ));
	}
        
        public function actionViewFPP($id)
	{
            $this->leftPortlets = array();
            $this->leftPortlets['ptl.APMenu'] = array(); 
            
            $model = FppHeader::model()->getHeaderFPP($id);  
            $detail = FppDetail::model()->getFppDetail($model->fppNo);  
            $total = FppDetail::model()->getDetailTotal($model->fppNo);
            $approval = FppApproval::model()->getApprovalList($model->fppNo);
            
            $this->render('viewFPP',array(
                    'model'=>$model,
                    'detail'=>$detail,
                    'total'=>$total,
                    'approval'=>$approval,
            ));
	}

        public function actionViewDetail($id)
	{
            $this->leftPortlets = array();
            $this->leftPortlets['ptl.FppMenu'] = array(); 
            
            $model = FppHeader::model()->findByAttributes(array('fppID'=>$id));

            $rqnHeader = PurchReq::model()->getHeader($model->fppCategoryValue);            
            $rqnDetail = PurchReqDetail::model()->getDetail($model->fppCategoryValue);
                        
            $this->render('viewDetail',array(
                    'header'=>$rqnHeader,
                    'detail'=>$rqnDetail,                    
            ));
	}

	public function actionCreate()
	{
		$model=new FppHeader;
        $detail = new FppDetail;
        $approval = new FppApproval;
        
        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDate();
        
        $model->fppUser = $employee->idCard;
        $model->fppUserName = $employee->userName;
        $model->fppUserDeptName = $employee->nameDept." - ".$employee->nameBranch;
        $model->fppUserDept = $employee->idDept;
        $model->fppUserDate = $now;
        $model->fppUserDateLong = $longDate;
        $model->fppCategory = 'KK';
        $model->fppCategoryDesc = 'Kas Kecil';
        $limit  = User::model()->findByAttributes(array("userid"=>Yii::app()->user->getState('usrid')))->limitKredit;            
        $model->fppLimit = $limit ;
        $model->limit = number_format($limit,0);
                
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['FppHeader']))
		{
                    $model->attributes=$_POST['FppHeader'];
                    $model->fppNo = Utility::getFppNo();
                    $isValid = $model->validate();    
                    $isOverLimit = false;
                    $urutan = 0;
                    
                    $limit = $_POST['FppHeader']['fppLimit'];
                    $total = $_POST['FppHeader']['fppCash'] + $_POST['FppHeader']['fppTotal'] + $_POST['FppHeader']['fppSaldo']+ $_POST['FppHeader']['fppOutstanding'];;
                    if($total>$limit)
                    {
                        $isOverLimit = true;
                    }
                    
                    //pengajuan
                    $approval->fppID = $model->fppNo;
                    $approval->pic = $model->fppUser;
                    $approval->tanggal = $model->fppUserDate;
                    $approval->persetujuan = 1;
                    $approval->urutan = $urutan;
                    $approval->aktif = 1;
                    $approval->keterangan = 'Pengajuan FPP';
                    $approval->an = '';
                    $approval->keterangan2 = 'Pengajuan FPP :';
                    
                    
                    $rows = 0;
                    if ($isValid) {                        
                        $transaction = Yii::app()->db->beginTransaction();                        
                        try {
                            $approval->save();
                            // approval depthead atau bm
                            $urutan = $urutan + 1;
                            $approval = new FppApproval;                                    
                            $approval->fppID = $model->fppNo;
                            $approval->pic = Utility::getDeptHead($model->fppUser) ;
                            $approval->tanggal = new CDbExpression('NULL'); 
                            $approval->persetujuan = new CDbExpression('NULL'); 
                            $approval->urutan = $urutan;
                            $approval->aktif = 0;
                            $approval->keterangan = 'DEPTHEAD-BM';
                            $approval->an = '';
                            $approval->keterangan2 = 'Ka. Dept / BM :';
                            
                            $approval->save();
                            
                            if($isOverLimit)
                            {
                                //fin Dept Head kalau overlimit
                                $urutan = $urutan + 1;
                                $approval = new FppApproval;                                    
                                $approval->fppID = $model->fppNo;
                                $approval->pic = Utility::getPIC("FinDeptHead") ;
                                $approval->tanggal = new CDbExpression('NULL'); ;
                                $approval->persetujuan = new CDbExpression('NULL'); 
                                $approval->urutan = $urutan;
                                $approval->aktif = 0;
                                $approval->keterangan = 'Finance Dept Head';
                                $approval->an = '';
                                $approval->keterangan2 = 'Ka. Finance Dept :';

                                $approval->save();
                            }    

                            //Finance I
                            $urutan = $urutan + 1;
                            $approval = new FppApproval;                                    
                            $approval->fppID = $model->fppNo;
                            $approval->pic = Utility::getPIC("FinAdmin") ;
                            $approval->tanggal = new CDbExpression('NULL'); ;
                            $approval->persetujuan = new CDbExpression('NULL'); ;
                            $approval->urutan = $urutan;
                            $approval->aktif = 0;
                            $approval->keterangan = 'Finance I';
                            $approval->an = '';
                            $approval->keterangan2 = 'Finance :';

                            $approval->save();

                            //Acct I
                            $urutan = $urutan + 1;
                            $approval = new FppApproval;                                    
                            $approval->fppID = $model->fppNo;
                            $approval->pic = '';
                            $approval->tanggal = new CDbExpression('NULL'); ;
                            $approval->persetujuan = new CDbExpression('NULL'); ;
                            $approval->urutan = $urutan;
                            $approval->aktif = 0;
                            $approval->keterangan = 'Accounting';
                            $approval->an = '';
                            $approval->keterangan2 = 'Accounting :';

                            $approval->save();                                                       
                            
                            if (isset($_POST['FppDetail']) && is_array($_POST['FppDetail'])) {
                                $model->save();                                 
                                foreach ($_POST['FppDetail'] as $line=>$item) {
                                    if (!empty($item['fppDetailValue']) || intval($item['fppDetailValue']) !==0){
                                        $rows = $rows + 1;
                                        $detail = new FppDetail;
                                        $detail->fppID = $model->fppNo;
                                        $detail->fppDesc = $item['fppDesc'];
                                        $detail->fppDetailValue = $item['fppDetailValue'];

                                        $valid = $detail->validate();
                                        if ($valid) {
                                            if (!$detail->save()){
                                                $transaction->rollBack();
                                                Yii::app()->user->setFlash('Error', CHtml::errorSummary($detail));
                                                exit();
                                            }
                                        } else {
                                                Yii::app()->user->setFlash('Error', CHtml::errorSummary($detail));
                                                exit();                                            }
                                    }
                                }                                
                            }
                            if($rows==0)
                            {
                                $transaction->rollBack();
                                //throw new CHttpException(403, $e);
                                Yii::app()->user->setFlash('Gagal', "Permohonan gagal dikirim!");
                                $this->redirect(array('formPP/index'));
                            }
                            else
                            {
                                $transaction->commit();
                                $newID = FppHeader::model()->findByAttributes(array('fppNo'=>$model->fppNo))->fppID;
                                //exit(json_encode(array('result' => 'success', 'msg' => 'Your data has been successfully saved')));
                                Yii::app()->user->setFlash('Berhasil', "Permohonan berhasil dikirim!");
                                $email = $this->kirimEmail($newID);
                                //$this->redirect(array('mail', 'id'=>$newID));
                                if($email)
                                {
                                    $this->redirect(array('index'));
                                }
                                
                            }
                        }catch (Exception $e) {
                            $transaction->rollBack();
                            throw new CHttpException(403, $e);
                            Yii::app()->user->setFlash('Error', $e);
                            $this->redirect(array('formPP/index'));                            
                        }
                    }
		}

		$this->render('create',array(
			'model'=>$model,
                        'detail'=>$detail,
		));
	} 
        
        public function actionExecFPP($id)
        {
            $model = FppHeader::model()->getHeaderFpp($id);
            
            $model->fppUser = $model->fppNo." - ".$model->fppUserName;
            $model->fppToBank = $model->fppToBank." - ".$model->fppToBankAcc;
            $model->desc = $model->apInvNo . " ( " . $model->apSupplier . " )";
            $model->TOTAL = number_format($model->TOTAL,0);
            
            if(isset($_POST['FppHeader']))
            {
                $model->attributes=$_POST['FppHeader'];
                $transaction = Yii::app()->db->beginTransaction();
                try
                {            
                    $verified = $_POST['FppHeader']['optVeri'];
                    $reason = $_POST['FppHeader']['reason'];
                    $approval = FppHeader::model()->findByAttributes(array('fppID'=>$id ));
                    $connection=Yii::app()->db; 
                    $username = Yii::app()->user->name;
                     
                    if($verified == 1)
                    {
                        $approval->fppStatus = 7;     
                        $strCommand = "update tr_apDetail set invStatus = 7
                                        where apInvNo in (select fppInvNo from tr_fppDetail 
                                                where fppID in (select fppNo from tr_fppHeader 
                                                        where fppID = '".$id."'))";                
                        $command = $connection->createCommand($strCommand);
                        $command->execute();      

                        $strCommand = " 
                            insert into tr_apLog (apInvNo, apLogNo, apLogDesc, apLogReason, inputUN, inputTime, modifUN, modifTime)			
                            select fppInvNo, 7, 'Pembayaran telah dilakukan oleh Finance', '', '".$username."', GETDATE(), '".$username."', GETDATE() from tr_fppDetail 
                                    where fppID in (select fppNo from tr_fppHeader 
                                            where fppID = '".$id."')
                                        ";                
                        $command = $connection->createCommand($strCommand);
                        $command->execute();                          
                    } else {
                        $approval->fppStatus = 8;     
                        $strCommand = "update tr_apDetail set invStatus = 8
                                        where apInvNo in (select fppInvNo from tr_fppDetail 
                                                where fppID in (select fppNo from tr_fppHeader 
                                                        where fppID = '".$id."'))";                
                        $command = $connection->createCommand($strCommand);
                        $command->execute();      

                        $strCommand = " 
                            insert into tr_apLog (apInvNo, apLogNo, apLogDesc, apLogReason, inputUN, inputTime, modifUN, modifTime)			
                            select fppInvNo, 8, 'FPP memerlukan revisi', '".$reason."', '".$username."', GETDATE(), '".$username."', GETDATE() from tr_fppDetail 
                                    where fppID in (select fppNo from tr_fppHeader 
                                            where fppID = '".$id."')
                                        ";                
                        $command = $connection->createCommand($strCommand);
                        $command->execute();   
                    }
                                                           
                    $approval->save();
                    
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
                $this->render('execVerifikasi',array('approval'=>$model,));
            }
            else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

        }
        
        public function actionCreateFPP()
        {
            $this->leftPortlets = array();
            $this->leftPortlets['ptl.APMenu'] = array(); 

            $model=new FppHeader;
            $model->items[] = new FppDetail();
            //$approval = new FppApproval;

            $employee = Employee::model()->getActiveEmployee();
            $now = date("Y-m-d H:i:s");
            $longDate = Utility::getLongDate();
                
            $model->fppUser = $employee->idCard;
            $model->fppUserName = $employee->userName;
            $model->fppUserDeptName = $employee->nameDept." - ".$employee->nameBranch;
            $model->fppUserDept = $employee->idDept;
            $model->fppUserDate = $now;
            $model->fppUserDateLong = $longDate;
            $model->fppCategory = 'AP';
            $model->fppCategoryDesc = 'AP Invoice';            
            $model->fppCategoryValue = '--';
            $model->fppLimit = 0;
            $model->limit = 0;

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['FppHeader']))
            {
                $model->attributes=$_POST['FppHeader'];
                $model->fppNo = Utility::getFppNoTR();                
                $model->fppStatus = 2;
                
                $transaction = Yii::app()->db->beginTransaction();
                try {       
                    
                    if (isset($_POST['FppDetail']) && is_array($_POST['FppDetail']))
                    {

                        foreach ($_POST['FppDetail'] as $line=>$item) {
                            if (!empty($item['fppDesc']))
                            {                            
                                $detail = new FppDetail;
                                $detail->fppID = $model->fppNo;
                                $detail->fppDesc = $item['fppDesc'];
                                $detail->fppDetailValue = $item['fppDetailValue'];
                                $detail->fppInvNo = $item['fppInvNo'];
                                
                                $log = new APLog();
                                $log->apInvNo = $item['fppInvNo'];
                                $log->apLogDesc = 'FPP';
                                $log->apLogNo = 2;
                                
                                $det = APDetail::model()->findByAttributes(array('apInvNo'=>$item['fppInvNo'] ));
                                $det->invStatus = 2;
                                
                                $valid = $log->validate();
                                if ($valid) {
                                    if ( !$log->save() ){
                                        $transaction->rollBack();                        
                                    }                                        
                                } else {
                                    $transaction->rollBack();                            
                                }
                                
                                $valid = $det->validate();
                                if ($valid) {
                                    if ( !$det->save() ){
                                        $transaction->rollBack();                        
                                    }                                        
                                } else {
                                    $transaction->rollBack();                            
                                }
                                
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
                                              
                    $valid = $model->validate(); 
                    
                    if ($valid) {
                        if ( !$model->save() ){
                            $transaction->rollBack();                        
                        }                                           
                    } else {
                        $transaction->rollBack();                            
                    } 
                    
                    $transaction->commit();
                    $this->redirect(array('indexFPP',));
                }catch (Exception $e) {
                    $transaction->rollBack();
                    throw new CHttpException(403, $e);
                    //Yii::app()->user->setFlash('Error', $e);
                    //$this->redirect(array('formPP/index'));                            
                } 
            }

            $this->render('createFPP',array(
                    'model'=>$model,
            ));
        }
    
        public function actionUpdateFPP($id)
        {
            $this->leftPortlets = array();
            $this->leftPortlets['ptl.APMenu'] = array(); 

            $model=new FppHeader;
            $model->items[] = new FppDetail();
            
            $model = FppHeader::model()->findByAttributes(array('fppID'=>$id));        
            $model->items = FppDetail::model()->findAllByAttributes(array('fppID'=>$model->fppNo));
            //$approval = new FppApproval;

            $employee = Employee::model()->getActiveEmployee();
            $now = date("Y-m-d H:i:s");
            $longDate = Utility::getLongDate();
                
            $model->fppUser = $employee->idCard;
            $model->fppUserName = $employee->userName;
            $model->fppUserDeptName = $employee->nameDept." - ".$employee->nameBranch;
            $model->fppUserDept = $employee->idDept;
            $model->fppUserDate = $now;
            $model->fppUserDateLong = $longDate;
            $model->fppCategory = 'AP';
            $model->fppCategoryDesc = 'AP Invoice';            
            $model->fppCategoryValue = '--';
            $model->fppLimit = 0;
            $model->limit = 0;

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);

            if(isset($_POST['FppHeader']))
            {
                $status ;
                $model->attributes=$_POST['FppHeader'];
                //$model->fppNo = Utility::getFppNoTR(); 
                if($model->fppStatus == 1 || $model->fppStatus == 2)
                {
                    $status = $model->fppStatus = 2;
                } else if ($model->fppStatus == 9) {
                    $status = $model->fppStatus = 10;
                }
                
                
                $transaction = Yii::app()->db->beginTransaction();
                try {       
                    FppDetail::model()->deleteAll('fppID=:fppID', array(':fppID'=>$model->fppNo));                    
                    if (isset($_POST['FppDetail']) && is_array($_POST['FppDetail'])) {

                        foreach ($_POST['FppDetail'] as $line=>$item) {
                            if (!empty($item['fppDesc'])){                            
                                $detail = new FppDetail;
                                $detail->fppID = $model->fppNo;
                                $detail->fppDesc = $item['fppDesc'];
                                $detail->fppDetailValue = $item['fppDetailValue'];
                                $detail->fppInvNo = $item['fppInvNo'];
                                
                                $log = new APLog();
                                $log->apInvNo = $item['fppInvNo'];
                                $log->apLogDesc = 'FPP';
                                $log->apLogNo = $status;
                                
                                $det = APDetail::model()->findByAttributes(array('apInvNo'=>$item['fppInvNo'] ));
                                $det->invStatus = $status;
                                
                                $valid = $log->validate();
                                if ($valid) {
                                    if ( !$log->save() ){
                                        $transaction->rollBack();                        
                                    }                                        
                                } else {
                                    $transaction->rollBack();                            
                                }
                                
                                $valid = $det->validate();
                                if ($valid) {
                                    if ( !$det->save() ){
                                        $transaction->rollBack();                        
                                    }                                        
                                } else {
                                    $transaction->rollBack();                            
                                }
                                
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
                                              
                    $valid = $model->validate(); 
                    
                    if ($valid) {
                        if ( !$model->save() ){
                            $transaction->rollBack();                        
                        }                                        
                    } else {
                        $transaction->rollBack();                            
                    } 
                    
                    $transaction->commit();
                    $this->redirect(array('indexFPP',));
                }catch (Exception $e) {
                    $transaction->rollBack();
                    throw new CHttpException(403, $e);
                    //Yii::app()->user->setFlash('Error', $e);
                    //$this->redirect(array('formPP/index'));                            
                } 
            }

            $this->render('createFPP',array(
                    'model'=>$model,
            ));
        }
        
        public function actionSendMail($id)
        {
            $fppID = FppHeader::model()->findByAttributes(array('fppNo'=>$id))->fppID;
            
            $kirim = $this->kirimEmail($fppID);
            if($kirim)
            {
                echo "Email dikirim";
            }
            else
            {
                echo "Gagal kirim";
            }
        }
        
        public function kirimEmail($id)
        {
            $ret =false;
            
            $model = FppHeader::model()->findByAttributes(array('fppID'=>$id));             
            $fppDetail = FppDetail::model()->findAllByAttributes(array('fppID'=>$model->fppNo));
            $approval = FppApproval::model()->findBySql("select top 1 *
                        from FPP..tr_fppApproval 
                        where persetujuan is null and fppID = '".$model->fppNo."'
                        order by urutan");       
            $fppApproval = FppApproval::model()->findAll(array('order'=>'urutan', 'condition'=>'fppID=:fppID and urutan <> 0', 'params'=>array(':fppID'=>$model->fppNo)));
            $TOTAL = FppDetail::model()->findBySql("select abs(sum(fppDetailValue)) as TOTAL from tr_fppDetail where fppID = '".$model->fppNo."'");
            $users = Employee::model()->findByAttributes(array('idCard'=>$model->fppUser));
            
            if(isset($users))
            {
                $userName = Employee::model()->findByAttributes(array('idCard'=>$model->fppUser))->userName;
            }
            else
            {
                $userName = Utility::getInactiveEmployee($model->fppUser); 
            }
            
            
            $dept = FppHeader::model()->findBySql("select nameDept + ' - ' + nameDiv + ' / ' + nameBranch fppUserDeptName
                                                    from vwEmployee where idCard = '".$model->fppUser."'");
            
            if(isset($approval->pic))
            {
                if($approval->pic !== "")
                {
                    $to[0] = Employee::model()->findByAttributes(array("idCard"=>$approval->pic))->email;            
                }
                else
                {
                    $to[0] =  Employee::model()->findByAttributes(array("idCard"=>Utility::getPIC("AcctAdmin")))->email;             
                }
            }
            else
            {
                $to[0] = "";
            }
            
            //$to = array("fajar.pratama@modena.co.id");
            $cc = '';
//            if(isset($approval->keterangan))
//            {
//                if($approval->keterangan === "Finance I" ||  $approval->keterangan === "Finance II")
//                {
//                    $cc[0] = Employee::model()->findByAttributes(array("idCard"=>Utility::getPIC("FinAdmin")))->email;             
//                }
//            }
            
            $bcc = array('fajar.pratama@modena.co.id','irfan.dadi@modena.co.id');
            

//            $modeyes = $this->pathEmail."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=1&jp=".$approval["keterangan"];
            $modeyes = $this->createAbsoluteUrl("formPP/approval", array("fppID"=>$model->fppID,"pic"=>$approval["pic"],"mode"=>1, "jp"=>$approval["keterangan"])) ; //."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=1&jp=".$approval["keterangan"];
//            $modeno = $this->pathEmail."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=0&jp=".$approval["keterangan"];
            $modeno = $this->createAbsoluteUrl("formPP/approval", array("fppID"=>$model->fppID,"pic"=>$approval["pic"],"mode"=>0, "jp"=>$approval["keterangan"])) ; //."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=1&jp=".$approval["keterangan"];
//            $link = $this->pathView."id=".$model->fppID;
            $link = $this->createAbsoluteUrl('formPP/viewAccounting',array("id"=>$model->fppID)) ;//."id=".$model->fppID;
            $subject ="[FPP Online :: Persetujuan Pengajuan] :: No. ".$model->fppNo." a/n ".$userName;                                                     
            $content = '';
            
            if($approval['keterangan']=="Accounting" && $approval['pic']=="" )
            {
                //template accounting 1
                $message = $this->mailTemplate(2);                            
                $message = str_replace("#link#", $link, $message);
            }
            elseif($approval['keterangan']=="Finance II" || $approval['keterangan']=="Finance III" || $approval['keterangan']=="DIVHEAD" ){
                //setelah accounting
                $subject ="[FPP Online :: Proses Bayar] :: No. ".$model->fppNo." a/n ".$userName; 
                $message = $this->mailTemplate(4);                            
                $message = str_replace("#link#", $modeyes, $message);
            }
            else
            {
                //template umum
                $message = $this->mailTemplate(1);
                $message = str_replace("#pathyes#", $modeyes, $message);
                $message = str_replace("#pathno#", $modeno, $message);
            }
           
            $message = str_replace("#NomorKasbon#", $model->fppNo, $message);
            $message = str_replace("#NamaPemohon#", $userName, $message);
            $message = str_replace("#Dept#", $dept['fppUserDeptName'], $message);
            $message = str_replace("#Tanggal#", date("d-m-Y", strtotime($model->fppUserDate)), $message);
            $message = str_replace("#Penerima#", $model->fppToName, $message);
            $message = str_replace("#Bank#", $model->fppToBank, $message);
            $message = str_replace("#No.Rekening#", $model->fppToBankAcc, $message);
            $message = str_replace("#TanggalDibutuhkan#", date("d-m-Y", strtotime($model->fppToDate)), $message);
            $message = str_replace("#TotalKasbon#", number_format($TOTAL["TOTAL"],0), $message);
            $message = str_replace("#Limit#", number_format($model->fppLimit,0), $message);
            $message = str_replace("#Saldo#", number_format($model->fppSaldo,0), $message);
            $message = str_replace("#Gantung#", number_format($model->fppOutstanding,0), $message);
            $message = str_replace("#Fisik#", number_format($model->fppCash,0), $message);                     
            
            if(!is_null($model->adjustmentType))
            {
                //koreksi
                if($model->adjustmentType == "++")
                {   
                    $subtot = (float)$TOTAL['TOTAL'] + $model->adjustmentValue;
                    $koreksi='<tr><td align="right" colspan="2"><strong>Koreksi (+)(Rp.)</strong></td><td align="right" id="col_grandtotal"><strong>'.number_format($model->adjustmentValue,0).'</strong></td></tr>';
                    $koreksi=$koreksi.'<tr><td align="right" colspan="2"><strong>Setelah Koreksi (Rp.)</strong></td><td align="right" id="col_grandtotal"><strong>'.number_format($subtot,0).'</strong></td></tr>';
                }
                elseif ($model->adjustmentType == "--"){ 
                    $subtot = (float)$TOTAL['TOTAL'] - $model->adjustmentValue;
                    $koreksi='<tr><td align="right" colspan="2"><strong>Koreksi (-)(Rp.)</strong></td><td align="right" id="col_grandtotal"><strong>'.number_format($model->adjustmentValue,0).'</strong></td></tr>';
                    $koreksi=$koreksi.'<tr><td align="right" colspan="2"><strong>Setelah Koreksi (Rp.)</strong></td><td align="right" id="col_grandtotal"><strong>'.number_format($subtot,0).'*</strong></td></tr>';
                }
                else
                {
                    $koreksi = '&nbsp;';
                }
                $keteranganKoreksi = '<tr><td align="left">*'.$model->adjustmentDesc.'</td></tr>';
                $message = str_replace("#koreksi#", $koreksi, $message); 
                $message = str_replace("#keteranganKoreksi#", $keteranganKoreksi, $message); 
                
            }
            else
            {
                $message = str_replace("#koreksi#", "", $message);  
                $message = str_replace("#keteranganKoreksi#", "", $message); 
            }
            
            $attachment = array();
            
            $sDetail = "";
            $rowNum = 0;
            foreach($fppDetail as $row=>$detail) {   
                $rowNum = (int)$rowNum+1 ;
                $sDetail .= "<tr><td align=center>". $rowNum ."</td>" ; 
                $sDetail .= '<td align=left>'.$detail['fppDesc'].'</td><td align=center>'.number_format($detail['fppDetailValue'],0).'</td></tr>' ;

            }
            $message = str_replace("#sInput_#", $sDetail, $message);            
            
            $sDetail = "";            
            foreach($fppApproval as $row=>$detail) {                 
                if($detail['pic'] != "")
                {
                    $approvalName = Employee::model()->findByAttributes(array('idCard'=>$detail['pic']))->userName; 
                }
                else {
                    $approvalName = "";
                }
                                
                $persetujuan = "";
                if(is_null($detail["persetujuan"]))
                {
                    $persetujuan = "N/A";
                }
                else
                {
                    if($detail["persetujuan"])
                    {
                        $persetujuan = "Disetujui";
                    }else{
                        $persetujuan = "Tidak Disetujui";
                    }
                }
                
                $approvalDate =  date("d-m-Y", strtotime($detail['tanggal']));
                if($persetujuan !== "N/A")
                {
                    $sDetail .= "<tr><td align=left>". $detail['keterangan2']. " ". $approvalName . " - " . $persetujuan . " (".$approvalDate.")" .  "</td></tr>" ;                    
                }
                else
                {
                    $sDetail .= "<tr><td align=left>". $detail['keterangan2']. " ". $persetujuan .  "</td></tr>" ;                    
                }               
            }
            $message = str_replace("#sApproval_#", $sDetail, $message);            
            if(!is_null($approval['fppID']))
            {
                $this->mailsend($to,$cc,$bcc,$subject,$message,$attachment);
                $tmpApproval = FppApproval::model()->findByAttributes(array('fppID'=>$approval['fppID'], 'persetujuanId'=>$approval['persetujuanId']));
                $tmpApproval->aktif = 1;
                $tmpApproval->persetujuan = new CDbExpression('NULL'); 
                $tmpApproval->save();
                //$this->redirect(array('index' ,));
                $ret = true;
            }
                
            return $ret;
        }
        
        public function actionApproval()
        {
            $fppID = Yii::app()->getRequest()->getQuery('fppID');
            $pic= Yii::app()->getRequest()->getQuery('pic');
            $persetujuan=Yii::app()->getRequest()->getQuery('mode');
            $aktif=1;
            $keterangan=Yii::app()->getRequest()->getQuery('jp');
            $ret=Yii::app()->getRequest()->getQuery('ret');
            $an='';
            $now = date('Y-m-d H:i:s');

            if(isset($fppID))
            {
                $fppNo = FppHeader::model()->findByAttributes(array('fppID'=>$fppID))->fppNo;
                $fppApproval = FppApproval::model()->findByAttributes(array('fppID'=>$fppNo, 'pic'=>$pic, 'keterangan'=>$keterangan));
                $urutan = $fppApproval->urutan;
                
                if(is_null($fppApproval->tanggal))
                {
                    $transaction = Yii::app()->db->beginTransaction();                        
                    try{
                        $fppApproval->persetujuan = $persetujuan;
                        $fppApproval->tanggal = $now;                        
                        $fppApproval->save();

                        if($fppApproval->persetujuan)
                        {
                            if($keterangan == "Accounting")
                            {
                                //finance 2
                                $urutan = $urutan + 1;
                                $approval = new FppApproval;                                    
                                $approval->fppID = $fppNo;
                                $approval->pic = Utility::getPIC("FinAdmin") ;
                                $approval->tanggal = new CDbExpression('NULL'); ;
                                $approval->persetujuan = new CDbExpression('NULL'); 
                                $approval->urutan = $urutan;
                                $approval->aktif = 0;
                                $approval->keterangan = 'Finance II';
                                $approval->an = '';
                                $approval->keterangan2 = 'Persiapan Pembayaran :';

                                $approval->save();

                                //finance dept head
                                $urutan = $urutan + 1;
                                $approval = new FppApproval;                                    
                                $approval->fppID = $fppNo;
                                $approval->pic = Utility::getPIC("FinDeptHead") ;
                                $approval->tanggal = new CDbExpression('NULL'); ;
                                $approval->persetujuan = new CDbExpression('NULL'); 
                                $approval->urutan = $urutan;
                                $approval->aktif = 0;
                                $approval->keterangan = 'Finance III';
                                $approval->an = '';
                                $approval->keterangan2 = 'Pembayaran :';

                                $approval->save();

                                $urutan = $urutan + 1;
                                $approval = new FppApproval;                                    
                                $approval->fppID = $fppNo;
                                $approval->pic = Utility::getPIC("AMDiv") ;
                                $approval->tanggal = new CDbExpression('NULL'); ;
                                $approval->persetujuan = new CDbExpression('NULL'); 
                                $approval->urutan = $urutan;
                                $approval->aktif = 0;
                                $approval->keterangan = 'DIVHEAD';
                                $approval->an = '';
                                $approval->keterangan2 = 'Ka. Divisi AM :';

                                $approval->save();

                            }
                            if($keterangan == "Finance III")
                            {
                                $divHead = FppApproval::model()->findByAttributes(array('fppID'=>$fppNo, 'pic'=>'1501.1829', 'keterangan'=>'DIVHEAD'));
                                $divHead->persetujuan = $persetujuan;
                                $divHead->tanggal = $now;                        
                                $divHead->save();
                            }
                            
                            $transaction->commit();

                            //if($this->kirimEmail($fppID))
                            //{
                                $this->kirimEmail($fppID);
                                $this->render('approval',array(
                                    'model'=>$fppApproval,'fppID'=>$fppID,
                                ));
                                exit();
                            //}
                        }
                        //else
                        //{
                        //    $fpp = FppHeader::model()->findByAttributes(array('fppID'=>$fppID));
                        //    $fpp->aprovalType = 0 ;
                        //    $fpp->save();
                       // }
                        //$transaction->commit();
                        
                        //$this->redirect('formPP/mail', array('id'=>$fppID));
                        $this->render('approval',array(
                                'model'=>$fppApproval,'fppID'=>'',
                        ));

                    } catch (Exception $ex) {
                        $transaction->rollBack();
                        throw new CHttpException(403, $ex);
                        Yii::app()->user->setFlash('Error', $ex);
                        $this->redirect(array('formPP/index'));
                    }
     
                }else
                {
                    $this->render('approval',array(
                            'model'=>$fppApproval,'fppID'=>'--',
                    ));
                }                
            }
           
        }
                
	public function actionAccounting()
	{
            $model=new FppHeader('searchAccounting');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['FppHeader']))
            {
                    $model->attributes=$_GET['FppHeader'];                    
            }


            $this->render('accounting',array(
                    'model'=>$model,
            ));
	}
        
        public function actionViewAccounting($id)
	{
            $model = FppHeader::model()->getHeader($id);                                          
            $detail = FppDetail::model()->getFppDetail($model->fppNo);  
            $total = FppDetail::model()->getDetailTotal($model->fppNo);
            $approval = FppApproval::model()->getAccounting($model->fppNo);  
            $approval->total = $model->TOTAL;
            $approval->adjustmentValue = 0;
            $approval->adjustmentDesc= "-";
            
            $this->render('viewAccounting',array(
                    'model'=>$model,
                    'detail'=>$detail,
                    'total'=>$total,
                    'approval'=>$approval,
            ));
	}
        
        public function actionExecAccounting()                               
	{            
            if(isset($_POST['FppApproval']))
            {
                $fppID = $_POST['FppApproval']['fppID'];
                $idcard = Yii::app()->user->getState('idcard');
                
                $keterangan = "ACCOUNTING";
                $pic = "";
                $model = FppApproval::model()->findByAttributes(array('fppID'=>$fppID, 'keterangan'=>$keterangan, 'pic'=>$pic));

                if(is_null($model->tanggal))
                {
                    $model->attributes=$_POST['FppApproval'];
                    $model->tanggal = new CDbExpression('NULL'); 
                    $model->persetujuan = new CDbExpression('NULL'); 
                    $model->aktif = 1;
                    $subTot = $_POST['FppApproval']['total'];
                    $koreksi = $_POST['FppApproval']['adjustmentValue'];
                    
                    //print_r($model);
                    //exit();
                    if($_POST['FppApproval']['adjType'] == "++")
                    {
                        $totalApprove = (float)$subTot + (float)$koreksi;
                    }
                    else
                    {
                        $totalApprove = (float)$subTot - (float)$koreksi;
                    }    
                    
                    
                    if($totalApprove <= 5000000)
                    {
                        $model->pic = Utility::getPIC("Acct I");
                    }
                    else
                    {
                        $model->pic = Utility::getPIC("Acct II");
                    }
                    
                    if($model->validate())
                    {    
                        $header = FppHeader::model()->findByAttributes(array('fppNo'=>$fppID));

                        $header->adjustmentValue = $_POST['FppApproval']['adjustmentValue'];
                        $header->adjustmentDesc = $_POST['FppApproval']['adjustmentDesc'];
                        $header->adjustmentType = $_POST['FppApproval']['adjType'];
                        
                        $header->save();
                        $fppID = $header->fppID;
                        $model->save(); 
                        if($kirimEmail = $this->kirimEmail($fppID))
                        {
                            exit(json_encode(array('result' => 'success', 'msg' => $model->persetujuan?"Disetujui":"Tidak Disetujui",'fppID'=>$model->fppID)));
                        }
                        
                    }                    
                }
                
            }
	}                
        
        public function actionPrintFinance()
        {
            $this->layout='iframe';
            $model=new FppHeader('searchFinance');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['FppHeader']))
                    $model->attributes=$_GET['FppHeader'];

            $this->render('financePrint',array(
                    'model'=>$model,
            ));
        }
        public function actionFinance()
	{
            $model=new FppHeader('searchFinance');
            $model->unsetAttributes();  // clear any default values
            
            if(isset($_GET['FppHeader']))
                    $model->attributes=$_GET['FppHeader'];                     
            
            $this->render('finance',array(
                    'model'=>$model,
            ));
	}          

        public function actionViewFinance($id)
	{
            $this->layout='iframe';
            $model = FppHeader::model()->getHeader($id);                                          
            $detail = FppDetail::model()->getFppDetail($model->fppNo);  
            $total = FppDetail::model()->getDetailTotal($model->fppNo);

            //$approval = FppApproval::model()->getFinance($model->fppNo);            
            $approval = Utility::getPrintApproval($model->fppNo);
            $this->render('viewFinance',array(
                    'model'=>$model,
                    'detail'=>$detail,
                    'total'=>$total,
                    'approval'=>$approval,
            ));
	}
        
        public function actionViewFinanceFPP($id)
	{
            $this->layout='iframe';
            $model = FppHeader::model()->getHeaderFpp($id);                                          
            $detail = FppDetail::model()->getFppDetail($model->fppNo);  
            $total = FppDetail::model()->getDetailTotal($model->fppNo);

            //$approval = FppApproval::model()->getFinance($model->fppNo);            
            $approval = Utility::getPrintApproval($model->fppNo);
            $this->render('viewFinanceFpp',array(
                    'model'=>$model,
                    'detail'=>$detail,
                    'total'=>$total,
                    'approval'=>$approval,
            ));
	}
        
        public function actionExecFinance($id)                               
	{                                          
            $model = FppHeader::model()->getHeader($id);
            
            $model->fppUser = $model->fppNo." - ".$model->fppUserName;
            $model->fppToBank = $model->fppToBank." - ".$model->fppToBankAcc;
            $model->adjustmentValue = number_format($model->adjustmentValue);
            
            if(isset($_POST['FppHeader']))
            {
                $model->attributes=$_POST['FppHeader'];
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        $criteria = new CDbCriteria;
                        $criteria->addCondition(" fppID = '".$model->fppNo."'");
                        $criteria->addCondition(" persetujuan is null ");
                        $criteria->addCondition(" keterangan = 'Finance II'");
                        
                        $approval = FppApproval::model()->find($criteria);   
                        $approval->persetujuan = 1;
                        $approval->tanggal =  date("Y-m-d H:i:s");
                        
                        $approval->save();
                        $transaction->commit();
                        if (!empty($_GET['asDialog']))
                        {   
                            $kirimEmail = $this->kirimEmail($id);
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
                $this->render('execFinance',array('approval'=>$model,));
            }
            else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

	}                
        
        public function actionExecVeriAcct($id)                               
	{                                          
            $model = FppHeader::model()->getHeaderFpp($id);       
            $total = FppDetail::model()->getDetailTotal($model->fppNo);
            $model->fppUser = $model->fppNo." - ".$model->fppUserName;
            $model->fppToBank = $model->fppToBank." - ".$model->fppToBankAcc;
            $model->TOTAL = number_format($total,0);
            if(isset($_POST['FppHeader']))
            {                
                $transaction = Yii::app()->db->beginTransaction();
                try
                {
                    $verified = $_POST['FppHeader']['optVeri'];
                    $reason = $_POST['FppHeader']['reason'];
                    $approval = FppHeader::model()->findByAttributes(array('fppID'=>$id ));
                    $connection=Yii::app()->db; 
                    $username = Yii::app()->user->name;
                     
                    if($verified == 1)
                    {
                        $approval->fppStatus = 4;     
                        $strCommand = "update tr_apDetail set invStatus = 4
                                        where apInvNo in (select fppInvNo from tr_fppDetail 
                                                where fppID in (select fppNo from tr_fppHeader 
                                                        where fppID = '".$id."'))";                
                        $command = $connection->createCommand($strCommand);
                        $command->execute();      

                        $strCommand = " 
                            insert into tr_apLog (apInvNo, apLogNo, apLogDesc, apLogReason, inputUN, inputTime, modifUN, modifTime)			
                            select fppInvNo, 4, 'FPP telah di verifikasi oleh Accounting', '', '".$username."', GETDATE(), '".$username."', GETDATE() from tr_fppDetail 
                                    where fppID in (select fppNo from tr_fppHeader 
                                            where fppID = '".$id."')
                                        ";                
                        $command = $connection->createCommand($strCommand);
                        $command->execute(); 
                    }
                    else
                    {
                        $approval->fppStatus = 5;     
                        $strCommand = "update tr_apDetail set invStatus = 5
                                        where apInvNo in (select fppInvNo from tr_fppDetail 
                                                where fppID in (select fppNo from tr_fppHeader 
                                                        where fppID = '".$id."'))";                
                        $command = $connection->createCommand($strCommand);
                        $command->execute();      

                        $strCommand = " 
                            insert into tr_apLog (apInvNo, apLogNo, apLogDesc, apLogReason, inputUN, inputTime, modifUN, modifTime)			
                            select fppInvNo, 5, 'FPP memerlukan revisi', '".$reason."', '".$username."', GETDATE(), '".$username."', GETDATE() from tr_fppDetail 
                                    where fppID in (select fppNo from tr_fppHeader 
                                            where fppID = '".$id."')
                                        ";                
                        $command = $connection->createCommand($strCommand);
                        $command->execute(); 
                    }
                    
                    $approval->save();
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
                $this->render('_formVeriAcct',array('model'=>$model,'total'=>$total));
            }
            else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

	}     
        
	public function actionIndex()
	{
		$model=new FppHeader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FppHeader']))
                {
                    $model->attributes=$_GET['FppHeader'];                        
                }

		$this->render('index',array(
			'model'=>$model,
		));
	}

        public function actionIndexFPP()
	{
            $this->leftPortlets = array();
            $this->leftPortlets['ptl.APMenu'] = array(); 

            $model=new FppHeader('searchFPP');
            $model->unsetAttributes();  // clear any default values
            
            $visible = "false";
            
            if(isset($_GET['FppHeader']))
            {
                $model->attributes=$_GET['FppHeader'];
            }
            
            $this->render('indexFPP',array(
                    'model'=>$model, 'visible' => $visible,
            ));
	}
        
        public function actionVerifikasiFPP()
	{
            $this->leftPortlets = array();
            $this->leftPortlets['ptl.APMenu'] = array(); 

            $model=new FppHeader('searchFPP');
            $model->unsetAttributes();  // clear any default values
            $model->mode = 'verifikasi';
            $visible = "true";
            
            if(isset($_GET['FppHeader']))
            {
                $model->attributes=$_GET['FppHeader'];
            }


            $this->render('indexFPP',array(
                    'model'=>$model, 'visible' => $visible,
            ));
	}
        
        public function actionVeriAcct()
        {       
            $this->leftPortlets = array();
            $this->leftPortlets['ptl.APMenu'] = array();        

            $model=new FppHeader('veriAcct');

            $model->unsetAttributes(); 
            if(isset($_GET['FppHeader']))
            {
                $model->attributes=$_GET['FppHeader'];
            }

            $this->render('verifyAcct',array(
                    'model'=>$model,
            ));
        }
        
        public function actionUpdateDelegation($id)
        {
            $approval = FppHeader::model()->findByAttributes(array('fppID'=>$id ));
            $connection=Yii::app()->db; 
            $username = Yii::app()->user->name;
            $log = new APLog;
            
            $transaction = Yii::app()->db->beginTransaction();
            try 
            { 
                if($approval->fppStatus == 2) 
                {
                    $approval->fppStatus = 3;                               
                    $strCommand = "update tr_apDetail set invStatus = 3
                                        where apInvNo in (select fppInvNo from tr_fppDetail 
                                                where fppID in (select fppNo from tr_fppHeader 
                                                        where fppID = '".$id."'))";                
                    $command = $connection->createCommand($strCommand);
                    $command->execute();      

                    $strCommand = " 
                        insert into tr_apLog (apInvNo, apLogNo, apLogDesc, apLogReason, inputUN, inputTime, modifUN, modifTime)			
                        select fppInvNo, 3, 'Invoice diterima Accounting', '', '".$username."', GETDATE(), '".$username."', GETDATE() from tr_fppDetail 
                                where fppID in (select fppNo from tr_fppHeader 
                                        where fppID = '".$id."')
                                    ";                
                    $command = $connection->createCommand($strCommand);
                    $command->execute();  
                }
            
                if($approval->fppStatus == 4) 
                {
                    $approval->fppStatus = 6;                               
                    $strCommand = "update tr_apDetail set invStatus = 6
                        where apInvNo in (select fppInvNo from tr_fppDetail 
                                where fppID in (select fppNo from tr_fppHeader 
                                        where fppID = '".$id."'))";   
                    $command = $connection->createCommand($strCommand);
                    $command->execute(); 

                    $strCommand = " 
                        insert into tr_apLog (apInvNo, apLogNo, apLogDesc, apLogReason, inputUN, inputTime, modifUN, modifTime)			
                        select fppInvNo, 6, 'Invoice diterima Finance', '', '".$username."', GETDATE(), '".$username."', GETDATE() from tr_fppDetail 
                                where fppID in (select fppNo from tr_fppHeader 
                                        where fppID = '".$id."')
                                    ";                
                    $command = $connection->createCommand($strCommand);
                    $command->execute(); 
                }

                if($approval->fppStatus == 5) 
                {
                    $approval->fppStatus = 1;                               
                    $strCommand = "update tr_apDetail set invStatus = 1
                        where apInvNo in (select fppInvNo from tr_fppDetail 
                                where fppID in (select fppNo from tr_fppHeader 
                                        where fppID = '".$id."'))";   
                    $command = $connection->createCommand($strCommand);
                    $command->execute(); 

                    $strCommand = " 
                        insert into tr_apLog (apInvNo, apLogNo, apLogDesc, apLogReason, inputUN, inputTime, modifUN, modifTime)			
                        select fppInvNo, 1, 'Invoice diterima User', '', '".$username."', GETDATE(), '".$username."', GETDATE() from tr_fppDetail 
                                where fppID in (select fppNo from tr_fppHeader 
                                        where fppID = '".$id."')
                                    ";                
                    $command = $connection->createCommand($strCommand);
                    $command->execute(); 
                }
                
                if($approval->fppStatus == 8) 
                {
                    $approval->fppStatus = 9;                               
                    $strCommand = "update tr_apDetail set invStatus = 9
                        where apInvNo in (select fppInvNo from tr_fppDetail 
                                where fppID in (select fppNo from tr_fppHeader 
                                        where fppID = '".$id."'))";   
                    $command = $connection->createCommand($strCommand);
                    $command->execute(); 

                    $strCommand = " 
                        insert into tr_apLog (apInvNo, apLogNo, apLogDesc, apLogReason, inputUN, inputTime, modifUN, modifTime)			
                        select fppInvNo, 9, 'Invoice diterima User', '', '".$username."', GETDATE(), '".$username."', GETDATE() from tr_fppDetail 
                                where fppID in (select fppNo from tr_fppHeader 
                                        where fppID = '".$id."')
                                    ";                
                    $command = $connection->createCommand($strCommand);
                    $command->execute(); 
                }

                if($approval->fppStatus == 10) 
                {
                    $approval->fppStatus = 6;                               
                    $strCommand = "update tr_apDetail set invStatus = 6
                        where apInvNo in (select fppInvNo from tr_fppDetail 
                                where fppID in (select fppNo from tr_fppHeader 
                                        where fppID = '".$id."'))";   
                    $command = $connection->createCommand($strCommand);
                    $command->execute(); 

                    $strCommand = " 
                        insert into tr_apLog (apInvNo, apLogNo, apLogDesc, apLogReason, inputUN, inputTime, modifUN, modifTime)			
                        select fppInvNo, 6, 'Invoice diterima User', '', '".$username."', GETDATE(), '".$username."', GETDATE() from tr_fppDetail 
                                where fppID in (select fppNo from tr_fppHeader 
                                        where fppID = '".$id."')
                                    ";                
                    $command = $connection->createCommand($strCommand);
                    $command->execute(); 
                }
                
                $approval->save();
                $transaction->commit();
                } catch (Exception $ex) {
                    $transaction->rollBack();
                    throw new CHttpException(403, $ex);
                }            
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            $this->redirect(array('invoice/logbook'));
        }

	public function loadModel($id)
	{
		$model=FppHeader::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}        

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='fpp-header-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
