<?php
class HF18_Final_Model_Observer
{
    /**
     * Event after submit place order event
     *
     * @param Varien_Event_Observer $observer
     * @throws Varien_Exception
     */
    public function disableVoucher(Varien_Event_Observer $observer){

        $order = $observer->getEvent()->getOrder();
        $code = $order->getPayment()->getSmartVoucher();
        $code_search=Mage::getModel('hf18_final/voucher')->getCollection()->addFieldToFilter('code', array('eq' => $code));
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        //Query with Binary to compare uppercase or lowercase
        $query=$code_search->getSelect()->where(' code =BINARY ?', $code);
        $voucher =$read->query($query)->fetchAll();
        // Update voucher status after user used code
        $quoteTotal = $order->getGrandTotal();
        $newValue = ($voucher[0]['value'] - $quoteTotal);
        if($newValue >= 0)
        {
            $updateVoucher = Mage::getModel('hf18_final/voucher')->load($voucher[0]['id']);
            $updateVoucher->setValue($newValue)->save();
        }

    }
}