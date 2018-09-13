<?php

class Disposal extends CActiveRecord
{
    public $fromDeptName;
    public $fromPICName;
    public $items;
    public $disposalDateLong;
    public $keyWord;
    public $image;
    public $keterangan;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tr_assetDisposal';
	}

	public function rules()
	{
		return array(
			array('disposalNo, disposalDate', 'required'),
			array('disposalNo', 'length', 'max'=>50),
            array('fromDept, fromPIC', 'length', 'max'=>10),
			array('inputUN, modifUN', 'length', 'max'=>30),
			array('inputTime, modifTime', 'safe'),
			array('disposalNo, disposalDate, disposalDateLong, fromDept,fromDeptName, fromPIC,fromPICName, keyWord, keterangan', 'safe', 'on'=>'search'),
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
			'disposalNo' => 'Disposal No',
			'disposalDate' => 'Tanggal',
            'fromDept' => 'Department/Cabang',
            'fromPIC' => 'Pemohon',
                        'fromDeptName' => 'Department/Cabang',
                        'fromPICName' => 'Pemohon',           
			'inputTime' => 'Input Time',
			'inputUN' => 'Input Un',
			'modifTime' => 'Modif Time',
			'modifUN' => 'Modif Un',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('a.disposalNo',$this->keyWord,true,'OR');
		$criteria->compare('disposalDate',$this->keyWord,true,'OR');
        $criteria->compare('a.fromDept',$this->keyWord,true,'OR');
            // $criteria->compare('b.fromDeptName',$this->keyWord,true,'OR');
                $criteria->compare('b.Department',$this->keyWord,true,'OR');
        $criteria->compare('a.fromPIC',$this->keyWord,true,'OR');
            // $criteria->compare('c.fromPICName',$this->keyWord,true,'OR');
              $criteria->compare('c.userName',$this->keyWord,true,'OR');
        $criteria->addCondition("urutan in ( select max (urutan) from tr_assetDisposalApproval where disposalNo=a.disposalNo and  persetujuan =1) ");
        

        $criteria->alias='a';
        $criteria->select="a.disposalNo, a.disposalDate,  b.Department fromDeptName, c.userName fromPICName,"
                        ."case"
                        ." when keterangan = 'Pengajuan Disposal'  then 'Menunggu Persetujuan : Dept. Head/BM' "
                        ." when keterangan ='DEPTHEAD-BM' then 'Menunggu Persetujuan : Accounting' "
                        ." when keterangan ='Accounting' then 'Menunggu Persetujuan : Internal Auditor' "
                        ." when keterangan ='Internal Auditor' then 'Menunggu Persetujuan : AM Div. Head' "
                        ." when keterangan ='AM Div. Head' then 'Menunggu Persetujuan :Direktur'"
                        ." when keterangan ='Direktur' then 'Disposal Selesai' "
                        ."end as keterangan"
                              ;
        $criteria->join='left join ms_kodeAsset b on b.kodeAsset= a.fromDept
                            left join vwEmployee c on c.idCard=a.fromPIC 
                            left join tr_assetDisposalApproval d on d.disposalNo=a.disposalNo
                        ';
        
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(         
                            'defaultOrder' => 'disposalNo',
                            'attributes'=>array(
                                'fromDeptName'=>array(
                                    'asc'=>'fromDeptName',
                                    'desc'=>'fromDeptName DESC',
                                ),
                                'fromPICName'=>array(
                                    'asc'=>'fromPICName',
                                    'desc'=>'fromPICName DESC',
                                ),
                                '*',
                            ),
                        ),
                        'pagination'=>array(
                          'pageSize'=>10,
                        ),
		));
	}

    public function getHeader($disposalNo)
    {   
        $criteria=new CDbCriteria;
                    
        $criteria->compare('a.disposalNo',$disposalNo,true);
             
        $criteria->alias='a';
        $criteria->select='a.disposalNo, a.disposalDate,  b.Department fromDeptName, c.userName fromPICName';
        $criteria->join='left join ms_kodeAsset b on b.kodeAsset= a.fromDept
                        left join vwEmployee c on c.idCard=a.fromPIC
                        ';
        //$criteria->addCondition(" urutan in ( select max (urutan) from tr_assetDisposalApproval where disposalNo=a.disposalNo and  persetujuan = 1) ");

        return  $this->find($criteria);
    }

    public static function getListFile($disposalNo)
    {
        if(empty($disposalNo))  
        $disposalNo = null;  
       
        //echo $idDept . "\n";    
        $record = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('tr_assetDisposalAttachment')
                    ->where("disposalNo=:id ", array(':id'=>$disposalNo))
                    ->queryAll();
        //print_r($record);
        return $record;        
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