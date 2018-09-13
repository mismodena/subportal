<?php


class Employee extends CActiveRecord{
    
   public function tableName()
    {
        return 'vwEmployee';
    }
    
    public function rules()
    {
        return array(
            array('idCard, name, idDiv, divName, email, idPos, posName, idBranch, branchName, joinDate, status, idPos, posName', 'safe', 'on'=>'search'),
        );
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getActiveEmployee()
    {
        $idcard = Yii::app()->user->getState('idcard');
        
        $criteria=array(            
            'condition'=>"
                   idCard = :cat " ,            
            'params'=>array(
                ':cat' => $idcard,                            
            )
        ); 
        
        $models = $this->find($criteria);
        
        return $models;
    }
    
    public function suggestEmployee($keyword,$limit=20)
    {                       
        $criteria=array(
                'alias'=>'a',
                'select'=>' a.idCard, a.userName, a.nameDept, a.nameDiv, a.nameBranch, a.email ',
                'condition'=>"
                    userName LIKE :cat and a.status = 'KO' " ,
                'order'=>'a.idCard',
                'limit'=>$limit,
                'params'=>array(
                    ':cat' => "%$keyword%",                            
                )
        ); 

        $models=$this->findAll($criteria);
        $data=array();
        foreach($models as $model) {
        $data[] = array(
                'id'=>$model->idCard,
                'text'=>$model->userName." ( ".$model->nameDept. '-' . $model->nameDiv. ' / '.$model->nameBranch . ')' ,
        );
        }
        return $data;
    }
    
    public function suggestEmployee2($keyword,$limit=20)
    {                       
        $criteria=array(
                'alias'=>'a',
                'select'=>' a.idCard, a.userName, a.nameDept, a.nameDiv,a.idBranch, a.nameBranch, a.email, a.idDept, a.jobGrade, a.idPos ',
                'condition'=>"
                    userName LIKE :cat /*and a.status = 'PE' */" ,
                'order'=>'a.idCard',
                'limit'=>$limit,
                'params'=>array(
                    ':cat' => "%$keyword%",                            
                )
        ); 

        $models=$this->findAll($criteria);
        $data=array();
        foreach($models as $model) {
        $data[] = array(
                'id'=>trim($model->idCard).",".$model->jobGrade.",".$model->nameDiv.",".$model->idDept.",".$model->idBranch.",".$model->idPos,                
                'text'=>$model->userName." ( ".$model->nameDept. '-' . $model->nameDiv. ' / '.$model->nameBranch . ')' ,
                
        );
        }
        return $data;
    }
    
}
