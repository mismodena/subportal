<?php

class DocumentRequest extends CActiveRecord
{       
           
    public $fmtDate;
    public $fmt2Date;
    public $fmtAmount;
    public $fmt2Amount;
    public $salesName;
    public $keyWord;
    public $items;
    public $unpaid;
    public $customer;
    public $attachment;
    public $tttfp;


    public function tableName()
	{
            return 'tr_docRequest';
	}

	public function rules()
	{
            return array(
                array('reqNumber, reqSales, reqDate', 'required',),
                array('reqNumber', 'unique',),
                array('reqNumber, reqSales, salesRcv, finRcv, inputUN, modifUN, finRet', 'length', 'max'=>50),
                array('reqDate, salesRcvDate, finRcvDate, inputTime, modifTime, reqDate', 'safe'),
                array('reqID, reqNumber, reqSales, reqDate, salesRcvDate, salesRcv, finRcvDate, finRcv, inputUN, inputTime, modifUN, modifTime, '
                    . 'fmtDate, salesName, keyWord, invCount, invValue, customer, returnDate, finRetDate,realisasi, retValue, fmt2date, fmtAmount, retCount, fmt2amount, revCount, revValue, attachment', 'safe', 'on'=>'search,getRequest'),
            );
	}

	public function relations()
	{
            return array(
            );
	}

	public function attributeLabels()
	{
            return array(
                    'reqNumber' => 'Nomor',
                    'reqSales' => 'Sales',
                    'reqDate' => 'Tanggal',
                    'salesRcvDate' => 'Tanggal Terima Sales',
                    'salesRcv' => 'Sales',
                    'finRcvDate' => 'Tanggal Terima Finance',
                    'finRcv' => 'Finance',     
                    'invCount' => 'Faktur diserahkan',
                    'invValue' => 'Senilai',    
                    'retCount' => 'Faktur kembali',
                    'retValue' => 'Senilai',     
                    'revCount' => 'Faktur terverifikasi',
                    'revValue' => 'Senilai',     
                    
            );
	}

	public function search()
	{
            $this->attributeLabels();
            
            $idcard = Yii::app()->user->getState('idcard');
            $level = Yii::app()->user->getState('level');
            $user = Yii::app()->user->name;            
            $idgrp = Yii::app()->user->getState('idgrp');
            $branch = Yii::app()->user->getState('branch');
            
            $criteria=new CDbCriteria;                                   
            
            $criteria->compare('reqNumber',$this->keyWord,true, 'OR');
            $criteria->compare('reqSales',$this->keyWord,true, 'OR');
            $criteria->compare('e.userName',$this->keyWord,true, 'OR');
            
            if($level == "Finance" && $branch != "PST"){
                $criteria->addCondition(" a.reqSales in (select idcard from ms_user where userlevel in ('SD','Finance') and branch = '".$branch."') ");
            }
            
            if($level != "Admin" && $level != "Finance" )
            {
                $criteria->addCondition(" a.reqSales = '".$idcard."'");
            } 
            
//            if($level == "Finance"  )
//            {
//                $criteria->addCondition(" persetujuan is null ");
//            }
                        
            $criteria->alias = 'a';                            
            $criteria->select="a.finRet, a.finRetDate, a.realisasi, isnull(a.retValue,0) retValue, isnull(a.retCount,0) retCount,a.returnDate, a.reqID, "
                    . "a.reqNumber, a.reqSales, e.userName salesName, a.reqDate, a.salesRcv, a.salesRcvDate, a.finRcv, a.finRcvDate, a.invCount, a.invValue,"
                    . "a.revValue, a.revCount ";
            $criteria->join = " left join vwEmployee e on e.idCard = a.reqSales ";

            return new ActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                            'defaultOrder'=>'reqNumber DESC',
                        )
            ));
	}    
        
        public function getRequest($id)
	{
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;    
            $criteria->compare('reqID',$id,true);

//            if($level !== "Admin" AND $level !== "Finance"  )
//            {
//                $criteria->addCondition(" fppUser = '".$idcard."'");
//            }
//            if($level == "Finance"  )
//            {
//                $criteria->addCondition(" persetujuan is null ");
//            }
                        
            $criteria->alias = 'a';                            
            $criteria->select=" a.finRet, a.finRetDate, a.realisasi, isnull(a.retValue,0) retValue, isnull(a.retCount,0) retCount, "
                    . "a.returnDate, a.reqID, a.reqNumber, a.reqSales, e.userName salesName, a.reqDate, a.salesRcv, a.salesRcvDate, a.finRcv,"
                    . " a.finRcvDate, a.invCount, a.invValue, a.revValue, a.revCount";
            $criteria->join = " left join vwEmployee e on e.idCard = a.reqSales ";

            return $this->find($criteria);
	}    

	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
        
        protected function beforeSave()
        {            
            if(parent::beforeSave())
            {
                if($this->isNewRecord)
                {
                        $this->inputTime=new CDbExpression('getdate()');
                        $this->inputUN=Yii::app()->user->name;
                        $this->modifTime=new CDbExpression('getdate()');
                        $this->modifUN=Yii::app()->user->name;
                }
                else
                        $this->modifTime=new CDbExpression('getdate()');
                        $this->modifUN=Yii::app()->user->name;
                return true;
            }
            else
                    return false;
        }
}
