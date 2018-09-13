<?php

class BQClaimDetail extends CActiveRecord {

    public $keyWord;
    public $userName;
    public $deptName;
    public $branchName;
    public $fmtDate;
    public $nonItems;
    public $items;
    public $bqAvail;
    public $tqAvail;
    public $totalAll; 
    
    public function tableName() {
        return 'tr_bqClaimDetail';
    }

    public function rules() {
        return array(
            array('bqClaimNo, nonItemDesc, nonItemValue', 'required',),
            array('nonItemValue, nonItemTotal', 'numerical',),
            array('bqClaimDetailID, bqClaimNo, nonItemDesc, nonItemValue, nonItemTotal', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }
   
    public function attributeLabels() {
        return array(
            'bqClaimNo' => 'Nomor',
            'nonItemDesc' => 'Keterangan',            
            'nonItemValue' => 'Nilai',
            
        );
    }

    public function search() {
        $this->attributeLabels();


        $criteria = new CDbCriteria;

        $criteria->compare('bqClaimNo', $this->keyWord, true, 'OR');
        $criteria->compare('deptID', $this->keyWord, true, 'OR');
        $criteria->compare('PIC', $this->keyWord, true, 'OR');

        $criteria->alias = 'a';
        $criteria->select = " a.bqClaimNo, a.claimDate, a.claimDesc, a.deptID, a.PIC, a.status, a.claimTotal, e.userName, e.nameDept deptName, bqUsed, tqUsed, a.idCust + ' - ' + c.NAMECUST as idCust ";
        $criteria->join = " left join vwEmployee e on a.PIC = e.idCard "
                . "          left join sgtdat..arcus c on c.idcust = a.idCust ";

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'bqClaimNo DESC',
            )
        ));
    }
    
    public function getDetail($claimNo) {
        $this->attributeLabels();


        $criteria = new CDbCriteria;

        $criteria->compare('bqClaimNo', $claimNo, true);

        $criteria->alias = 'a';
        $criteria->select = " bqClaimDetailID, bqClaimNo, nonItemValue, nonItemDesc ";

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'bqClaimNo DESC',
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
