<?php

class hrisContract extends CActiveRecord
{
    public $keyWord; 
    public $userName; 
    public $deptName;
    public $divName;
    public $branchName;
    public $posName;
    public $newStartDate;
    public $newEndDate;
    public $dispStart;
    public $dispEnd;        
    public $period;
    public $deptHead;
                        
    public function tableName()
    {
            return 'HRIS_Contract';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
        return array(
            array('idCard, startDate, endDate, contractType', 'required'),                                    
            //array('period','required', 'on' => 'createContract'),
            array('startDate, endDate, newStartDate, newEndDate','safe'),
            array('idPos, idDept, idDiv, contractType, idBranch', 'length', 'max'=>100),              
            //array('endDate', 'compare','compareAttribute'=>'startDate','operator'=>'>', 'allowEmpty'=>false ),                                  
            array('idCard, idPos, idDept, idDiv, idBranch, contractType, contractReplacement, contractAction, startDate, endDate, isActive, keyWord, userName, posName, deptName, divName, branchName,dispStart, dispStart, period, deptHead', 'safe', 'on'=>'search'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'idCard' => 'Karyawan',
            'idPos' => 'Posisi',
            'idDept' => 'Departemen',
            'idDiv' => 'Divisi',
            'contractType' => 'Tipe Kontrak',            
            'contractReplacement' => 'Keterangan', 
            'contractAction' => 'Action', 
            'startDate' => 'Mulai', 
            'endDate' => 'Berakhir', 
            'isActive' => 'Status', 
            'posName' => 'Posisi', 
            'period' => 'Periode', 
            'deptName' => 'Departemen', 
            'newStartDate' => 'Mulai Kontrak Baru', 
            'newEndDate' => 'Akhir Kontrak Baru', 
            
        );
    }
    
    public function search()
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;

        $criteria->compare('userName',$this->keyWord,true, 'OR');
        $criteria->compare('deptName',$this->keyWord,true, 'OR');
        $criteria->compare('branchName',$this->keyWord,true, 'OR');     
        $criteria->compare('isActive',$this->isActive,true);    
        $criteria->compare('a.idCard',$this->idCard,true);  
        
        
        
        $criteria->alias = 'a';                            
        $criteria->select=" a.contractID, a.idCard, d.userName, a.idDept, b.deptName, b.idDiv, c.branchName, e.posName,
                            startDate, endDate, contractType, contractReplacement, contractAction, isActive ";
        $criteria->join = " left join Department b on a.idDept = b.idDept
                            left join cabang c on a.idBranch = c.idBranch
                            left join karyawan d on d.idCard = a.idCard
                            left join position e on e.idPos = a.idPos ";

        return new ActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                       'defaultOrder'=>'endDate ASC',
                    )
        ));
    }
    
    public function getContract($id)
    {
        $criteria=new CDbCriteria;
                        
        $criteria->compare('contractID',$id,true); 

        $criteria->alias = 'a';                            
        $criteria->select=" a.contractID, a.idCard, d.userName, a.idDept, b.deptName, b.idDiv, c.branchName, e.posName,
                            startDate, endDate, contractType, contractReplacement, 
                            case contractAction
                                when 'stop' then 'Tidak diperpanjang'
                                when 'cont' then 'Kontrak diperpanjang'
                                when 'cont-os' then 'Dialihkan ke outsourcing'
                                when 'permanent' then 'Permanen'
                                when '3' then '3 bulan'
                                when '6' then '6 bulan'
                                when '12' then '12 bulan'
                                else '-' end as contractAction
                            , isActive, dbo.fnGetDirectHead(a.idBranch, a.idDept, a.idPos) deptHead ";
        $criteria->join = " left join Department b on a.idDept = b.idDept
                            left join cabang c on a.idBranch = c.idBranch
                            left join karyawan d on d.idCard = a.idCard
                            left join position e on e.idPos = a.idPos ";

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