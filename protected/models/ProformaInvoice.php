<?php

class ProformaInvoice extends CActiveRecord
{    
   
    public $keyWord;
    public $accName;
    public $items;
    public $grandTotal;
    public $beforeTax;
    public $vat;
    public $grand;
    public $textAmt;
    public $approval;


    public function tableName()
    {
        return 'tr_invHeader';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('invNo, poNo, poName, salesAcc, invDate', 'required',),
                //array('invTempDP, invTotal, invDP, invTotalWtx, invDisc','numerical'),
                array('invNo', 'unique',),
                array('invID, invNo, poNo, poName, invTotal, invDisc, invTotalWtx, invDP, salesAcc, invDate, keyWord, accName, grandTotal, beforeTax, ppn, grand, textAmt, invTempDP, status, picNo, status, approval, invRetensi' , 'safe', 'on'=>'search'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                    'invID' => 'ID',
                    'invNo' => 'No. Faktur',
                    'poNo' => 'No. PO',
                    'poName' => 'Buyer',
                    'invTotal' => 'Total',
                    'invDisc' => 'Diskon Penjualan',
                    'invDate' => 'Tgl. Faktur',
                    'invDP' => 'DP',
                    'salesAcc' => 'Sales',
                    'grandTotal' => 'Total Penjualan',
                    'beforeTax' => 'Total Sebelum PPn',
                    'vat' => 'PPn',
                    'grand' => 'Total',
                    'accName' => 'Sales',
                    'invTempDP' => 'Penagihan DP',
                    'status' => 'Status',
                    'picNo' => 'PIC',
                    'invRetensi' => 'Retensi',
                    
            );
    }

    public function search()
    {
            $this->attributeLabels();
            $idcard = Yii::app()->user->getState('idcard');
            $level = Yii::app()->user->getState('level');
            
            $criteria=new CDbCriteria;

            $criteria->compare('h.invNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.poNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.poName',$this->keyWord,true,'OR');
            if($level !== "Admin" AND $level !== "Finance"  )
            {
                $criteria->addCondition(" picNo = '".$idcard."'");
            }
            
            $criteria->alias = 'h';                            
            $criteria->select=" 
                     h.invID, invNo, invDate, poNo, poName, sa.accName, invTotal, invDisc, invTotalWtx, invDP, salesAcc, invRetensi,
                     case 
                        when status = 0 then 'Entry'
                        when status = 1 then 'Verified'
                        when status = 2 then 'Signed' end as status
                        " ;
            $criteria->join = "	
                   /* left join tr_invDetail dt on dt.invID = h.invID */
                    left join ms_salesAccount sa on sa.accNo = h.salesAcc
                    ";

            $criteria->limit = 20;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'invDate DESC',
                  )
            ));                    

    }
    
    public function verify()
    {
            $this->attributeLabels();
            $idcard = Yii::app()->user->getState('idcard');
            $level = Yii::app()->user->getState('level');
            
            $criteria=new CDbCriteria;

            $criteria->compare('h.invNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.poNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.poName',$this->keyWord,true,'OR');
            $criteria->addCondition(" status = 0 ");
            if($level !== "Admin" AND $level !== "Finance"  )
            {
                $criteria->addCondition(" picNo = '".$idcard."'");
            }
            
            $criteria->alias = 'h';                            
            $criteria->select=" 
                     h.invID, invNo, invDate, poNo, poName, sa.accName, invTotal, invDisc, invTotalWtx, invDP, salesAcc, invRetensi,
                     case 
                        when status = 0 then 'Entry'
                        when status = 1 then 'Verified'
                        when status = 2 then 'Signed' end as status
                        " ;
            $criteria->join = "	
                    /*left join tr_invDetail dt on dt.invID = h.invID*/
                    left join ms_salesAccount sa on sa.accNo = h.salesAcc
                    ";

            $criteria->limit = 20;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'invDate DESC',
                  )
            ));                    

    }
    
    public function getInvHeader($invID)
    {   
        $criteria=new CDbCriteria;

        $criteria->compare('h.invID',$invID,true); 

        $criteria->alias = 'h';                            
        $criteria->select=" 
                h.invID, invNo, invDate, poNo, poName, sa.accName, invTotal, invDisc, invTotalWtx, invDP, salesAcc, invTempDP, invRetensi, status, 
                (select sum(unitPrice*unitQty) from tr_invDetail d where d.invID = h.invNo) grand, accName, picNo,
                case
                    when invTempDP = 0 then dbo.fnMoneyToEnglish(invTotalWtx) 
                    else
                        dbo.fnMoneyToEnglish((invTempDP/100)*invTotalWtx) end as textAmt
                    " ;
        $criteria->join = "	
                left join tr_invDetail dt on dt.invID = h.invID
                left join ms_salesAccount sa on sa.accNo = h.salesAcc
                ";

        return  $this->find($criteria);
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
