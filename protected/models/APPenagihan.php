<?php

class APInvoice extends CActiveRecord
{    
   
    public $keyWord;
    public $items;
    public $details;
    public $docCategory;
    public $deptName;
    public $apDetailID;
    public $invStatus;
    public $dtApInvNo;
    public $dtApInvDate;
    public $dtApDueDate;
    public $dtApInvTotal;
    public $fppStatus;
    public $fppID;

    public function tableName()
    {
        return 'tr_apInvoice';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            return array(
                array('apSupplier, apInvCategory, recDate, apInvTotal', 'required',),
                array('apInvNo, recNo,', 'unique',),
                array('poNo, bapbNo, ppNo, recNo, apDesc', 'length','max'=>50),
                array('apInvTotal', 'numerical',),
                array('apInvID, apInvNo, apSupplier, apDesc, apInvDate, apDueDate, poNo, bapbNo, ppNo, status, keyWord, items, recNo, apInvCategory, apInvTotal, docCategory, recDate, deptID, apDetailID, invStatus'
                    . 'dtApInvNo, dtApInvTotal, dtApDueDate, dtApInvDate, fppStatus, fppID', 'safe', 'on'=>'search, delegation, inkuiri'),
            );
    }
    
    public function attributeLabels()
    {
            return array(
                    'apInvNo' => 'No. Faktur',
                    'apSupplier' => 'Supplier',
                    'apDesc' => 'Keterangan',
                    'apInvDate' => 'Tgl. Faktur',
                    'apDueDate' => 'Tgl. Jatuh Tempo',
                    'poNo' => 'No. PO',
                    'bapbNo' => 'No. BAPB',
                    'ppNo' => 'No. PP',
                    'status' => 'Status',
                    'apInvTotal' => 'Total',
                    'deptID' => 'Departmen',
                    'deptName' => 'Departmen',
                    'PIC' => 'PIC',                                      
                    'recNo' => 'No. Penerimaan',                              
                    'apInvCategory' => 'Jenis Faktur', 
                    'docCategory' => 'Jenis Faktur',
                    'recDate' => 'Tgl. Terima Faktur',
                    'deptID' => 'Departemen',
            );
    }

