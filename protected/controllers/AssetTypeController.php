<?php

class AssetTypeController extends Controller
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
                        'actions'=>array('index','view','create','delete','mail'),
                        'users'=>array('@'),
                    ),
                    array('deny',  // deny all users
                            'users'=>array('*'),
                    ),
                );
        } 

    public function actionView($id)
    {
        //$allow=$this->checkRights('isView');
        $this->render('view',array(
                    'model'=>$this->loadModel($id),
            ));
    }

    

     
    public function actionUpdate($id)
    {
        $model = AssetType::model()->findByAttributes(array('TypeID'=>$id));  

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['AssetType']))
        {

            $model->attributes=$_POST['AssetType'];      
            $model->validate();
            // echo "<pre>";
            // print_r($model);
            //  echo "</pre>";
            //  exit(); 
            
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
        $model = new AssetType;        

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['AssetType']))
        {
            $model->attributes=$_POST['AssetType'];
                    
            $model->validate();

            if($model->validate())
            {
                if($model->save())
                {
                    $this->redirect(array('index'));
                }
            }                
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    } 

    public function ActionIndex()
    {
        $model=new AssetType('search');
        
        $model->unsetAttributes(); 
        //$model->keyWord = '';
        if(isset($_GET['AssetType']))
        {
            $model->attributes=$_GET['AssetType'];
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
        $model = AssetType::model()->findByAttributes(array('TypeID'=>$id)); 
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function actionCreateAssetDepartmentCode()
    {
        $model = new AssetDepartmentCode;        

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['AssetDepartmentCode']))
        {
            $model->attributes=$_POST['AssetDepartmentCode'];
                    
            $model->validate();

            if($model->validate())
            {
                if($model->save())
                {
                    $this->redirect(array('indexAssetDepartmentCode'));
                }
            }                
        }

        $this->render('createAssetDepartmentCode',array(
            'model'=>$model,
        ));
    } 

    public function ActionIndexAssetDepartmentCode()
    {
        $model=new AssetDepartmentCode('search');
        
        $model->unsetAttributes(); 
        //$model->keyWord = '';
        if(isset($_GET['AssetDepartmentCode']))
        {
            $model->attributes=$_GET['AssetDepartmentCode'];
        }
            

        $this->render('indexAssetDepartmentCode',array(
                'model'=>$model,
        ));
    }

    public function actionViewAssetDepartmentCode($id)
    {
        //$allow=$this->checkRights('isView');

        $model = AssetDepartmentCode::model()->getHeader($id);
        $this->render('viewAssetDepartmentCode',array(
                    'model'=>$model,
            ));
    }

    public function actionUpdateAssetNumber($id)
    {
        $model = AssetDepartmentCode::model()->findByAttributes(array('id'=>$id));  

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        if(isset($_POST['AssetDepartmentCode']))
        {

            $model->attributes=$_POST['AssetDepartmentCode'];      
            $model->validate();
            // echo "<pre>";
            // print_r($model);
            //  echo "</pre>";
            //  exit(); 
            
            if($model->validate())
            {
                if($model->save())
                {
                    $this->redirect(array('indexAssetDepartmentCode'));
                }
            }                
        }

        $this->render('updateAssetNumber',array(
            'model'=>$model,
        ));
    }
  

   
}