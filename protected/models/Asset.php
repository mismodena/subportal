<?php

class Asset extends CActiveRecord
{
	
 	public $Department;
 	public $TipeAsset;
 	public $TypeName;
 	public $statusName;
 	public $keyWord;
 	public $assetNumber;
 	public $assetID;
 	public $mutationNo;
 	public $user;
 	public $lokasi;

	public function tableName()
	{
		return 'ms_asset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('assetNumber,idDept', 'required'),
			array('assetLocation, assetCondition, assetType, idDept, modenaPIC', 'length', 'max'=>50),
			array('assetDesc, assetRemarks, ppbjNo, bapbNo, statusID', 'length', 'max'=>200),
			array('inputUN, modifUN', 'length', 'max'=>30),
			array('acquisitionDate', 'default', 'setOnEmpty' => true, 'value' => null),
			array('inputTime, modifTime', 'safe'),
			array('assetID, assetType, assetNumber,  assetDesc, assetLocation, assetCondition, ppbjNo, bapbNo,
			 TypeName,  Department, statusName, idDept,keyWord, mutationNo , lokasi', 'safe', 'on'=>'search'),
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
			'assetDesc' => 'Aktiva Tetap/ Deskripsi',
			'acquisitionDate' => 'Tanggal Perolehan',
			'assetLocation' => 'Lokasi',
			'assetRemarks' => 'Keterangan',
			'assetCondition'=> 'Kondisi',
			'idDept' => 'Departement',
				'Department'  => 'Departement',
			'modenaPIC' => 'Modena PIC',
			'assetType' => 'Tipe Asset',
				'TypeName' => 'Tipe Asset',
			'statusID' =>'Status',
				'statusName' => 'Status',
			'inputTime' => 'Input Time',
			'inputUN' => 'Input UN',
			'modifTime' => 'Modif Time',
			'modifUN' => 'Modif UN',
			'ppbjNo' => 'PPBJ No',
			'bapbNo' => 'BAPB No',
			'lokasi' => 'Lokasi',

		);
	}

	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('a.assetID',$this->keyWord,true,'OR');
		$criteria->compare('a.assetNumber',$this->keyWord,true,'OR');
		$criteria->compare('assetDesc',$this->keyWord,true,'OR');
		$criteria->compare('acquisitionDate',$this->keyWord,true,'OR');
		$criteria->compare('assetLocation',$this->keyWord,true,'OR');
		$criteria->compare('assetRemarks',$this->keyWord,true,'OR');
		$criteria->compare('assetCondition',$this->keyWord,true,'OR');
		$criteria->compare('c.id',$this->keyWord,true,'OR');
		$criteria->compare('a.idDept',$this->keyWord,true,'OR');
		$criteria->compare('a.modenaPIC',$this->keyWord,true,'OR');
		$criteria->compare('assetType',$this->keyWord,true,'OR');
		$criteria->compare('ppbjNo',$this->keyWord,true,'OR');
		$criteria->compare('bapbNo',$this->keyWord,true,'OR');
		$criteria->compare('Department',$this->keyWord,true,'OR');
		$criteria->compare('TypeName',$this->keyWord,true,'OR');
		$criteria->compare('statusName',$this->keyWord,true,'OR');
		$criteria->compare('lokasi',$this->keyWord,true,'OR');

		$criteria->alias='a';
		$criteria->select=' a.assetID, a.assetNumber assetNumber, b.TypeID, b.TypeName TypeName  , a.assetDesc, a.assetLocation, c.lokasi lokasi, a.acquisitionDate, 
					a.assetCondition,a.assetRemarks, a.ppbjNo, a.bapbNo,
						c.id, c.kodeAsset, c.Department Department, a.modenaPIC, e.statusID, e.statusName statusName, f.mutationNo';
		
		$criteria->join='left join ms_assetType b on b.TypeID=a.assetType
						left join ms_kodeAsset c on c.kodeAsset=a.idDept
						left join ms_assetStatus e on e.statusID=a.statusID
						left join tr_assetMutationDetail f on f.assetID=a.assetID
						';
		


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

	public function searchAsset()
	{
		// echo "ABCD";
		$search_string = "";
		if(isset($this->keyWord) && $this->keyWord != ""){
			$search_string = " where a.assetDesc like '%".$this->keyWord."%'";
		}
		$sql = "
				select a.assetID as assetID, a.assetNumber as assetNumber, b.TypeID as TypeID, b.TypeName as TypeName , a.assetDesc as assetDesc, 
				a.assetLocation as assetLocation, c.lokasi as lokasi, a.acquisitionDate as acquisitionDate, a.assetCondition as assetCondition,a.assetRemarks as assetRemarks, 
						c.id as id, c.kodeAsset as kodeAsset, c.Department as Department, a.modenaPIC as modenaPIC, e.statusID as statusID, e.statusName as statusName, null as mutationNo
				from ms_asset a
				left join ms_assetType b on b.TypeID=a.assetType
				left join ms_kodeAsset c on c.kodeAsset=a.idDept
				left join ms_assetStatus e on e.statusID=a.statusID
				left join tr_assetMutationDetail f on f.assetID=a.assetID".$search_string."
				union all
				select  a.assetID as assetID, a.assetNumber as assetNumber, c.TypeID as TypeID, c.TypeName as TypeName, b.assetDesc as assetDesc, b.assetLocation as assetLocation,
					d.lokasi as lokasi,  b.acquisitionDate as acquisitionDate,
					b.assetCondition as assetCondition, b.assetRemarks as assetRemarks ,  d.id as id, d.kodeAsset as kodeAsset, null as Department, null as modenaPIC,
					e.statusID as statusID, e.statusName as statusName, mutationNo as mutationNo
				from tr_assetMutationDetail a
				left join ms_asset b on b.assetID=a.assetID
				left join ms_assetType c on c.TypeID=b.assetType
				left join ms_kodeAsset d on d.kodeAsset=b.idDept
				left join ms_assetStatus e on e.statusID=b.statusID".$search_string."
				";

	  	$result = Yii::app()->db->createCommand($sql)->queryAll();
		return new CSqlDataProvider ($sql, array(
			'keyField' => 'assetID',
			'totalItemCount' => count($result),
			'sort'=>array(
		        'attributes'=>array('assetNumber'),
		        //'defaultOrder' =>'assetNumber',
			),
            'pagination'=>array(
       			'pageSize'=>10,
            ),
		));
	}

		

	public function getHeader($assetID)
    {   
        $criteria=new CDbCriteria;
                    
        $criteria->compare('a.assetID',$assetID,true);
             
        $criteria->alias='a';
        $criteria->select='a.assetID, a.assetNumber, b.TypeID, b.TypeName TipeAsset , a.assetDesc, a.assetLocation, c.lokasi lokasi, a.acquisitionDate, a.assetCondition,a.assetRemarks, a.ppbjNo, a.bapbNo,
					c.id, c.kodeAsset, c.Department Department, a.modenaPIC, e.statusID, e.statusName ';
        $criteria->join='left join ms_assetType b on b.TypeID=a.assetType
						left join ms_kodeAsset c on c.kodeAsset=a.idDept
						left join ms_assetStatus e on e.statusID=a.statusID
                        ';
        //$criteria->addCondition(" urutan in ( select max (urutan) from tr_assetDisposalApproval where disposalNo=a.disposalNo and  persetujuan = 1) ");

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
