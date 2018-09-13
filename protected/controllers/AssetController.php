<?php

class AssetController extends Controller
{
    
    public $layout='leftbar';
    
    function init() {
        parent::init();
        $this->leftPortlets['ptl.AssetMenu'] = array();
    }

    public function filters()
    {
        return array(
            'Rights',
            //'accessControl', // perform access control for CRUD operations
            //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function allowedActions()
    {
        return 'index';
    }

    public function accessRules()
        {
            return array(
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                        'actions'=>array('index','view','create','delete','mail','ExportExcel'),
                        'users'=>array('@'),
                    ),
                    array('deny',  // deny all users
                            'users'=>array('*'),
                    ),
                );
        } 

    public function actionView($id)
    {
        $model = Asset::model()->getHeader($id);
        $detail = MutationDetail::model()->getDetailAsset($model->assetID);
        $this->render('view',array(
                    'model'=>$model,
                    'detail'=>$detail,

            ));
    }

    public function viewDetail($id)
    {            
        $detailDataProvider=new CActiveDataProvider('AssetLog',array(
            'criteria'=>array(
            'condition'=>'assetID=:assetID',
            'params'=>array(':assetID'=>$id),
                ),
                'pagination' => false,                
                //'pagination'=>array(
                //    'pageSize'=>10,
                //),
            ));
        return $detailDataProvider;
    }

    public function viewHistory($id)
    {            
        $historyDataProvider=new CActiveDataProvider('Asset',array(
            'criteria'=>array(
            'condition'=>'assetID=:assetID',
            'params'=>array(':assetID'=>$id),
                ),
                'pagination' => false,                
                //'pagination'=>array(
                //    'pageSize'=>10,
                //),
            ));
        return $historyDataProvider;
    }


    public function actionUpdate($id)
    {
        $model = Asset::model()->findByAttributes(array('assetID'=>$id));  

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['Asset']))
        {
            $model->attributes=$_POST['Asset'];
            //$model->assetNumber=Utility::getAssetNumber($model->idDept);       
            $model->validate();
            
            if($model->validate())
            {
                if($model->save())
                {
                    $this->redirect(array('index'));
                }
            }                
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }



