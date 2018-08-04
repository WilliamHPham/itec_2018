<?php
class HF18_Final_Block_Info_Smartvoucher extends Mage_Payment_Block_Info
{
    protected function _prepareSpecificInformation($transport = null)
    {
        if (null !== $this->_paymentSpecificInformation)
        {
            return $this->_paymentSpecificInformation;
        }

        $data = array();
        if ($this->getInfo()->getSmartVoucher())
        {
            $data[Mage::helper('payment')->__('Smart Voucher')] = $this->getInfo()->getSmartVoucher();
            $data[Mage::helper('payment')->__('Total Paid')] = $this->getInfo()->getOrder()->getGrandTotal();
        }

        $transport = parent::_prepareSpecificInformation($transport);

        return $transport->setData(array_merge($data, $transport->getData()));
    }
}