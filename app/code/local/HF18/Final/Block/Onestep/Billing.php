<?php

class HF18_Final_Block_Onestep_Billing extends Mage_Core_Block_Template
{
    public function getCustomer()
    {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        return $customer;
    }

    public function getCustomerAddress()
    {
        $customerAddressId = Mage::getSingleton('customer/session')->getCustomer()->getDefaultBilling(); //oder getDefaultShipping
        if ($customerAddressId) {
            $address = Mage::getModel('customer/address')->load($customerAddressId);
            return $address;
        }
    }

    public function getCustomerShippingAddress()
    {
        $customerAddressId = Mage::getSingleton('customer/session')->getCustomer()->getDefaultShipping(); //oder getDefaultShipping
        if ($customerAddressId) {
            $address = Mage::getModel('customer/address')->load($customerAddressId);
            return $address;
        }
    }

    public function getCountries()
    {
        $countryList = Mage::getModel('directory/country')->getResourceCollection()
            ->loadByStore()
            ->toOptionArray(true);
        unset($countryList[0]);
        return $countryList;
    }

    public function getRegionCollection($countryCode)
    {
        $regionCollection = Mage::getModel('directory/region_api')->items($countryCode);

        return $regionCollection;
    }

    public function getAddress()
    {
        $address = $this->getData('address');
        if (is_null($address)) {
            $address = Mage::getSingleton('checkout/type_multishipping')->getQuote()->getBillingAddress();
            $this->setData('address', $address);
        }
        return $address;
    }

    public function checkNewsletter($email)
    {
        $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
        if($subscriber->getId())
        {
            return $isSubscribed = $subscriber->getData('subscriber_status') == Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED;
        }
    }

    public function getCountryByCode($country_code)
    {
        $country_name=Mage::app()->getLocale()->getCountryTranslation($country_code);
        return $country_name;
    }

    public function getQuoteId()
    {
        return Mage::getSingleton('checkout/session')->getQuoteId();
    }

    public function getQuoteCollection()
    {
        return Mage::getModel('sales/quote_address')->getCollection();
    }

    public function getBillingAddressIdQuote()
    {
        $quoteId=$this->getQuoteId();
        $quote_billing=$this->getQuoteCollection();

        $quote_billing->addFieldToFilter("address_type", array("eq" => "billing"));
        $quote_billing->addFieldToFilter("quote_id", array("eq" => $quoteId));
        $address_billing=$quote_billing->getData();
        foreach ($address_billing as $item) {
            return $item['address_id'];
        }
    }

    public function getShippingAddressIdQuote()
    {
        $quoteId=$this->getQuoteId();
        $quote_billing=$this->getQuoteCollection();

        $quote_billing->addFieldToFilter("address_type", array("eq" => "shipping"));
        $quote_billing->addFieldToFilter("quote_id", array("eq" => $quoteId));
        $address_billing=$quote_billing->getData();
        foreach ($address_billing as $item) {
            return $item['address_id'];
        }
    }
}