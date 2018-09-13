<?php

class MutationDetailTest extends CActiveRecord
{
       
        // public $typeName;
        // public $serialNumber;
        //public $assetNumber;
        public $assetDesc;
		public $keyWord;
       

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tr_assetMutationDetail';
	}

	public function rules()
	{
		return array(
			array(' mutationNo,  mutationDesc', 'required'),
			array('mutationNo, assetID, assetNumber', 'length', 'max'=>50),
			array('mutationDesc', 'length', 'max'=>200),
			array('inputUN, modifUN', 'length', 'max'=>30),
			array('inputTime, modifTime', 'safe'),
			array('mutationLineNo, mutationNo, assetID, assetNumber,assetDesc, mutationDesc, keyWord', 'safe', 'on'=>'search'),
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
			'mutationLineNo' => 'Mutation Line No',
			'mutationNo' => 'Mutation No',
			'assetID' => 'Asset',
				'assetNumber' => 'Asset',
                'assetDesc' => 'Asset',
			'mutationDesc' => 'Description',
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

		$criteria->compare('mutationLineNo',$this->keyWord,true,'OR');
		$criteria->compare('mutationNo',$this->keyWord,true,'OR');
		$criteria->compare('a.assetID',$this->keyWord,true,'OR');
			$criteria->compare('a.assetNumber',$this->keyWord,true,'OR');
           // $criteria->compare('a.assetDesc',$this->keyWord,true,'OR');
		$criteria->compare('mutationDesc',$this->keyWord,true,'OR');

        $criteria->alias='a';
        $criteria->select='a.assetID, a.assetNumber, c.TypeID, c.TypeName, b.assetDesc, b.assetLocation, b.acquisitionDate,
                    b.assetCondition, b.assetRemarks, b.ppbjNo, b.bapbNo, d.id, d.kodeAsset, null as Department, null as modenaPIC,
                    e.statusID, e.statusName, mutationNo';
        $criteria->join='left join ms_asset b on b.assetID=a.assetID
                left join ms_assetType c on c.TypeID=b.assetType
                left join ms_kodeAsset d on d.kodeAsset=b.idDept
                left join ms_assetStatus e on e.statusID=b.statusID';

		
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(         
                            'defaultOrder' => 'mutationNo',
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

	public function GetMutationDetail($mutationNo)
    {
        $criteria=array(
            'alias'=>'a',
            'select'=>'  a.mutationLineNo, a.mutationNo, a.assetID, a.assetNumber, a.mutationDesc',
            
            'condition'=>"                       
                    a.mutationNo = :cat " ,                                
            'params'=>array(
                ':cat' => $mutationNo,                            
            )
        ); 

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'mutationDesc ASC',
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
        ));
    }

    public function GetDetailAsset($assetID)
    {
        $criteria=array(
            'alias'=>'a',
            'select'=>'  a.mutationLineNo, a.mutationNo, a.assetID, a.assetNumber, a.mutationDesc',
            
            'condition'=>"                       
                    a.assetID = :cat " ,                                
            'params'=>array(
                ':cat' => $assetID,                            
            )
        ); 

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'mutationDesc ASC',
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