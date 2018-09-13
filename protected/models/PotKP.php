<?php

class PotKP extends AccpacActiveRecord
{    
    public $keyWord; 
    public $nameCust; 
    public $branch;
    
    public function tableName()
    {
        return 'MIS_PKP_SOURCE';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
        return array(
            array('invNumber, id, idCust, invDate, payDate, keyWord, nameCust, branch', 'safe', 'on'=>'search'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
                'invNumber' => 'Inv. Num',
                'idCust' => 'Kode Dealer',
                'payDate' => 'Tgl. Bayar',
                'invDate' => 'Tgl. Invoice',
                'nameCust' => 'Nama Delaer',
                'cancelReason' => 'Alasan',
                'pkpValue' => 'Nilai PKP',
                
        );
    }
    
    public function search()
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;
       
        $criteria->compare('invNumber',$this->keyWord,true, 'OR');
        $criteria->compare('nameCust',$this->keyWord,true, 'OR');  
        
        $criteria->addCondition(" id not in (select pkpid from SGTDAT..MIS_PKP_Allocate) and pkpValue > 0 ");
        
        $criteria->alias = 'a';                            
        $criteria->select=" id, a.idCust, invNumber, invDate, payDate, pkpValue, pkpValueWtx, b.NAMECUST nameCust " ;
        $criteria->join = " left join ARCUS b on a.idCust = b.IDCUST ";
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,                      
        ));           
    }
    
    public function getPKP($id)
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;

        $criteria->compare('id',$id,false);  
        $criteria->addCondition(" pkpValue > 0 ");
        
        $criteria->alias = "a";                            
        $criteria->select=" id, a.idCust, invNumber, invDate, payDate, pkpValue, pkpValueWtx, b.NAMECUST nameCust " ;
        $criteria->join = " left join ARCUS b on a.idCust = b.IDCUST ";
        
        return  $this->find($criteria);           
    }
    
    public function getSource($id)
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;
        $criteria->distinct=true;
        $criteria->addCondition(" a.idCust = '".$id."' and pkpBranch <> '-'");
        $criteria->alias = "a";                    
        $criteria->select="   a.idCust, c.NAMECUST nameCust, g.TEXTDESC branch, pkpBranch, dbo.fnGetPKPValue(a.idCust, getdate(), pkpBranch) pkpValue " ;
        $criteria->join = " left join sgtdat..arcus c on c.IDCUST = a.idCust
	left join SGTDAT..argro g on g.IDGRP = a.pkpBranch ";
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,  
             'pagination'=>false,
        ));         
    }
    
    
    
}
