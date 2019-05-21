<?php

namespace XCode\CustomerGroupAccess\Ui\Component\Listing\Column;

use \Magento\Framework\Api\SearchCriteriaBuilder;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{
    protected $_orderRepository;
    protected $_searchCriteria;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $criteria,
        \Magento\Framework\App\ResourceConnection $resource,
        array $components = [],
        array $data = []
    ) {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria = $criteria;
        $this->resource = $resource;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->tableSalesOrderGrid = $this->resource->getTableName("sales_order_grid");
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $connection = $this->resource->getConnection();

            foreach ($dataSource['data']['items'] as &$item) {
                $columnName = $this->getData('name');

                $order = $this->_orderRepository->get($item["entity_id"]);
                // $status = $order->getData("sales_repesentative");
                $dealer = $order->getSalesRepresentative(); 
      //          if(isset($dealer)){
                                   
                // switch ($status) {
                //     case "0":
                //         $export_status = "No";
                //         break;
                //     case "1";
                //         $export_status = "Yes";
                //         break;
                //     default:
                //         $export_status = "Failed";
                //         break;

                // }

                // $this->getData('name') returns the name of the column so in this case it would return export_status
                //$item[$this->getData('name')] = $export_status;
                    $item[$this->getData('name')] = $dealer;
            //    } 
         //       else {
          //          $item[$this->getData('name')] = "-";
          //      }
                //  if ($columnName == "sales_representative") {
                //      $sql = "UPDATE " . $this->tableSalesOrderGrid . " SET sales_representative = :VALUE WHERE entity_id = " . $item["entity_id"];
                //      $binds = [
                //          "VALUE" => $dealer,
                //      ];
                //      $connection->query($sql, $binds);
                //  }

            }
        }

        return $dataSource;
    }
}
