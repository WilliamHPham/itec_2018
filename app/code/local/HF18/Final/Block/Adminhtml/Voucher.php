<?php
class HF18_Final_Block_Adminhtml_Voucher extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct()
    {
        $this->_blockGroup = 'hf18_final';
        $this->_controller = 'adminhtml_voucher';
        $this->_headerText = $this->__('All Vouchers');

        parent::__construct();

        $this->_addButton('add', array(
            'label' => Mage::helper('hf18_final')->__('Add Item'),
            'onclick' => "setLocation('" . $this->getUrl('*/*/add') . "')",
            'class' => 'add'
        ));
    }
}