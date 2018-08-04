<?php
class HF18_Final_Block_Adminhtml_Voucher_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Init class
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('hf18_voucher_form');
        $this->setTitle($this->__('Voucher Information'));
    }

    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $voucherId = Mage::registry('voucherId');
        $model = Mage::getModel('hf18_final/voucher')->load($voucherId);
        $values = [ 0 => "Inactive" , 1 => "Active" ];

        $customer_group = Mage::getResourceModel('customer/group_collection');
        $customer= Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect();
        foreach ($customer as $item)
        {
            $customerArray[$item->getId()]=array('label'=>$item->getName().' ('.$item->getEmail().')','value'=>$item->getId());
        }

        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('hf18_final')->__('Voucher Information'),
            'class'     => 'fieldset-wide',
        ));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        } else {
            if (!empty(Mage::getSingleton('core/session')->getSampleInput())){
                $model = Mage::getModel('hf18_final/voucher')->setData(Mage::getSingleton('core/session')->getSampleInput());
            }
        }

        if(empty($model->getId()))
        {
            $fieldset->addField('code', 'text', array(
                'name' => 'code',
                'label' => Mage::helper('hf18_final')->__('Code'),
                'required' => true
            ));
        }
        else
        {
            $fieldset->addField('code', 'label', array(
                'name' => 'code',
                'label' => Mage::helper('hf18_final')->__('Code'),
                'required' => true
            ));
        }

        $fieldset->addField('value', 'text', array(
            'name'      => 'value',
            'label'     => Mage::helper('hf18_final')->__('Value'),
            'required'  => true
        ));

        $fieldset->addField('active', 'select', array(
            'name'      => 'active',
            'label'     => Mage::helper('hf18_final')->__('Status'),
            'values'    => $values,
            'required'  => false
        ));

        $fieldset->addField('started_at', 'date', array(
            'name'      => 'started_at',
            'label'     => Mage::helper('hf18_final')->__('Started At'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'required'  => true
        ));

        $fieldset->addField('expire_at', 'date', array(
            'name'      => 'expire_at',
            'label'     => Mage::helper('hf18_final')->__('Expire At'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));

        $fieldset->addField(
            'customer_group',
            'multiselect',
            [
                'label'=>'Apply to Customer Group',
                'name' => 'customer_group[]',
                'values' => $customer_group->toOptionArray(),
            ]
        );

        $fieldset->addField(
            'customer_id',
            'multiselect',
            [
                'label'=>'Apply to Customer',
                'name' => 'customer_id[]',
                'values' => $customerArray,
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}