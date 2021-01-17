<?php

namespace Ticket\Booking\Observer\BookingSeats;

use Magenest\Pin\Model\Purchased;
use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order;
use Ticket\Booking\Model\BookingSeatsFactory;
use Magento\Framework\Event\ObserverInterface;
use Ticket\Booking\Model\ResourceModel\BookingSeats\CollectionFactory;
use Ticket\Booking\Model\ResourceModel\BookingSeats;
use Magento\Catalog\Model\ProductFactory;
use Ticket\Booking\Model\ResourceModel\Orders;

class Update implements ObserverInterface
{
    private $bookingSeats;
    private $seatModel;
    private $seatSourceModel;
    protected $productFactory;
    protected $orderSourceModel;
    protected $itemCollection;
    protected $stockRegistry;

    public function __construct(
        CollectionFactory $collectionFactory,
        BookingSeatsFactory $bookingSeatsFactory,
        BookingSeats $bookingSeats,
        ProductFactory $productFactory,
        Orders $orderSourceModel,
        \Ticket\Booking\Model\ResourceModel\Item\CollectionFactory $itemCollectionFactory,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
    ) {
        $this->bookingSeats = $collectionFactory->create();
        $this->seatModel = $bookingSeatsFactory->create();
        $this->seatSourceModel = $bookingSeats;
        $this->productFactory = $productFactory;
        $this->orderSourceModel = $orderSourceModel;
        $this->itemCollection = $itemCollectionFactory->create();
        $this->stockRegistry = $stockRegistry;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $products = $order->getItems();
        $origStatus = $order->getOrigData('status');
        $status = $order->getStatus();
        $customerId = $order->getCustomerId();
        if ($customerId == null) {
            $customerName = 'guest';
            $customerId = 0;
        } else {
            $customerName = $order->getCustomerFirstName() . " " . $order->getCustomerLastName();
        }
        $email = $order->getCustomerEmail();
        if ($origStatus == __('pending') && ($status == __('processing') || ($status == __('complete')))) {
            foreach ($products as $item) {
                if ($item->getProductType() == __('ticket_booking')) {
                    $productId = $item->getProductId();
                    $options = $item->getProductOptions();
                    $seats = $options['info_buyRequest']['choosed_seats'];
                    $date = $options['info_buyRequest']['select_date'];
                    $bookingItemId = $this->itemCollection->getBookingItem($productId, $date)->getId();
                    $bookingSeats = $this->bookingSeats->getBookingSeats($bookingItemId);
                    if ($bookingSeats) {
                        foreach ($bookingSeats as $bookingSeat) {
                            $bookingSeat->setData('seats', $bookingSeat->getSeats() . ", " . $seats);
                            $bookingSeat->save();
                            break;
                        }
                    } else {
                        $data = [
                            'product_booking_item_id' => $bookingItemId,
                            'seats' => $seats,
                            'status' => 1
                        ];
                        $this->seatSourceModel->insertMultiple($data);
                    }
                    $orderId = $item->getOrderId();
                    $orderItemId = $bookingItemId;
                    $orderItemName = $item->getName();
                    $orderAmount = $item->getRowInvoiced();
                    $orderItemType = $item->getProductType();
                    $slots = $item->getQtyInvoiced();
                    $seats = $item->getProductOptions()['info_buyRequest']['choosed_seats'];
                    $productOrder = $this->productFactory->create()->load($productId);
                    $time = $productOrder->getTime();
                    $date = $item->getProductOptions()['info_buyRequest']['select_date'];
                    $data = [
                        'order_id' => $orderId,
                        'order_item_id' => $orderItemId,
                        'order_item_name' => $orderItemName,
                        'order_item_amount' => $orderAmount,
                        'order_item_type' => $orderItemType,
                        'customer_id' => $customerId,
                        'customer_email' => $email,
                        'customer_name' => $customerName,
                        'time' => $time,
                        'date' => $date,
                        'slots' => $slots,
                        'seats' => $seats
                    ];
                    $this->orderSourceModel->insertMultiple($data);
                    $this->updateProductQty($productOrder);

                }
            }
        }
    }

    public function updateProductQty(Product $product)
    {
        $qty = $product->getNumberPlate();
        $stockItem = $this->stockRegistry->getStockItemBySku($product->getSku());
        $stockItem->setQty($qty);
        $stockItem->setIsInStock((bool)$qty);
        $this->stockRegistry->updateStockItemBySku($product->getSku(), $stockItem);
        $product->setStockData($stockItem->getStoredData());
    }

//    protected function sendLicenseEmail(Order $order, Purchased $purchase)
//    {
//        $customerEmail = $order->getBillingAddress()->getEmail();
//        $customerName = $order->getBillingAddress()->getFirstname() . ' ' . $order->getBillingAddress()->getLastname();
//        $storeId = $order->getStoreId();
//        if ($purchase->getPinCode()) {
//            $body = $purchase->getPinCode();
//            $name = $purchase->getProductName() . '.txt';
//        } else {
//            $blob = $this->_blobFactory->create()->load($purchase->getPinFileId());
//            $code = $this->_pinFactory->create()->load($purchase->getPinFileId());
//            $name = $code->getOriFileName();
//            $body = $blob->getPinFile();
//        }
//        $purchaseItemsToDelivered = [];
//        $purchaseItemsToDelivered[] = ['body' => $body, 'name' => $name];
//    }
}
