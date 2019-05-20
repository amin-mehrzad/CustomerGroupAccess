<?php

namespace XCode\CustomerGroupAccess\Observer;

use Magento\Framework\Event\ObserverInterface;

class AdminCheckoutSubmitAllAfter implements ObserverInterface
{
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $backendAuthSession;
    protected $logger;

    /**
     * @param \Magento\Backend\Model\Auth\Session $backendAuthSession
     */
    public function __construct(
        \Magento\Backend\Model\Auth\Session $backendAuthSession
    ) {
        $this->backendAuthSession = $backendAuthSession;
    }

    /**
     * Add sale repsentative name to the order table
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $adminUserName = $this->backendAuthSession->getUser()->getUserName();
        if ($adminUserName) {
            $order = $observer->getEvent()->getOrder();
            $order->setSalesRepresentative($adminUserName);
            $order->save();
        }
    }
}