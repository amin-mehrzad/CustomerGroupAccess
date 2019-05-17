<?php

namespace XCode\CustomerGroupAccess\Block\Adminhtml\Custom;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;
use \Magento\Backend\Helper\Data;
use \Magento\Framework\View\Element\BlockFactory;

//use Magento\Backend\Block\Widget\Context ;
class Grid extends WidgetGrid
{
    protected $_blockFactory;
    protected $_backendHelper;
    protected $authSession;

    public function __construct(
        \Magento\Framework\View\Element\BlockFactory $blockFactory,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Backend\Model\Auth\Session $authSession,
        array $data = []
    ) {

        $this->_backendHelper = $backendHelper;
        $this->_blockFactory = $blockFactory;
        $this->authSession = $authSession;
        parent::__construct($context, $backendHelper, $data);
        //      $this->setSaveParametersInSession(true);
        //      //for default filter
        //      if ($this->hasData('default_filter')){
        //          $this->setDefaultFilter($this->getData('default_filter'));
        //      }
    }

    public function getCurrentUser()
    {
        return $this->authSession->getUser();
    }

    protected function _prepareCollection()
    {

        echo $this->getNameInLayout() . "<br>";
        $layoutName = $this->getNameInLayout();
        if ($layoutName == "adminhtml.customer.grid.container") {
            $v = $this->getParam($this->getVarNameFilter(), null);
            echo $this->getVarNameFilter() . "<br>";

            $user = $this->getCurrentUser();

            if ($user->getUsername() == "amin") {
                // echo $user;
                print_r($user->getUsername());
                //on clicking reset filter on Grid it will make 'complete' status as default:

                if (!$this->getParam($this->getVarNameFilter(), null)) {
                    $this->getCollection()->addFieldToFilter('customer_group', array('in' => ['wholesale']));
                    //$data['customer_group'] = 'wholesale';
                    // $this->_setFilterValues($data);
                }
            }
        }
        parent::_prepareCollection();
    }
}
