<?php

namespace XCode\CustomerGroupAccess\Block\Adminhtml\Custom;
use Magento\Backend\Block\Widget\Grid as WidgetGrid;
class Grid extends WidgetGrid
    {
         protected function _construct()
         {
             parent::_construct();
             $this->setSaveParametersInSession(true);        
             //for default filter
             if ($this->hasData('default_filter')){
                 $this->setDefaultFilter($this->getData('default_filter'));
             }
         }
         protected function _prepareCollection()
         {
             //on clicking reset filter on Grid it will make 'complete' status as default:
              if(!$this->getParam($this->getVarNameFilter(), null)) {
                  $this->getCollection()->addFieldToFilter('customer_group', array('in' => ['premiumbuyer','wholesale']));
                  $data['customer_group'] = 'premiumbuyer';           
                  $this->_setFilterValues($data);
              }
              parent::_prepareCollection();
         }
    }