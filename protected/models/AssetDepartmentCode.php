<?php

class AssetDepartmentCode extends CActiveRecord
{
	
 	public $keyWord;

	public function tableName()
	{
		return 'ms_kodeAsset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Department, kodeAsset', 'required'),
			array('id, Department, kodeAsset, PICDept, lokasi', 'length', 'max'=>150),
			array('inputUN, modifUN', 'length', 'max'=>30),
			array('inputTime, modifTime', 'safe'),
			array('id, Department, kodeAsset, lokasi, PICDept, keyWord', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'Department' => 'Department/Cabang',
			'kodeAsset' => 'Kode Asset',
			'PICDept' => 'Dept. Head/BM',
			'lokasi' => 'Lokasi',
			'inputTime' => 'Input Time',
			'inputUN' => 'Input UN',
			'modifTime' => 'Modif Time',
			'modifUN' => 'Modif UN',

		);
	}

	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->keyWord,true,'OR');
		$criteria->compare('Department',$this->keyWord,true,'OR');
		$criteria->compare('kodeAsset',$this->keyWord,true,'OR');
		$criteria->compare('PICDept',$this->keyWord,true,'OR');
		$criteria->compare('lokasi',$this->keyWord,true,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getHeader($id)
	{   
            $criteria=new CDbCriteria;
                        
            $criteria->compare('id',$id,true);            
            $criteria->alias = 'a';                            
            $criteria->select=" id, Department, PICDept, lokasi, kodeAsset ";   


            return  $this->find($criteria);
	}
       

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

	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
