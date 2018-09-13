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
class TradingClaim extends CActiveRecord{

    public $keyWord;   
    public $groupName;
    public $details;
    
    public function tableName()
    {
        return 'tr_tradingClaim';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('claimDate, claimGroup', 'required',),
                array('claimNo,', 'unique',),  
                array('claimStatus, isRevise', 'numerical'),
                array('claimDesc,', 'length','max'=>300),                
                array('fileName', 'file', 'types'=>'xls'),
                array('claimNo, claimID, claimDate, claimDesc, claimAppr, claimReject, claimStatus, claimGroup, '
                    . 'fileName, filePath, keyWord, groupName', 'safe', 'on'=>'search'),
            );
    }
    
    public function dateRangeExists($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->compare('claimGroup',$this->claimGroup,true);        
        $criteria->addCondition(
                        " (periodStart = '{$this->periodStart}' or periodEnd = '{$this->periodEnd}' or '{$this->periodStart}' between periodStart and periodEnd or 
                            '{$this->periodEnd}' between periodStart and periodEnd or ((periodStart<='{$this->periodStart}' and periodEnd>='{$this->periodEnd}')
                             or (periodStart>'{$this->periodStart}' and periodStart<'{$this->periodEnd}') or (periodStart<'{$this->periodStart}' and (periodEnd<'{$this->periodEnd}' and periodEnd>'{$this->periodStart}')) 
                             or ('{$this->periodStart}'<periodStart and '{$this->periodEnd}'>periodEnd)))"
                                );

        $record = self::model()->exists($criteria); 

        if(!empty($record)) {
             $this->addError($attribute, 'Item already exists within range.');
             return false;
        }
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
                "claimStatus"=>"Status",
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
                    . " d.NAMECUST groupName, case claimStatus "
                    . " when 0 then 'entry'"
                    . " when 1 then 'approved'"
                    . " else 'reject' end as claimStatus " ;
            $criteria->join = " left join SGTDAT..ARCUS d on h.claimGroup = d.IDCUST ";

            //$criteria->limit = 20;

            return new ActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'claimNo DESC',
                  )
            ));                    

    }
    
    public function getClaim($id){
            
        $criteria=new CDbCriteria;
        $criteria->addCondition(" h.claimNo = '".$id."'");
        $criteria->alias = 'h';                            
        $criteria->select=" claimID, claimNo, claimDate, claimGroup, claimDesc, claimTotal, claimAppr, claimReject, fileName, filePath, "
                . " d.NAMECUST groupName, case claimStatus "
                    . " when 0 then 'entry'"
                    . " when 1 then 'approved'"
                    . " else 'reject' end as claimStatus " ;
        $criteria->join = " left join SGTDAT..ARCUS d on h.claimGroup = d.IDCUST ";
        
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
