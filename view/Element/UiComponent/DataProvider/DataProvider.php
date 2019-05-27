<?php
namespace XCode\CustomerGroupAccess\View\Element\UiComponent\DataProvider;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\RequestInterface;

class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**
     * Data Provider name
     *
     * @var string
     */
    protected $name;

    /**
     * Data Provider Primary Identifier name
     *
     * @var string
     */
    protected $primaryFieldName;

    /**
     * Data Provider Request Parameter Identifier name
     *
     * @var string
     */
    protected $requestFieldName;

    /**
     * @var array
     */
    protected $meta = [];

    /**
     * Provider configuration data
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var ReportingInterface
     */
    protected $reporting;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var SearchCriteria
     */
    protected $searchCriteria;
    // protected $seller_order_arr;

    protected $authSession;
    //  \Magento\Framework\View\Element\Template\Context $context,

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        // array $meta = [],
        array $data = [],
        \Magento\Framework\View\Element\Context $context,

        \Magento\Backend\Model\Auth\Session $authSession
    ) {
        $this->authSession = $authSession;

        $this->request = $request;
        $this->filterBuilder = $filterBuilder;
        $this->name = $name;
        $this->primaryFieldName = $primaryFieldName;
        $this->requestFieldName = $requestFieldName;
        $this->reporting = $reporting;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        // $this->meta = $meta;
        $this->data = $data;
        $this->prepareUpdateUrl();

    }
    protected function searchResultToOutput(SearchResultInterface $searchResult)
    {
        $arrItems = [];

        $arrItems['items'] = [];
        foreach ($searchResult->getItems() as $item) {
            $itemData = [];
            foreach ($item->getCustomAttributes() as $attribute) {
                $itemData[$attribute->getAttributeCode()] = $attribute->getValue();
            }
            $arrItems['items'][] = $itemData;
            $arrItems['totalRecords'] = $searchResult->getTotalCount();
        }

        //   $getCustomeId = [];
        //   foreach ($arrItems['items'] as $getcustomer_id) {
        //       $getCustomeId[] = $getcustomer_id['sales_representative'];
        //   }

        $user = $this->getCurrentUser();

        $currentUserData = $this->getCurrentUser()->getRole()->getData();
        $currentUserRoleName = $currentUserData['role_name'];
       //print_r('----------------------------------------------------' . sizeof($itemData));

        // $currentUser='amin';
       // if ($currentUserRoleName != 'Administrators') {
            $currentUser = $this->getCurrentUser()->getUsername();
            $seller_order_arr = [];
$a=0;
            foreach ($arrItems['items'] as $row) {
                
                if ($row['sales_representative'] != null) {
                   $a++;
                    if (in_array($currentUser, explode(",", $row['sales_representative']))) {
                        $seller_order_arr[] = $row;
                    }
                }
            }
            $arrItems['items'] = $seller_order_arr;
            $arrItems['totalRecords']=$a;

       // }

        //  var_dump($seller_order_arr);
        // die('die');

//          $user = $this->getCurrentUser();
          // echo '--------------------------------------'. $a;
        //          if ($user->getUsername() == "amin") {
        //              // echo $user;
        //             // print_r($user->getUsername());

//          }

        return $arrItems;
    }

    public function getCurrentUser()
    {
        return $this->authSession->getUser();
    }

    public function getSearchCriteria()
    {
        if (!$this->searchCriteria) {
            $this->searchCriteria = $this->searchCriteriaBuilder->create();
            $this->searchCriteria->setRequestName($this->name);
        }
        return $this->searchCriteria;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->searchResultToOutput($this->getSearchResult());
    }

    /**
     * Get config data
     *
     * @return array
     */

    /**
     * Set data
     *
     * @param mixed $config
     * @return void
     */

    /**
     * Returns Search result
     *
     * @return SearchResultInterface
     */

    public function getSearchResult()
    {
        return $this->reporting->search($this->getSearchCriteria());
    }

}
