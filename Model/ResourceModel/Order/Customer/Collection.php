<?php
namespace XCode\CustomerGroupAccess\Model\ResourceModel\Order\Customer;

//se Magento\Backend\Block\Widget\Grid as WidgetGrid;

class Collection extends \Magento\Sales\Model\ResourceModel\Order\Customer\Collection
{
    // protected $widgetGrid;

    // public function __construct(
    //     WidgetGrid $widgetGrid
    // ){
    //     $this->widgetGrid;
    //     parent::__construct();
    // }

    protected function _initSelect()
    {
        parent::_initSelect();

        $this->joinField(
            'customer_group',
            'customer_group',
            'customer_group_code',
            'customer_group_id=group_id',
            null,
            'left'
        );

        return $this;
    }

    // protected function _prepareCollection()
    // {
    //     //on clicking reset filter on Grid it will make 'complete' status as default:
    //      if(!$this->getParam($this->getVarNameFilter(), null)) {
    //          $this->getCollection()->addFieldToFilter('customer_group', array('in' => ['premiumbuyer','wholesale']));
    //        //   $data['customer_group'] = 'premiumbuyer';
    //        //   $this->_setFilterValues($data);
    //      }
    //      parent::_prepareCollection();
    // }
}
