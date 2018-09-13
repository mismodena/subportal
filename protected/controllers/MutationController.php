<?php

class MutationController extends Controller
{
    
    public $layout='leftbar';
    
    function init() {
        parent::init();
        $this->leftPortlets['ptl.AssetMenu'] = array();
    }

    public function filters()
    {
        return array(
            'Rights',
            //'accessControl', // perform access control for CRUD operations
            //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function allowedActions()
    {
        return 'index, approval, approvalDisposal, view, sendMail,
        viewDisposal, viewDetail, sendMail2, loadArray';
    }



    public function accessRules()
        {
            return array(
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                        'actions'=>array('index','view','create','delete','mail','verifiedMAT', 'viewPrint'),
                        'users'=>array('@'),
                    ),
                    array('deny',  // deny all users
                            'users'=>array('*'),
                    ),
                );
        } 

    public function actionView($id)
    {
        //$allow=$this->checkRights('isView');

        //$this->layout='iframe';
        $model = Mutation::model()->getHeader($id);
        $detail = MutationDetail::model()->getMutationDetail($model->mutationNo);
        
        $this->render('view',array(
                    'model'=>$model,
                    'detail'=>$detail,
            ));

        
    }

    public function actionViewPrint($id)
    {
        //$allow=$this->checkRights('isView');

        $this->layout='iframe';
        $model = Mutation::model()->getHeader($id);
        //$detail = MutationDetail::model()->getMutationDetail($model->mutationNo);
        $detail = MutationDetail::model()->findAllByAttributes(array('mutationNo'=>$model->mutationNo));
        $approval = Utility::getPrintApprovalMutation($model->mutationNo);
        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

        # render (full page)
        $mPDF1->WriteHTML($this->render('viewPrint', array(
            'model'=>$model,
            'detail'=>$detail,
            'approval'=>$approval), true));
            
        # Outputs ready PDF
        $mPDF1->Output($model->mutationNo.'.pdf','I');

    }

    public function viewDetail($id)
    {            
        $detailDataProvider=new CActiveDataProvider('MutationDetail',array(
            'criteria'=>array(
            'condition'=>'mutationNo=:mutationNo',
            'params'=>array(':mutationNo'=>$id),
                ),
                'pagination' => false,                
                //'pagination'=>array(
                //    'pageSize'=>10,
                //),
            ));
        return $detailDataProvider;
    }


    public function actionCreate()
    {
        
        $model = new Mutation;
        $model->items[] = new MutationDetail();
        $approval = new MutationApproval;

        
        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDate();

        // $model->fromPIC = '1603.1943';
        // $model->fromDept = '11';
        $model->fromPIC = $employee->idCard;
        $model->fromPICName = $employee->userName;
        $model->mutationDateLong = $longDate;
        $model->mutationDate = $now;

        $this->performAjaxValidation($model);
        
        if(isset($_POST['Mutation']))
        {
            $model->attributes=$_POST['Mutation'];
            $model->mutationNo = Utility::getNoMutation();      
            $model->validate();
            $urutan = 0;


            //PEMOHON
            $approval->mutationNo= $model->mutationNo;
            $approval->pic =  $model->fromPIC; //'1603.1943';
            $approval->tanggal = $model->mutationDate;
            $approval->persetujuan = 1;
            $approval->urutan = $urutan;
            $approval->aktif = 1;
            $approval->keterangan = 'Pengajuan MAT';
            $approval->an = '';
            $approval->keterangan2 = 'Pengajuan MAT :';
            
            $rows=0;
            if($model->validate())
            {
                $transaction = Yii::app()->db->beginTransaction();
                try
                {
                    $isValid = $model->validate();
                    $model->save();
                    $connection=Yii::app()->db; 
                    $approval->save();



                    //Dept. Head/BM
                    $urutan = $urutan + 1;
                    $approval = new MutationApproval;                                    
                    $approval->mutationNo= $model->mutationNo;
                    $approval->pic = '1603.1943'; //Utility::getDeptHead($model->fromPIC) ;
                    $approval->tanggal = new CDbExpression('NULL'); 
                    $approval->persetujuan = new CDbExpression('NULL'); 
                    $approval->urutan = $urutan;
                    $approval->aktif = 0;
                    $approval->keterangan = 'DEPTHEAD-BM';
                    $approval->an = '';
                    $approval->keterangan2 = 'Ka. Dept / BM :';
                            
                    $approval->save();

                    // $detail = MutationDetail::model()->findByAttributes(array('mutationNo'=>$model->mutationNo));
                    // $cariAsset = Asset::model()->findByAttributes(array('assetID'=>$detail['assetID']));

                    // if ($cariAsset['assetType']==1)
                    // {
                    //         $urutan = $urutan + 1;
                    //         $approval = new MutationApproval;                                    
                    //         $approval->mutationNo= $model->mutationNo;
                    //         $approval->pic = '1603.1943'; //Utility::getDeptHead($model->fppUser) ;
                    //         $approval->tanggal = new CDbExpression('NULL'); 
                    //         $approval->persetujuan = new CDbExpression('NULL'); 
                    //         $approval->urutan = $urutan;
                    //         $approval->aktif = 0;
                    //         $approval->keterangan = 'DEPTHEAD-BM';
                    //         $approval->an = '';
                    //         $approval->keterangan2 = 'Ka. Dept / BM :';
                                    
                    //         $approval->save();
                    // }



                    // if ($detail['assetType']==1)
                    // {
                    //     //Dept. Head/BM
                    //     $urutan = $urutan + 1;
                    //     $approval = new MutationApproval;                                    
                    //     $approval->mutationNo= $model->mutationNo;
                    //     $approval->pic = '1603.1943'; //Utility::getDeptHead($model->fppUser) ;
                    //     $approval->tanggal = new CDbExpression('NULL'); 
                    //     $approval->persetujuan = new CDbExpression('NULL'); 
                    //     $approval->urutan = $urutan;
                    //     $approval->aktif = 0;
                    //     $approval->keterangan = 'DEPTHEAD-BM';
                    //     $approval->an = '';
                    //     $approval->keterangan2 = 'Ka. Dept / BM :';
                                
                    //     $approval->save();
                    // }

                    $cariDiv = Mutation::model()->findBySql(" select userName, nameDiv, idDept, nameDept
                                                            from vwEmployee where idCard= '".$model->fromPIC."'
                                             ");
                    if ($cariDiv['nameDiv']=="AM")
                    {
                        //AM Div. Head 
                        $urutan = $urutan + 1;
                        $approval = new MutationApproval;                                    
                        $approval->mutationNo= $model->mutationNo;
                        $approval->pic = '1603.1943 '; //Utility::getPIC("AMDiv") ;
                        $approval->tanggal = new CDbExpression('NULL'); 
                        $approval->persetujuan = new CDbExpression('NULL'); 
                        $approval->urutan = $urutan;
                        $approval->aktif = 0;
                        $approval->keterangan = 'Div. Head';
                        $approval->an = '';
                        $approval->keterangan2 = 'AM Div. Head:';

                        $approval->save();
                    }
                    elseif ($cariDiv['nameDiv']=="CM") {
                         //CM Div. Head 
                        $urutan = $urutan + 1;
                        $approval = new MutationApproval;                                    
                        $approval->mutationNo= $model->mutationNo;
                        $approval->pic = '0607.0342 ';//contoh pak mus //Utility::getPIC("CMDiv") ;
                        $approval->tanggal = new CDbExpression('NULL'); 
                        $approval->persetujuan = new CDbExpression('NULL'); 
                        $approval->urutan = $urutan;
                        $approval->aktif = 0;
                        $approval->keterangan = 'Div. Head';
                        $approval->an = '';
                        $approval->keterangan2 = 'CM Div. Head:';

                        $approval->save();
                    }
                    else
                    {
                        //OM Div. Head 
                        $urutan = $urutan + 1;
                        $approval = new MutationApproval;                                    
                        $approval->mutationNo= $model->mutationNo;
                        $approval->pic = '1603.1943'; //Utility::getPIC("OMDiv") ;
                        $approval->tanggal = new CDbExpression('NULL'); 
                        $approval->persetujuan = new CDbExpression('NULL'); 
                        $approval->urutan = $urutan;
                        $approval->aktif = 0;
                        $approval->keterangan = 'Div. Head';
                        $approval->an = '';
                        $approval->keterangan2 = 'Div. Head:';

                        $approval->save();
                    }

                    //Penerima MAT
                    $urutan = $urutan + 1;
                    $approval = new MutationApproval;                                    
                    $approval->mutationNo= $model->mutationNo;
                    $approval->pic = '1603.1943'; //Utility::getToDeptHead ($model->toDept) ;//
                    $approval->tanggal = new CDbExpression('NULL'); 
                    $approval->persetujuan = new CDbExpression('NULL'); 
                    $approval->urutan = $urutan;
                    $approval->aktif = 0;
                    $approval->keterangan = 'Penerima';
                    $approval->an = '';
                    $approval->keterangan2 = 'Penerima:';

                    $approval->save();
                    
                                      
                    if (isset($_POST['MutationDetail']) && is_array($_POST['MutationDetail']))
                    {
                        foreach ($_POST['MutationDetail'] as $line => $items) {
                            if (!empty($items['mutationDesc']))
                            {
                                $rows=$rows + 1;
                                $detail = new MutationDetail;
                                $assetNumber = Asset::model()->findByAttributes(array('assetID'=>$items['assetID']))->assetNumber;
                                $detail->mutationNo= $model->mutationNo;
                                $detail->assetID=$items['assetID'];
                                $detail->assetNumber=$assetNumber;
                                $detail->mutationDesc= $items['mutationDesc'];

                                if ($detail->validate())
                                {
                                    $detail->save();
                                } 
                            }
                        }
                    }

                    if ($rows==0)
                    {
                        $transaction->rollBack();
                        //throw new CHttpException(403, $e);
                        Yii::app()->user->setFlash('Gagal', "Permohonan gagal dikirim!");
                        $this->redirect(array('index'));
                    }
                    else
                    { 
                    /* print_r($model->validate()); */
                        $transaction->commit(); 
                        $newID = Mutation::model()->findByAttributes(array('mutationNo'=>$model->mutationNo))->mutationNo;
                        //exit(json_encode(array('result' => 'success', 'msg' => 'Your data has been successfully saved')));
                        Yii::app()->user->setFlash('Berhasil', "Permohonan berhasil dikirim!");
                        $email = $this->kirimEmail($newID);
                        //$this->redirect(array('mail', 'id'=>$IDNew));
                        if($email)
                        {
                            $this->redirect(array('index'));
                        }
                        
                    } 
                    
                }
                catch (Exception $e)
                {
                    $transaction->rollBack();
                    throw new CHttpException(403, $e);
                    Yii::app()->user->setFlash('Error',$e);
                    $this->redirect(array('index'));
                    
                }                
                  
              
            }            
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    } 

      
    public function actionSendMail($id)
    {
            $mutationNo = Mutation::model()->findByAttributes(array('mutationNo'=>$id))->mutationNo;
                        
            $kirim = $this->kirimEmail($mutationNo);
            if($kirim)
            {
                echo "Email dikirim";
            }
            else
            {
                echo "Gagal kirim";
            }
    }
    
    public function kirimEmail($id)
    {
        $ret =false;
        
        $model = Mutation::model()->findByAttributes(array('mutationNo'=>$id));             
        $MATdetail = MutationDetail::model()->findAllByAttributes(array('mutationNo'=>$model->mutationNo));

        $approval = MutationApproval::model()->findBySql("select top 1 *
                    from FPP..tr_assetMutationApproval 
                    where persetujuan is null and mutationNo = '".$model->mutationNo."'
                    order by urutan");       
        $MATApproval = MutationApproval::model()->findAll(array('order'=>'urutan', 'condition'=>'mutationNo=:mutationNo and urutan <> 0', 'params'=>array(':mutationNo'=>$model->mutationNo)));
        $users = Employee::model()->findByAttributes(array('idCard'=>$model->fromPIC));
        
        if(isset($users))
        {
            $userName = Employee::model()->findByAttributes(array('idCard'=>$model->fromPIC))->userName;
        }
        else
        {
            $userName = Utility::getInactiveEmployee($model->fromPIC); 
        }
        
        $dept = Mutation::model()->findBySql(" select nameDept + ' - ' + nameDiv + ' / ' + nameBranch fromDeptName
                                                from vwEmployee where idCard = '".$model->fromPIC."'
                                             ");
        
        if(isset($approval->pic))
        {
            $to[0] = Employee::model()->findByAttributes(array("idCard"=>$approval->pic))->email; 
        }
        else
        {
            $to[0] = "";
        }
        
       
        $bcc = array('meriza.putri@modena.co.id');
        

//            $modeyes = $this->pathEmail."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=1&jp=".$approval["keterangan"];
        $modeyes = $this->createAbsoluteUrl("mutation/approval", array("mutationNo"=>$model->mutationNo,"pic"=>$approval["pic"],"mode"=>1, "jp"=>$approval["keterangan"])) ; //."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=1&jp=".$approval["keterangan"];
//            $modeno = $this->pathEmail."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=0&jp=".$approval["keterangan"];
        $modeno = $this->createAbsoluteUrl("mutation/approval", array("mutationNo"=>$model->mutationNo,"pic"=>$approval["pic"],"mode"=>0, "jp"=>$approval["keterangan"])) ; //."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=1&jp=".$approval["keterangan"];
//            $link = $this->pathView."id=".$model->fppID;
        $link = $this->createAbsoluteUrl('mutation/view',array("id"=>$model->mutationNo)) ;//."id=".$model->fppID;
        $subject ="[MAT Online :: Persetujuan MAT] :: No. ".$model->mutationNo." a/n ".$userName;                                                     
        $content = '';
       
       
        if ($approval['keterangan']=="Penerima" )
        {
            //template penerima
            $message = $this->mailTemplate(11);
            //$message = str_replace("#link", $link, $message);
        }
        else
        {
           //template umum
            $message = $this->mailTemplate(7);
            $message = str_replace("#pathyes#", $modeyes, $message);
            $message = str_replace("#pathno#", $modeno, $message);
            
        }
       
        $message = str_replace("#NomorMAT#", $model->mutationNo, $message);
        $message = str_replace("#Tanggal#", date("d-m-Y", strtotime($model->mutationDate)), $message);
        $message = str_replace("#NamaPemohon#", $userName, $message);
        $message = str_replace("#Dept#", $dept['fromDeptName'], $message);
        $message = str_replace("#Penerima#", $model->toPIC , $message);
        $message = str_replace("#toDept#", KodeAsset::model()->find('KodeAsset=:KodeAsset', array(':KodeAsset'=>$model->toDept))->Department, $message);

        //$attachment = array();
        
        $sDetail = "";
        $rowNum = 0;
    
        foreach($MATdetail as $row=>$detail) 
        {   
            $asset = MutationDetail::model()->findBySql("select assetDesc assetDesc, assetNumber
                                from ms_asset where assetID='".$detail->assetID."'");
            $rowNum = (int)$rowNum+1 ;
            $sDetail .= "<tr><td align=center>". $rowNum ."</td>" ; 
            $sDetail .= '<td align=left>'.$asset['assetDesc'].'</td><td align=left>'.$detail['mutationDesc'].'</td></tr>' ;

        }
        $message = str_replace("#sInput_#", $sDetail, $message);            
        
        $sDetail = "";            
        foreach($MATApproval as $row=>$detail) 
        {                 
            if($detail['pic'] != "")
            {
                $approvalName = Employee::model()->findByAttributes(array('idCard'=>$detail['pic']))->userName; 
            }
            else {
                $approvalName = "";
            }
                            
            $persetujuan = "";
            if(is_null($detail["persetujuan"]))
            {
                $persetujuan = "N/A";
            }
            else
            {
                if($detail["persetujuan"])
                {
                    $persetujuan = "Disetujui";
                }else{
                    $persetujuan = "Tidak Disetujui";
                }
            }
            
            $approvalDate =  date("d-m-Y", strtotime($detail['tanggal']));
            if($persetujuan !== "N/A")
            {
                $sDetail .= "<tr><td align=left>". $detail['keterangan2']. " ". $approvalName . " - " . $persetujuan . " (".$approvalDate.")" .  "</td></tr>" ;                    
            }
            else
            {
                $sDetail .= "<tr><td align=left>". $detail['keterangan2']. " ". $persetujuan .  "</td></tr>" ;                    
            }               
        }
        $message = str_replace("#sApproval_#", $sDetail, $message);            
        if(!is_null($approval['mutationNo']))
        {
            $this->mailsendMAT($to,$bcc,$subject,$message);
            $tmpApproval = MutationApproval::model()->findByAttributes(array('mutationNo'=>$approval['mutationNo'], 'IDPersetujuan'=>$approval['IDPersetujuan']));
            $tmpApproval->aktif = 1;
            $tmpApproval->persetujuan = new CDbExpression('NULL'); 
            $tmpApproval->save();
            //$this->redirect(array('index' ,));
            $ret = true;
        }
            
        return $ret;
    }

    public function actionApproval()
    {
        $mutationNo= Yii::app()->getRequest()->getQuery('mutationNo');
        $pic = Yii::app()->getRequest()->getQuery('pic');
        $persetujuan = Yii::app()->getRequest()->getQuery('mode');
        $aktif=1;
        $keterangan=Yii::app()->getRequest()->getQuery('jp');
        $ret=Yii::app()->getRequest()->getQuery('ret');
        $an='';
        $now= date ('Y-m-d H:i:s');

        if (isset($mutationNo))
        {
            $mutationNo= Mutation::model()->findByAttributes(array('mutationNo'=>$mutationNo))->mutationNo;
            $MATApproval= MutationApproval::model()->findByAttributes(array('mutationNo'=>$mutationNo, 'pic'=>$pic, 'keterangan'=>$keterangan));
            $urutan = $MATApproval->urutan;

            if (is_null($MATApproval->tanggal))
            {
                $transaction = Yii::app()->db->beginTransaction();
                try
                {
                    $connection=Yii::app()->db;
                    $MATApproval->persetujuan = $persetujuan;
                    $MATApproval->tanggal= $now;
                    $MATApproval->save();

                    if ($MATApproval->persetujuan)
                    {
                        $transaction->commit();
                        $this->kirimEmail($mutationNo);
                        $this->render('approval', array(
                                'model'=>$MATApproval, 'mutationNo'=>$mutationNo,
                            ));
                        // if ($MATApproval['keterangan']=="Div. Head"  && $MATApproval['persetujuan']==1)
                        // {
                            
                        // } 

                        exit();
                    }

                    

                    $this->render('approval',array(
                            'model'=>$MATApproval, 'mutationNo'=>'',
                        ));
                }
                catch (Exception $ex)
                {
                    //$transaction->rollBack();
                    throw new CHttpException(403, $ex);
                    Yii::app()->user->setFlash('Error', $ex);
                    $this->redirect(array('mutation/index'));
                }
            }
            else
            {
                $this->render('approval',array(
                        'model'=>$MATApproval, 'mutationNo'=>'--',
                    ));
            }

        }
    }
   
    
    public function actionVerifiedMAT($id)
    {
        $model = Mutation::model()->findByAttributes(array('mutationNo'=>$id));
        $detailMAT = MutationDetail::model()->findAllByAttributes(array('mutationNo'=>$model->mutationNo)); 
        $connection=Yii::app()->db;

        foreach ($detailMAT as $key => $value) 
        {
           if (!empty($value['assetNumber']))
           {
               
                $detail = Asset::model()->findByAttributes(array('assetID'=>$value['assetID']));
                $detail->assetNumber=Utility::getAssetNumber($model->toDept);
                $detail->save(false);

                $strCommand =" update ms_asset set 
                        idDept = (select toDept from tr_assetMutation where mutationNo='".$id."'), 
                        modenaPIC= (select toPIC from tr_assetMutation where mutationNo='".$id."'),
                    assetRemarks = (select mutationDesc from tr_assetMutationDetail where mutationNo='".$id."')
                        where assetID in 
                        (select assetID from tr_assetMutationDetail where mutationNo='".$id."')
                        ";

                $command = $connection->createCommand($strCommand);
                $command->execute();

                $strCommand="update tr_assetMutationApproval set aktif=0
                                where keterangan='Penerima' and mutationNo='".$id."'
                            ";

                $command = $connection->createCommand($strCommand);
                $command->execute();

           }
        }

        $this->redirect(array('mutation/index'));
    }


    public function ActionIndex()
    {
       $this->leftPortlets = array();
        $this->leftPortlets['ptl.AssetMenu'] = array(); 

        $model=new Mutation('search');
        
        $model->unsetAttributes(); 
        //$model->keyWord = '';
        if(isset($_GET['Mutation']))
        {
            $model->attributes=$_GET['Mutation'];

        }
            
        
        $this->render('index',array(
                'model'=>$model,
        ));
    }

     

    public function ActionDelete($id)
    {
        
        //$allow=$this->checkRights('isDelete');
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                MutationDetail::model()->deleteAll('mutationNo=:mutationNo', array(':mutationNo'=>$id));
                MutationApproval::model()->deleteAll('mutationNo=:mutationNo', array(':mutationNo'=>$id));
                $this->loadModel($id)->delete(); 
                $transaction->commit();
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                throw new CHttpException(403,$e);
                
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        
            // $this->loadModel($id)->delete();

            // if(!isset($_GET['ajax']))
            // $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
       
    }

    
    protected function performAjaxValidation($model)
    {
            if(isset($_POST['ajax']) && $_POST['ajax']==='disposal-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }
    }

    public function loadModel($id)
    {
        $model=Disposal::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    

  
    public function ActionCreateDisposal()
    {
        $model = new Disposal;
        $model->items[] = new DisposalDetail();
        $model->image[] = new DisposalAttachment();
        $approval = new DisposalApproval;

        
        $employee = Employee::model()->getActiveEmployee();
        $now = date("Y-m-d H:i:s");
        $longDate = Utility::getLongDate();

        // $model->fromPIC = '1603.1943';
        // $model->fromDept = '11';
        $model->fromPIC = $employee->idCard;
        $model->fromPICName = $employee->userName;
        $model->disposalDateLong = $longDate;
        $model->disposalDate = $now;

        $this->performAjaxValidation($model);
        $cekSelect = false;
        
        if(isset($_POST['Disposal']))
        {
            $model->attributes=$_POST['Disposal'];
            $model->disposalNo = Utility::getDisposalNo();      
            $model->validate();
            $urutan = 0;

            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";

            for ($i=0; $i< sizeof($_POST['DisposalDetail']); $i++)
            {
                if ($_POST['DisposalDetail'][$i]['assetID']=='')
                {
                    $cekSelect = true ;
                    break;
                } 
            }

           // exit();
            if (!$cekSelect)
            {
                //PEMOHON
                $approval->disposalNo= $model->disposalNo;
                $approval->pic = $model->fromPIC; //'1603.1943';  
                $approval->tanggal = $model->disposalDate;
                $approval->persetujuan = 1;
                $approval->urutan = $urutan;
                $approval->aktif = 1;
                $approval->keterangan = 'Pengajuan Disposal';
                $approval->an = '';
                $approval->keterangan2 = 'Pengajuan Disposal :';
                
                $rows=0;
                if($model->validate())
                {
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        $isValid = $model->validate();
                        $model->save();
                        $connection=Yii::app()->db; 
                        $approval->save();

                        //Dept. Head/BM
                        $urutan = $urutan + 1;
                        $approval = new DisposalApproval;                                    
                        $approval->disposalNo= $model->disposalNo;
                        $approval->pic = Utility::getDeptHead($model->fromPIC) ;
                        $approval->tanggal = new CDbExpression('NULL'); 
                        $approval->persetujuan = new CDbExpression('NULL'); 
                        $approval->urutan = $urutan;
                        $approval->aktif = 0;
                        $approval->keterangan = 'DEPTHEAD-BM';
                        $approval->an = '';
                        $approval->keterangan2 = 'Ka. Dept / BM :';
                                
                        $approval->save();

                        //Accounting
                        $urutan = $urutan + 1;
                        $approval = new DisposalApproval;                                    
                        $approval->disposalNo= $model->disposalNo;
                        $approval->pic = '1110.1481'; //1110.1481  Elsa Sari
                        $approval->tanggal = new CDbExpression('NULL'); 
                        $approval->persetujuan = new CDbExpression('NULL'); 
                        $approval->urutan = $urutan;
                        $approval->aktif = 0;
                        $approval->keterangan = 'Accounting';
                        $approval->an = '';
                        $approval->keterangan2 = 'Accounting :';
                                
                        $approval->save();

                        //Internal Auditor
                        $urutan = $urutan + 1;
                        $approval = new DisposalApproval;                                    
                        $approval->disposalNo= $model->disposalNo;
                        $approval->pic = '1010.1213'; //1405.1772  Dept. Head IA
                        $approval->tanggal = new CDbExpression('NULL'); 
                        $approval->persetujuan = new CDbExpression('NULL'); 
                        $approval->urutan = $urutan;
                        $approval->aktif = 0;
                        $approval->keterangan = 'Internal Auditor';
                        $approval->an = '';
                        $approval->keterangan2 = 'Internal Auditor:';
                                
                        $approval->save();

                        //AM Div. Head 
                        $urutan = $urutan + 1;
                        $approval = new DisposalApproval;                                    
                        $approval->disposalNo= $model->disposalNo;
                        $approval->pic = '1501.1829'; //1501.1829 ; pak mul
                        $approval->tanggal = new CDbExpression('NULL'); 
                        $approval->persetujuan = new CDbExpression('NULL'); 
                        $approval->urutan = $urutan;
                        $approval->aktif = 0;
                        $approval->keterangan = 'AM Div. Head';
                        $approval->an = '';
                        $approval->keterangan2 = 'AM Div. Head:';

                        $approval->save();

                        //Direktur

                        /*$urutan = $urutan + 1;
                        $approval = new DisposalApproval;                                    
                        $approval->disposalNo= $model->disposalNo;
                        $approval->pic = '1603.1943'; //99999999 ;
                        $approval->tanggal = new CDbExpression('NULL'); 
                        $approval->persetujuan = new CDbExpression('NULL'); 
                        $approval->urutan = $urutan;
                        $approval->aktif = 0;
                        $approval->keterangan = 'Direktur';
                        $approval->an = '';
                        $approval->keterangan2 = 'Direktur :';
                                
                        $approval->save();*/
                                
                                          
                        if (isset($_POST['DisposalDetail']) && is_array($_POST['DisposalDetail']))
                        {
                            // print_r($_POST['DisposalDetail']);
                            // exit();
                           // $model->save();
                            foreach ($_POST['DisposalDetail'] as $line => $items) {
                                //if (!empty($items['assetID']))
                                //{
                                    $rows=$rows + 1 ;
                                    $detail = new DisposalDetail;
                                    $detail->disposalNo= $model->disposalNo;
                                    $detail->assetID=$items['assetID'];
                                    $detail->qty= $items['qty'];
                                    $detail->nilaiasset= $items['nilaiasset'];
                                    $detail->disposalDesc= $items['disposalDesc'];
                                    $detail->save();
                                    /*if ($detail->validate())
                                    {
                                        $detail->save();
                                    }  */
                                //}
                            }
                        }

                        $file_attach = array();
                        if (isset($_POST['DisposalAttachment']) && is_array($_POST['DisposalAttachment']))
                        {
                            /*
                            echo "<pre>";
                            print_r($_FILES);
                            echo "</pre>"; 
                            echo file_exists($explode_script_filename[0]."upload/disposal/Desert.jpg"); */

                            if(isset($_FILES['DisposalAttachment']))
                            {
                                $explode_script_filename = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
                                $tmp_name = $_FILES['DisposalAttachment']['tmp_name'];
                                $name = $_FILES['DisposalAttachment']['name'];

                                for($i = 0; $i < sizeof($tmp_name); $i++){
                                    $name_explode = explode(".",$name[$i]['filePath']);
                                    $new_name = "File-".rand(0,100).".".$name_explode[(sizeof($name_explode) - 1)];
                                    $rows= $rows + 1;
                                    $row = new DisposalAttachment;
                                    $row->disposalNo=$model->disposalNo;
                                    $row->filePath=$new_name;
                                    $row->save();
                                    $file_attach[] = $explode_script_filename[0]."upload/disposal/".$new_name;
                                    move_uploaded_file($tmp_name[$i]['filePath'], $explode_script_filename[0]."upload/disposal/".$new_name);
                                }
                            }
                            
                        }

                        if ($rows==0)
                        {
                            $transaction->rollBack();
                            //throw new CHttpException(403, $e);
                            Yii::app()->user->setFlash('Gagal', "Permohonan gagal dikirim!");
                            $this->redirect(array('indexDisposal'));
                        }
                        else
                        { 
                        /* print_r($model->validate()); */
                            $transaction->commit(); 
                            $IDNew = Disposal::model()->findByAttributes(array('disposalNo'=>$model->disposalNo))->disposalNo;
                            //exit(json_encode(array('result' => 'success', 'msg' => 'Your data has been successfully saved')));
                            Yii::app()->user->setFlash('Berhasil', "Permohonan berhasil dikirim!");
                            $email = $this->kirimEmailDisposal($IDNew,$file_attach);
                            //$this->redirect(array('mail', 'id'=>$IDNew));
                            if($email)
                            {
                                $this->redirect(array('indexDisposal'));
                            }
                            
                        }
                        
                        
                    }
                    catch (Exception $e)
                    {
                        $transaction->rollBack();
                        throw new CHttpException(403, $e);
                        Yii::app()->user->setFlash('Error',$e);
                        $this->redirect(array('indexDisposal'));
                        
                    }                
                }
            }            
        }

        $this->render('createDisposal',array(
            'model'=>$model,
            'cekSelect'=>$cekSelect,
        )); 
    }

    public function actionSendMail2($id)
    {
            $disposalNo = Disposal::model()->findByAttributes(array('disposalNo'=>$id))->disposalNo;
                       
            $kirim = $this->kirimEmailDisposal($disposalNo);
            if($kirim)
            {
                echo "Email dikirim";
            }
            else
            {
                echo "Gagal kirim";
            }
    }
    
    public function kirimEmailDisposal($id,$file_attach = array())
    {
        $ret =false;
        
        $model = Disposal::model()->findByAttributes(array('disposalNo'=>$id)); 
        $attach = DisposalAttachment::model()->findByAttributes(array('disposalNo'=>$model->disposalNo));             
        $DISdetail = DisposalDetail::model()->findAllByAttributes(array('disposalNo'=>$model->disposalNo));
        $approval = DisposalApproval::model()->findBySql("select top 1 *
                    from FPP..tr_assetDisposalApproval 
                    where persetujuan is null and disposalNo = '".$model->disposalNo."'
                    order by urutan");

        $explode_protected = explode("protected",Yii::app()->basePath);

        $list = Yii::app()->db->createCommand("select filePath from tr_assetDisposalAttachment where disposalNo = '".$model->disposalNo."'")->queryAll();
        $assetID = "";
        $path_file = array();
        foreach($list as $item){
            //process each item here
            $path_file[] = $explode_protected[0].'upload/disposal/'.$item['filePath'];

        }
        
        /*
        echo "<pre>";
        print_r($attach);
        echo "</pre>"; */
        
        $path = $explode_protected[0].'upload/disposal/'.$attach->filePath ;            
        $data = $path;
        
        
        $DISApproval = DisposalApproval::model()->findAll(array('order'=>'urutan', 'condition'=>'disposalNo=:disposalNo and urutan <> 0', 'params'=>array(':disposalNo'=>$model->disposalNo)));
        $users = Employee::model()->findByAttributes(array('idCard'=>$model->fromPIC));
        
        if(isset($users))
        {
            $userName = Employee::model()->findByAttributes(array('idCard'=>$model->fromPIC))->userName;
        }
        else
        {
            $userName = Utility::getInactiveEmployee($model->fromPIC); 
        }
        
        
        $dept = Disposal::model()->findBySql("select nameDept + ' - ' + nameDiv + ' / ' + nameBranch fromDeptName
                                                from vwEmployee where idCard = '".$model->fromPIC."'");
        
        if(isset($approval->pic))
        {
            $to[0] = Employee::model()->findByAttributes(array("idCard"=>$approval->pic))->email; 
        }
        else
        {
            $to[0] = "";
        }
        
        
        $bcc = array('meriza.putri@modena.co.id');
        

//            $modeyes = $this->pathEmail."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=1&jp=".$approval["keterangan"];
        $modeyes = $this->createAbsoluteUrl("mutation/approvalDisposal", array("disposalNo"=>$model->disposalNo,"pic"=>$approval["pic"],"mode"=>1, "jp"=>$approval["keterangan"])) ; //."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=1&jp=".$approval["keterangan"];
//            $modeno = $this->pathEmail."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=0&jp=".$approval["keterangan"];
        $modeno = $this->createAbsoluteUrl("mutation/approvalDisposal", array("disposalNo"=>$model->disposalNo,"pic"=>$approval["pic"],"mode"=>0, "jp"=>$approval["keterangan"])) ; //."fppID=".$model->fppID."&pic=".$approval["pic"]."&mode=1&jp=".$approval["keterangan"];
//            $link = $this->pathView."id=".$model->fppID;
        $link = $this->createAbsoluteUrl('mutation/update',array("id"=>$model->disposalNo)) ;//."id=".$model->fppID;
        $subject ="[Disposal Online :: Persetujuan Disposal Asset] :: No. ".$model->disposalNo." a/n ".$userName;                                                     
        $content = '';
        
        if ($approval['keterangan']=="Accounting" )
        {
            //template accounting
            $message = $this->mailTemplate(9);
            $message = str_replace("#link", $link, $message);
        }
        else
        {
        //template umum
            $message = $this->mailTemplate(8);
            $message = str_replace("#pathyes#", $modeyes, $message);
            $message = str_replace("#pathno#", $modeno, $message);
            
        }
       
        $message = str_replace("#NomorDisposal#", $model->disposalNo, $message);
        $message = str_replace("#Tanggal#", date("d-m-Y", strtotime($model->disposalDate)), $message);
        $message = str_replace("#Pemohon#", $userName, $message);
        $message = str_replace("#Dept#", $dept['fromDeptName'], $message);
        
       
        
                   
        $attachment = sizeof($file_attach) > 0 ? $file_attach : $path_file;
       
        $sDetail = "";
        $rowNum = 0;
        foreach($DISdetail as $row=>$detail) 
        {   
            $asset = DisposalDetail::model()->findBySql("select assetDesc assetDesc, assetNumber
                                    from ms_asset where assetID='".$detail->assetID."'");
            $rowNum = (int)$rowNum+1 ;
            $sDetail .= "<tr><td align=center>". $rowNum ."</td>" ; 
            $sDetail .= '<td align=left>'.$asset['assetDesc'].'</td><td align=left>'.$detail['disposalDesc'].'</td><td align=left>'.$detail['nilaiasset'].'</td></tr>' ;

        }
        $message = str_replace("#sInput_#", $sDetail, $message);            
        
        $sDetail = "";            
        foreach($DISApproval as $row=>$detail) 
        {                 
            if($detail['pic'] != "")
            {
                $approvalName = Employee::model()->findByAttributes(array('idCard'=>$detail['pic']))->userName; 
            }
            else {
                $approvalName = "";
            }
                            
            $persetujuan = "";
            if(is_null($detail["persetujuan"]))
            {
                $persetujuan = "N/A";
            }
            else
            {
                if($detail["persetujuan"])
                {
                    $persetujuan = "Disetujui";
                }else{
                    $persetujuan = "Tidak Disetujui";
                }
            }
            
            $approvalDate =  date("d-m-Y", strtotime($detail['tanggal']));
            if($persetujuan !== "N/A")
            {
                $sDetail .= "<tr><td align=left>". $detail['keterangan2']. " ". $approvalName . " - " . $persetujuan . " (".$approvalDate.")" .  "</td></tr>" ;                    
            }
            else
            {
                $sDetail .= "<tr><td align=left>". $detail['keterangan2']. " ". $persetujuan .  "</td></tr>" ;                    
            }               
        }
        $message = str_replace("#sApproval_#", $sDetail, $message);            
        if(!is_null($approval['disposalNo']))
        {
            
            $this->mailsendMAT($to,$bcc,$subject,$message, $attachment);
            $tmpApproval = DisposalApproval::model()->findByAttributes(array('disposalNo'=>$approval['disposalNo'], 'persetujuanID'=>$approval['persetujuanID']));
            $tmpApproval->aktif = 1;
            $tmpApproval->persetujuan = new CDbExpression('NULL'); 
            $tmpApproval->save();
            //$this->redirect(array('index' ,));
            $ret = true;
        }
            
        return $ret;
    }

    public function actionApprovalDisposal()
    {
        $disposalNo= Yii::app()->getRequest()->getQuery('disposalNo');
        $pic = Yii::app()->getRequest()->getQuery('pic');
        $persetujuan = Yii::app()->getRequest()->getQuery('mode');
        $aktif=1;
        $keterangan=Yii::app()->getRequest()->getQuery('jp');
        $ret=Yii::app()->getRequest()->getQuery('ret');
        $an='';
        $now= date ('Y-m-d H:i:s');

        if (isset($disposalNo))
        {
            $disposalNo= Disposal::model()->findByAttributes(array('disposalNo'=>$disposalNo))->disposalNo;
            $DISApproval= DisposalApproval::model()->findByAttributes(array('disposalNo'=>$disposalNo, 'pic'=>$pic, 'keterangan'=>$keterangan));
            $urutan = $DISApproval->urutan;

            if (is_null($DISApproval->tanggal))
            {
                $transaction = Yii::app()->db->beginTransaction();
                try
                {
                    $connection=Yii::app()->db; 
                    $DISApproval->persetujuan = $persetujuan;
                    $DISApproval->tanggal= $now;
                    $DISApproval->save();

                    if ($DISApproval->persetujuan)
                    {
                        $transaction->commit();
                        $this->kirimEmailDisposal($disposalNo);
                        $this->render('approvalDisposal', array(
                                'model'=>$DISApproval, 'disposalNo'=>$disposalNo,
                            ));
                        if ($DISApproval['keterangan']=="Direktur"  && $DISApproval['persetujuan']==1)
                        {
                            $strCommand = " update ms_asset set statusID = 2 where assetID in 
                                        (select assetID from tr_assetDisposalDetail where disposalNo='".$disposalNo."')";

                            $command = $connection->createCommand($strCommand);
                            $command->execute();
                        }
                        exit();
                    }

                    

                    $this->render('approvalDisposal',array(
                            'model'=>$DISApproval, 'disposalNo'=>'',
                        ));
                }
                catch (Exception $ex)
                {
                    //$transaction->rollBack();
                    throw new CHttpException(403, $ex);
                    Yii::app()->user->setFlash('Error', $ex);
                    $this->redirect(array('mutation/indexDisposal'));
                }
            }
            else
            {
                $this->render('approvalDisposal',array(
                        'model'=>$DISApproval, 'disposalNo'=>'--',
                    ));
            }

        }
    }

    public function actionViewPrintDisposal($id)
    {
        $this->layout='iframe';
        $model = Disposal::model()->getHeader($id);
        $detail = DisposalDetail::model()->findAllByAttributes(array('disposalNo'=>$model->disposalNo));
        $approval = Utility::getPrintApprovalDisposal($model->disposalNo);
        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

        # render (full page)
        $mPDF1->WriteHTML($this->render('viewPrintDisposal', array(
            'model'=>$model,
            'detail'=>$detail,
            'approval'=>$approval), true));
            
        # Outputs ready PDF
        $mPDF1->Output($model->disposalNo.'.pdf','I');

    }

    public function actionViewAccounting($id)
    {
        $model = Disposal::model()->getHeader($id);
        $model->items[] = new DisposalDetail();  
                                          
        $detail = DisposalDetail::model()->getDisposalDetail($model->disposalNo);  
        $approval = DisposalApproval::model()->getAccounting($model->disposalNo);  
        $approval->keterangan= "-";
        
        $this->render('viewAccounting',array(
                'model'=>$model,
                'detail'=>$detail,
                'approval'=>$approval,
        ));
    }

    public function actionExecAccounting()                               
    {            
        if(isset($_POST['DisposalApproval']))
        {
            $disposalNo = $_POST['DisposalApproval']['disposalNo'];
            $idcard = Yii::app()->user->getState('idcard');
            
            
            $model = DisposalApproval::model()->findByAttributes(array('disposalNo'=>$disposalNo, 'keterangan'=>$keterangan, 'pic'=>$pic));

            if(is_null($model->tanggal))
            {
                $model->attributes=$_POST['DisposalApproval'];
                $model->tanggal = new CDbExpression('NULL'); 
                $model->persetujuan = new CDbExpression('NULL'); 
                $model->aktif = 1;
                $koreksi = $_POST['DisposalApproval']['keterangan'];
                
                               
                if($model->validate())
                {    
                    $header = Disposal::model()->findByAttributes(array('disposalNo'=>$disposalNo));
                    $header->keterangan = $_POST['DisposalApproval']['keterangan'];

                    
                    $header->save();
                    $disposalNo = $header->disposalNo;
                    $model->save(); 
                    if($kirimEmailDisposal = $this->kirimEmailDisposal($disposalNo))
                    {
                        exit(json_encode(array('result' => 'success', 'msg' => $model->persetujuan?"Disetujui":"Tidak Disetujui",'disposalNo'=>$model->disposalNo)));
                    }
                    
                }                    
            }
            
        }
    } 


    public function ActionIndexDisposal()
    {
       $this->leftPortlets = array();
        $this->leftPortlets['ptl.AssetMenu'] = array(); 

        $model=new Disposal('search');
        
        $model->unsetAttributes(); 
        //$model->keyWord = '';
        if(isset($_GET['Disposal']))
        {
            $model->attributes=$_GET['Disposal'];
            // print_r($model->attributes);
            // exit();
        }
            
        
        $this->render('indexDisposal',array(
                'model'=>$model,
        ));
    }

    public function actionViewDisposal($id)
    {
       
        // $this->leftPortlets = array();
        // $this->leftPortlets['ptl.AssetMenu'] = array(); 
            
        $model = Disposal::model()->getHeader($id);
        $detail = DisposalDetail::model()->getDisposalDetail($model->disposalNo);
        
        $this->render('viewDisposal',array(
                    'model'=>$model,
                    'detail'=>$detail,
            ));

    }

    public function actionUpdate($id)
    {
        //$this->loadModel($id);
        $model = Disposal::model()->findByAttributes(array('disposalNo'=>$id)); 
        $model->items = DisposalDetail::model()->findAllByAttributes(array('disposalNo'=>$model->disposalNo));
        $model->image = DisposalAttachment::model()->findAllByAttributes(array('disposalNo'=>$model->disposalNo));
        $approval= DisposalApproval::model()->findAllByAttributes(array('disposalNo'=>$model->disposalNo));

        $this->performAjaxValidation($model);
        
        if(isset($_POST['Disposal']))
        {
            
            $model->attributes=$_POST['Disposal'];
            $model->fromDept = $_POST['Disposal']['fromDept'];
            $transaction = Yii::app()->db->beginTransaction();
            try
            {

                    if (isset($_POST['DisposalDetail']) && is_array($_POST['DisposalDetail']))
                    {
                        
                        $model->save();
                        DisposalDetail::model()->deleteAll('disposalNo=:disposalNo', array(':disposalNo'=>$model->disposalNo));

                        foreach ($_POST['DisposalDetail'] as $line => $items) {
                            if (!empty($items['disposalDesc']))
                            {
                                $detail = new DisposalDetail;
                                $detail->disposalNo= $model->disposalNo;
                                $detail->assetID=$items['assetID'];
                                $detail->qty= $items['qty'];
                                $detail->nilaiasset= $items['nilaiasset'];
                                $detail->disposalDesc= $items['disposalDesc'];

                                if ($detail->validate())
                                {

                                    $detail->save();
                                }  
                            }
                        }

                    }

                    $criteria = new CDbCriteria;
                    $criteria->addCondition(" disposalNo = '".$model->disposalNo."'");
                    $criteria->addCondition(" persetujuan is null ");
                    $criteria->addCondition(" keterangan = 'DEPTHEAD-BM'");

                    
                    $approval = DisposalApproval::model()->find($criteria);   
                    $approval->persetujuan = 1;
                    $approval->tanggal =  date("Y-m-d H:i:s");

                    $approval->save();
                    $transaction->commit();
                    
                    if($kirimEmailDisposal = $this->kirimEmailDisposal($id))
                    {
                        $this->redirect(array('indexDisposal',));
                        exit(json_encode(array('result' => 'success', 'msg' => $approval->persetujuan?"Disetujui":"Tidak Disetujui",'disposalNo'=>$model->disposalNo)));
                    } 
                    

                    $valid = $model->validate();

                    if ($valid)
                    {
                        if (!$model->save())
                        {
                            $transaction->rollBack();
                        }
                    }
                    else{
                        $$transaction->commit();
                    }
                   
                    // $transaction->commit();
                    $this->redirect(array('indexDisposal',));               
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
                throw new CHttpException(403, $e);
                
            }      
                    
        }
      

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    public function actionSendEmailUlang ($id)
    {

        $model = Disposal::model()->findByAttributes(array('disposalNo'=>$id)); 
        $model->items = DisposalDetail::model()->findAllByAttributes(array('disposalNo'=>$model->disposalNo));
        $model->image = DisposalAttachment::model()->findAllByAttributes(array('disposalNo'=>$model->disposalNo));
        $approval= DisposalApproval::model()->findAllByAttributes(array('disposalNo'=>$model->disposalNo));

        $this->performAjaxValidation($model);
        
        if($kirimEmailDisposal = $this->kirimEmailDisposal($id))
        {
            $this->redirect(array('indexDisposal',));
            exit(json_encode(array('result' => 'success', 'msg' => $approval->persetujuan?"Disetujui":"Tidak Disetujui",'disposalNo'=>$model->disposalNo)));
        }
      
    }


   
}