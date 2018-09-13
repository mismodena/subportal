<?php

class Invoice extends AccpacActiveRecord {

    public $CNTBTCH;
    public $IDRMIT;
    public $DATERMIT;
    public $NAMECUST;
    public $DATEBTCH;
    public $AMTPAYM;
    public $keyWord;
    public $pkpAge;
    public $ITEM;
    public $QTYORDERED;
    public $QTYSHIP;
    public $DESC;
    
    public function tableName() {
        return 'OEINVH';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('CNTBTCH, ORDNUMBER, INVNUMBER, IDRMIT, NAMECUST, DATERMIT, DATEBTCH, CUSTOMER, INVDATE, INVNETWTX, AMTPAYM, keyWord, pkpAge', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'CNTBTCH' => 'Receipt Batch',
            'ORDNUMBER' => 'No. Order',
            'INVNUMBER' => 'No. Invoice',
            'IDRMIT' => 'Refference',
            'NAMECUST' => 'Nama Dealer',
            'DATERMIT' => 'Tgl. Bayar',
            'DATEBTCH' => 'Tgl. Post CB',
            'CUSTOMER' => 'Kode Delaer',
            'INVDATE' => 'Tgl. Invoice',
            'INVNETWTX' => 'Total Inv.',
            'AMTPAYM' => 'Total Bayar',
            'pkpAge' => 'Umur PKP',
        );
    }

    public function search() {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        $criteria->compare('h.INVNUMBER', $this->keyWord, false);
        $criteria->alias = 'h';
        $criteria->select = " 
                    h.INVUNIQ, h.CUSTOMER, cu.NAMECUST, h.ORDNUMBER, h.INVNUMBER, pd.CNTBTCH, ph.IDRMIT, dbo.fnGetAccpacDate(h.invdate) INVDATE, 
                    dbo.fnGetaccpacdate(ph.DATERMIT) DATERMIT, dbo.fnGetAccpacDate(pc.DATEBTCH) DATEBTCH, h.INVNETWTX, 
                    datediff(d, dbo.fnGetaccpacdate(ph.DATERMIT), getdate()) pkpAge,
                    case 
                        when (select COUNT(batchid) from CBBTHD where REFERENCE = ph.IDRMIT and TEXTDESC like 'reverse - %') > 0 then 0 
                        else pd.AMTPAYM end as AMTPAYM ";

        $criteria->join = "	
                    left join ARTCP pd on pd.IDINVC = h.INVNUMBER
                    left join ARTCR ph on ph.CNTBTCH = pd.CNTBTCH and ph.CNTITEM = pd.CNTITEM
                    left join ARBTA pc on pc.CNTBTCH = ph.CNTBTCH 
                    left join ARCUS cu on cu.IDCUST = h.CUSTOMER";

        $criteria->limit = 20;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getInvoice() {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        $criteria->addCondition("datediff(d, SGTDAT.dbo.fnGetAccpacDate(h.invdate), getDate()) <=7 
		and c.IDGRP in ('Y','Y1') and dt.invNumber not in (select docNumber from FPP..tr_docHeader)");
        $criteria->alias = 'h';
        $criteria->select = " h.INVNUMBER invNumber, h.INVNETWTX invTotal, dt.custName customer, dbo.fnGetAccpacDate(INVDATE) invDate ";

        $criteria->join = " left join SGTDAT..mis_pajak_detail dt on dt.invNumber = h.INVNUMBER
	left join SGTDAT..arcus c on c.IDCUST = h.CUSTOMER ";

        $criteria->limit = 20;

        return $this->findAll($criteria) ;
    }
    
    public function getInvoiceItem($id){
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        $criteria->compare('h.INVNUMBER', $id, true);
        $criteria->alias = 'h';
        $criteria->select = " 
                    h.INVNUMBER, d.ITEM, d.[DESC],sum(d.QTYORDERED) QTYORDERED, (select sum(qtyShipment) from FPP..tr_docDetailItem where docID in (select docID from FPP..tr_docDetail where docNumber = h.INVNUMBER and itemNo = d.ITEM)) QTYSHIP ";

        $criteria->join = "	
                   left join SGTDAT..OEINVD d on h.INVUNIQ = d.INVUNIQ ";
        $criteria->group = " h.INVNUMBER, d.ITEM, d.[DESC]";

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 100),
        ));
    }

}