    public function search()
    {
            $this->attributeLabels();
            
            $criteria=new CDbCriteria;

            $criteria->compare('h.apInvNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.poNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.bapbNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.reffNo',$this->keyWord,true,'OR');        
            $criteria->compare('h.apSupplier',$this->keyWord,true,'OR');        
            
            $criteria->alias = 'h';                            
            $criteria->select=" 
                     h.apInvID, apSupplier, apDesc, apInvNo, apInvDate, apDueDate, poNo, bapbNo, reffNo, ppNo, status, apInvTotal, recNo, recDate                    
                        " ;
            $criteria->join = "	
                    
                    ";

            $criteria->limit = 20;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'apInvDate DESC',
                  )
            ));                    

    }
    
    public function delegation()
    {
            $this->attributeLabels();
            
            $idcard = Yii::app()->user->getState('idcard');
            $level = Yii::app()->user->getState('level');
            $deptID = Yii::app()->user->getState('deptid');
        
            $criteria=new CDbCriteria;
            
            $criteria->compare('h.apInvNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.poNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.bapbNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.reffNo',$this->keyWord,true,'OR');        
            $criteria->compare('h.apSupplier',$this->keyWord,true,'OR');                    
            $criteria->addCondition('d.invStatus = 0'); 
            
            $criteria->alias = 'h';                            
            $criteria->select=" 
                     h.apInvID, apSupplier, apDesc, d.apInvNo, d.apInvDate, d.apDueDate, d.poNo, 
                     bapbNo, reffNo, ppNo, d.invStatus, d.apInvTotal, recNo, recDate, h.deptID, 
                     isnull(deptName,'---') deptName, apDetailID                    
                        " ;
            $criteria->join = "	
                    left join tr_apDetail d on d.apInvoiceID = h.recNo
                    left join Department e on e.idDept = d.deptID                    
                    ";

            $criteria->limit = 20;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'apInvDate DESC',
                  )
            ));                    

    }
    
    public function logbook()
    {
            $this->attributeLabels();
            
            $idcard = Yii::app()->user->getState('idcard');
            $level = Yii::app()->user->getState('level');
            $deptID = Yii::app()->user->getState('deptid');
        
            $criteria=new CDbCriteria;
            
            $criteria->compare('d.apInvNo',$this->keyWord,true,'OR');    
            $criteria->compare('h.apSupplier',$this->keyWord,true,'OR');        
            $criteria->addCondition(" d.invStatus = 0  ");
    
            if($level !== "Admin" && $level !== "Finance" )
            {                
                $criteria->addCondition(" ( d.deptID = ".$deptID." or d.deptID is NULL )");
            }
            //else if($level == "Accounting")
            //{
            //    $criteria->addCondition(" d.invStatus = 2 ");
            //}
            //else if($level == "Finance")
           // {
            //    $criteria->addCondition(" d.invStatus = 4 ");
            //}
            //else if($level == "Admin")
            //{
            // /   $criteria->addCondition(" d.invStatus = 2 ");
            //}
            
            $criteria->alias = 'h';                            
            $criteria->select=" 
                     h.apInvID, apSupplier, apDesc, d.apInvNo, d.apInvDate, d.apDueDate, 
                     d.apInvTotal, recNo, recDate, d.deptID, 
                     isnull(deptName,'---') deptName, apDetailID, d.invStatus                    
                        " ;
            $criteria->join = "	
                    left join tr_apDetail d on d.apInvoiceID = h.recNo
                    left join Department e on e.idDept = d.deptID                    
                    ";

            $criteria->limit = 20;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'apInvDate DESC',
                  )
            ));                    

    }
    
    public function getInvHeader($invID)
    {   
        $criteria=new CDbCriteria;

        $criteria->compare('h.apInvID',$invID,true); 

        $criteria->alias = 'h';                            
        $criteria->select=" 
                h.apInvID, apInvNo, apSupplier, apDesc, recNo, apInvDate, apDueDate, apInvCategory, poNo, bapbNo, ppNo, reffNo, status, apInvTotal,                
                d.invCatName docCategory, recDate
                    " ;
        $criteria->join = "	
                left join ms_invCategory d on d.invCatID = h.apInvCategory
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

    public function suggestTT($keyword,$limit=20)
    {                       
        $criteria=array(
                'alias'=>'a',
                'select'=>'  a.apInvID, a.recNo, a.apSupplier, a.apInvNo  ',                    
                'condition'=>"                       
                        a.status = 1                            
                        and a.recNo LIKE :cat " ,
                'order'=>'a.recNo',
                'limit'=>$limit,
                'params'=>array(
                    ':cat' => "%$keyword%",   
                )
        ); 

        $models=$this->findAll($criteria);
        //$models=$this->findAll();
        $data=array();
        foreach($models as $model) {
        $data[] = array(
                'id'=>$model->apInvID,
                'text'=>$model->apSupplier." - ".$model->apInvNo,
        );
        }
        return $data;
    }
    
    public function inkuiri()
    {
        $this->attributeLabels();

        $criteria=new CDbCriteria;

        $criteria->compare('fpd.fppID',$this->keyWord,true,'OR');    
        $criteria->compare('dt.apInvNo',$this->keyWord,true,'OR');    
        $criteria->compare('d.deptName',$this->keyWord,true,'OR');                
        $criteria->compare('h.apSupplier',$this->keyWord,true,'OR');        

        $criteria->alias = 'h';                            
        $criteria->select=" dt.apInvoiceID, dt.apInvNo dtApInvNo, dt.apInvDate dtApInvDate, dt.apDueDate dtApInvDueDate, dt.apInvTotal dtApInvTotal, dt.invStatus fppStatus, 
                            dt.deptID, d.deptName, h.recNo,
                            h.recDate, h.apSupplier, h.apInvCategory, dc.invCatName , 
                            (select top 1 fppID from tr_fppDetail fpd where fpd.fppInvNo = dt.apInvNo) fppID
                            " ;
        $criteria->join = "	
                        left join tr_apDetail dt on h.recNo = dt.apInvoiceID		
                        left join Department d on d.idDept = dt.deptID		
                        left join ms_invCategory dc on dc.invCatID = h.apInvCategory	
                        /*left join tr_fppDetail fpd on fpd.fppInvNo = dt.apInvNo*/
                ";

        $criteria->limit = 20;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria, 
            'sort'=>array(
                'defaultOrder'=>'dt.apInvNo DESC',
              )
        ));                    

    }
}
