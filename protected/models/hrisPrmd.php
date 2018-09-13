<?php

class hrisPrmd extends CActiveRecord
{
    public $keyWord; 
    public $userName;
    public $posName;
    public $deptName;
    public $divName;
    public $deptHeadName;
    public $newPosName;
    public $newDeptName;
    public $newDivName;
    public $newDeptHeadName;
    public $branchName;
    public $newBranchName;
    public $prmdCategoryName;
        
    public function tableName()
    {
        return 'HRIS_Prmd';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
        return array(
            array('idCard, startDate, endDate, idCard, prmdCategory, newIdPos, newIdDept, newIdDiv, newJobGrade', 'required'),                                    
            array('startDate, endDate','safe'),
            array('idCard, prmdCategory, idPos, idDept, idDiv, deptHead, newIdPos, newIdDept, newIdDiv, status, prmdDesc, idBranch, newIdBranch, prmdAction', 'length', 'max'=>100),              
            array('jobGrade, newJobGrade','numerical'),
            array('endDate', 'compare','compareAttribute'=>'startDate','operator'=>'>', 'allowEmpty'=>false ),                                  
            array('prmdID, idCard, prmdCategory, idPos, idDept, idDiv, deptHead, jobGrade, newIdPos, newIdDept, newIdDiv, newJobGrade, status, prmdDesc, startDate, endDate,'
                    . 'userName, keyWord, posName, newPosName, deptName, newDeptName, divName, newDivName, deptHeadName, newDeptHeadName, idBranch, branchName, newIdBranch, newBranchName, prmdCategoryName, isActive, prmdAction', 'safe', 'on'=>'search'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'idCard' => 'Karyawan',
            'prmdCategory'=>'Kategori',
            'idPos' => 'Posisi',
            'idDept' => 'Departemen',
            'idDiv' => 'Divisi',
            'deptHead' => 'Atasan',            
            'jobGrade' => 'Grade', 
            'newIdPos' => 'Posisi',
            'newIdDept' => 'Departemen',
            'newIdDiv' => 'Divisi',
            'newDeptHead' => 'Atasan',            
            'newJobGrade' => 'Grade',            
            'status' => 'Status', 
            'startDate' => 'Mulai', 
            'endDate' => 'Berakhir', 
            'prmdDesc' => 'Keterangan',        
            'idBranch' => 'Cabang',
            'newIdBranch' => 'Cabang',
            'prmdCategoryName' => 'Kategori',
            'newPosName' => 'Posisi',
            'posName' => 'Posisi',
            'prmdStatus' => 'Status'
        );
    }
    
    public function search()
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;

        $criteria->compare('b.userName',$this->keyWord,true, 'OR');
        $criteria->compare('d.deptName',$this->keyWord,true, 'OR');
        $criteria->compare('i.branchName',$this->keyWord,true, 'OR');     
        $criteria->compare('isActive',$this->isActive,true);  
        
        $criteria->alias = 'a';                            
        $criteria->select=" a.prmdID, a.idCard, a.prmdCategory,
                case a.prmdCategory
                    when 'P' then 'Promosi'
                    when 'R' then 'Rotasi'
                    when 'M' then 'Mutasi'
                    when 'D' then 'Demosi' end as prmdCategoryName,
                    a.idPos, a.idDept, a.idDiv, a.deptHead, a.jobGrade, a.newIdPos, a.newIdDept, a.newIdDiv, a.newDeptHead, a.newJobGrade, a.[status], a.prmdDesc, a.startDate, a.endDate,a.isActive,
                    b.userName, c.posName, d.deptName, e.userName deptHeadName, f.posName newPosName, g.deptName newDeptName, h.userName newDeptHeadName, 
                    i.branchName, j.branchName newBranchName";
        $criteria->join = "left join karyawan b on a.idCard = b.idCard	
                        left join position c on c.idPos = a.idPos
                        left join department d on d.idDept = a.idDept
                        left join karyawan e on e.idCard = a.deptHead
                        left join position f on f.idPos = a.newIdPos
                        left join department g on g.idDept = a.newIdDept
                        left join karyawan h on h.idCard = a.newDeptHead 
                        left join cabang i on i.idBranch = a.idBranch
                        left join cabang j on j.idBranch = a.idBranch";

        return new ActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                       'defaultOrder'=>'endDate DESC',
                    )
        ));
    }
    
    public function getPRMD($id)
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;
        
        $criteria->compare('prmdID',$id,false); 
        
        $criteria->alias = 'a';                            
        $criteria->select=" a.prmdID, a.idCard, a.prmdCategory,
                case a.prmdCategory
                    when 'P' then 'Promosi'
                    when 'R' then 'Rotasi'
                    when 'M' then 'Mutasi'
                    when 'D' then 'Demosi' end as prmdCategoryName,
                    a.idPos, a.idDept, a.idDiv, a.deptHead, a.jobGrade, a.newIdPos, a.newIdDept, a.newIdDiv, a.newDeptHead, a.newJobGrade, a.[status], a.prmdDesc, a.startDate, a.endDate,a.isActive,
                    b.userName, c.posName, d.deptName, e.userName deptHeadName, f.posName newPosName, g.deptName newDeptName, h.userName newDeptHeadName, 
                    i.branchName, j.branchName newBranchName";
        $criteria->join = "left join karyawan b on a.idCard = b.idCard	
                        left join position c on c.idPos = a.idPos
                        left join department d on d.idDept = a.idDept
                        left join karyawan e on e.idCard = a.deptHead
                        left join position f on f.idPos = a.newIdPos
                        left join department g on g.idDept = a.newIdDept
                        left join karyawan h on h.idCard = a.newDeptHead 
                        left join cabang i on i.idBranch = a.idBranch
                        left join cabang j on j.idBranch = a.idBranch";

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
