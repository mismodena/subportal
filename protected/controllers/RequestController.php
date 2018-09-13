<?php

class RequestController extends Controller {

    public function filters() {
        
        return array(
            'accessControl',
            'ajaxOnly -uploadFile'
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array(
                    'suggestCategory',
                    'suggestBatchKK',
                    'suggestEmployee',
                    'suggestEmployee2',
                    'BatchKKList',
                    //'Approval',
                    'addTabProforma',
                    'addTabProforma2',
                    'addTabReqDetail',
                    'addTabTTTDetail',
                    'addTabRetDetail',
                    'addTabRevDetail',
                    'addTabInvDetail',
                    'addTabDisposal',
                    'addTabImage',
                    'addTabFPP',
                    'addTabMAT',
                    'addTabTrading',
                    'addTabTradingDetail',
                    'addTabAPD',
                    'addTabAPP',
                    'DocList',
                    'DocFlowList',
                    'Docfollow',
                    'giro',
                    'suggestSupplier',
                    'SuggestPO',
                    'suggestItem',
                    'suggestTT',
                    'addTabBQNonItems',
                    'addTabBQItems',
                    'addTabReqFile',
                    'coba'
                ),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actions() {
        return array(
            'suggestCategory' => array(
                'class' => 'ext.actions.XSelect2SuggestAction',
                'modelName' => 'Category',
                'methodName' => 'suggestCategory',
                'limit' => 30
            ),
            /* 'initCategory'=>array(
              'class'=>'ext.actions.XSelect2InitAction',
              'modelName'=>'Category',
              'textField'=>'categoryDesc',
              ), */

            /* 'suggestBatchKK'=>array(
              'class'=>'ext.actions.XSelect2SuggestAction',
              'modelName'=>'Cashbook',
              'methodName'=>'suggestBatchKK',
              'limit'=>15
              ), */
            'suggestBatchKK' => array(
                'class' => 'ext.actions.XSelect2SuggestAction',
                'modelName' => 'PurchReq',
                'methodName' => 'suggestBatchKK',
                'limit' => 15
            ),
            /* 'initBatchKK'=>array(
              'class'=>'ext.actions.XSelect2InitAction',
              'modelName'=>'Cashbook',
              'textField'=>'batchID',
              ), */
            'suggestEmployee' => array(
                'class' => 'ext.actions.XSelect2SuggestAction',
                'modelName' => 'Employee',
                'methodName' => 'suggestEmployee',
                'limit' => 15
            ),
            'suggestTT' => array(
                'class' => 'ext.actions.XSelect2SuggestAction',
                'modelName' => 'APInvoice',
                'methodName' => 'suggestTT',
                'limit' => 15
            ),
            'suggestEmployee2' => array(
                'class' => 'ext.actions.XSelect2SuggestAction',
                'modelName' => 'Employee',
                'methodName' => 'suggestEmployee2',
                'limit' => 15
            ),
            'addTabProforma' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'ProformaDetail',
                'viewName' => '/site/extensions/_tabularPI',
            ),
            'addTabProforma2' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'ProformaDetail',
                'viewName' => '/site/extensions/_tabularPIItem',
            ),
            'addTabReqDetail' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'DocumentReqDetail',
                'viewName' => '/site/extensions/_tabularReqDetail',
            ),
            'addTabTTTDetail' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'DocumentTTTDetail',
                'viewName' => '/site/extensions/_tabularTTTDetail',
            ),
            'addTabRetDetail' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'DocumentReqDetail',
                'viewName' => '/site/extensions/_tabularRetDetail',
            ),
            'addTabRevDetail' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'DocumentReqDetail',
                'viewName' => '/site/extensions/_tabularRevDetail',
            ),
            'addTabReqFile' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'DocumentReqFile',
                'viewName' => '/site/extensions/_tabularReqFile',
            ),
            'addTabDisposal' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'DisposalDetail',
                'viewName' => '/site/extensions/_tabularDisposal',
            ),
            'addTabImage' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'DisposalAttachment',
                'viewName' => '/site/extensions/_tabularImage',
            ),
            'addTabFPP' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'FppDetail',
                'viewName' => '/site/extensions/_tabularFPP',
            ),
            'addTabMAT' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'MutationDetail',
                'viewName' => '/site/extensions/_tabularMAT',
            ),
            'addTabAPD' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'APDetail',
                'viewName' => '/site/extensions/_tabularAPD',
            ),
            'addTabAPP' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'APDetail',
                'viewName' => '/site/extensions/_tabularAPP',
            ),
            'addTabTrading' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'MsTradingTermDetail',
                'viewName' => '/site/extensions/_tabularTrading',
            ),
            'addTabTradingDetail' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'MsTradingClaim',
                'viewName' => '/site/extensions/_tabularTradingClaim',
            ),
            'addTabBQNonItems' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'BQNonItem',
                'viewName' => '/site/extensions/_tabularBQNonItems',
            ),
            'addTabBQItems' => array(
                'class' => 'ext.actions.XTabularInputAction',
                'modelName' => 'BQItem',
                'viewName' => '/site/extensions/_tabularBQItems',
            ),
        );
    }

    /* public function actionBatchKKList()
      {
      if(isset($_GET['id'])){

      if(isset($_GET['kategori'])){

      if(($_GET['kategori']=='KK')){
      $batchID = $_GET['id'];

      $criteria = new CDbCriteria;
      $criteria->alias = 'a';
      $criteria->select = ' BATCHID, ACCTID, ACCTDESC, (sum(DTLAMOUNT)) DTLAMOUNT ';
      $criteria->condition = ' BATCHID = :BATCHID';
      $criteria->params = array(':BATCHID' => $batchID);
      $criteria->group = " BATCHID, ACCTID, ACCTDESC ";

      $models=CashbookDetail::model()->findAll($criteria);
      if($models!==null)
      {
      foreach($models as $index=>$data){
      if(Yii::app()->request->isAjaxRequest && isset($_GET['id']))
      {
      $model = new FppDetail();
      $model->fppDesc = trim($data['ACCTID'])." || ".$data['ACCTDESC'];
      $model->fppDetailValue = ($data['DTLAMOUNT']);
      $model->formatedAmount = ($data['formatedAmount']);
      $this->renderPartial('/site/extensions/_XtabularKK', array(
      'model' => $model,
      'index' => $index,
      ));
      }
      else
      throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
      }
      }
      }
      }
      }
      } */

    public function actionBatchKKList() {
        if (isset($_GET['id'])) {

            if (isset($_GET['kategori'])) {

                if (($_GET['kategori'] == 'KK')) {
                    $batchID = $_GET['id'];

                    $criteria = new CDbCriteria;
                    $criteria->alias = 'a';
                    $criteria->select = ' a.RQNNUMBER, GLACCTFULL , b.ACCTDESC, SUM(HCURRVAL) HCURRVAL ';
                    $criteria->join = ' left join SGTDAT..GLAMF b on a.GLACCTFULL = b.ACCTFMTTD ';
                    $criteria->condition = ' RQNNUMBER = :BATCHID';
                    $criteria->params = array(':BATCHID' => $batchID);
                    $criteria->group = " RQNNUMBER, GLACCTFULL, ACCTDESC ";

                    $models = PurchReqDetail::model()->findAll($criteria);

                    if ($models !== null) {
                        foreach ($models as $index => $data) {
                            if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
                                $model = new FppDetail();
                                $model->fppDesc = trim($data['GLACCTFULL']) . " || " . $data['ACCTDESC'];
                                $model->fppDetailValue = ($data['HCURRVAL']);
                                $model->formatedAmount = ($data['formatedAmount']);
                                $this->renderPartial('/site/extensions/_XtabularKK', array(
                                    'model' => $model,
                                    'index' => $index,
                                ));
                            } else
                                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
                        }
                    }
                }
            }
        }
    }

    public function actionSuggestSupplier() {
        $data = Utility::getSupplier($_GET['q']);

        echo CJSON::encode($data);
    }

    public function actionSuggestPO() {
        $data = Utility::getNoPo($_GET['q']);

        echo CJSON::encode($data);
    }

    public function actionSuggestItem() {
        $sql = " SET NOCOUNT ON;                 
                        select MODEL, [desc]
                            from SGTDAT..ICITEM
                            left join mesdb..TBL_ICITEM on TBL_ICITEM.ITEMNO = ICITEM.ITEMNO
                            where MODEL like '%" . $_GET['q'] . "%' and MODEL is not null
                        union
                        select '" . $_GET['q'] . "', '" . $_GET['q'] . "'";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($data as $r => $rows) {
            $app[] = array(
                'id' => $rows['MODEL'],
                'text' => $rows['desc'],
            );
        }
        echo CJSON::encode($data);
    }

    public function actionDocList() {
        if (isset($_GET['id'])) {
            $catID = $_GET['id'];

            $sql = "select a.invCatID, invCatName, a.invDocID, invDocName, 0 docCheck
                                        from ms_docList a
                                left join ms_invCategory b on a.invCatID = b.invCatID
                                left join ms_docCategory c on a.invDocID = c.invDocID
                        where a.invCatID = '$catID'
                        order by invCatName, invDocOrder ";

            $models = Yii::app()->db->createCommand($sql)->queryAll();

            if ($models !== null) {
                foreach ($models as $index => $data) {
                    if (Yii::app()->request->isAjaxRequest && isset($_GET['id'])) {
                        $model = new APDocument();
                        $model->docID = $data['invDocID'];
                        $model->docName = ($data['invDocName']);
                        $model->docValue = ($data['docCheck']);
                        $this->renderPartial('/site/extensions/_tabularAP', array(
                            'model' => $model,
                            'index' => $index,
                        ));
                    } else
                        throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
                }
            }
        }
    }

    

    public function actionDocFlowList() {
        if (isset($_GET['type'])) {
            
            $type = $_GET['type'];            
            $level = Yii::app()->user->getState('level');
            $idgrp = Yii::app()->user->getState('idgrp');
            $branch = Yii::app()->user->getState('branch');
            $idcust = "";            
            $customer = "";           
            $warehouse = "GDGCGK, GDGTGN, GDGJTH, GDGKWC, GDTGNB, GDTGNK,GDGKGA,GDGKGB,GDGKGA,GDGKMA,"
                    . " GDGKMB,GDGKMK,GDGCSA,GDGCSB,GDGCSK,GDGVMA,GDGVMB,GDGVMK,GDGKGK, GDGSTA, GDGSTB, GDGSTK, GDGPIA";
            $invType = $idgrp; // 'MD,TR,PROF,PROJ,PMRN,SHWR,BANK,ESHP,TRIN,KARY';
            
            if($branch != "PST" && $branch != "JKT"){                
                $warehouse = Utility::getWarehouse($branch);
                
            }
            

            
            if (isset($_GET['customer']) && $_GET['customer'] != '' && $_GET['customer'] !=  "0") {
                $customer = $_GET['customer'];
                
            } else {
                $customer = $idgrp;
            };      
            
            if($idgrp == $customer){
               $idcust = "(c.IDCUST in (select IDCUST from getDealer('".$branch."','".$customer."')) OR c.IDNATACCT in (select IDCUST from getDealer('".$branch."','".$customer."')) ) "; 
            } else {
               $idcust = "(c.IDNATACCT = '" . $customer . "' or c.IDCUST = '" . $customer . "')";
            }
            
            if ($type == "FK" && $level == "Sales") {
                $sql = "select hh.invnumber invNumber, hh.BILNAME customer, dbo.fnGetAccpacDate(hh.INVDATE) invDate, hh.INVNETWTX invTotal
                    from tr_docHeader h
                    inner join sgtdat..mis_pajak_detail pd on pd.invnumber = h.docNumber
                    left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                    left join sgtdat..arcus c on c.idcust = hh.customer
                    where invType in (select param from fn_MVParam('".$invType."', ',')) and isComplete = 0 and isPBH = 0 and docNumber not in (select docNumber from tr_docDetail where docType = 'FK') 
                        and ".$idcust."  "
                        . "  order by hh.invnumber desc ";
                
                $models = Yii::app()->db->createCommand($sql)->queryAll();
            } else if ($type == "FK" && $level == "Finance") {
                $sql = "select hh.invNumber, hh.BILNAME customer, dbo.fnGetAccpacDate(hh.INVDATE) invDate, hh.INVNETWTX invTotal
                    from tr_docHeader h
                    left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                    left join tr_docDetail dt on dt.docNumber = h.docNumber
                    left join sgtdat..arcus c on c.idcust = hh.customer
                    where invType in (select param from fn_MVParam('".$invType."', ',')) /*and isComplete = 0*/ and datediff(d, dbo.fnGetAccpacDate(hh.invdate), getDate()) <= 30 and dt.docType = 'FK' and dt.[status] = 0  
                        and ".$idcust."  "
                        . "  order by hh.invnumber desc ";

                $models = Yii::app()->db->createCommand($sql)->queryAll();
            } else if ($type == "EF" && ($level == "Accounting" )) {
                $sql = "select hh.invnumber invNumber, hh.BILNAME customer, dbo.fnGetAccpacDate(hh.INVDATE) invDate, hh.INVNETWTX invTotal
                    from tr_docHeader h
                    inner join sgtdat..mis_pajak_detail pd on pd.invnumber = h.docNumber
                    left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                    left join sgtdat..arcus c on c.idcust = hh.customer
                    where invType in (select param from fn_MVParam('".$invType."', ',')) and isComplete = 0 and isPBH = 0 and docNumber not in (select docNumber from tr_docDetail where docType = 'EF')  
                        and ".$idcust."  "
                        . "  order by hh.invnumber desc ";

                $models = Yii::app()->db->createCommand($sql)->queryAll();
            } else if ($type == "EF" && ($level == "Finance" )) {
                $sql = "select hh.invNumber, hh.BILNAME customer, dbo.fnGetAccpacDate(hh.INVDATE) invDate, hh.INVNETWTX invTotal
                    from tr_docHeader h
                    left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                    left join tr_docDetail dt on dt.docNumber = h.docNumber
                    left join sgtdat..arcus c on c.idcust = hh.customer
                    where invType in (select param from fn_MVParam('".$invType."', ',')) /* and isComplete = 0 */ and datediff(d, dbo.fnGetAccpacDate(hh.invdate), getDate()) <= 30 and dt.docType = 'EF' and dt.[status] = 0 
                        and ".$idcust."  /*and invType not in (select param from fn_MVParam('SHWR,TRIN,KARY,WEB,PMRN,MDHC', ','))*/ "
                        . " order by hh.invnumber desc ";
             
                $models = Yii::app()->db->createCommand($sql)->queryAll();
            } else if ($type == "SJ" && ($level == "Warehouse" || $level == "Admin")) {
                $sql = "select dt.docID, hh.invNumber, /*dbo.fnGetAccpacDate(hh.INVDATE)*/ dt.inputTime invDate, hh.BILNAME customer, dl.qtyShipment, dl.qtyOrder, dl.itemName, hh.INVNETWTX invTotal,
                        dl.itemNo, dl.itemName, dl.qtyOrder, dl.qtyShipment
                        from tr_docHeader h
                        left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                        left join tr_docDetail dt on dt.docNumber = h.docNumber
                        left join tr_docDetailItem dl on dl.docID = dt.docID
                        left join sgtdat..arcus c on c.idcust = hh.customer
                        where isPBH not in (99) and dt.docType = 'SJ' and dt.[status] = 0 and qtyShipment > 0 
                        and ".$idcust." "
                        . " /* and hh.invnumber in (select docNumber from tr_docHeader where isComplete = 0) */ "
                        . " and dt.location in (select param from fn_MVParam('".$warehouse."', ',')) order by hh.invnumber desc";
//                echo $sql;
//                exit();
                $models = Yii::app()->db->createCommand($sql)->queryAll();
            } else if ($type == "SJ" && ($level == "Sales" )) {
                $sql = "select dt.docID, hh.invNumber, /*dbo.fnGetAccpacDate(hh.INVDATE)*/ dt.inputTime  invDate, hh.BILNAME customer, dl.qtyShipment, dl.qtyOrder, dl.itemName, hh.INVNETWTX invTotal,
                        dl.itemNo, dl.itemName, dl.qtyOrder, dl.qtyShipment
                        from tr_docHeader h
                        left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                        left join tr_docDetail dt on dt.docNumber = h.docNumber
                        left join tr_docDetailItem dl on dl.docID = dt.docID
                        left join sgtdat..arcus c on c.idcust = hh.customer
                        where dt.docType = 'SJ' and dt.[status] = 1 and qtyShipment > 0 
                        and ".$idcust."  "
                        . " /* and hh.invnumber in (select docNumber from tr_docHeader where isComplete = 0) */ order by hh.invnumber desc";

                $models = Yii::app()->db->createCommand($sql)->queryAll();
            } else if ($type == "SJ" && ($level == "Finance")) {
                $sql = "select dt.docID, hh.invNumber, /*dbo.fnGetAccpacDate(hh.INVDATE)*/ dt.inputTime  invDate, hh.BILNAME customer, dl.qtyShipment, dl.qtyOrder, dl.itemName, hh.INVNETWTX invTotal,
                        dl.itemNo, dl.itemName, dl.qtyOrder, dl.qtyShipment
                        from tr_docHeader h
                        left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                        left join tr_docDetail dt on dt.docNumber = h.docNumber
                        left join tr_docDetailItem dl on dl.docID = dt.docID
                        left join sgtdat..arcus c on c.idcust = hh.customer
                        where dt.docType = 'SJ' and isPBH = 0 and dt.[status] = 2 and qtyShipment > 0  
                        and ".$idcust."  and invType not in (select param from fn_MVParam('SHWR,TRIN,KARY,WEB,PMRN,MDHC', ','))"
                        . " /* and hh.invnumber in (select docNumber from tr_docHeader where isComplete = 0)*/ order by hh.invnumber desc";

                $models = Yii::app()->db->createCommand($sql)->queryAll();
            } else if ($type == "SJ" && ($level == "Accounting")) {
                $sql = "select dt.docID, hh.invNumber, /*dbo.fnGetAccpacDate(hh.INVDATE)*/ dt.inputTime  invDate, hh.BILNAME customer, dl.qtyShipment, dl.qtyOrder, dl.itemName, hh.INVNETWTX invTotal,
                        dl.itemNo, dl.itemName, dl.qtyOrder, dl.qtyShipment
                        from tr_docHeader h
                        left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                        left join tr_docDetail dt on dt.docNumber = h.docNumber
                        left join tr_docDetailItem dl on dl.docID = dt.docID
                        left join sgtdat..arcus c on c.idcust = hh.customer
                        where dt.docType = 'SJ' and isPBH = 0 and dt.[status] = 2 and qtyShipment > 0  
                        and ".$idcust."  /*and invType not in (select param from fn_MVParam('SHWR,TRIN,KARY,WEB,PMRN,MDHC', ','))*/"
                        . " /* and hh.invnumber in (select docNumber from tr_docHeader where isComplete = 0)*/ order by hh.invnumber desc";

                $models = Yii::app()->db->createCommand($sql)->queryAll();
            }

            $lastDoc = "";
            if ($models !== null) {
                if ($type == "SJ") {
                    foreach ($models as $index => $data) {
                        $model = new DocumentLog();
                        if ($lastDoc != $data['docID']) {
                            $model->invNumber = $data['invNumber'];
                            $model->customer = $data['customer'];
                            $model->invDate = date("d-m-Y", strtotime($data['invDate']));
                            $model->invTotal = 'Rp. ' . number_format($data['invTotal']);
                        } else {
                            $model->invNumber = "";
                            $model->customer = "";
                            $model->invDate = "";
                            $model->invTotal = "";
                        }
                        $model->itemNo = $data['itemNo'];
                        $model->itemName = $data['itemName'];
                        $model->qtyOrder = $data['qtyOrder'];
                        $model->qtyShipment = $data['qtyShipment'];
                        $model->docID = $data['docID'];
                        $this->renderPartial('/site/extensions/_tabularDocFlow', array(
                            'model' => $model,
                            'index' => $index,
                        ));
                        $lastDoc = $data["docID"];
                    }
                } else {
                    foreach ($models as $index => $data) {
                        $model = new DocumentLog();
                        $model->invNumber = $data['invNumber'];
                        $model->customer = $data['customer'];
                        $model->invDate = date("d-m-Y", strtotime($data['invDate']));
                        $model->invTotal = 'Rp. ' . number_format($data['invTotal']);
                        $model->itemNo = "";
                        $model->itemName = "";
                        $model->qtyOrder = "";
                        $model->qtyShipment = "";
                        $model->docID = "";
                        $this->renderPartial('/site/extensions/_tabularDocFlow', array(
                            'model' => $model,
                            'index' => $index,
                        ));
                    }
                }
            }
        }
    }

    public function actionDocfollow() {
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            $customer = "";
            if (isset($_GET['customer'])) {
                $customer = $_GET['customer'];
            };

            $level = Yii::app()->user->getState('level');

            if ($type == "IN") {
                $sql = " select hh.invnumber invNumber, hh.BILNAME customer, dbo.fnGetAccpacDate(hh.INVDATE) invDate, hh.INVNETWTX invTotal
                                from tr_docHeader h                                
                                left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                                left join sgtdat..arcus c on c.idcust = hh.customer
                                where h.invType in ('Y01','Y02','Y11','Y12' ) and h.isComplete = 1 and  h.collectorRcv is null and ('" . trim($customer) . "' = '0' or '" . trim($customer) . "' = '' or c.IDNATACCT = '" . $customer . "' or c.IDCUST = '" . $customer . "') order by h.docNumber "; // hh.BILNAME like '%" . $customer . "%'";

                $models = Yii::app()->db->createCommand($sql)->queryAll();
            } else if ($type == "EX") {
                $sql = " select hh.invnumber invNumber, hh.BILNAME customer, dbo.fnGetAccpacDate(hh.INVDATE) invDate, hh.INVNETWTX invTotal
                                from tr_docHeader h
                                left join sgtdat..oeinvh hh on h.docNumber = hh.INVNUMBER
                                left join sgtdat..arcus c on c.idcust = hh.customer
                                where h.invType in ('Y01','Y02','Y11','Y12' ) and h.isComplete = 1 and h.collectorRcv = 1 and  h.customerRcv is null and ('" . trim($customer) . "' = '0' or '" . trim($customer) . "' = '' or c.IDNATACCT = '" . $customer . "' or c.IDCUST = '" . $customer . "') order by h.docNumber ";

                $models = Yii::app()->db->createCommand($sql)->queryAll();
            }

            if ($models !== null) { {
                    foreach ($models as $index => $data) {
                        $model = new DocumentHeader();
                        $model->docNumber = $data['invNumber'];
                        $model->customer = $data['customer'];
                        $model->invDate = date("d-m-Y", strtotime($data['invDate']));
                        $model->invTotal = 'Rp. ' . number_format($data['invTotal']);
                        $model->fromDate = date("Y-m-d");
                        $this->renderPartial('/site/extensions/_tabularDocFollow', array(
                            'model' => $model,
                            'index' => $index,
                        ));
                    }
                }
            }
        }
    }

    public function actionGiro() {
        $customer = "";
        if (isset($_GET['customer'])) {
            $customer = $_GET['customer'];
        };

        $level = Yii::app()->user->getState('level');

        $sql = "  select docNumber,  h.BILNAME customer, dbo.fnGetAccpacDate(h.invDate) invDate, dt.invValue, dt.retNumber, dt.retDate, ph.DATERMIT, dt.retType,
                    case retType
                    when 'TR' then 'Transfer' + char(10) + dt.revNumber
                    when 'GR' then 'Giro' + char(10) + dt.revNumber
                    else '-' end as revNumber
                    from tr_docRequestDetail dt
                    left join SGTDAT..OEINVH h on h.INVNUMBER = dt.docNumber
                    left join SGTDAT.dbo.ARTCP pd on pd.IDINVC = h.INVNUMBER
                    left join SGTDAT.dbo.ARTCR ph on ph.CNTBTCH = pd.CNTBTCH and ph.CNTITEM = pd.CNTITEM
                    where dt.retType in ('GR', 'TR') and ph.DATERMIT is Null and ('" . trim($customer) . "' = '0' or '" . trim($customer) . "' = '' or h.customer = '" . $customer . "') order by dt.docNumber "; // hh.BILNAME like '%" . $customer . "%'";

        $models = Yii::app()->db->createCommand($sql)->queryAll();

        if ($models !== null) { {
                foreach ($models as $index => $data) {
                    $model = new DocumentReqDetail();
                    $model->docNumber = $data['docNumber'];
                    $model->customer = $data['customer'];
                    $model->invDate = date("d-m-Y", strtotime($data['invDate']));
                    $model->invTotal = 'Rp. ' . number_format($data['invValue']);
                    $model->revNumber = $data['revNumber'];
                    $model->retType = $data['retType'];
                    $this->renderPartial('/site/extensions/_tabularGiro', array(
                        'model' => $model,
                        'index' => $index,
                    ));
                }
            }
        }
    }
    

}
