<?php

class DocumentReqGiro extends CActiveRecord
{    
   
    public $keyWord; 
    public $invDate; 
    public $bilName; 
    public $invTotal; 
    public $retNumber;
    
    public function tableName()
    {
        return 'tr_docRequestGiro';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('docNumber', 'required',),   
                array('docNumber, logStatus, invDate, bilName, invTotal, inputTime, retNumber, retType', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                "docNumber" => "Doc. Number",
                "logStatus" => "Status",   
            );
    }

    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

            $criteria->compare('h.docNumber',$this->keyWord,true,'OR');    
            $criteria->compare('hh.bilnName',$this->keyWord,true,'OR');
            $criteria->addCondition(" hd.retType = 'GR'");
            
            $criteria->alias = 'h';                            
            $criteria->select=" h.docNumber, dbo.fnGetAccpacDate(invDate) invDate, hh.invnetwtx invTotal, hh.bilName, h.logStatus, h.inputTime, hd.retNumber
                        " ; 
            $criteria->join = "left join SGTDAT..OEINVH hh on hh.INVNUMBER = h.docNumber "
                    . "         left join tr_docRequestDetail hd on hd.docNumber = h.docNumber";

            return new ActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'docNumber DESC, inputTime DESC',
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
