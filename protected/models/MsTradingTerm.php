<?php

class MsTradingTerm extends CActiveRecord
{    
   
    public $keyWord;      
    public $details;
	public $nameAcct;
    
    public function tableName()
    {
        return 'ms_tradingTerm';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('idCust, termDesc, periodStart, periodEnd', 'required'),                
                array('payTermNew, payTermExisting, sellingTarget', 'numerical',),                
                array('termID, idCust, termDesc, periodStart, periodEnd, payTermExisting, payTermNew, sellingTarget, termNo, keyWord, nameAcct, isTT', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                "termID" => "ID",
                "termNo" => "No. Term",
                "idCust" => "Customer Group",
                "termDesc" => "Deskripsi",
                "periodStart" => "Tanggal Mulai",
                "periodEnd" => "Tanggal Akhir",
                "payTermExisting" => "Pay Term Existing",
                "payTermNew" => "Pay Term New Store",
                "isTT" => "Tipe",
                'sellingTarget'=>"Target Penjualan",
            );
    }

    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;
        
            $criteria->compare('h.termDesc',$this->keyWord,true); 
            //$criteria->addCondition(" periodEnd > getDate() ");
            
            $criteria->alias = 'h';                            
            $criteria->select=" termID, termDesc, termNo, idCust, periodStart, periodEnd, payTermExisting, payTermNew, sellingTarget, nameAcct " ;
            $criteria->join = " left join sgtdat..arnat on idnatacct = idCust ";

            //$criteria->limit = 20;

            return new ActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'termNo DESC',
                  )
            ));                    

    }
    
     public function getTerm($id)
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;
        
            $criteria->addCondition(" termID = '".$id."' ");
            
            $criteria->alias = 'h';                            
            $criteria->select=" termID, termDesc, termNo, idCust, periodStart, periodEnd, payTermExisting, payTermNew, sellingTarget, nameAcct, isTT " ;
            $criteria->join = " left join sgtdat..arnat on idnatacct = idCust ";

            //$criteria->limit = 20;

            return $this->find($criteria);                    

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
