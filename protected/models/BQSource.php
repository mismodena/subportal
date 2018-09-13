<?php

class BQSource extends CActiveRecord {

    public $keyWord;
    public $option;
    public $nameCust;

    public function tableName() {
        return 'ms_bqtqSource';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
//            array('termType, classDealer, fromValue, toValue, percentage', 'required',),
//            array('fromValue, toValue,', 'numerical',),
//            array('percentage,', 'numerical', 'max' => 100),
            array('fiscalPeriod, idCust, branchID, invTotal, bqPerc, bqValue, tqPerc, tqValueP, tqValueC, bbtPerc, bbtValue, count37, count44, status, keyWord, option, nameCust', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            "fiscalPeriod" => "Fiskal",
            "idCust" => "Dealer",
            "branchID" => "Cabang",
            "invTotal" => "Total Invoice",
            "bqPerc" => "Persentase BQ",
            "bqValue" => "Nilai BQ",
            "tqPerc" => "Persentase TQ",
            "tqValueP" => "Nilai TQ Pusat",
            "tqValueC" => "Nilai TQ Cabang",
            "bbtPerc" => "Persentase BBT",
            "bbtValue" => "Nilai BBT",
            "count37" => "x2",
            "count44" => "x1",
            "status" => "Status",
            "nameCust"=>"Nama Dealer"
            
        );
    }

    public function search() {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        $criteria->compare('c.nameCust', $this->keyWord, true, 'OR');    
        
        $criteria->alias = 's';
        $criteria->select = "  s.idCust, c.nameCust, branchID,  sum(bqValue) bqValue, sum(tqValueC) tqValueC, sum(tqValueP) tqValueP, sum(bbtValue) bbtValue ";
        $criteria->join = " left join ms_bqtqfiscal f on s.fiscalPeriod = f.fiscalPeriod
                            left join sgtdat..arcus c on c.idcust = s.idcust ";
        $criteria->group = "s.idCust, c.namecust,  branchID";

        //$criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'c.nameCust ASC',
            ),
            'pagination' => array(
                'pageSize' => 25,
            ),
        ));
    }

    public function getSourceDetail($reff, $id) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        $criteria->addCondition(" s.fiscalPeriod =  '".$reff."' and branchID = '".$id."'");    
        
        $criteria->alias = 's';
        $criteria->select = "  fiscalPeriod, s.idCust, c.nameCust, invTotal, bqValue, tqValueC, count37, count44, status ";
        $criteria->join = " left join sgtdat..arcus c on c.idcust = s.idcust ";
        
        //$criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'c.nameCust ASC',
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
