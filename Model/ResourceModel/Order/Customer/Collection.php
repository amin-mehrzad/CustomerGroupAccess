<?php
namespace XCode\CustomerGroupAccess\Model\ResourceModel\Order\Customer;

class Collection extends \Magento\Sales\Model\ResourceModel\Order\Customer\Collection
{
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
}