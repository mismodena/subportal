<?php

class APLog extends CActiveRecord
{    
   
    public $keyWord;      
    
    public function tableName()
    {
        return 'tr_apLog';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('apInvNo, apLogNo, apLogDesc', 'required',),                
                array('apInvNo, apLogNo, apLogReason, apLogDesc, keyword,', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
              
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
