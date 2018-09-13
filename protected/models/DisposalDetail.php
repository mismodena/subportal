<?php

class DisposalDetail extends CActiveRecord
{
       
        // public $typeName;
        // public $serialNumber;
        public $assetNumber;
        public $assetDesc;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tr_assetDisposalDetail';
	}

	public function rules()
	{
		return array(
			array(' disposalNo,  assetID', 'required'),
			array('disposalNo, assetID', 'length', 'max'=>50),
			array('disposalDesc, qty, nilaiasset', 'length', 'max'=>200),
			array('inputUN, modifUN', 'length', 'max'=>30),
			array('inputTime, modifTime', 'safe'),
			array('disposalLineNo, disposalNo, assetID, assetNumber, assetDesc,disposalDesc, nilaiasset', 'safe', 'on'=>'search'),
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
			'disposalLineNo' => 'Disposal Line No',
			'disposalNo' => 'Disposal No',
			'assetID' => 'Asset',
			'qty' =>'Jumlah',
      'nilaiasset' => 'Asset Jurnal',
				'assetNumber' => 'Asset',
        'assetDesc' =>'Asset',
			//'mutationStatus' => 'Status',
			'disposalDesc' => 'Description',
			'inputTime' => 'Input Time',
			'inputUN' => 'Input Un',
			'modifTime' => 'Modif Time',
			'modifUN' => 'Modif Un',
                        // 'typeName' => 'Type',
                        // 'serialNumber' => 'Serial Number',
		);
	}

	public function search()
	{	
		$criteria=new CDbCriteria;

		$criteria->compare('disposalLineNo',$this->disposalLineNo,true);
		$criteria->compare('disposalNo',$this->disposalNo,true);
		$criteria->compare('a.assetID',$this->keyWord,true,'OR');
      $criteria->compare('a.assetNumber',$this->keyWord,true,'OR');
      $criteria->compare('a.assetDesc',$this->keyWord,true,'OR');
    $criteria->compare('qty', $this->qty,true);
		$criteria->compare('disposalDesc',$this->disposalDesc,true);
    $criteria->compare('nilaiasset',$this->keyWord,true);

    $criteria->alias='ad';
    $criteria->select="ad.disposalLineNo, ad.disposalNo , a.assetID, a.assetNumber, a.assetDesc, ad.qty, ad.disposalDesc, ad.nilaiasset nilaiasset";
    $criteria->join='left join ms_asset a on ad.assetID = a.assetID
                                 ';

		return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
      'sort'=>array(         
                            'defaultOrder' => 'disposalNo',
                            'attributes'=>array(
                                'assetNumber'=>array(
                                    'asc'=>'assetNumber',
                                    'desc'=>'assetNumber DESC',
                                ),
                                '*',
                            ),
                        ),
                        'pagination'=>array(
                          'pageSize'=>10,
                        ),
    ));
	
	}

  public function GetDisposalDetail($disposalNo)
    {
        $criteria=array(
            'alias'=>'a',
            'select'=>'  a.disposalLineNo, a.disposalNo,a.assetID, a.disposalDesc, a.nilaiasset nilaiasset, a.qty ',
            'condition'=>"                       
                    a.disposalNo = :cat " ,                                
            'params'=>array(
                ':cat' => $disposalNo,                            
            )
        ); 

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'disposalDesc ASC',
            ),
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