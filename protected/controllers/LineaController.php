<?php

class LineaController extends Controller {

    public $layout = 'leftbar';

    function init() {
        parent::init();
        $this->leftPortlets['ptl.LineaMenu'] = array();
    }

    public function filters() {
        return array(
            'Rights',
        );
    }

    public function allowedActions() {
//        return 'getMaxValue';
    }

    public function actionIndex() {
        $model = new Linea('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Linea'])) {
            $model->attributes = $_GET['Linea'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionExport() {        
        $itemNo = isset($_GET['itemNo']) ? $_GET['itemNo'] : '';
        $fiscalYear = isset($_GET['fiscalYear']) ? $_GET['fiscalYear'] : '';
        $fiscalPeriod = isset($_GET['fiscalPeriod']) ? $_GET['fiscalPeriod'] : '';
                
        $model = new Linea("export");
        $model->itemNo = $itemNo;
        $model->fiscalYear = $fiscalYear;
//        echo("<pre>");
//        print_r($model);
//        echo("</pre>");
//        exit();
        $this->widget('ext.EExcelView', array(
            'title' => "Linea",
            'dataProvider' => $model->export(),
            'grid_mode' => 'export',
            'columns' => array(
                array(
                    "name" => "fiscalYear",
                    "value" => '$data->fiscalYear',
                ),
                array(
                    "name" => "fiscalPeriod",
                    "value" => '$data->fiscalPeriod',
                ),
                array(
                    "name" => "itemNo",
                    "value" => '$data->itemNo',
                    "type" => "raw",
                ),
                array(
                    "name" => "itemName",
                    "value" => '$data->itemName',
                ),
                array(
                    "name" => "lineaValueHome",
                    "value" => '"Rp. ".number_format($data->lineaValue)',
                    'htmlOptions' => array('style' => 'text-align:right;'),),
                array(
                    "name" => "qtyOrder",
                    "value" => 'number_format($data->qtyOrder)." unit"',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    "name" => "lineaPerOrder",
                    "value" => '"Rp. ". number_format($data->qtyOrder * $data->lineaValue)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
            ),
        ));
    }

}
