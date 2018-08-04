<?php
class HF18_Final_Block_Adminhtml_Voucher_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setDefaultSort('id');
        $this->setId('hf18_voucher_grid');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("hf18_final/voucher")->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn('code',
            array(
                'header'=> $this->__('Code'),
                'width' => '80px',
                'align' =>'left',
                'index' => 'code'
            )
        );
        $this->addColumn('value',
            array(
                'header'=> $this->__('Amount'),
                'align' =>'left',
                'width' => '50px',
                'index' => 'value'
            )
        );
        $this->addColumn('active',
            array(
                'header'=> $this->__('Status'),
                'align' =>'left',
                'width' => '80px',
                'index' => 'active',
                'type'      => 'options',
                'options'   => array('0' => 'Inactive', '1' => 'Active' )
            )
        );
        $this->addColumn('started_at',
            array(
                'header'=> $this->__('Date start '),
                'align' =>'left',
                'width' => '50px',
                'index' => 'started_at',
                'type'  => 'date',
                'format'=>  'yyyy-MM-dd'
            )
        );
        $this->addColumn('expire_at',
            array(
                'header'=> $this->__('Date Expire'),
                'align' =>'left',
                'width' => '50px',
                'index' => 'expire_at',
                'type'  => 'date',
                'format'=>  'yyyy-MM-dd'
            )
        );
        $this->addColumn('created_at',
            array(
                'header'=> $this->__('Created At'),
                'align' =>'left',
                'width' => '150px',
                'index' => 'created_at'
            )
        );
        $this->addColumn('action',
            array(
                'header' => Mage::helper('hf18_final')->__('Action'),
                'width' => '10px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('hf18_final')->__('Edit'),
                        'url' => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
            ));

        Mage::getSingleton('core/session')->setSampleInput(false);
        return parent::_prepareColumns();
    }


    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id'); //Key of request

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}