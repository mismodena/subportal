<?php

class CampaignController extends Controller
{
	public $layout='leftbar';
        public $totalCN = 0;        
        public $link = "";
        public $pathMail = 'http://apache-indomo/dev/fpp/index.php/en/site/crednot?';
        
	function init() {
            parent::init();
            $this->leftPortlets['ptl.invMenu'] = array();
        }
    
        public function allowedActions()
        {
            return 'mail, loadArray, sendMail';
        }
        
        public function filters()
	{
            return array(
                'Rights',
            );
	}
	
	

	public function accessRules()
        {
            return array(
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                        'actions'=>array('index','view','create','delete','mail','sendMail'),
                        'users'=>array('@'),
                    ),
                    array('deny',  // deny all users
                            'users'=>array('*'),
                    ),
                );
        } 
        
        public function setCategory($catID)
        {
            return Utility::getBranchName($catID);           
        }
        
	public function actionView($id)
	{
            $model = $this->loadModel($id);            
            $model->campaignCategory = $this->setCategory($model->campaignCategory);
            $approval = CampaignApproval::model()->searchApproval($model->campaignNo);
            
            $path = Yii::app()->basePath.'/../'.$model->excelFiles ;
            
            $data = $this->loadArray($path, $model->campaignNo);

            //$path = Yii::app()->baseUrl.$model->excelFiles ;
               
            $this->render('view',array(
                    'model'=>$model,
                    'excel'=>$data,
                    'total'=>$this->totalCN,
                    'approval'=>$approval,
            ));
	}
        
        public function actionViewApproval($id)
	{            
            $model =$this->loadModel($id);            
            $model->campaignCategory = $this->setCategory($model->campaignCategory);
            
            $path = Yii::app()->basePath.'/../'.$model->excelFiles ;
           
            $data = $this->loadArray($path);
            
            //$path = Yii::app()->baseUrl.$model->excelFiles ;
                        
            $this->render('viewApproval',array(
                    'model'=>$model,
                    'excel'=>$data,
                    'total'=>$this->totalCN,
            ));
	}


	public function actionCreate()
	{
            $model=new Campaign;
            
            $this->performAjaxValidation($model);
            
            if(isset($_POST['Campaign']))
            {
                $model->attributes=$_POST['Campaign'];
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $model->save() ;
                    
                    //upload File
                    $path = DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'cn'.DIRECTORY_SEPARATOR;                       
                    $temp=CUploadedFile::getInstance($model,'excelFiles');
                    $formatName=time().'-'.$model->campaignNo.'.'.$temp->getExtensionName();

                    $model->excelFiles = str_replace(DIRECTORY_SEPARATOR,'/',$path.$formatName);                        			
                    $model->save();
                    $temp->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.$path.$formatName); 
                    
                    $approval = new CampaignApproval();
                    $approval->campaignID = $model->campaignNo;
                    $approval->pic = Utility::getPIC("AMDiv");
                    $approval->keterangan = "DIV-HEAD";
                    $approval->an = 1;
                    $approval->save();
                    
                    $approval = new CampaignApproval();
                    $approval->campaignID = $model->campaignNo;
                    $approval->pic = Utility::getPIC("Acct II");
                    $approval->keterangan = "Acct-Dept Head";
                    $approval->an = 0;
                    $approval->save();
                    
                    $transaction->commit();
                }catch (Exception $e) {
                        $transaction->rollBack();
                        throw new CHttpException(403, $e);
                        Yii::app()->user->setFlash('Error', $e);
                        //$this->redirect(array('formPP/index'));                            
                } 
                $this->redirect(array('mail', 'id'=>$model->campaignNo,));
            }

            $this->render('create',array(
                    'model'=>$model,
            ));
	}

        public function actionSendmail($id){
			
             $campaignNo = $id;
			 
             $this->redirect(array('mail', 'id'=>$campaignNo,));
        }

        
        public function actionMail($id)
        {
			
            $model = Campaign::model()->findByAttributes(array('campaignNo'=>$id));  
            
            //$criteria=new CDbCriteria;
            //$criteria->addCondition("campaignID = '".$model->campaignNo."'");
            //$criteria->addCondition(" tanggal is null ");            
            //$approval = CampaignApproval::model()->find($criteria);
            
            $approval = CampaignApproval::model()->findBySql("select top 1 *
                        from SGTDAT..MIS_CampaignApproval
                        where persetujuan is null and campaignID = '".$model->campaignNo."'
                        order by an");   
            
            $path = Yii::app()->basePath.'/../'.$model->excelFiles ;            
            $data = $this->loadArray($path);
                        
            $to[0] = Employee::model()->findByAttributes(array("idCard"=>$approval->pic))->email;            
            //$to = array("fajar.pratama@modena.co.id");
            $cc = '';
            $bcc = array('admin.acc4@modena.co.id','irfan.dadi@modena.co.id');

           // print_r($approval);
            //exit();
            
            //$modeyes = $this->pathMail."campaignID=".$model->campaignID."&pic=".$approval->pic."&mode=1";
            $modeyes = $this->createAbsoluteUrl("site/crednot", array("campaignID"=>$model->campaignID,"pic"=>$approval->pic,"mode"=>1)) ;
            //$modeno = $this->pathMail."campaignID=".$model->campaignID."&pic=".$approval->pic."&mode=0";
            $modeno = $this->createAbsoluteUrl("site/crednot", array("campaignID"=>$model->campaignID,"pic"=>$approval->pic,"mode"=>0)) ;
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
			
			echo "EMAIL TERKIRIM : " . $id;
			exit();
            //$this->redirect(array('index' ,));

        }
        
	public function actionExecApproval()
	{           
            if(isset($_POST['Campaign']))
            {
                $campaignID = $_POST['Campaign']['campaignID'];
                $model = Campaign::model()->findByAttributes(array('campaignID'=>$campaignID));
                $model->campaignApproval = $_POST['Campaign']['campaignApproval'];
                
                $path = Yii::app()->basePath.'/../'.$model->excelFiles ;

                try {
                    if($model->save()){
                        if($model->campaignApproval)
                        {
                            error_reporting(E_ALL ^ E_NOTICE);
                            require_once('excel_reader2.php');

                            $data = new Spreadsheet_Excel_Reader($path);

                            for ($j=2; $j <= $data->sheets[0]['numRows']; $j++)
                            {            
                               $valuewtx = (float)$data->sheets[0]['cells'][$j][3] * 1.1;
                               $detail = new CreditNote();
                               $detail->idCust = $data->sheets[0]['cells'][$j][2];                                             
                               $detail->invNumber = $model->campaignNo;
                               $detail->invDate = $model->campaignFrom;
                               $detail->payDate = $model->CNStartDate;
                               $detail->pkpValue = $data->sheets[0]['cells'][$j][3];
                               $detail->pkpValueWtx = $valuewtx;
                               $detail->pkpAllocate = 0;
                               $detail->pkpAllowance = 0 ;
                               //print_r($detail);
                               //exit();
                               $detail->save();
                            }   
                        } 
                        exit(json_encode(array('result' => 'success', 'msg' => $model->campaignApproval?"Disetujui":"Tidak Disetujui",'cnID'=>$model->campaignNo)));
                    }
                    else
                    {
                        exit(json_encode(array('result' => 'success', 'msg' => CHtml::errorSummary($model))));
                            
                        
                    }
                    //$transaction->commit();
                    
                } catch (Exception $ex) {
                    //$transaction->rollBack();
                    exit(json_encode(array('result' => 'success', 'msg' => $ex->getMessage())));                    
                }
            }
            
	}
        
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$model=new Campaign('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Campaign']))
			$model->attributes=$_GET['Campaign'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
        
        public function actionApproval()
	{
		$model=new Campaign('searchApproval');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Campaign']))
			$model->attributes=$_GET['Campaign'];

		$this->render('approval',array(
			'model'=>$model,
		));
	}
        
        public function loadArray($path, $campaignNo = '')
        {
                       
            if (strpos($path, '.xls') !== false) {

                error_reporting(E_ALL ^ E_NOTICE);
                require_once('excel_reader2.php');
                
                $data = new Spreadsheet_Excel_Reader($path);
                $this->totalCN = 0;
                $rawData = array();
                
                for ($j=2; $j <= $data->sheets[0]['numRows']; $j++)
                {         
                    
                   $idcust = $data->sheets[0]['cells'][$j][2];               
                   //$namecust = trim(Customer::model()->findByAttributes(array('IDCUST'=>$idcust,))->NAMECUST);
                   $namecust = $data->sheets[0]['cells'][$j][3];
                   $nilaiCN = $data->sheets[0]['cells'][$j][4];
                   $this->totalCN  = $this->totalCN  +  (int)$nilaiCN ;
                   
                   if(isset($idcust) && !is_null($idcust) && trim($idcust) !== "")
                   {
                    $rawData[$j]['idcust']= $idcust;
                    $rawData[$j]['namecust'] = $namecust;
                    $rawData[$j]['cnvalue']= $nilaiCN;
                   }

                }
            }else{

                $this->totalCN = 0;
                $rawData = array();                
                $data = CreditNote::model()->getPKPSource($campaignNo);  
                $i=0;

                foreach($data->getData() as $record) {
                    $rawData[$i]['id'] = $record->id; 
                    $rawData[$i]['idcust'] = $record->idCust;                    
                    $rawData[$i]['namecust'] = $record->header['NAMECUST'];
                    $rawData[$i]['cnvalue'] = (int)$record->pkpValue;

                    $this->totalCN  = $this->totalCN  + (int)$record->pkpValue ;
                    $i++;
                }
            }

            $data = new CArrayDataProvider($rawData, array(
                            'id'=>'id',
                            /* 'sort'=>array(
                                    'attributes'=>array(
                                            'username', 'email',
                                    ),
                            ), */
                            'pagination'=>array(
                                    'pageSize'=>10,
                            ),
                    ));
            
            return $data;
        }

	public function loadModel($id)
	{
		$model=Campaign::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

        
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='campaign-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
