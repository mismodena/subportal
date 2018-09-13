<?php


class TrialActiveRecord extends CActiveRecord{
    
    public function getDbConnection() {
        return Yii::app()->dbTrial;
    }

    
    
    
}