<?php

class UserController extends Controller
{
	private $_model;

	public $layout='leftbar';

	function init()
	{
            parent::init();
            $this->leftPortlets['ptl.UtilityMenu']=array();
	}

        public function filters()
	{
            return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete', // we only allow deletion via POST request
            );
	}

	public function accessRules()
	{
            return array(
                    array('allow', // allow authenticated user to perform 'create' and 'update' actions
                            'actions'=>array('index','view','create','update','admin','delete'),
                            'users'=>array('@'),
                    ),
                    array('deny',  // deny all users
                            'users'=>array('*'),
                    ),
            );
	}

        public function actionView($id)
	{
            $this->render('view',array(
                    'model'=>$this->loadModel($id),
            ));
	}

	public function actionCreate()
	{
            $model=new User;
            $itemsToDisplay = 2;
            for($x = 0; $x <= $itemsToDisplay-1; $x++)
                $model->items[] = new Appright();
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            $this->performAjaxValidation($model);

            if(isset($_POST['User']))
            {
                    $model->attributes=$_POST['User'];
                    /* The child models */
                    if (isset($_POST['Appright'])) {
                        $valid = true;
                        echo count($_POST['Appright']);
                        if (count($_POST['Appright']) > 0) {
                            $model->items = array();
                            /* Create enough blank models for the child records, then populate them with a massive assign */
                            for ($x = 0; $x < count($_POST['Appright']); $x++) {
                                $item = new Appright();
                                if (isset($_POST['Appright'][$x])) {
                                    $item->attributes = $_POST['Appright'][$x];
                                    /* If it is empty then it is just an empty row from the form so ignore */
                                    //if ($item->isNotEmpty()) {
                                        if (!empty($item)) {
                                        $valid = $item->validate() && $valid;
                                        /* It is valid so add the populated item to the array
                                         * – ready to be used in PurchaseLedger afterSave() */
                                        $model->items[] = $item;
                                    }
                                }
                            }
                        }

                        /* If the PurchaseLedger validates AND the items have already validated then do the saving of everything */
                        if ($model->validate() && $valid) {
                            /* We know that the child records are all valid so can be saved by the
                             * PurchaseLedger aftersave method in the model
                             */
                            echo 'xxxxx';
                            //print_r($model);
                            //if ($model->save()) {
                             //   //$this->redirect(array(‘supplier/view’,'id’=>$model->supplierId));
                            //}
                        }else{echo 'ssss';}
                    }
                    /*if($model->save())
                            $this->redirect(array('view','id'=>$model->userid));*/
            }

            $this->render('create',array(
                    'model'=>$model,
            ));
	}
 
        public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->userid));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

        protected function performAjaxValidation($model)
        {
            if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
            {
                //$parentModelValidationResults = json_decode(CActiveForm::validate($model), 1);
                //$childModelValidationResults = json_decode(CActiveForm::validateTabular($model->items), 1);
                //echo json_encode(array_merge($parentModelValidationResults, $childModelValidationResults));
                $parentModelValidationResults = json_decode(CActiveForm::validate($model), 1);
                echo json_encod($parentModelValidationResults);
                Yii::app()->end();
            }
        }
}
