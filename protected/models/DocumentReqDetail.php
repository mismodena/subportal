<?php

class DocumentReqDetail extends CActiveRecord {

    public $invTotal;
    public $invDate;
    public $customer;
    public $customer2;
    public $fmtAmount;
    public $fmt2Amount;
    public $bilname;
    public $check = 0;
    public $finance;
    
    public function afterFind() {
        $this->fmtAmount = Yii::app()->format->number(($this->invTotal));
        $this->fmt2Amount = Yii::app()->format->number(($this->retValue));
        return parent::afterFind();
    }

    public function tableName() {
        return 'tr_docRequestDetail';
    }

    public function rules() {
        return array(
            array('reqID', 'required'),
            array('docNumber, reqID, inputUN, modifUN, retType, retNumber', 'length', 'max' => 50),
            array('inputTime, modifTime', 'safe'),
            array('reqID, docNumber, revNumber, inputUN, inputTime, modifUN, modifTime, retType, retValue, retNumber, retDate, isModena, invTotal, invDate, customer, customer2, bilname, revValue,revDesc, retDesc', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'docNumber' => 'Faktur',
            'inputUN' => 'Input Un',
            'inputTime' => 'Input Time',
            'modifUN' => 'Modif Un',
            'modifTime' => 'Modif Time',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('inputUN', $this->inputUN, true);
        $criteria->compare('inputTime', $this->inputTime, true);
        $criteria->compare('modifUN', $this->modifUN, true);
        $criteria->compare('modifTime', $this->modifTime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getDetail($id) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;
        $criteria->compare('reqID', $id);

//            if($level !== "Admin" AND $level !== "Finance"  )
//            {
//                $criteria->addCondition(" fppUser = '".$idcard."'");
//            }
//            if($level == "Finance"  )
//            {
//                $criteria->addCondition(" persetujuan is null ");
//            }

        $criteria->alias = 'd';
        $criteria->select = " h.BILNAME customer, d.docNumber, dbo.fnGetAccpacDate(h.invDate) invDate, d.invValue invTotal, retValue, retDate, retNumber, isModena,"
                . " case retType"
                . "     when 'CH' then 'Cash' "
                . "     when 'TR' then 'Transfer' "
                . "     when 'GR' then 'Giro' "
                . "     when 'CK' then 'Cek' "
                . "     when 'FL' then 'Gagal' "
                . "     when 'TT' then 'TTTFP' "
                . "     else '-' end as retType, d.revValue, revNumber ";    
        $criteria->join = " left join SGTDAT..oeinvh h on d.docNumber = h.INVNUMBER ";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 100),
        ));
    }        

    public function getDetailD($id) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;
        $criteria->compare('reqID', $id);

//            if($level !== "Admin" AND $level !== "Finance"  )
//            {
//                $criteria->addCondition(" fppUser = '".$idcard."'");
//            }
//            if($level == "Finance"  )
//            {
//                $criteria->addCondition(" persetujuan is null ");
//            }

        $criteria->alias = 'd';
        $criteria->select = "h.bilname, detID, ltrim(rtrim(d.docNumber)) + CHAR(10) + ltrim(rtrim(h.BILNAME)) + CHAR(10) + convert(varchar(10), dbo.fnGetAccpacDate(h.invDate), 105) customer, d.docNumber, dbo.fnGetAccpacDate(h.invDate) invDate, d.invValue invTotal, retValue, retDate, revValue, retNumber, isModena,"
                . " case retType"
                . "     when 'TT' then 'TTTFP' "
                . "     when 'TR' then 'Transfer' "
                . "     when 'GR' then 'Giro' "
                . "     when 'CK' then 'Cek' "
                . "     when 'FL' then 'Gagal' "
                . "     else '---' end as retType , revNumber ";
        
        $criteria->join = " left join SGTDAT..oeinvh h on d.docNumber = h.INVNUMBER ";

        return $this->findAll($criteria);
    }
    
    public function getDetailR($id) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;
        $criteria->compare('reqID', $id);

//            if($level !== "Admin" AND $level !== "Finance"  )
//            {
//                $criteria->addCondition(" fppUser = '".$idcard."'");
//            }
//            if($level == "Finance"  )
//            {
//                $criteria->addCondition(" persetujuan is null ");
//            }

        $criteria->alias = 'd';
        $criteria->select = "h.bilname, detID, "
                . "  case retType"
                . "     when 'TT' then 'Tukar Tanda Terima' + CHAR(10) + ltrim(rtrim(d.retNumber)) + CHAR(10) + convert(varchar(10), retDate, 105) "
                . "     when 'TR' then 'Transfer' + CHAR(10) + ltrim(rtrim(d.retNumber)) + CHAR(10) + convert(varchar(10), retDate, 105) "
                . "     when 'GR' then 'Giro' + CHAR(10) + ltrim(rtrim(d.retNumber)) + CHAR(10) + convert(varchar(10), retDate, 105)"
                . "     when 'CK' then 'Cek' + CHAR(10) + ltrim(rtrim(d.retNumber)) + CHAR(10) + convert(varchar(10), retDate, 105)"
                . "     when 'FL' then 'Gagal' + CHAR(10) + ltrim(rtrim(d.retNumber)) + CHAR(10) + convert(varchar(10), retDate, 105)"
                . "     else '---' end as customer2, "
                . " ltrim(rtrim(d.docNumber)) + CHAR(10) + ltrim(rtrim(h.BILNAME)) + CHAR(10) + convert(varchar(10), dbo.fnGetAccpacDate(h.invDate), 105) customer, "
                . " d.docNumber, dbo.fnGetAccpacDate(h.invDate) invDate, d.invValue invTotal, retValue, retDate, retNumber, isModena, revValue, "
                . " case retType"
                . "     when 'TT' then 'TTTFP' "
                . "     when 'TR' then 'Transfer' "
                . "     when 'GR' then 'Giro' "
                . "     when 'CK' then 'Cek' "
                . "     when 'FL' then 'Gagal' "
                . "     else '---' end as retType , revNumber ";
        
        $criteria->join = " left join SGTDAT..oeinvh h on d.docNumber = h.INVNUMBER ";

        return $this->findAll($criteria);
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
