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
class TradingDetails extends CActiveRecord{

    public $keyWord;   
    public $groupName;
    public $details;
    public $tradDesc;

    
    public function tableName()
    {
        return 'tr_tradingDetail';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('claimNo, tradCode, value', 'required',),                    
                array('claimNo, tradCode, value, claim, status, pocheck', 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                "claimID" => "ID",
                "claimNo" => "No. Klaim",
                "claimDate" => "Tanggal",
                "claimDesc" => "Deskripsi",
                "claimTotal" => "Total",
                "claimAppr" => "Disetujui",
                "claimReject" => "Ditolak",
                'fileName'=>"Nama File",
                'filePath'=>"Lokasi File",                
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
    
    
    
    public function getDetails($id){                            
        
        $criteria=new CDbCriteria;
        $criteria->addCondition(" dt.claimNo = '".$id."'");
        $criteria->alias = 'dt';                            
        $criteria->select=" dt.claimNo, dt.tradCode, tr.tradDesc, dt.claim, dt.value " ;
        $criteria->join = " left join ms_trading tr on tr.tradCode = dt.tradCode ";        
        
        return new ActiveDataProvider($this, array(
            'criteria'=>$criteria, 
            'sort'=>array(
                'defaultOrder'=>'tradCode ASC',
              )
        ));        
    }       
    
    public function getDetailSummary($id){                            
        
        $criteria=new CDbCriteria;
        $criteria->addCondition(" dt.claimNo = '".$id."'");
        $criteria->alias = 'dt';                            
        $criteria->select=" sum(dt.claim) claim, sum(dt.value) value, sum(dt.pocheck) poCheck " ;        
        
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
