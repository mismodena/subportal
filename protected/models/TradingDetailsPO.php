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
class TradingDetailsPO extends CActiveRecord {

    public $keyWord;
    public $groupName;
    public $tradDesc;

    public function tableName() {
        return 'tr_tradingDetailPO';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('claimNo, poNo, tradCode, value, claim, status, description ', 'safe', 'on' => 'search, getExport'),
        );
    }

    public function attributeLabels() {
        return array(
            "claimNo" => "No. Klaim",
            "poNo" => "No. Po",
            "tradCode" => "Kode Trading",
            "value" => "Accpac",
            "claim" => "Klaim",
            "status" => "Status",
            "description" => "Deskripsi",
        );
    }

    public function getDetailPO($id, $tradCode) {
        $criteria = new CDbCriteria;

        $criteria->compare('d.claimNo', $id, true);
        $criteria->compare('d.tradCode', $tradCode, true);

        $criteria->alias = 'd';
        $criteria->select = " d.claimID, d.claimNo, d.tradCode, tr.tradDesc, d.poNo, d.claim, d.value-d.retur value, d.status, d.description ";
        $criteria->join = " left join ms_trading tr on tr.tradCode = d.tradCode ";

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'poNo ASC',
              )
        ));
    }
    
        public function getExport() {
        $criteria = new CDbCriteria;

        $criteria->compare('d.claimNo', $this->claimNo, true);
        $criteria->compare('d.tradCode', $this->tradCode, true);
        $criteria->compare('d.status', '0', true);

        $criteria->alias = 'd';
        $criteria->select = " d.claimID, d.claimNo, d.tradCode, tr.tradDesc, d.poNo, d.claim, d.value-d.retur value, d.status, d.description ";
        $criteria->join = " left join ms_trading tr on tr.tradCode = d.tradCode ";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
//            'sort'=>array(
//                'defaultOrder'=>'claimNo DESC',
//              )
        ));
    }
    
    public function getTotal($id, $tradCode){
        $criteria=new CDbCriteria;
        $criteria->addCondition(" dt.claimNo = '".$id."' and dt.tradCode = '".$tradCode."' and status =1");
        $criteria->alias = 'dt';                            
        $criteria->select=" sum(dt.claim) claim, sum(dt.value-dt.retur) value " ;        
        
        return $this->findAll($criteria);
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->inputTime = new CDbExpression('getdate()');
                $this->inputUN = Yii::app()->user->name;
                $this->modifTime = new CDbExpression('getdate()');
                $this->modifUN = Yii::app()->user->name;
            } else
                $this->modifTime = new CDbExpression('getdate()');
            $this->modifUN = Yii::app()->user->name;
            return true;
        } else
            return false;
    }

}
