<?php

class pkpAllocated extends AccpacActiveRecord
{    
    public $keyWord; 
    public $nameCust; 
    public $value; 
    
    public function tableName()
    {
        return 'MIS_PKP_ALLOCATE';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
        return array(
            array('idCust, nameCust, keyWord, value', 'safe', 'on'=>'search'),
        );
    }
    
    public function attributeLabels()
    {
        return array(                
                'idCust' => 'Kode Dealer',
                'value' => 'Total',                
                'nameCust' => 'Nama Delaer',
                'cancelReason' => 'Alasan',                                
        );
    }
    
    public function search()
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;
       
        $criteria->compare('invNumber',$this->keyWord,true, 'OR');
        $criteria->compare('nameCust',$this->keyWord,true, 'OR');                  
        
        $criteria->alias = 'a';                            
        $criteria->select=" a.idCust, b.NAMECUST nameCust, a.invNumber, SUM(a.pkpAllocated) value  " ;
        $criteria->join = " left join ARCUS b on a.idCust = b.IDCUST ";
        $criteria->group = 'a.idCust, a.invNumber, b.NAMECUST';
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,                      
        ));           
    }
    
    public function getAllocated($id)
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;
       
        $criteria->compare('invNumber',$id,false);        
        
        $criteria->alias = 'a';                            
        $criteria->select=" a.idCust, b.NAMECUST nameCust, a.invNumber, SUM(a.pkpAllocated) value  " ;
        $criteria->join = " left join ARCUS b on a.idCust = b.IDCUST ";
        $criteria->group = 'a.idCust, a.invNumber, b.NAMECUST';
                
        return  $this->find($criteria);           
    }
    
}
