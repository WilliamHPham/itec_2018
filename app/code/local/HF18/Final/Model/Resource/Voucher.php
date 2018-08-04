<?php

class HF18_Final_Model_Resource_Voucher extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('hf18_final/voucher', 'id');
    }
}
