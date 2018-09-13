<?php

class Order extends AccpacActiveRecord
{    
    public $keyWord; 
    public $invTotal; 
    public $branch;
    
    public function tableName()
    {
        return 'OEORDH';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
        return array(
            array('invNumber, id, idCust, payDate, keyWord, nameCust, branch', 'safe', 'on'=>'search, getSource'),
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
    
    public function getOrder($id)
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;
        $criteria->distinct=true;
        $criteria->addCondition(" h.customer = '".$id."' and OPTFIELD = 'POTKP' and [value] = '0.000' and ltrim(rtrim(h.LASTINVNUM)) = '' and INVNETWTX > 0 ");
        $criteria->alias = "h";                    
        $criteria->select=" h.ORDNUMBER , dbo.fnGetAccpacDate(h.orddate) INVDATE, h.INVNETWTX invTotal " ;
        $criteria->join = " left join SGTDAT..OEORDHO o on o.ORDUNIQ = h.ORDUNIQ ";
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,  
             'pagination'=>false,
        ));         
    }
    
    
    
}
