<?php

class SiteController extends Controller
{
	public function actions()
	{
            return array(
                    // captcha action renders the CAPTCHA image displayed on the contact page
                    'captcha'=>array(
                            'class'=>'CCaptchaAction',
                            'backColor'=>0xFFFFFF,
                    ),
                    'page'=>array(
                            'class'=>'CViewAction',
                    ),
            );
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionError()
	{
            if($error=Yii::app()->errorHandler->error)
            {
                if(Yii::app()->request->isAjaxRequest)
                        echo $error['message'];
                else
                        $this->render('error', $error);
            }
	}

	public function actionLogin()
	{
            $model=new LoginForm;

            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }

            // collect user input data
            if(isset($_POST['LoginForm']))
            {
                    $model->attributes=$_POST['LoginForm'];
                    // validate user input and redirect to the previous page if valid
                    if($model->validate() && $model->login())
                            $this->redirect(Yii::app()->user->returnUrl);
            }
            // display the login form
            $this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
                
        public function actionCredNot()
        {
            $campaignID = Yii::app()->getRequest()->getQuery('campaignID');
            $pic= Yii::app()->getRequest()->getQuery('pic');
            $persetujuan=Yii::app()->getRequest()->getQuery('mode');            
            $aktif=1;
            $now = date('Y-m-d H:i:s');
            
            if(isset($campaignID))
            {
                $model = Campaign::model()->findByAttributes(array('campaignID'=>$campaignID));                
                $approval = CampaignApproval::model()->findByAttributes(array('campaignID'=>$model->campaignNo, 'pic'=>$pic));
                    
                if(is_null($approval->tanggal))
                {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {                        
                        $approval->persetujuan = $persetujuan;
                        $approval->aktif = $aktif;                                        
                        $approval->tanggal = $now;

                        $approval->save()   ;         
                        
                        if($approval->persetujuan)
                        {                           
                            //$exist = CampaignApproval::model()->exists("keterangan = 'DIV-HEAD' and campaignID = :campaignID", array(":campaignID"=>$approval->campaignID));
                            
                            if($pic !== '1501.1829')
                            {                                
                                $this->redirect(array('campaign/mail', 'id'=>$approval->campaignID,));
                            }
                            else
                            {
                                if($approval->pic == Utility::getPIC("AMDiv"))
                                {
                                    error_reporting(E_ALL ^ E_NOTICE);
                                    require_once('excel_reader2.php');
                                    
                                    $path = Yii::app()->basePath.'/../'.$model->excelFiles ;
                                    $data = new Spreadsheet_Excel_Reader($path);
                                   
                                    for ($j=2; $j <= $data->sheets[0]['numRows']; $j++)
                                    {       
                                       $idCust = $data->sheets[0]['cells'][$j][2];                                             
                                       if(isset($idCust) && !is_null($idCust) && trim($idCust) !== "")
                                       {
                                            $valuewtx = (float)$data->sheets[0]['cells'][$j][4] * 1.1;
                                             $detail = new CreditNote();
                                             $detail->idCust = $data->sheets[0]['cells'][$j][2];                                             
                                             $detail->invNumber = $model->campaignNo;
                                             $detail->invDate = $model->campaignFrom;
                                             $detail->payDate = $model->CNStartDate;
                                             $detail->pkpBranch = $model->campaignCategory;
                                             $detail->pkpValue = $data->sheets[0]['cells'][$j][4];
                                             $detail->pkpValueWtx = $valuewtx;
                                             $detail->pkpAllocate = 0;
                                             $detail->pkpAllowance = 0 ;
                                             //print_r($detail);
                                             //exit();
                                             $detail->save();
                                       }                                       
                                    }   
                                }
                                $transaction->commit();
                            }
                            
                        }
                        $this->render('approvalCN',array(
                                'model'=>$approval,
                        ));                             
                    } catch (Exception $ex) {
                            $transaction->rollback();
                            exit(json_encode(array('result' => 'error', 'msg' => CHtml::errorSummary($ex->getMessage())))); 
                    }
                }else
                {
                    $this->render('approvalCN',array(
                            'model'=>$approval,
                    ));
                }
            }
        }
        
        public function actionMail($id)
        {
            $model = Campaign::model()->findByAttributes(array('campaignNo'=>$id));  
            
            $criteria=new CDbCriteria;
            $criteria->addCondition("campaignID = '".$model->campaignNo."'");
            $criteria->addCondition(" tanggal is null ");            
            $approval = CampaignApproval::model()->find($criteria);
            
            $path = Yii::app()->basePath.'/../'.$model->excelFiles ;            
            $data = $this->loadArray($path);
                        
            $to[0] = Employee::model()->findByAttributes(array("idCard"=>$approval->pic))->email;            
            //$to = array("fajar.pratama@modena.co.id");
            $cc = '';
            $bcc = array('fajar.pratama@modena.co.id');

           // print_r($approval);
            //exit();
            
            $modeyes = $this->pathMail."campaignID=".$model->campaignID."&pic=".$approval->pic."&mode=1";

            $modeno = $this->pathMail."campaignID=".$model->campaignID."&pic=".$approval->pic."&mode=0";
            $subject ="Pengajuan Credit Note :: Kode Promo ".$model->campaignNo;                            
            $content = '';

            $message = $this->mailTemplate(3);
            $message = str_replace("#campaignNo#", $model->campaignNo, $message);
            $message = str_replace("#nama promo#", $model->campaignName, $message);
            $message = str_replace("#periode promo#", date("d-m-Y", strtotime($model->campaignFrom))." s/d ".date("d-m-Y", strtotime($model->campaignTo)), $message);
            $message = str_replace("#kategori#", $this->setCategory($model->campaignCategory), $message);
            $message = str_replace("#keterangan#", $model->campaignDesc, $message);
            $message = str_replace("#tanggal berlaku#", date("d-m-Y", strtotime($model->CNStartDate)), $message);
            $message = str_replace("#total CN#",number_format($this->totalCN,0), $message);
            $message = str_replace("#pathyes#", $modeyes, $message);
            $message = str_replace("#pathno#", $modeno, $message);           

            $attachment = array($path);
            
            $this->mailsend($to,$cc,$bcc,$subject,$message,$attachment);
            $this->redirect(array('index' ,));

        }
        
        public function actionOpenAppr($id){
            $model = BQOpen::model()->findByAttributes(array("openID"=>$id));
            
            $this->render('openAppr', array(
                '$model' => $model,
            ));
            
            
        }
}