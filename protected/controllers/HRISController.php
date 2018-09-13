<?php

class HRISController extends Controller {
    
    public $layout='leftbar';
    
    function init() {
        parent::init();
        $this->leftPortlets['ptl.HRISMenu'] = array();
    }

    public function filters()
    {
        return array(
            'Rights',
        );
    }
    public function actionViewPrmd($id)
    {
        $model = hrisPrmd::model()->getPrmd($id);                                          
        
        $this->render('viewPrmd',array(
                'model'=>$model,
        ));
    }
    
    public function actionView($id)
    {
        $model = hrisContract::model()->getContract($id);                                          
        
        $history = new hrisContract('search');
        $history->unsetAttributes();  // clear any default values
        $history->idCard = $model->idCard ;
        $history->isActive = 0 ;
        
        $this->render('view',array(
                'model'=>$model, 'history'=>$history, 
        ));
    }
    
    public function actionIndex()
    {
        $model=new hrisContract('search');
        $model->unsetAttributes();  // clear any default values
        $model->isActive = 1 ;
        
        if(isset($_GET['hrisContract']))
                $model->attributes=$_GET['hrisContract'];

        $this->render('index',array(
                'model'=>$model,
        ));
    }
    
    public function actionIndexPrmd()
    {
        $model=new hrisPrmd('search');
        $model->unsetAttributes();  // clear any default values
        $model->isActive = 1 ;
        
        if(isset($_GET['hrisPrmd']))
        {
            
            $model->attributes=$_GET['hrisPrmd'];
        }

        $this->render('indexPrmd',array(
                'model'=>$model,
        ));
    }

