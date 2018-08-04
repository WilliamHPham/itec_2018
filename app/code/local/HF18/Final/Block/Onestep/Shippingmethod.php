<?php

class HF18_Final_Block_Onestep_Shippingmethod extends Mage_Core_Block_Template
{
    public function getShippingMethod()
    {
        $methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
        $shipMethods = array();

        foreach ($methods as $shippigCode => $shippingModel) {
            if($_methods = $shippingModel->getAllowedMethods()) {
                $shippingTitle = Mage::getStoreConfig('carriers/' . $shippigCode . '/title');
                $shippingPrice = Mage::getStoreConfig('carriers/' . $shippigCode . '/price');
                $code = $shippigCode."_".$shippigCode;
                $shipMethods[] = array(
                    'shipping_type' => $shippigCode,
                    'title' => $shippingTitle,
                    'price' => $shippingPrice,
                    'code'=>$code,
                    'method' => $_methods[$shippigCode]
                );
            }
        }
        return $shipMethods;
    }

    public function getSubtotal()
    {
        return Mage::helper('checkout/cart')->getQuote()->getSubtotal();
    }

    public function getFreeShippingValue()
    {
        return Mage::getStoreConfig("carriers/freeshipping/free_shipping_subtotal");
    }

    public function isAllowedFreeShipping()
    {
        $allowed=true;
        $minimum=$this->getFreeShippingValue();
        $subtotal=$this->getSubtotal();
        if($subtotal < $minimum)
        {
            $allowed=false;
        }
        return $allowed;
    }
}