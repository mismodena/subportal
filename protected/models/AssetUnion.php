<?php

class AssetUnion extends CActiveRecord
{
	
	public $keyWord;
	public $mutationNo;

	public function tableName()
	{
		return 'vwAsset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' assetID, assetNumber,  TypeName ,assetDesc, assetLocation, acquisitionDate, assetCondition,assetRemarks, 
				Department,modenaPIC, statusName, mutationNo, keyWord', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'assetID' => 'ID',
			'assetNumber' => 'Asset Number',
			'TypeName'=> 'TypeName',
			'assetDesc' => 'Aktiva Tetap/ Deskripsi',
			'acquisitionDate' => 'Tanggal Perolehan',
			'assetLocation' => 'Lokasi',
			'assetRemarks' => 'Keterangan',
			'assetCondition'=> 'Kondisi',
			'Department'  => 'Departemen',
			'modenaPIC' => 'Modena PIC',
			'statusName' => 'Status',
			'mutationNo'=> 'mutationNo',


		);
	}

	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('assetID',$this->keyWord,true,'OR');
		$criteria->compare('assetNumber',$this->keyWord,true,'OR');
		$criteria->compare('assetDesc',$this->keyWord,true,'OR');
		$criteria->compare('acquisitionDate',$this->keyWord,true,'OR');
		$criteria->compare('assetLocation',$this->keyWord,true,'OR');
		$criteria->compare('assetRemarks',$this->keyWord,true,'OR');
		$criteria->compare('assetCondition',$this->keyWord,true,'OR');
		$criteria->compare('TypeName',$this->keyWord,true,'OR');
		$criteria->compare('Department',$this->keyWord,true,'OR');
		$criteria->compare('modenaPIC',$this->keyWord,true,'OR');
		$criteria->compare('TypeName',$this->keyWord,true,'OR');
		$criteria->compare('statusName',$this->keyWord,true,'OR');
		$criteria->compare('mutationNo',$this->keyWord,true,'OR');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(         
                            'defaultOrder' => 'assetNumber',
                            'attributes'=>array(
                                'TypeName'=>array(
                                    'asc'=>'TypeName',
                                    'desc'=>'TypeName DESC',
                                ),
                                'statusName'=>array(
                                    'asc'=>'statusName',
                                    'desc'=>'statusName DESC',
                                ),
                                '*',
                            ),
                        ),
                        'pagination'=>array(
                          'pageSize'=>10,
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


	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