    public function actionCreateContract()
    {
        $model=new hrisContract;        

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['hrisContract']))
        {
            $model->attributes=$_POST['hrisContract'];
            $employee = Employee::model()->findByAttributes(array('idCard'=>$model->idCard));
            $model->idPos = $employee->idPos ;
            $model->idDept = $employee->idDept ;
            $model->idDiv = $employee->nameDiv ;
            $model->idBranch = $employee->idBranch ;
            $model->period = $_POST['hrisContract']['period'];
            $model->endDate = date('Y-m-d', strtotime($model->startDate . "+$model->period months"));
            $model->endDate = date('Y-m-d', strtotime($model->endDate . '-1 day' ));
            $model->endDate = Utility::getEndDate($model->endDate);
                    
            $model->validate();
            if($model->validate())
            {
                if($model->save())
                {
                    $this->redirect(array('index'));
                }
            }                
        }

        $this->render('createContract',array(
            'model'=>$model,
        ));
    }
    
    public function actionCreatePrmd()
    {
        $model=new hrisPrmd;        

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['hrisPrmd']))
        {
            $model->attributes=$_POST['hrisPrmd'];
            $model->deptHead = Utility::getDeptHeadHris($model->idBranch, $model->idDept);
            $model->newDeptHead = Utility::getDeptHeadHris($model->newIdBranch, $model->newIdDept);
            $model->endDate = Utility::getEndDate($model->endDate);
            
            $model->validate();
            if($model->validate())
            {
                if($model->save())
                {
                    $this->redirect(array('indexPrmd'));
                }
            }                
        }

        $this->render('createPrmd',array(
            'model'=>$model,
        ));
    }
    
    public function actionApproval()                               
    {            
        if(isset($_POST['hrisPrmd']))
        {
            $prmdID = $_POST['hrisPrmd']['prmdID'];
            $status = $_POST['hrisPrmd']['status'];
            $action = $_POST['hrisPrmd']['prmdAction'];
            
            $model = hrisPrmd::model()->findByAttributes(array('prmdID'=>$prmdID));
            
            if(is_null($model->status))
            {                
                $transaction = Yii::app()->db->beginTransaction();                
                try
                {
                    $model->status=$status;
                    $model->isActive = 0;
                    
                    if($model->status !== 0 && $model->status !== "ok")
                    {   
                        $newRow = new hrisPrmd();
                        $newRow->idCard = $model->idCard;
                        $newRow->prmdCategory = $model->prmdCategory;
                        $newRow->idPos = $model->idPos;
                        $newRow->idDept = $model->idDept;
                        $newRow->idDiv = $model->idDiv;
                        $newRow->deptHead = $model->deptHead;
                        $newRow->jobGrade = $model->jobGrade;
                        $newRow->idBranch = $model->idBranch;
                        $newRow->newIdPos = $model->newIdPos;
                        $newRow->newIdDept = $model->newIdDept;
                        $newRow->newIdDiv = $model->newIdDiv;
                        $newRow->newDeptHead = $model->newDeptHead;
                        $newRow->newJobGrade = $model->newJobGrade;
                        $newRow->newIdBranch = $model->newIdBranch;
                        $newRow->prmdAction = '';
                        $newRow->status = new CDbExpression('NULL'); 
                        $newRow->prmdDesc = $model->prmdDesc;
                        $newRow->isActive = 1;                        
                        $newRow->startDate = date('Y-m-d', strtotime($model->endDate . '+1 day' ));
                        $newRow->endDate = date('Y-m-d', strtotime($newRow->startDate . "+$action months"));
                        
                        $newRow->save();
                    }

                    if($model->validate())
                    {    
                        $model->save(); 
                        $transaction->commit();
                        exit(json_encode(array('result' => 'success', 'msg' => $model->status?"Disetujui":"Tidak Disetujui",'prmdID'=>$model->prmdID)));               
                    }    
                } catch (Exception $ex) {
                    throw new CHttpException(403, $ex);
                }                        
            }
        }
    }    
    
    public function actionUpdate($id)
    {
        $model = hrisContract::model()->getContract($id);
        $model->deptName = $model->deptName."-".$model->idDiv." / ".$model->branchName;
        $model->dispStart = date("d-m-Y", strtotime($model->startDate));
        $model->dispEnd = date("d-m-Y", strtotime($model->endDate));

        if(isset($_POST['hrisContract']) )
        {            
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $update = hrisContract::model()->findByAttributes(array("contractID"=>$id));
                $update->contractReplacement = $_POST['hrisContract']['contractReplacement']; 
                $update->contractType = $_POST['hrisContract']['contractType'];                 
                $update->startDate = $_POST['hrisContract']['startDate']; 
                $update->endDate = $_POST['hrisContract']['endDate']; 
                $update->save();                

                $transaction->commit();           

                if (!empty($_GET['asDialog']))
                {                       
                    echo CHtml::script("window.parent.$('#cru-dlg').dialog('close');window.parent.$('#cru-change').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
                    Yii::app()->end();
                }
            }
            catch(Exception $e) 
            { 
               $transaction->rollBack(); 
               print_r($e);
               exit();
            }
        }

        if (!empty($_GET['asDialog']))
        {
            $this->layout = '//layouts/iframex';
            $this->render('update',array('model'=>$model,));
        }
        else
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionUpdateContract($id)
    {
        //$model = hrisContract::model()->findByAttributes(array("contractID"=>$id));
        $model = hrisContract::model()->getContract($id);
        $model->deptName = $model->deptName."-".$model->idDiv." / ".$model->branchName;
        $model->dispStart = date("d-m-Y", strtotime($model->startDate));
        $model->dispEnd = date("d-m-Y", strtotime($model->endDate));
       
        if(isset($_POST['hrisContract']) )
        {            
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $update = hrisContract::model()->findByAttributes(array("contractID"=>$id));
                //$update->contractReplacement = $_POST['hrisContract']['contractReplacement']; 
                $update->contractAction = $_POST['hrisContract']['contractAction']; 
                $update->isActive = 0;
                $update->save();
                
                if($update->contractAction !== "stop" && $update->contractAction !== "cont-os" && $update->contractAction !== "permanent")
                {
                    $model = new hrisContract;
                    $model->idCard = $update->idCard;
                    $model->idPos = $update->idPos;
                    $model->idDept = $update->idDept;
                    $model->idDiv = $update->idDiv;
                    $model->idBranch = $update->idBranch;

                    $model->startDate = date('Y-m-d', strtotime($update->endDate . '+1 day' ));
                    $model->endDate = date('Y-m-d', strtotime($model->startDate . "+$update->contractAction months"));                    
                    
                    if($update->contractType === "I")
                    {
                        $model->contractType = "II";                        
                    }
                    else
                    {
                        $model->contractType = "I";
                        $model->startDate = date('Y-m-d', strtotime($update->endDate . '+1 months' ));
                        $model->endDate = date('Y-m-d', strtotime($model->startDate . "+$update->contractAction months"));
                    }
                    $model->endDate = Utility::getEndDate($model->endDate);
                    
                    $model->save();                    
                }
                
                $transaction->commit();           
                
                if (!empty($_GET['asDialog']))
                {   
                    if($update->contractAction !== "stop" && $update->contractAction !== "permanent")
                    {
                        $kirimEmail = $this->kirimEmail($update->contractID);
                    }
                    
                    echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
                    Yii::app()->end();
                }
               
            }
            catch(Exception $e) 
            { 
               $transaction->rollBack(); 
               print_r($e);
               exit();
            }
        }

        if (!empty($_GET['asDialog']))
        {
            $this->layout = '//layouts/iframex';
            $this->render('updateContract',array('model'=>$model,));
        }
        else
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    protected function performAjaxValidation($model)
    {
            if(isset($_POST['ajax']) && $_POST['ajax']==='hris-contract-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }
    
    public function kirimEmail($id)
    {
        $ret =false;

        $model = hrisContract::model()->getContract($id);             
        
        $to[0] =  Employee::model()->findByAttributes(array("idCard"=>$model->deptHead))->email;             

        //$to = array("fajar.pratama@modena.co.id");
        $cc[0] = 'sasmito.adi@modena.co.id';
        $cc[1] = 'teresia.christina@modena.co.id';
        $bcc = array('fajar.pratama@modena.co.id');

        $subject ="Informasi Perpanjangan Kontrak Kerja :: ".$model->userName;                                                     
        $content = '';
    
        //template Kontrak
        $message = $this->mailTemplate(5);                            
        
        $message = str_replace("#nama#", $model->userName, $message);
        $message = str_replace("#departemen#", $model->deptName, $message);
        
        if($model->contractAction == "Dialihkan ke outsourcing"){
            $keterangan = "Diperpanjang melalui outsourcing. ";
            $message = str_replace("#keterangan#", $keterangan, $message);            
        }
        else
        {
            $keterangan = "Diperpanjang selama $model->contractAction. ";
            $message = str_replace("#keterangan#", $keterangan, $message);
        }
                
        $attachment = array();
            
        $this->mailsend($to,$cc,$bcc,$subject,$message,$attachment);       
        $ret = true;
        
        return $ret;
    }
        
    public function actionGetDepartment()
    {
        $data=  Department::model()->findAll(array('condition'=>"idDiv='".$_POST['idDiv']."'"));         
        $data=CHtml::listData($data,'idDept','deptName');

        foreach($data as $value=>$deptName)  {
            //echo $data ;
            echo CHtml::tag('option',
               array('value'=>$value),CHtml::encode($deptName),true);
        }
        
        
    }
            

    
    
    
    
    
    
    
    
    
}