    public function actionCreate()
    {
        $model = new Asset; 
        //$employee = Employee::model()->getActiveEmployee();       
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['Asset']))
        {
            $model->attributes=$_POST['Asset'];
            $model->statusID='1'; //insert hardcode
            $model->assetNumber=Utility::getAssetNumber($model->idDept);
                    
            //$model->validate();

            $transaction = Yii::app()->db->beginTransaction();
            try 
            {
               
                $model->save() ;
                if ($model->assetType=='1' AND $user= Yii::app()->user->name !== 'Elsa Yuliana Sari' ) 
                {
                   
                    $list = Yii::app()->db->createCommand('select assetID from ms_asset order by inputTime desc')->queryAll();
                    $assetID = "";
                    foreach($list as $item)
                    {
                        $assetID = $item['assetID'];
                        break;
                    }
                    $transaction->commit();
                    $this->redirect(array('mail', 'id'=>$assetID,));
                    exit();
                }
                else
                {
                    $transaction->commit();
                    $this->redirect(array('index'));
                }
                
                
  
            } 
            catch (Exception $ex)
            {
                //$transaction->rollBack();
                throw new CHttpException(403, $ex);
                Yii::app()->user->setFlash('Error', $ex);
                $this->redirect(array('index'));
            }        
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    } 

    public function actionMail($id)
    {
        $model = Asset::model()->findByAttributes(array('assetID'=>$id));
         
        //$to = array("meriza.putri@modena.co.id");
		 $to = array("elsa.sari@modena.co.id");
        $cc = '';
        $bcc = array('meriza.putri@modena.co.id');

        $subject ="Penambahan Asset :: Low Value Asset";                            
        $content = '';

        $message = $this->mailTemplate(10);
        $message = str_replace("#assetNumber#", $model->assetNumber, $message);
        $message = str_replace("#assetDesc#", $model->assetDesc, $message);
        $message = str_replace("#assetLocation#", $model->assetLocation, $message);
        $message = str_replace("#acquisitionDate#", date("d-m-Y", strtotime($model->acquisitionDate)), $message);
        $message = str_replace("#assetCondition#",$model->assetCondition, $message);
        $message = str_replace("#assetRemarks#",$model->assetRemarks, $message);

        $this->mailsend($to,$cc,$bcc,$subject,$message);
        $this->redirect(array('index' ,));

    }

    public function ActionIndex()
    {
        $this->leftPortlets = array();
        $this->leftPortlets['ptl.AssetMenu'] = array(); 

        $model=new AssetUnion('search');
        
        $model->unsetAttributes(); 
        //$model->keyWord = '';
        if(isset($_GET['AssetUnion']))
        {
            $model->attributes=$_GET['AssetUnion'];
        }

        $this->render('index',array(
                'model'=>$model,
        ));
    }

   
    public function ActionDelete($id)
    {
        
            $this->loadModel($id)->delete();

            if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
       
    }

    public function actionGetPICActive() 
    {              

            $data=LookupView::getPICActive($_POST['idDept']);         
            $data=CHtml::listData($data,'idCard','userName');
            
            foreach($data as $value=>$userName)  {
                //echo $data ;
                echo CHtml::tag('option',
                   array('value'=>$value),CHtml::encode($userName),true);
            }
    }

    public function actionGetAssetDept() 
    {              

            $data=LookupView::getKodeAssetDept($_POST['kodeAsset']);         
            $data_list=CHtml::listData($data,'assetID','assetDesc');
            //print_r($data);
            $address = 0;
            echo "<option value=''>-- Pilih --</option>\n";
            foreach($data_list as $value=>$assetDesc)  {
                //echo $data ;
                echo CHtml::tag('option',
                   array('value'=>$value),CHtml::encode($data[$address]['assetNumber'] . " - " . $assetDesc),true) . "\n";
                $address++;
            }
    }

    public function actionExportExcel()
    {
        $model=new AssetUnion('search');
        //$model->inputTime = new CDbExpression('getdate()');
        $model->attributes=isset($_POST['AssetUnion']);
        

        $this->widget('ext.EExcelView', array(
            'title'=>'Daftar Project',
            'dataProvider' => $model->search(),
            'filter'=>$model,
            'grid_mode'=>'export',
            'columns'=>array(
                array(
                    'header' => 'assetNumber', //number asset
                    'value' => '$data->assetNumber',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'TypeName', //tipe asset
                    'value' => '$data->TypeName',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'assetDesc', //deskripsi
                    'value' => '$data->assetDesc',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'assetLocation', //lokasi
                    'value' => '$data->assetLocation',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'Department',
                    'value' => '$data->Department',
                    'htmlOptions' => array('width' => '60px'),
                ),
                 array(
                    'name' => 'modenaPIC',
                    'value' => '$data->modenaPIC',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'acquisitionDate',
                    //'value' => 'date("d-m-Y",strtotime($data->acquisitionDate))',
                    'value' => '$data->acquisitionDate == null ? "-" : date("d-m-Y",strtotime($data->acquisitionDate))',
                    'htmlOptions' => array('width' => '70px'),
                ),
                array(
                    'name' => 'assetCondition',
                    'value' => '$data->assetCondition',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'statusName',
                    'value' => '$data->statusName',
                    'htmlOptions' => array('width' => '60px'),
                ),
                array(
                    'name' => 'assetRemarks',
                    'value' => '$data->assetRemarks',
                    'htmlOptions' => array('width' => '60px'),
                ),
                 array(
                    'name' => 'Nomor MAT',
                    'value' => '$data->mutationNo',
                    'htmlOptions' => array('width' => '60px'),
                ),

            ),
        ));
    
    }    

    
    protected function performAjaxValidation($model)
    {
            if(isset($_POST['ajax']) && $_POST['ajax']==='asset-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }

    public function loadModel($id)
    {
        $model=Asset::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
  

   
}