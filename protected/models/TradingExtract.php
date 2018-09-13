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
class TradingExtract extends CActiveRecord{

    public $keyWord;   
    public $groupName;
    
    public function tableName()
    {
        return 'tr_tradingExtract';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(                
                array('claimNo, poNo, tradCode, value, claim, status', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(                
                "claimNo" => "No. Klaim",
                "poNo" => "No. Po",
                "tradCode" => "Kode Trading",
                "value" => "Nilai",
                "claim" => "Klaim",
                "status" => "status",
            );
    }
    
    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

            $criteria->compare('d.groupName',$this->keyWord,true,'OR');    
            $criteria->compare('h.claimDesc',$this->keyWord,true,'OR');    
            
            $criteria->alias = 'h';                            
            $criteria->select=" claimID, claimNo, claimDate, claimGroup, claimDesc, claimTotal, claimAppr, claimReject, fileName, filePath, "
                    . " d.NAMECUST groupName " ;
            $criteria->join = " left join SGTDAT..ARCUS d on h.claimGroup = d.IDCUST ";

            //$criteria->limit = 20;

            return new ActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'claimNo DESC',
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
