<?php

class DisposalAttachment extends CActiveRecord
{

	public $image;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tr_assetDisposalAttachment';
	}

	public function rules()
	{
		return array(
			//array('disposalAttachNo, disposalNo', 'required'),
			//array('disposalAttachNo', 'length', 'max'=>19),
			array('disposalNo', 'length', 'max'=>50), 
			array('fileName, filePath', 'length', 'max'=>200),
			array('inputUN, modifUN', 'length', 'max'=>30),
			array('inputTime, modifTime', 'safe'),
            /* array('filePath', 'file', 'types'=>'jpg, gif, png, pdf, rar, zip'), */
			array('disposalNo, fileName, inputTime, inputUN, modifTime, modifUN', 'safe', 'on'=>'search'),
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
			//'disposalAttachNo' => 'No Atachment Disposal',
			'disposalNo' => 'Disposal No',
			'fileName' => 'File Name',
            'filePath' => 'File Path',
			'inputTime' => 'Input Time',
			'inputUN' => 'Input Un',
			'modifTime' => 'Modif Time',
			'modifUN' => 'Modif Un',
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		//$criteria->compare('disposalAttachNo',$this->disposalAttachNo,true);
		$criteria->compare('disposalNo',$this->disposalNo,true);
		$criteria->compare('fileName',$this->fileName,true);
		$criteria->compare('inputTime',$this->inputTime,true);
		$criteria->compare('inputUN',$this->inputUN,true);
		$criteria->compare('modifTime',$this->modifTime,true);
		$criteria->compare('modifUN',$this->modifUN,true);

		$criteria->alias='a';
        $criteria->select=' a.disposalAttachNo, b.disposalNo, a.filePath ';
        $criteria->join='left join tr_assetDisposal b on b.disposalNo=a.disposalNo
                        ';

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
}