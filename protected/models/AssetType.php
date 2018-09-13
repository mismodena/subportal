<?php

class AssetType extends CActiveRecord
{
	
 	public $keyWord;

	public function tableName()
	{
		return 'ms_assetType';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' TypeName', 'required'),
			array('TypeID, TypeName', 'length', 'max'=>50),
			array('TypeDesc', 'length', 'max'=>150),
			array('inputUN, modifUN', 'length', 'max'=>30),
			array('inputTime, modifTime', 'safe'),
			array('TypeID, TypeName, TypeDesc, keyWord', 'safe', 'on'=>'search'),
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
			'TypeID' => 'Type ID',
			'TypeName' => 'Type Name',
			'TypeDesc' => 'Type Desc',
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

		$criteria->compare('TypeID',$this->keyWord,true,'OR');
		$criteria->compare('TypeName',$this->keyWord,true,'OR');
		$criteria->compare('TypeDesc',$this->keyWord,true,'OR');


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
