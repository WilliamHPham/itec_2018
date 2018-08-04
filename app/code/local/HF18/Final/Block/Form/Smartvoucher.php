<?php
/**
 * Created by PhpStorm.
 * User: hcm-ca-00022
 * Date: 26/06/2018
 * Time: 14:03
 */
class HF18_Final_Block_Form_Smartvoucher extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('hf18/final/smart_voucher.phtml');
    }
}