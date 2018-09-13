<?php

class User extends CActiveRecord
{
	public $personIds;
	public $countryIds;
        public $items;

	public $selectOption;

	const SELECT_EYECOLOR=2;
	const SELECT_COUNTRY=1;

	public function getSelectOptions()
	{
            return array(
                self::SELECT_EYECOLOR=>Yii::t('ui', 'Eyecolor'),
                self::SELECT_COUNTRY=>Yii::t('ui', 'Country'),
            );
	}

	public function tableName()
	{
            return 'ms_user';
	}

	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array(' username, userpsw, userlevel, idcard', 'required'),
                array(' deptid, logstatus, shipstatus', 'numerical', 'integerOnly'=>true),
                array('username, userpsw, userlevel, email, nopolkend', 'length', 'max'=>50),
                array('usernik', 'length', 'max'=>20),
                array('idcard', 'length', 'max'=>10),
                array('jobs', 'length', 'max'=>24),
                array('regu', 'length', 'max'=>3),
                array('branch', 'length', 'max'=>60),
                array('logdate, logtime, expired, active', 'safe'),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
                array('userid, username, usernik, idcard, userpsw, userlevel, email, jobs, deptid, logdate, logtime, logstatus, expired, active, regu, nopolkend, shipstatus, branch, limitKredit', 'safe', 'on'=>'search'),
            );
	}

	public function relations()
	{
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
            );
	}

	public function attributeLabels()
	{
            return array(
                'userid' => 'Userid',
                'username' => 'Name',
                'usernik' => 'Usernik',
                'idcard' => 'ID. Card',
                'userpsw' => 'Password',
                'userlevel' => 'Role',
                'email' => 'Email',
                'jobs' => 'Jobs',
                'deptid' => 'Deptid',
                'logdate' => 'Logdate',
                'logtime' => 'Logtime',
                'logstatus' => 'Logstatus',
                'expired' => 'Expired',
                'active' => 'Active',
                'regu' => 'Regu',
                'nopolkend' => 'Nopolkend',
                'shipstatus' => 'Shipstatus',
                'branch' => 'Branch',
                'kodeasset' => 'Kode Asset',
                //'items' => ''
        );
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('userid',$this->userid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('usernik',$this->usernik,true);
		$criteria->compare('idcard',$this->idcard,true);
		$criteria->compare('userpsw',$this->userpsw,true);
		$criteria->compare('userlevel',$this->userlevel,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('jobs',$this->jobs,true);
		$criteria->compare('deptid',$this->deptid);
		$criteria->compare('logdate',$this->logdate,true);
		$criteria->compare('logtime',$this->logtime,true);
		$criteria->compare('logstatus',$this->logstatus);
		$criteria->compare('expired',$this->expired,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('regu',$this->regu,true);
		$criteria->compare('nopolkend',$this->nopolkend,true);
		$criteria->compare('shipstatus',$this->shipstatus);
		$criteria->compare('branch',$this->branch,true);
		$criteria->compare('kodeasset',$this->kodeasset,true);                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(         
                                'defaultOrder' => 'username',                                                        
                             ),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function suggestUsername($keyword, $limit=20)
	{
                $keyword = $keyword['term'];
		$criteria=array(
			'select'=>'DISTINCT(username) AS username, kodeasset as kodeasset',
			'condition'=>'username LIKE :keyword',
			'order'=>'username',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>"$keyword%"
			)
		);
		$models=$this->findAll($criteria);
		$suggest=array();
		foreach($models as $model) {
	    		$suggest[] = array(
	    			'value'=>$model->username.",".$model->kodeasset,
	        		'label'=>$model->username.",".$model->kodeasset,
	        	);
		}
		return $suggest;
	}

	public function getAssetDept()
    {
        $idDept = Yii::app()->user->getState('usernik');
        
        $criteria=array(            
            'condition'=>"
                   usernik = :cat " ,            
            'params'=>array(
                ':cat' => $idDept,                            
            )
        ); 
        
        $models = $this->find($criteria);
        
        return $models;
    }
        
	public function getOptions()
	{
		return CHtml::listData($this->findAll(array('order'=>'username')),'idcard', 'username');
	}
        
}
