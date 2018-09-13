<?php

class BQTerm extends CActiveRecord {

    public $keyWord;
    public $option;

    public function tableName() {
        return 'ms_bqtqTerm';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('termType, classDealer, fromValue, toValue, percentage', 'required',),
            array('fromValue, toValue,', 'numerical',),
            array('percentage,', 'numerical', 'max' => 100),
            array('termType, classDealer, fromValue, toValue, percentage, keyWord, option', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            "termType" => "Type",
            "classDealer" => "Kelas Dealer",
            "fromValue" => "Omset Dari",
            "toValue" => "sampai dengan",
            "percentage" => "Persentase",
        );
    }

    public function search() {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        $criteria->compare('h.termType', $this->keyWord, true, 'OR');
        $criteria->compare('h.classDealer', $this->keyWord, true, 'OR');
        
        if($this->option != "All"){
            $criteria->addCondition(" termType = '".$this->option."'");
        }
        
        $criteria->alias = 'h';
        $criteria->select = " termType, classDealer, fromValue, toValue, percentage ";
        $criteria->join = " ";

        //$criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'termType ASC, classDealer ASC',
            ),
            'pagination' => array(
                'pageSize' => 25,
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
