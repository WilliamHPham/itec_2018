<?php

class HF18_Final_Model_Voucher extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('hf18_final/voucher');
    }

    /**
     * Execute before saving voucher
     *
     * @return Mage_Core_Model_Abstract|void
     * @throws Varien_Exception
     */
    protected function _beforeSave()
    {
        $getError = false;
        // Validate date before saving
        if($this->getExpireAt()) {
            if (strtotime($this->getStartedAt()) > strtotime($this->getExpireAt())) {
                Mage::getSingleton('adminhtml/session')->addError("Please input valid expire day.");
                $this->_dataSaveAllowed = false;
                $getError = true;
            }
        }

        if($getError) {
            Mage::register('getError', $getError);
        }
    }

    protected function _afterSave()
    {
        if(empty($this->getId()))
        {
            Mage::getSingleton('adminhtml/session')->addSuccess("Update voucher successful.");
        }
        else {
            Mage::getSingleton('adminhtml/session')->addSuccess("Save successful.");
        }
    }

}