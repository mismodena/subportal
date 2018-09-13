<?php

class CreditNote extends AccpacActiveRecord
{
    
    public function tableName()
    {
            return 'MIS_PKP_SOURCE';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function relations()
    {
        return array(
          'header' => array(self::BELONGS_TO, 'Customer', 'idCust')
        );
    }

    public function attributeLabels()
    {
        return array(
                'namecust' => 'namecust',
                'idcust' => 'idcust',
                
                
        );
    }

    public function rules()
    {
        return array(
            array('namecust, idcust'),
        );
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
    
    public function getPKPSource($invPKP)
    {   

        $criteria=new CDbCriteria;

        $criteria->compare('invNumber',$invPKP,true); 

        $criteria->alias = 'P';                            
        $criteria->select="id,idCust,pkpValue" ;
        $criteria->with = array('header'=>array('select'=>'NAMECUST'));

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,          
            ));  
    }
}