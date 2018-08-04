<?php
class HF18_Final_Block_Adminhtml_Voucher_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {
        $this->_blockGroup = 'hf18_final';
        $this->_controller = 'adminhtml_voucher';

        parent::__construct();

        $this->_removeButton('delete', 'label', $this->__('Delete Baz'));
    }

    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return $this->__('Voucher Detail');
    }
}