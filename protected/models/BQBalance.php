<?php

class BQBalance extends CActiveRecord {

    public $keyWord;
    public $nameCust;
    public $bqIn;
    public $bqOut;
    public $tqIn;
    public $tqOut;
    public $stat;
    public $year;
    public $BQ1;
    public $BQ2;
    public $BQ3;
    public $BQ4;
    public $TQ1;
    public $TQ2;
    public $TQ3;
    public $TQ4;
    public $claimDesc;

    public function tableName() {
        return 'tr_bqBalance';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
//            array('termType, classDealer, fromValue, toValue, percentage', 'required',),
//            array('fromValue, toValue,', 'numerical',),
//            array('percentage,', 'numerical', 'max' => 100),
            array('balanceID, balanceReff, balanceDate, balanceType, idBranch, idCust, bqValue, tqValue, bbtValue, balanceDesc, keyWord, option, nameCust, stat,'
                . 'Q1,Q2,Q3,Q4, year, claimDesc, tqIn, tqOut', 'safe', 'on' => 'search, rptRealisasi,rptQ'),
        );
    }

    public function attributeLabels() {
        return array(
            "balanceReff" => "Referensi",
            "balanceType" => "Tipe",
            "idBranch" => "Cabang",
            "idCust" => "Dealer",
            "bqValue" => "Nilai BQ",
            "tqValue" => "Nilai TQ",
            
        );
    }

    public function search() {
        $this->attributeLabels();
        
        $idgrp = Yii::app()->user->getState('idgrp');
            
        $criteria = new CDbCriteria;

        $criteria->compare('g.TEXTDESC', $this->keyWord, true, 'OR');
        $criteria->addCondition(" isCancel <> 1 and idBranch in (select param from dbo.fn_MVParam('".$idgrp."',','))");

        $criteria->alias = 'b';
        $criteria->select = " idBranch, g.TEXTDESC nameCust, sum(bqValue) bqValue, sum(tqValue) tqValue ";
        $criteria->join = " left join SGTDAT..ARGRO g on g.IDGRP = b.idBranch ";
        $criteria->group = "  idBranch, g.TEXTDESC ";

        //$criteria->limit = 20;

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'g.TEXTDESC ASC',
            ),
            'pagination' => array(
                'pageSize' => 25,
            ),
        ));
    }

    public function getBQ($idBranch) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;
        $criteria->distinct = true;
        $criteria->addCondition("b.idBranch = '" . $idBranch . "' and idBranch <> 'A1'  and bqValue <> 0");
        $criteria->alias = 'b';
        $criteria->select = "  balanceReff, b.idBranch,
	(select isnull(sum(bqValue),0) from tr_bqBalance where balanceReff = b.balanceReff and balanceType in ('IN','UP') and idBranch = b.idBranch and isCancel <> 1) bqIn,
	(select abs(isnull(sum(bqValue),0)) from tr_bqBalance where balanceReff = b.balanceReff and balanceType in ('OUT','EXP') and idBranch = b.idBranch and isCancel <> 1) bqOut ";

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'b.balanceReff DESC',
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }
    
    public function getBQDetail($reff,$idBranch) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;
        $criteria->addCondition("balanceReff = '".$reff."' and bqValue <> 0 and idBranch = '".$idBranch."'  and isCancel <> 1");
        $criteria->alias = 'b';
        $criteria->select = "   balanceReff, convert(varchar(10), balanceDate, 105) balanceDate, balanceDesc, linkReff, sum(
                                case
                                        when bqValue > 0 then bqValue
                                        else 0 end) 'bqIn',
                               sum( case 
                                        when bqValue < 0 then abs(bqValue)
                                        else 0 end)  'bqOut' 
                                ";
        $criteria->group = "balanceReff, convert(varchar(10), balanceDate, 105) , balanceDesc, linkReff";

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'balanceDate ASC',
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    public function getTQ($idBranch) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;

        if ($idBranch != 'A1') {
            $criteria->addCondition("b.idBranch = '" . $idBranch . "' and b.idCust <> ''  and tqValue <> 0 ");
            $criteria->alias = 'b';
            $criteria->select = "  balanceReff, idBranch, b.idcust idCust, c.NAMECUST nameCust,
            (select isnull(sum(tqValue),0) from tr_bqBalance where balanceReff = b.balanceReff and balanceType in ('IN','UP') and idBranch = b.idBranch and idCust = b.idCust and isCancel <> 1) bqIn,
            (select abs(isnull(sum(tqValue),0)) from tr_bqBalance where balanceReff = b.balanceReff and balanceType in ('OUT','EXP') and idBranch = b.idBranch and idCust = b.idCust and isCancel <> 1) bqOut ";
            $criteria->join = "  left join SGTDAT..ARCUS c on c.IDCUST = b.idCust ";
            $criteria->group = "  balanceReff, idBranch, b.idCust, c.NAMECUST ";
        } else {
            $criteria->addCondition("b.idBranch = '" . $idBranch . "'  and tqValue <> 0 " );
            $criteria->alias = 'b';
            $criteria->select = " balanceReff, idBranch idCust, 'PUSAT' nameCust, 
                (select isnull(sum(tqValue),0) from tr_bqBalance where balanceReff = b.balanceReff and balanceType in ('IN','UP') and idBranch = b.idBranch and isCancel <> 1) bqIn,
                (select abs(isnull(sum(tqValue),0)) from tr_bqBalance where balanceReff = b.balanceReff and balanceType in ('OUT','EXP') and idBranch = b.idBranch and isCancel <> 1) bqOut ";
            $criteria->group = "  balanceReff, idBranch  ";
        }

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'balanceReff DESC',
            ),
        ));
    }
    
    public function rptRealisasi() {
        $this->attributeLabels();

        $idgrp = Yii::app()->user->getState('idgrp');

        $count=Yii::app()->db->createCommand(
           " select  count(distinct idBranch)
                from tr_bqBalance b
                where balanceReff like '".$this->keyWord."'+'%'")->queryScalar();
        
        $criteria   = new CDbCriteria;

        $arr_idgrp = array();
        foreach( explode(",", $idgrp) as $index=>$value )
            $arr_idgrp[] = "'". $value ."'";
            $criteria->addCondition(" balanceReff like '".$this->keyWord."'+'%' and g.idgrp = b.idBranch and   idBranch in (".implode(",", $arr_idgrp).") ");

        $condition  = $criteria->condition;
        $params     = $criteria->params;        
//        unset($criteria);
        
        $sql = Yii::app()->db->createCommand()
        ->select("  
                    idBranch, TEXTDESC nameCust, 
                    (select isnull(sum(bqValue),0) 
                        from tr_bqBalance c 
                        where datediff(d, balanceDate, '".$this->keyWord."'+'-03-31') >= 0 
                                and c.idBranch = b.idBranch and isCancel = 0) BQ1,
                    (select isnull(sum(tqValue),0) 
                        from tr_bqBalance c 
                        where datediff(d, balanceDate, '".$this->keyWord."'+'-03-31') >= 0 
                                and c.idBranch = b.idBranch and isCancel = 0) TQ1,
                    (select isnull(sum(bqValue),0) 
                        from tr_bqBalance c 
                        where datediff(d, balanceDate, '".$this->keyWord."'+'-06-30') >= 0 
                                and c.idBranch = b.idBranch and isCancel = 0) BQ2, 
                    (select isnull(sum(tqValue),0) 
                        from tr_bqBalance c 
                        where datediff(d, balanceDate,  '".$this->keyWord."'+'-06-30') >= 0 
                                and c.idBranch = b.idBranch and isCancel = 0) TQ2,
                    (select isnull(sum(bqValue),0) 
                        from tr_bqBalance c 
                        where datediff(d, balanceDate, '".$this->keyWord."'+'-09-30') >= 0 
                                and c.idBranch = b.idBranch and isCancel = 0) BQ3,
                    (select isnull(sum(tqValue),0) 
                        from tr_bqBalance c 
                        where datediff(d, balanceDate, '".$this->keyWord."'+'-09-30') >= 0 
                                and c.idBranch = b.idBranch and isCancel = 0) TQ3,
                    (select isnull(sum(bqValue),0) 
                        from tr_bqBalance c 
                        where datediff(d, balanceDate, '".$this->keyWord."'+'-12-31') >= 0 
                                and c.idBranch = b.idBranch and isCancel = 0) BQ4,
                    (select isnull(sum(tqValue),0) 
                            from tr_bqBalance c 
                            where datediff(d, balanceDate, '".$this->keyWord."'+'-12-31') >= 0 
                                    and c.idBranch = b.idBranch and isCancel = 0) TQ4                                
                ")
                ->from(" tr_bqBalance b, SGTDAT.dbo.ARGRO g")
                ->group(" idBranch, TEXTDESC")
                ->where($condition, $params);       
        return new CSqlDataProvider($sql, array(
            'keyField' => 'idBranch',
            'totalItemCount'=>$count,
            'pagination'=>array(
                'pageSize'=>25, //Show all records
            ),
        )); 
    }
    
    public function rptQ(){
        
        $this->attributeLabels();

        $idgrp = Yii::app()->user->getState('idgrp');
        $level = Yii::app()->user->getState('level');
        $criteria = new CDbCriteria;
        
        $criteria->addCondition(" b.balanceReff = '".$this->year."-".$this->keyWord."' and isCancel = 0");

        if($level !== "Admin" && $level !== "Accounting" )
        {                
            $arr_idgrp = array();
            foreach( explode(",", $idgrp) as $index=>$value )
                $arr_idgrp[] = "'". $value ."'";
            
            $criteria->addCondition(" idBranch in (".implode(",", $arr_idgrp).")");
        }

       
        
        $criteria->alias = 'b';
        $criteria->select = " balanceReff, idBranch, g.TEXTDESC nameCust, sum(bqValue) bqValue, sum(tqValue) tqValue  ";
        $criteria->join = " left join SGTDAT..ARGRO g on g.IDGRP = b.idBranch ";
        $criteria->group = " balanceReff, idBranch,  g.TEXTDESC ";
        
        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'b.idBranch ASC',
            ),
            'pagination' => array(
                'pageSize' => 25,
            ),
        ));
        
    }
    
    public function expBQ(){
        $this->attributeLabels();

        $criteria = new CDbCriteria;
        $criteria->addCondition("balanceReff = '".$this->balanceReff."' and idBranch = '".$this->idBranch."'  and isCancel <> 1");
        $criteria->alias = 'b';
        $criteria->select = "   balanceReff, convert(varchar(10), balanceDate, 105) balanceDate, balanceDesc, linkReff, 
                                case 
                                        when left(linkReff,2) = 'BQ' then c.idCust
                                        when left(linkReff,2) = 'IM' then o.dealer_id
                                        else '' end as idCust,
                                case 
                                        when left(linkReff,2) = 'BQ' then (select namecust from sgtdat..arcus where idcust = c.idcust)
                                        when left(linkReff,2) = 'IM' then (select namecust from sgtdat..arcus where idcust = o.dealer_id)
                                        else '' end as nameCust,
                                c.claimDesc,
                                sum( case
                                        when bqValue > 0 then bqValue
                                        else 0 end) 'bqIn',
                                sum( case 
                                        when bqValue < 0 then abs(bqValue)	
                                        else 0 end) 'bqOut',
                                sum( case
                                        when tqValue > 0 then tqValue
                                        else 0 end) 'tqIn',
                                sum( case 
                                        when tqValue < 0 then abs(tqValue)	
                                        else 0 end) 'tqOut'  
                                ";
        $criteria->join = "left join tr_bqClaim c on c.bqClaimNo = b.linkReff
	left join dm..[order] o on o.order_id = b.linkReff"; 
        $criteria->group = " balanceReff, convert(varchar(10), balanceDate, 105) , balanceDesc, linkReff, c.idCust, o.dealer_id, claimDesc ";


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'balanceDate ASC',
            ),
            
        ));
        
    }
    
    public function getTQDetail($reff,$idBranch,$idCust) {
        $this->attributeLabels();

        $criteria = new CDbCriteria;
        
        if($idCust == 'A1'){
            $criteria->addCondition(" balanceReff = '".$reff."' and tqValue <> 0 and idBranch = '".$idCust."'  and isCancel <> 1");
        }else{
            $criteria->addCondition(" balanceReff = '".$reff."' and tqValue <> 0 and idBranch = '".$idBranch."' and idCust = '".$idCust."'  and isCancel <> 1 ");
        }
        
        $criteria->alias = 'b';
        $criteria->select = " balanceReff, convert(varchar(10), balanceDate, 105) balanceDate,balanceDesc, linkReff ,
                                sum(case
                                        when tqValue > 0 then tqValue
                                        else 0 end ) 'bqIn',
                                sum(case 
                                        when tqValue < 0 then abs(tqValue)
                                        else 0 end ) 'bqOut' 
                                 ";
        $criteria->group = "balanceReff, convert(varchar(10), balanceDate, 105) , balanceDesc, linkReff";
        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'balanceDate DESC',
            ),
            'pagination' => array(
                'pageSize' => 20,
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
