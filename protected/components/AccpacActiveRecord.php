<?php


class AccpacActiveRecord extends CActiveRecord{
    
    public function getDbConnection() {
        return Yii::app()->dbAccpac;
    }

    
    
    
}