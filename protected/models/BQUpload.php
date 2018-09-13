<?php

class BQUpload extends CActiveRecord {

    public $keyWord;
    public $branchName;
    public $deptName;
    public $userName;
    public $nameCust;
    public $fmtDate;
    
    public function tableName() {
        return 'tr_bqUpload';
    }

    public function rules() {
        return array(
            array('bqUploadNo, uploadDate', 'required',),
            array('bqUploadNo', 'unique',),
            array('bqValue, tqValue, uploadTotal', 'numerical',),
            array('uploadDesc', 'length', 'max' => 400),
            array('bqUploadID, bqUploadNo, uploadDate, uploadDesc, branchID, deptID, PIC, status, bqValue, tqValue, uploadTotal, uploadBranch', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'bqUploadNo' => 'Nomor',
            'uploadDate' => 'Tanggal',
            'idCust' => 'Dealer',            
            'uploadDesc' => 'Keterangan',
            'deptID' => 'Departemen / Cabang',
            'PIC' => 'PIC',
            'status' => 'Status',
            'uploadTotal' => 'Total',  
            'deptName' => 'Dept - Cabang',
            'bqValue' => 'Nilai BQ',
            'tqValue' => 'Nilai TQ',
            'branchID' => 'Cabang',                      
        );
    }

    public function search() {
        $this->attributeLabels();

//            $idcard = Yii::app()->user->getState('idcard');
//            $level = Yii::app()->user->getState('level');
//            $user = Yii::app()->user->name;

        $criteria = new CDbCriteria;

        $criteria->compare('bqUploadNo', $this->keyWord, true, 'OR');
        $criteria->compare('deptID', $this->keyWord, true, 'OR');
        $criteria->compare('PIC', $this->keyWord, true, 'OR');

        $criteria->alias = 'a';
        $criteria->select = " bqUploadID, bqUploadNo, uploadDate, branchID, e.userName, d.textdesc branchName, c.nameCust, deptID, a.idCust, uploadDesc, "
                . " case a.status"
                . " when 1 then 'Disetujui'"
                . " when 0 then 'Draft'"
                . " else 'Ditolak' end as status, bqValue, tqValue, uploadTotal ";
        $criteria->join = " left join vwEmployee e on a.PIC = e.idCard "
                . "         left join sgtdat..arcus c on c.idcust = a.idCust "
                . "         left join sgtdat..argro d on d.idgrp = a.uploadBranch ";

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'bqUploadNo DESC',
            )
        ));
    }
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
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
