<?php

class BQOpen extends CActiveRecord {

    public $keyWord;
    public $option;
    public $total;
    public $nameCust;
    public $deptName;
    public $userName;
    
    public function tableName() {
        return 'tr_bqOpen';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('fiscalPeriod, idCust, salesTarget, openTarget', 'required',),
            //array('salesTarget, openTarget', 'numerical',),
            array('fiscalPeriod, idCust, revNo, branchID, salesTarget, openTarget, openBonus, status, keyWord, openDesc, option, total, nameCust, openUser, lastQ', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            "fiscalPeriod" => "Periode",
            "idCust" => "Dealer",
            "revNo" => "Revisi",
            "branchID" => "Cabang",
            "salesTarget" => "Target Sales",
            "openTarget" => "Open TQ",
            "openBonus" => "Bonus BQ",
            "status" => "Status",
            "total" => "Total",
            "openDesc" => "Keterangan",
        );
    }

    public function search() {
        $this->attributeLabels();

        $idgrp = Yii::app()->user->getState('idgrp');
        $level = Yii::app()->user->getState('level');

        $criteria = new CDbCriteria;

        $criteria->compare('h.fiscalPeriod', $this->keyWord, true, 'OR');
        $criteria->compare('h.idCust', $this->keyWord, true, 'OR');
        $criteria->compare('c.NAMECUST', $this->keyWord, true, 'OR');
        $criteria->addCondition(" h.visible = 1");

        if($level !== "Admin" && $level !== "Accounting" )
        {                
            $arr_idgrp = array();
            foreach( explode(",", $idgrp) as $index=>$value )
                $arr_idgrp[] = "'". $value ."'";
            
          $criteria->addCondition(" c.IDGRP in (".implode(",", $arr_idgrp).")");
        }


        $criteria->alias = 'h';
        $criteria->select = " h.openID,h.fiscalPeriod, h.idCust, c.NAMECUST nameCust, h.revNo, h.branchID, h.salesTarget, h.openTarget, h.openBonus, openDesc,"
                . " case h.status  "
                . "     when 1 then 'Disetujui' "
                . "     when 0 then 'Draft' "
                . "     else 'Ditolak' end as status";
        $criteria->join = " left join SGTDAT..arcus c on c.idcust = h.idcust ";

        //$criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'fiscalPeriod DESC, idCust ASC',
            ),
            'pagination' => array(
                'pageSize' => 25,
            ),
        ));
    }

    public function getDetail($fiscalPeriod, $idCust) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;
        $criteria->addCondition("fiscalPeriod = '".$fiscalPeriod."' and h.idCust = '".$idCust."'");
        $criteria->alias = 'h';
        $criteria->select = "   h.openID,h.fiscalPeriod, h.idCust, c.NAMECUST nameCust, h.revNo, h.branchID, h.salesTarget, h.openTarget, h.openBonus, "
                . " case h.status  "
                . "     when 1 then 'Disetujui' "
                . "     when 0 then 'Draft' "
                . "     else 'Ditolak' end as status";
        $criteria->join = " left join SGTDAT..arcus c on c.idcust = h.idcust ";

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'revNo DESC',
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }
    
    public function getBQOpen($id) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;
        $criteria->addCondition("openID = '".$id."'");
        $criteria->alias = 'o';
        $criteria->select = "  fiscalPeriod, c.IDCUST, c.nameCust, revNo, openID, salesTarget, openTarget, openBonus, lastQ, openUser, userName,"
                . " nameDept + ' - ' + nameDiv + ' / ' + nameBranch deptName ";
        $criteria->join = " left join SGTDAT..arcus c on c.IDCUST = o.idCust
                            left join vwEmployee e on e.idCard = o.openUser ";

        return $this->find($criteria);
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
