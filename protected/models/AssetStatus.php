<?php
class AssetStatus extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function tableName()
	{
		return 'ms_assetStatus';
	}

	public function rules()
	{
		return array(
            array('statusID', 'unique'),
			//array('statusID, statusName', 'required'),
			array('statusID', 'length', 'max'=>20),
			array('statusName', 'length', 'max'=>30),
			array('statusID, statusName', 'safe', 'on'=>'search'),
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
			'statusID' => 'ID',
			'statusName' => 'Name',

		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('statusID',$this->statusID,true);
		$criteria->compare('statusName',$this->statusName,true);

		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>20,
                        ),
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
}