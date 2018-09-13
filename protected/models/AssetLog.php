<?php

class AssetLog extends CActiveRecord
{
        public $fromDate;
        public $toDate;
        public $PICMis;
        public $PICUser;
        public $assetModel;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tr_assetLog';
	}

	public function rules()
	{
		return array(
			array('logLineNo, assetID, logDate, logDesc', 'required'),
			array('logLineNo', 'length', 'max'=>19),
			array('assetID', 'length', 'max'=>50),
			array('logDesc', 'length', 'max'=>1000),
			array('inputUN, modifUN', 'length', 'max'=>30),
			array('inputTime, modifTime', 'safe'),
			array('LogLineNo, assetID, logDate, logDesc, 
                                fromDate, toDate, PICUser, PICMis, assetModel', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'LogLineNo' => 'Line No',
			'assetID' => 'Asset ID',
			'logDate' => 'Date',
			'logDesc' => 'Description',
			
                        // 'fromDate' => 'From Date',
                        // 'toDate' => 'To Date',
                        // 'PICUser' => 'User',
                        // 'PICMis' => 'MIS PIC',
                        // 'assetNumber' => 'Asset Number'
                        // 'assetDesc' => 'Model',
			'inputTime' => 'Input Time',
			'inputUN' => 'Input Un',
			'modifTime' => 'Modif Time',
			'modifUN' => 'Modif Un',
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('LogLineNo',$this->LogLineNo,true);
		$criteria->compare('a.assetID',$this->assetID,true);
		$criteria->compare('logDate',$this->logDate,true);
		$criteria->compare('logDesc',$this->logDesc,true);
		$criteria->compare('inputTime',$this->inputTime,true);
		$criteria->compare('inputUN',$this->inputUN,true);
		$criteria->compare('modifTime',$this->modifTime,true);
		$criteria->compare('modifUN',$this->modifUN,true);

        $criteria->alias='ad';
                $criteria->select=" ad.LogLineNo , a.assetID, a.assetNumber , ad.mutationDesc";
                $criteria->join='left join ms_asset a on ad.assetID = a.assetID
                                  ';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'defaultOrder'=>array('logDate'=>true,),
                        'pagination'=>array(
                            'pageSize'=>10,
                        ),
		));
	}
        
        // public function logMonitoring()
        // {
        //     $criteria=new CDbCriteria;  
        //     $criteria->compare('al.assetID',$this->assetID,true);
        //     $criteria->compare('assetModel',$this->assetModel,true);
        //     $criteria->compare('PICUser',$this->PICUser,true);
        //     $criteria->compare('logDesc',$this->logDesc,true);
        //     $criteria->compare('logSolution',$this->logSolution,true);
        //     $criteria->compare('logCategory',$this->logCategory,true);
        //     $criteria->compare('logStatus',$this->logStatus,true);
        //     $criteria->compare('PICMis',$this->PICMis,true);
        //     $criteria->alias='al';
        //     $criteria->select='u.PICName as PICUser, model as assetModel, logDate, logDesc, logSolution, logCategory, logStatus, p.PICName as PICMis ';
        //     $criteria->join=' left join vwLookupPIC p on p.PICNo = al.logPIC
        //                     left join ms_asset a on a.assetID = al.assetID
        //                     left join vwLookupPIC u on u.deptID = a.deptID and u.PICNo = a.userPIC
        //                     ';
            

        //     return new CActiveDataProvider($this, array(
        //             'criteria'=>$criteria,                    
        //              'sort'=>array(         
        //                 'defaultOrder' => 'logDate DESC', 
        //                  'attributes'=>array(
        //                     'model'=>array(
        //                         'asc'=>'model',
        //                         'desc'=>'model DESC',
        //                     ),
        //                     'PICUser'=>array(
        //                         'asc'=>'PICUser',
        //                         'desc'=>'PICUser DESC',
        //                     ),
        //                     'PICMis'=>array(
        //                         'asc'=>'PICMis',
        //                         'desc'=>'PICMis DESC',
        //                     ),
        //                     '*',
        //                  ),
        //              ),                        
        //              'pagination'=>array(
        //               'pageSize'=>20,
        //              ),
        //     ));

        // }
                
        protected function beforeSave()
        {
            if(parent::beforeSave())
            {
                if($this->isNewRecord)
                {
                        $this->inputTime=new CDbExpression('getdate()');
                        $this->inputUN=Yii::app()->user->name;
                        $this->modifTime=new CDbExpression('getdate()');
                        $this->modifUN=Yii::app()->user->name;
                }
                else
                        $this->modifTime=new CDbExpression('getdate()');
                        $this->modifUN=Yii::app()->user->name;
                return true;
            }
            else
                    return false;
        }
}