<?php

class DocumentLog extends CActiveRecord
{    
   
    public $keyWord; 
    public $check;
    public $invNumber;
    public $invTotal;
    public $invDate;
    public $customer;
    public $type;
    public $itemName;
    public $itemNo;
    public $qtyOrder;
    public $qtyShipment;
    public $rcvNote;
    public $adds; 

    public function tableName()
    {
        return 'tr_docLog';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('logStatus, docNumber, logDesc,', 'required',),   
                array('docTTSJ', 'numerical'),
                array('docID, logStatus, docNumber, logDesc, keyWord, docTTSJ', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                "docNumber" => "Doc. Number",
                "logStatus" => "Status",              
                "logDesc" => "Descripsion",
                "inputTime" => "Date",
                "inputUN" => "Username",
            );
    }

    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

            $criteria->compare('apInvNo',$this->apInvNo,true);   
            
            $criteria->alias = 'h';                            
            $criteria->select=" 
                     apLogNo, apInvNo, apLogReason, inputUN, inputTime
                        " ;            
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'inputTime DESC',
                  )
            ));                    

    }

    public function getFaktur($docNum){
       $this->attributeLabels();
            
        $criteria=new CDbCriteria;

        $criteria->compare('docNumber',$docNum,true);   
        $criteria->compare('docType',"FK",true); 
        
        $criteria->alias = 'h';                            
        $criteria->select=" 
                 docNumber, logDesc, inputTime, inputUN
                    " ;   
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria, 
            'sort'=>array(
                'defaultOrder'=>'inputTime DESC',
              )
        )); 
    }
    
    public function getEfaktur($docNum){
       $this->attributeLabels();
            
        $criteria=new CDbCriteria;

        $criteria->compare('docNumber',$docNum,true);   
        $criteria->compare('docType',"EF",true); 
        
        $criteria->alias = 'h';                            
        $criteria->select=" 
                 docNumber, logDesc, inputTime, inputUN
                    " ;            
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria, 
            'sort'=>array(
                'defaultOrder'=>'inputTime DESC',
              )
        )); 
    }
    
    public function getSJ($docNum, $docID){
       $this->attributeLabels();
            
        $criteria=new CDbCriteria;

        $criteria->compare('docNumber',$docNum,true);   
        $criteria->compare('docID',$docID,true); 
        $criteria->compare('docType', "SJ" ,true); 
        
        $criteria->alias = 'h';                            
        $criteria->select=" 
                 docNumber, logDesc, inputTime, inputUN
                    " ;            
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria, 
            'sort'=>array(
                'defaultOrder'=>'inputTime DESC',
              )
        )); 
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
