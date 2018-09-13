<?php

class BQItem extends CActiveRecord {

    public $keyWord;
    public $option;
    public $nameCust;

    public function tableName() {
        return 'tr_bqClaimDetail';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('bqClaimNo', 'required',),
            array('itemQty, itemPrice, itemTotal, nonItemValue, nonItemTotal', 'numerical',),
//            array('percentage,', 'numerical', 'max' => 100),
            array('bqClaimDetailID, bqClaimNo, itemNo, itemQty, itemPrice, itemTotal, nonItemDesc, nonItemValue, nonItemTotal, keyWord', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            "bqClaimNo" => "No. Klaim",
            "itemNo" => "Barang",
            "itemQty" => "Jumlah",
            "itemPrice" => "Harga",
            "itemTotal" => "Total",
            "nonItemDesc" => "Selain Barang",
            "nonItemValue" => "Nilai",
            "nonItemTotal" => "Total",
                        
        );
    }

//    public function search() {
//        $this->attributeLabels();
//
//        $criteria = new CDbCriteria;
//
//        $criteria->compare('c.nameCust', $this->keyWord, true, 'OR');    
//        
//        $criteria->alias = 's';
//        $criteria->select = "  s.idCust, c.nameCust, branchID,  sum(bqValue) bqValue, sum(tqValueC) tqValueC, sum(tqValueP) tqValueP, sum(bbtValue) bbtValue ";
//        $criteria->join = " left join ms_bqtqfiscal f on s.fiscalPeriod = f.fiscalPeriod
//                            left join sgtdat..arcus c on c.idcust = s.idcust ";
//        $criteria->group = "s.idCust, c.namecust,  branchID";
//
//        //$criteria->limit = 20;
//
//        return new ActiveDataProvider($this, array(
//            'criteria' => $criteria,
//            'sort' => array(
//                'defaultOrder' => 'c.nameCust ASC',
//            ),
//            'pagination' => array(
//                'pageSize' => 25,
//            ),
//        ));
//    }

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
