<?php
class FppApproval extends CActiveRecord
{
        public $adjustmentValue;
        public $adjustmentDesc;
        public $total;
        public $Acct1 = '9411.0022'; // Bu Tety <= 5000k
        public $Acct2 = '1409.1808'; // Bu Dian > 5000k
        public $bank;
        public $cheque;
        public $voucher;
        public $adjType;
        public $userName;


        public function tableName()
	{
		return 'tr_fppApproval';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fppID', 'required'),
			array('fppID, persetujuanId, pic, an', 'length', 'max'=>50),
			array('keterangan', 'length', 'max'=>20),
			array('tanggal, persetujuan, aktif, keterangan2', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fppID, persetujuanId, pic, tanggal, persetujuan, aktif, keterangan, an, keterangan2, adjustmentValue,adjustmentDesc, total, Acct1, Acct2, 
                                bank, cheque, voucher, urutan, adjType, userName' , 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'fppID' => 'Fpp',
			'persetujuanId' => 'Persetujuan',
			'pic' => 'Pic',
			'tanggal' => 'Tanggal',
			'persetujuan' => 'Persetujuan',
			'aktif' => 'Aktif',
			'keterangan' => 'Keterangan',
			'an' => 'An',
			'keterangan2' => 'Keterangan2',
                        'adjType' => 'Tipe Koreksi',
                        'adjustmentValue'=>'Koreksi (Rp.)',
                        'adjustmentDesc'=>'Alasan',
                        'bank'=>'Bank',
                        'cheque'=>'No. Cheque',
                        'voucher'=>'No. Voucher',
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('fppID',$this->fppID,true);
		$criteria->compare('persetujuanId',$this->persetujuanId,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('persetujuan',$this->persetujuan);
		$criteria->compare('aktif',$this->aktif);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('an',$this->an,true);
		$criteria->compare('keterangan2',$this->keterangan2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getApproval($fppID)
	{             
            $idcard = Yii::app()->user->getState('idcard');
            $criteria=new CDbCriteria;
                        
            $criteria->compare('fppID',$fppID,true); 
            $criteria->addCondition("pic = '".$idcard."'"); 
            $criteria->addCondition('persetujuan is null');
            
            $criteria->alias = 'a';                            
            $criteria->select=" fppID, pic, tanggal, persetujuan, aktif, keterangan ";
            return  $this->find($criteria);
	}
        
        public function getAccounting($fppID)
	{             
            $idcard = Yii::app()->user->getState('idcard');
            $criteria=new CDbCriteria;
                        
            $criteria->compare('fppID',$fppID,true); 
            //$criteria->addCondition("pic = ''"); 
            $criteria->addCondition(" keterangan = 'Accounting' ");
            
            $criteria->alias = 'a';                            
            $criteria->select=" fppID, pic, tanggal, persetujuan, aktif, keterangan ";
            return  $this->find($criteria);
	}
        
        public function getFinance($fppID)
	{             
            $idcard = Yii::app()->user->getState('idcard');
            $criteria=new CDbCriteria;
                        
            $criteria->compare('fppID',$fppID,true); 
            $criteria->addCondition("pic = ''"); 
            $criteria->addCondition("keterangan = 'FINANCE-REVIEW' ");
            
            $criteria->alias = 'a';                            
            $criteria->select=" fppID, pic, tanggal, persetujuan, aktif, keterangan ";
            return  $this->find($criteria);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
         public function GetApprovalList($fppNo)
        {
            $criteria=array(
                'alias'=>'app',
                'select'=>"urutan, pic, userName, tanggal, 
                            case persetujuan
                            when 1 then 'Disetujui'
                            when 0 then 'Tidak Disetujui'
                            else 'N/A' end as persetujuan, keterangan2",
                "join"=>" left join vwEmployee emp on emp.idCard = app.pic " ,
                'condition'=>"app.fppID = :cat and urutan > 0" ,                                
                'params'=>array(
                    ':cat' => $fppNo,                            
                )
            ); 

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'urutan ASC',
                ),
                'pagination'=>array(
                    'pageSize'=>20,
                ),
            ));
        }
}
