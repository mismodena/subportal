<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TradingClaim
 *
 * @author fajar.pratama
 */
class TradingRetur extends CActiveRecord{

    public $keyWord;   
    public $groupName;
    public $tradDesc;
    public $nameAcct;


    public function tableName()
    {
        return 'tr_tradingRetur';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(                
                array('returNo, tradCode, poNo, value, tradDesc, nameAcct, keyWord', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(                
                "returNo" => "No. Retur",
                "poNo" => "No. Po",
                "tradCode" => "Kode Trading",                                
                "value" => "Nilai",
            );
    }
    
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('n.nameAcct',$this->keyWord,true, "OR");    
        $criteria->compare('mt.tradDesc',$this->keyWord,true, "OR");    
        $criteria->compare('r.poNo',$this->keyWord,true, "OR");

        $criteria->alias = 'r';                            
        $criteria->select=" r.returNo, r.tradCode, mt.tradDesc, r.poNo, r.value, r.groupCode, n.NAMEACCT nameAcct ";                    
        $criteria->join = " left join ms_trading mt on r.tradCode = mt.tradCode
                            left join SGTDAT..ARNAT n on IDNATACCT = r.groupCode ";

        return new ActiveDataProvider($this, array(
            'criteria'=>$criteria, 
//            'sort'=>array(
//                'defaultOrder'=>'claimNo DESC',
//              )
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
