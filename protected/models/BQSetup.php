<?php

class BQSetup extends CActiveRecord {

    public $keyWord;
    public $option;

    public function tableName() {
        return 'ms_bqtqFiscal';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('fiscalPeriod, openTQ, openSource', 'required',),
//            array('fromValue, toValue,', 'numerical',),
//            array('percentage,', 'numerical', 'max' => 100),
            array('fiscalPeriod, openTQ, openSource, keyWord, option', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            "fiscalPeriod" => "Fiskal",
            "openTQ" => "Pengajuan Open TQ",
            "openSource" => "Saldo Bisa Digunakan",
        );
    }

    public function search() {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        $criteria->compare('h.fiscalPeriod', $this->keyWord, true, 'OR');
        
        $criteria->alias = 'h';
        $criteria->select = " fiscalPeriod, openTQ, openSource ";
        $criteria->join = " ";

        //$criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => ' fiscalPeriod ASC',
            ),
            'pagination' => array(
                'pageSize' => 4,
            ),
        ));
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
