<?php

class MoaroleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

        /**
        * @var CActiveRecord the currently loaded data model instance.
        */
       private $_model;

       /**
        * @var string the default layout for the views.
        */
       public $layout = 'leftbar';

       /**
        * initialize the default portlets for the views
        */
       function init() {
           parent::init();
           $this->leftPortlets['ptl.UtilityMenu'] = array();
       }
    
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
            return array(
              array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                  'actions'=>array('index','view','create','update','admin','check','delete','useridentity'),
                                  'users'=>array('@'),
                          ),
                          array('deny',  // deny all users
                                  'users'=>array('*'),
                          ),
              );
        }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id1,$id2)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id1,$id2),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Moarole;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

                
		if(isset($_POST['Moarole']))
		{
			$model->attributes=$_POST['Moarole'];
                        //print_r($model->attributes);
                        $isValid = $model->validate();
                        if ($isValid) {
                            try{
                                $transaction = Yii::app()->db->beginTransaction();
                                //$model->save();
                                //if($model->save())
                                //    $this->redirect(array('view','id1'=>$model->idcard,'id2'=>$model->appcode));
                                if($model->save()){
                                    $transaction->commit();
                                    $this->redirect(array('moarole/admin'));
                                }
                            }catch (Exception $e) {
                                $transaction->rollBack();
                                throw new CHttpException(403, $e);
                                exit(json_encode(array('result' => 'error', 'msg' => 'No input data has been passed.')));
                            }
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id1,$id2)
	{
		$model=$this->loadModel($id1,$id2);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Moarole']))
		{
			$model->attributes=$_POST['Moarole'];
                        $isValid = $model->validate();
                        if ($isValid) {
                            try{
                                $transaction = Yii::app()->db->beginTransaction();
                                //$model->save();
                                if($model->save())
                                    $this->redirect(array('view','id1'=>$model->idcard,'id2'=>$model->appcode));
                                $transaction->commit();
                            }catch (Exception $e) {
                                $transaction->rollBack();
                                throw new CHttpException(403, $e);
                                exit(json_encode(array('result' => 'error', 'msg' => 'No input data has been passed.')));
                            }
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id1,$id2)
	{
		$this->loadModel($id1,$id2)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Moarole');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Moarole('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Moarole']))
			$model->attributes=$_GET['Moarole'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Moarole the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id1,$id2)
	{
		//$model=Moarole::model()->findByPk($id);
                $model = Moarole::model()->findByAttributes(array('idcard' => $id1, 'appcode' => $id2));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Moarole $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='moarole-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionUserIdentity()
	{
		if(isset($_GET['id']))
			$model=User::model()->findbyAttributes(array('idcard'=>$_GET['id']));
		if($model!==null)
		{
			$data=array();
		    	$data[] = $model->username;
                        $data[] = $model->usernik;
                        $data[] = $model->deptid;
                        $data[] = $model->branch;
                        $data[] = $model->email;
			//echo $data;
                        echo implode(', ', $data);
		}

	}
}
