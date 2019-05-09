<?php
namespace XCode\CustomerGroupAccess\Model\ResourceModel\Order\Customer;

class Collection extends \Magento\Sales\Model\ResourceModel\Order\Customer\Collection
{
    /**
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->addAttributeToSelect(
           ['email'=>'1']
        );
        return $this;
    }
}