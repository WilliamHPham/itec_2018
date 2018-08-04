<?php
class HF18_Final_OnestepController extends Mage_Core_Controller_Front_Action
{
    public function ajaxShippingAction()
    {
        $quote = Mage::getModel('checkout/session')->getQuote();
        $code = $this->getRequest()->getParam('code_value');
        $shippingType = $this->getRequest()->getParam('shipping_type');
        $arrayObj = array();
        $address = $quote->getShippingAddress();
        $rate = (float) Mage::getStoreConfig('carriers/'.$shippingType.'/price');
        $quote->getShippingAddress()->setShippingMethod($code)->setTotalCollectedFlag(false)->collectTotals()->save();
        $quote->getShippingAddress()->setShippingAmount($rate);
        $quote->getShippingAddress()->setBaseShippingAmount($rate);
        $cartItems = $quote->getAllVisibleItems();
        $taxItem = 0;
        foreach($cartItems as $item){
            $productId = $item->getProductId();
            $_product = Mage::getModel('catalog/product')->load($productId);
            $tax_class_id = $_product->getTaxClassId();
            $store = Mage::app()->getStore();
            $customerAddressId = Mage::getSingleton('customer/session')->getCustomer()->getDefaultShipping();
            if ($customerAddressId){
                $address = Mage::getModel('customer/address')->load($customerAddressId);
            }
            $taxCalculation = Mage::getModel('tax/calculation');
            $request = $taxCalculation->getRateRequest($address, null, null, $store);
            $percent = $taxCalculation->getStoreRate($request->setProductClassId($tax_class_id), $store);
            $price = Mage::helper('tax')->getPrice($_product, $_product->getFinalPrice());
            $tax_amount = round(($price*$percent)/100,2);
            $taxItem += $tax_amount*$item->getQty();
        }
        $quote->getShippingAddress()->setTaxAmount($taxItem);
        $quote->getShippingAddress()->save();
        $arrayObj['ShippingAmount'] = Mage::helper('core')->currency($quote->getShippingAddress()->getShippingAmount(),true,false);
        $arrayObj['BaseShippingAmount'] = Mage::helper('core')->currency($quote->getShippingAddress()->getBaseShippingAmount(),true,false);
        $arrayObj['TaxAmount'] = Mage::helper('core')->currency($quote->getShippingAddress()->getTaxAmount(),true,false);
        $arrayObj['GrandTotal'] = Mage::helper('core')->currency($quote->getShippingAddress()->getSubtotal() + $quote->getShippingAddress()->getBaseShippingAmount() + $quote->getShippingAddress()->getTaxAmount(),true,false);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($arrayObj));
    }

    public function ajaxRegionAction()
    {
        $countryCode=$this->getRequest()->getParam('value');
        $regionCollection = Mage::getModel('directory/region_api')->items($countryCode);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($regionCollection));
    }

    /**
     * Get one page model to reuse its function
     *
     * @return Mage_Core_Model_Abstract
     */
    public function getOnepage()
    {
        return Mage::getSingleton('checkout/type_onepage');
    }


    /**
     * Save checkout method
     */
    public function saveMethodAction($method)
    {
        $result = $this->getOnepage()->saveCheckoutMethod($method);
        return $result;
    }

    /**
     * Save checkout billing address
     */
    public function saveBillingAction($data, $customerAddressId = null)
    {
        if (isset($data['email'])) {
            $data['email'] = trim($data['email']);
        }
        $result = $this->getOnepage()->saveBilling($data, $customerAddressId);
        return $result;
    }

    /**
     * Shipping address save action
     */
    public function saveShippingAction($data, $customerAddressId = null)
    {
        $result = $this->getOnepage()->saveShipping($data, $customerAddressId);
        return $result;
    }


    /**
     * Shipping method save action
     */
    public function saveShippingMethodAction($data)
    {
        $this->getOnepage()->getQuote()->getShippingAddress()
            ->setShippingMethod($data);

        if (!$this->getOnepage()->getQuote()->isVirtual()) {
            //Recollect Shipping rates for shipping methods
            $this->getOnepage()->getQuote()->getShippingAddress()->setCollectShippingRates(true);
        }

        $this->getOnepage()->getQuote()->setTotalsCollectedFlag(false)->collectTotals()->save();

        return $result = array();
    }

    /**
     * Save payment ajax action
     *
     * Sets either redirect or a JSON response
     */
    public function savePaymentAction($data)
    {
        try {
            $result = $this->getOnepage()->savePayment($data);

        } catch (Mage_Payment_Exception $e) {
            if ($e->getFields()) {
                $result['fields'] = $e->getFields();
            }
            $result['error'] = 1;
            $result['message'][] = $e->getMessage();
        } catch (Mage_Core_Exception $e) {
            $result['error'] = 1;
            $result['message'][] = $e->getMessage();
        } catch (Exception $e) {
            Mage::logException($e);
            $result['error'] = 1;
            $result['message'][] = $this->__('Unable to set Payment Method.');
        }
        return $result;
    }

    /**
     * Save new subscriber for newsletter
     *
     * @param $email
     * @throws Varien_Exception
     */
    public function saveNewsletter($email)
    {
        Mage::getModel('newsletter/subscriber')->setImportMode(true)->subscribe($email);

        // Get just generated subscriber
        $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);

        // Change status to "subscribed" and save
        $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);
        $subscriber->save();
    }

    /**
     * Validate data and save order
     *
     * @throws Varien_Exception
     */
    public function saveQuoteAction() {
        if ($this->isFormkeyValidationOnCheckoutEnabled() && !$this->_validateFormKey()) {
            return;
        }

        $data = $this->getRequest()->getPost();
        $method = $this->getRequest()->getPost('checkout_method');
        $billing = $this->getRequest()->getPost('billing', array());
        $customerBillingAddressId = $this->getRequest()->getPost('billing_address_id', false);
        $shipping = $this->getRequest()->getPost('shipping', array());
        $customerShippingAddressId = $this->getRequest()->getPost('shipping_address_id', false);
        $shippingMethod = $this->getRequest()->getPost('shipping_method', '');
        $payment = $this->getRequest()->getPost('payment', array());

        $requestFormKey = Mage::app()->getRequest()->getParam('form_key');
        $sessionFormKey = Mage::getSingleton('core/session')->getFormKey();

        if($this->getRequest()->isPost() && $requestFormKey == $sessionFormKey) {
            $errorArray = array();
            $errMethod = array();
            $errShipping = array();

            // Save checkout method
            if(!empty($method)) {
                $errMethod = $this->saveMethodAction($method);
            }
            // Save billing address
            $errBilling = $this->saveBillingAction($billing, $customerBillingAddressId);

            // Save shipping address
            if($billing['use_for_shipping'] == 0) {
                $errShipping = $this->saveShippingAction($shipping, $customerShippingAddressId);
            }
            if($data['newslettersubscription'] == 1) {
                if(Mage::getSingleton('customer/session')->isLoggedIn()) {
                    $email = Mage::getSingleton('customer/session')->getCustomer()->getEmail();
                }
                else {
                    $email = $billing['email'];
                }
                $this->saveNewsletter($email);

            }

            // Save shipping method
            $errShippingMethod = $this->saveShippingMethodAction($shippingMethod);

            // Save payment method
            $errPayment = $this->savePaymentAction($payment);

            // Get error array
            array_push($errorArray, $errMethod, $errBilling, $errShipping, $errShippingMethod, $errPayment);

            $dataReturn = array();
            $dataReturn['errorsList'] = $this->checkError($errorArray);

            if(empty($dataReturn['errorsList'])) {
                $this->getOnepage()->saveOrder();
                // Update Quote after save order
                Mage::getSingleton('checkout/cart')->truncate()->save();

                $dataReturn['success'] = 1;
                $this->_prepareDataJSON($dataReturn);
            }
            else {
                $dataReturn['success'] = 0;
                $this->_prepareDataJSON($dataReturn);
            }

        }
    }

    /**
     * Convert errors to one array
     *
     * @param $errorArray
     * @return bool
     * @throws Varien_Exception
     */
    public function checkError($errorArray) {
        $errorArr = array();
        foreach($errorArray as $array) {
            if(!empty($array)) {
                if(is_array($array['message'])) {
                    foreach($array['message'] as $err) {
                        array_push($errorArr, $err);
                    }
                }
                else {
                    array_push($errorArr, $array['message']);
                }
            }
        }
        return $errorArr;
    }

    /**
     * Prepare JSON formatted data for response to client
     *
     * @param $response
     * @return Zend_Controller_Response_Abstract
     */
    protected function _prepareDataJSON($response)
    {
        $this->getResponse()->setHeader('Content-type', 'application/json', true);
        return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}
