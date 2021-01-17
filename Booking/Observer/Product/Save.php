<?php


namespace Ticket\Booking\Observer\Product;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;

class Save implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    protected $itemModel;

    protected $itemCollection;

    public function __construct(
        RequestInterface $request,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager,
        \Ticket\Booking\Model\ItemFactory $itemFactory,
        \Ticket\Booking\Model\ResourceModel\Item\CollectionFactory $itemCollection
    ) {
        $this->_request = $request;
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->messageManager = $messageManager;
        $this->itemModel = $itemFactory;
        $this->itemCollection = $itemCollection;
    }

    public function execute(Observer $observer)
    {
        /** @var  $product \Magento\Catalog\Model\Product */
        $product = $observer->getProduct();
        $productId = $product->getId();
        if (!$productId) {
            return;
        }
        $productType = $product->getTypeId();
        $params = $this->_request->getParam('product');
        if ($productType == "ticket_booking") {
            try {
                if (isset($params['date_start'])) {
                    for($i = 0; $i <= 7; $i++) {
                        $date = date('Y-m-d', strtotime($params['date_start'] .' +' .$i. ' day'));
                        $itemId = $this->itemCollection->create()->addFieldToFilter('product_booking_id', ['eq' => $productId])
                            ->addFieldToFilter('date', ['eq' => $date])->getFirstItem()->getId();
                        if(!$itemId) {
                            $itemModel = $this->itemModel->create()->load(null);
                            $itemModel->setProductBookingId($productId);
                            $itemModel->setDate($date);
                            $itemModel->save();
                        }

                    }
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->logger->critical($e->getMessage());
            }
        }
    }
}
