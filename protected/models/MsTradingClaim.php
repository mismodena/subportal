<?php

class msTradingClaim extends CActiveRecord
{    
   
    public $keyWord;      
    public $checkBox;
    public $tradDesc;


    public function tableName()
    {
        return 'ms_tradingClaim';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('tradCode, value, claim, status', 'required',),               
                array('tradCode, value, keyWord, checkbox, claim, status', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                "tradCode" => "Kode",
                "value" => "Nilai",                
            );
    }

    public function getClaimList()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;
            
            $criteria->alias = 'h';                            
            $criteria->select=" h.tradCode, tradDesc, value " ;
            $criteria->join = " left join ms_trading d on d.tradCode = h.tradCode ";

            //$criteria->limit = 20;

            return $this->findAll($criteria);                   

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
