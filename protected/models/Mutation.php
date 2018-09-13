<?php

class Mutation extends CActiveRecord
{
        public $fromPICName;
        public $fromDeptName;
        public $toPICName;
        public $toDeptName;
        public $mutationDateLong;
        public $items;
        public $keyWord;
        public $print;
        public $verified;
        public $keterangan;
        public $approval;
        public $nameDiv;

        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tr_assetMutation';
	}

	public function rules()
	{
		return array(
			array('mutationNo, mutationDate,  toDept, toPIC', 'required'),
			array('mutationNo', 'length', 'max'=>50),
			array(' fromPIC, toPIC', 'length', 'max'=>100),
			array('fromDept, toDept', 'length', 'max'=>100),
			array('inputUN, modifUN', 'length', 'max'=>30),
			array('inputTime, modifTime', 'safe'),
			array('mutationNo, mutationDate, mutationDateLong, fromDept, toDept, fromPIC, toPIC, fromPICName, 
                fromDeptName, toPICName, toDeptName, keterangan, nameDiv, 
                keyWord, print, verified,  approval', 'safe', 'on'=>'search'),
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
			'mutationNo' => 'Mutation No',
			'mutationDate' => 'Date',
			'fromDept' => '|',
			'toDept' => 'To',
			'fromPIC' => 'From',
			'toPIC' => 'Name',
                        'toPICName' => 'Penerima/User',
                        'toDeptName' => 'Department',
                        'fromPICName' => 'Pemohon/User',
                        'fromDeptName' => 'Department',
			'inputTime' => 'Input Time',
			'inputUN' => 'Input Un',
			'modifTime' => 'Modif Time',
			'modifUN' => 'Modif Un',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('a.mutationNo',$this->keyWord,true,'OR');
		$criteria->compare('mutationDate',$this->keyWord,true,'OR');
		$criteria->compare('a.fromDept',$this->keyWord,true,'OR');
		$criteria->compare('a.toDept',$this->keyWord,true,'OR');
		$criteria->compare('a.fromPIC',$this->keyWord,true,'OR');
		$criteria->compare('a.toPIC',$this->keyWord,true,'OR');
		//$criteria->compare('toPICName',$this->keyWord,true,'OR');
		$criteria->compare('c.Department',$this->keyWord,true,'OR');
       // $criteria->compare('fromPICName',$this->keyWord,true,'OR');
		$criteria->compare('b.Department',$this->keyWord,true,'OR');
        $criteria->compare('d.username',$this->keyWord,true,'OR');
        $criteria->addCondition(" urutan in ( select min (urutan) from tr_assetMutationApproval where mutationNo = a.mutationNo and persetujuan is null)");
        
        $criteria->alias='a';
        $criteria->select="a.mutationNo, a.mutationDate, b.Department fromDeptName, c.Department toDeptName, d.username fromPICName, a.toPIC,"
                ."  case  "
                ."   when keterangan = 'Pengajuan MAT'  then 'Menunggu Persetujuan: New MAT'" 
                ."   when keterangan ='DEPTHEAD-BM' then 'Menunggu Persetujuan: Dept. Head/BM'"
                ."   when keterangan ='Div. Head' then 'Menunggu Persetujuan: Div. Head'"
                ."    when keterangan ='Penerima' and aktif=1 then 'Menunggu Persetujuan: Department Penerima MAT'"
                ."    when keterangan ='Penerima' and aktif=0 then 'MAT Selesai'"
                ."    end as keterangan,"
                . " (select 1 from tr_assetMutationApproval where mutationNo = a.mutationNo and keterangan = 'Div. Head' and persetujuan = 1) 'print', " 
                . " (select 1 from tr_assetMutationApproval where mutationNo = a.mutationNo and keterangan = 'Penerima' and aktif = 1) 'verified' "; 
        $criteria->join='left join ms_kodeAsset b on b.kodeAsset=a.fromDept 
                        left join ms_kodeAsset c on c.kodeAsset=a.toDept
                        left join vwEmployee d on d.idCard=a.fromPIC
                        left join tr_assetMutationApproval f on f.mutationNo=a.mutationNo';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(         
                            'defaultOrder' => 'mutationNo',
                            'attributes'=>array(
                                'fromDeptName'=>array(
                                    'asc'=>'fromDeptName',
                                    'desc'=>'fromDeptName DESC',
                                ),
                                'toPICName'=>array(
                                    'asc'=>'toPICName',
                                    'desc'=>'toPICName DESC',
                                ),
                                'toDeptName'=>array(
                                    'asc'=>'toDeptName',
                                    'desc'=>'toDeptName DESC',
                                ),
                                'fromPICName'=>array(
                                    'asc'=>'fromPICName',
                                    'desc'=>'fromPICName DESC',
                                ),
                                '*',
                            ),
                        ),
                        'pagination'=>array(
                          'pageSize'=>15,
                        ),
		));
         
	}

     public function getHeader($mutationNo)
    {   
        $criteria=new CDbCriteria;
                    
        $criteria->compare('a.mutationNo',$mutationNo,true);
             
        $criteria->alias='a';
        $criteria->select='a.mutationNo, a.mutationDate, b.Department fromDeptName, c.Department toDeptName, d.username fromPICName, a.toPIC toPICName';
        $criteria->join='left join ms_kodeAsset b on b.kodeAsset=a.fromDept 
                        left join ms_kodeAsset c on c.kodeAsset=a.toDept
                        left join vwEmployee d on d.idCard=a.fromPIC
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
}