<?php

class APJatuhTempo extends CActiveRecord
{    
   
  public $keyWord;

    public function tableName()
    {
        return 'tr_utang';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('utang_dari, utang_nilai,utang_tanggalcair, utang_jatuhtempo', 'required'),
            array('utang_id, utang_nilai', 'length', 'max'=>50),
            array('utang_dari, utang_matauang, utang_outstanding, utang_keterangan', 'length', 'max'=>150),
            array('utang_id, utang_dari, utang_nilai, utang_matauang, utang_tanggalcair,
                    utang_outstanding, utang_jatuhtempo, utang_keterangan, keyWord', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'utang_id' => 'ID',
            'utang_dari' => 'Dari',
            'utang_nilai' => 'Nilai',
            'utang_matauang' => 'Mata Uang',
            'utang_tanggalcair' => 'Tanggal Cair',
            'utang_outstanding' => 'OutStanding',
            'utang_jatuhtempo' => 'Jatuh Tempo',
            'utang_keterangan' => 'Keterangan',

        );
    }

    
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('utang_id',$this->keyWord,true,'OR');
        $criteria->compare('utang_dari',$this->keyWord,true,'OR');
        $criteria->compare('utang_nilai',$this->keyWord,true,'OR');
        $criteria->compare('utang_matauang',$this->keyWord,true,'OR');
        $criteria->compare('utang_tanggalcair',$this->keyWord,true,'OR');
        $criteria->compare('utang_outstanding',$this->keyWord,true,'OR');
        $criteria->compare('utang_jatuhtempo',$this->keyWord,true,'OR');
        $criteria->compare('utang_keterangan',$this->keyWord,true,'OR');


        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria, 
                'sort'=>array(
                    'defaultOrder'=>'utang_jatuhtempo ASC',
                  )
            ));                    

    }

    public function searchGroupBy()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('utang_id',$this->keyWord,true,'OR');
        $criteria->compare('utang_dari',$this->keyWord,true,'OR');
        $criteria->compare('utang_matauang',$this->keyWord,true,'OR');
        $criteria->compare('utang_nilai',$this->keyWord,true,'OR');
        $criteria->compare('utang_outstanding',$this->keyWord,true,'OR');


        $criteria->group = 'utang_dari';                            
        $criteria->select='utang_dari, sum(utang_nilai) as utang_nilai, sum(utang_outstanding) as utang_outstanding ';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));

    }

    public function getHeader($id)
    {   
        $criteria=new CDbCriteria;
                    
        $criteria->compare('a.utang_id',$id,true);
             
        $criteria->alias='a';
        $criteria->select='a.utang_id, a.utang_dari, a.utang_nilai, a.utang_matauang, a.utang_tanggalcair, a.utang_outstanding, a.utang_jatuhtempo, a.utang_keterangan';

        return  $this->find($criteria);
    }

    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
