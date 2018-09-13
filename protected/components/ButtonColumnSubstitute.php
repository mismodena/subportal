<?php

class ButtonColumnSubstitute extends CButtonColumn
{
    protected function renderButton($id, $button, $row, $data)
    {
        //if (empty($button['url'])) {
                if (isset($button['visible']) && !$this->evaluateExpression($button['visible'],array('row'=>$row,'data'=>$data))) {
                        return;
                }                       

                if (isset($button['label'])) {
                        echo $this->evaluateExpression($button['label'],array('data'=>$data,'row'=>$row));
                }
        //} else {
        //        parent::renderButton($id,$button,$row,$data);   
       // }
    }
}