<?php

class HF18_Final_Model_Resource_Voucher_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('hf18_final/voucher');
    }
}
