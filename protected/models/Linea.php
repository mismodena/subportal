<?php

class Linea extends CActiveRecord {

    public $keyWord;
    public $itemName;
    
    public function tableName() {
        return 'tr_lineaValue';
    }

    public function rules() {
        return array(
//            array('itemNo, fi', 'required',),
//            array('bqClaimNo', 'unique',),
//            array('totalNonItems, totalItems, claimTotal, bqUsed, tqUsed', 'numerical',),
//            array('claimDesc', 'length', 'max' => 400),
            array('itemNo, fiscalPeriod, fiscalYear, currency, unitPrice, currencyRate, lineaPercentage, lineaValue, lineaValueHome, qtyOrder, lineaPerOrder, keyWord, itemName', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'itemNo' => 'Item No.',
            'fiscalPeriod' => 'Periode',
            'fiscalYear' => 'Tahun',            
            'lineaValueHome' => 'Linea Per Unit',
            'qtyOrder' => 'Qty Terjual',
            'lineaPerOrder' => 'Linea HPP',
        );
    }

    public function search() {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        if($this->itemNo != "ALL"){
            $criteria->compare('l.itemNo', $this->itemNo, true);
        }
        if($this->fiscalPeriod != "ALL"){
            $criteria->compare('fiscalPeriod', $this->fiscalPeriod, true);
        }
        
        $criteria->compare('fiscalYear', $this->fiscalYear, true);

        $criteria->alias = 'l';
        $criteria->select = " l.itemNo, i.[DESC] itemName, fiscalPeriod, fiscalYear, avg(lineaValueHome) lineaValue, avg(qtyorder) qtyOrder ";
        $criteria->join = " left join SGTDAT..ICITEM i on i.FMTITEMNO = l.itemNo ";
        $criteria->group = " l.itemno, i.[DESC], fiscalPeriod, fiscalYear";
        
        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 12,
            ),
            'sort' => array(
                'defaultOrder' => 'fiscalYear DESC, itemNo ASC, fiscalPeriod ASC',
            )
        ));
    }
    
    public function export() {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        if($this->itemNo != "ALL"){
            $criteria->compare('l.itemNo', $this->itemNo, true);
        }
        if($this->fiscalPeriod != "ALL"){
            $criteria->compare('fiscalPeriod', $this->fiscalPeriod, true);
        }
        
        $criteria->compare('fiscalYear', $this->fiscalYear, true);

        $criteria->alias = 'l';
        $criteria->select = " l.itemNo, i.[DESC] itemName, fiscalPeriod, fiscalYear, avg(lineaValueHome) lineaValue, avg(qtyorder) qtyOrder ";
        $criteria->join = " left join SGTDAT..ICITEM i on i.FMTITEMNO = l.itemNo ";
        $criteria->group = " l.itemno, i.[DESC], fiscalPeriod, fiscalYear";
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 12,
            ),
            'sort' => array(
                'defaultOrder' => 'fiscalYear DESC, itemNo ASC, fiscalPeriod ASC',
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
