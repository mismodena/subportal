<?php

class CampaignApproval extends AccpacActiveRecord
{   
    public $userName ;
    
    public function tableName()
    {
        return 'MIS_CampaignApproval';
    }
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(                    
                    array('campaignID, persetujuanId, pic, an', 'length', 'max'=>50),
                    array('keterangan', 'length', 'max'=>20),
                    array('tanggal, persetujuan, aktif, keterangan2', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('fppID, persetujuanId, pic, tanggal, persetujuan, aktif, keterangan, an, keterangan2, userName ' , 'safe', 'on'=>'search'),
            );
    }
   
     public function searchApproval($id)
	{
            $this->attributeLabels();
           
            $criteria=new CDbCriteria;
            
            $criteria->compare('campaignID',$id,true);            
            
            $criteria->alias = 'a';                            
            $criteria->select=" campaignID, persetujuanId, pic, tanggal,	
                            case persetujuan	
                                    when NULL then keterangan+' - '+'N/A'
                                    when 1 then keterangan+' : ' + userName + ' - '+'Disetujui (' + convert(varchar(10),tanggal,105) + ')'
                                    when 0 then keterangan+' : ' + userName + ' - '+'Tidak Disetujui ('+ convert(varchar(10),tanggal,105) + ')'
                            else keterangan+' - '+'N/A' end as persetujuan
                            ";
            $criteria->join = ' left join FPP..vwEmployee b on a.pic = b.idCard ';
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                           // 'defaultOrder'=>'orderDate DESC',
                        )
            ));
	}

}
