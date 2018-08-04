<?php
class HF18_Final_Adminhtml_VoucherController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Get list vouchers
     */
    public function indexAction() {
        $this->loadLayout()->_setActiveMenu('final/adminhtml');
        $this->_addContent($this->getLayout()->createBlock('hf18_final/adminhtml_voucher'));
        $this->renderLayout();
    }

    /**
     * Get voucher edit page
     *
     * @throws Mage_Core_Exception
     */
    public function editAction()
    {
        $this->loadLayout()->_setActiveMenu('final/adminhtml');
        $this->_title($this->__("Admin Grid"));

        $requestId = $this->getRequest()->getParam('id');
        Mage::register('voucherId', $requestId);

        $this->_addContent($this->getLayout()
            ->createBlock('hf18_final/adminhtml_voucher_edit'));
        $this->renderLayout();
    }

    /**
     * Get add voucher page
     */
    public function addAction() {
        $this->_forward('edit');
    }

    /**
     * Save action after adding or editing
     *
     * @throws Exception
     */
    public function saveAction() {
        $request = Mage::app()->getRequest()->getPost();
        $id = $request['id'];
        $request['customer_group']= implode( ",", $request['customer_group']);
        $request['customer_id']= implode( ",", $request['customer_id']);

        //Get code from request to compare
        $code=$request['code'];
        $value=number_format($request['value']);
        $code_search = Mage::getModel('hf18_final/voucher')->getCollection()->addFieldToFilter('code', array('eq' => $code));
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');

        //Query with Binary to compare uppercase or lowercase
        $query = $code_search->getSelect()->where('code =BINARY ?', $code);
        $smart_code = $read->query($query)->fetchAll();

        $voucher = Mage::getModel('hf18_final/voucher')->load($id);
        $id_exist=Mage::getModel('hf18_final/voucher')->getCollection()
            ->addFieldToFilter('id', array('eq' => $id));

        if($smart_code){
            if($id_exist->getSize()) {
                if(!$value || $value <0){
                    Mage::getSingleton('adminhtml/session')->addError("Please input valid value");
                    $this->_redirect('*/*/edit');
                }
                else{
                    Mage::getSingleton('core/session')->setSampleInput(false);
                    $voucher->load($id)->addData($request)->save();
                    $this->_redirect('*/*/index');
                }
            }
            else {
                Mage::getSingleton('adminhtml/session')->addError("Can not save ". $request['code'] .", code is existed");
                Mage::getSingleton('core/session')->setSampleInput($request);
                $this->_redirect('*/*/edit');
            }
        }

        else {
            if(!$value || $value<0){
                Mage::getSingleton('adminhtml/session')->addError("Please input valid value");
                $this->_redirect('*/*/edit',['id'=>$id]);
            }
            else {
                $voucher->setData($request);
                $voucher->save();
                $this->_redirect('*/*/index');
            }
        }

    }

}