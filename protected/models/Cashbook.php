<?php

class Cashbook extends AccpacActiveRecord
{
    
    public function tableName()
    {
        return 'CBBCTL';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

   
        
     public function suggestBatchKK($keyword,$limit=20)
	{                       
            $criteria=array(
                    'alias'=>'a',
                    'select'=>' a.BATCHID, a.BANKCODE, b.BANKNAME ,a.ACTIVESW, a.TEXTDESC, a.USERID, a.TOTDEBIT, a.TOTCREDIT ',
                    'join'=>' left join CBBANK b on a.BANKCODE = b.BANKCODE
                               /* inner join CBBTHD c on c.batchid = a.batchid */',
                    'condition'=>"
                           b.BANKNAME like 'KAS KECIL%'
                            and a.ACTIVESW = 'A'
                            and a.STATUS = 0
                            and a.batchID LIKE :cat /*and a.batchID not in (select fppCategoryValue from FPP..tr_fppHeader where approvalType = 1) */" ,
                    'order'=>'a.batchID',
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
                    'id'=>$model->BATCHID,
                    'text'=>$model->BATCHID." - ".$model->TEXTDESC,
            );
            }
            return $data;
	}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
