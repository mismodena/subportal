<?php

class PurchReq extends AccpacActiveRecord
{
    
    public function tableName()
    {
        return 'PTPRH';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

   
        
     public function suggestBatchKK($keyword,$limit=20)
	{                       
            $criteria=array(
                    'alias'=>'a',
                    'select'=>' a.RQNNUMBER, a.REQRID, a.REQRNAME, a.WORKFLOW ',                    
                    'condition'=>"
                            a.WORKFLOW like 'FP%'
                            and a.NXTSTEPNUM = 4                             
                            and a.RQNNUMBER LIKE :cat /*and a.batchID not in (select fppCategoryValue from FPP..tr_fppHeader where approvalType = 1) */" ,
                    'order'=>'a.RQNNUMBER',
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
                    'id'=>$model->RQNNUMBER,
                    'text'=>$model->RQNNUMBER ,//." - ".$model->TEXTDESC,
            );
            }
            return $data;
	}
    
        public function getHeader($id)
	{   
            $criteria=new CDbCriteria;
                        
            $criteria->compare('RQNNUMBER',$id,true);            
            
            $criteria->alias = 'a';                            
            $criteria->select=" a.RQNNUMBER, a.REQRID, dbo.fnGetAccpacDate(a.REQDATE) REQDATE, a.COSTCTR, a.WORKFLOW, a.DESCRIPTIO, a.REFERENCE ";            

            return  $this->find($criteria);
	}
    
    
    
    
    
    
    
    
    
    
    
    
    
}
