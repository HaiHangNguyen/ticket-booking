<?php

namespace Ticket\Booking\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ObserverInterface;

class AddToCart implements ObserverInterface
{
    private $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function execute(Observer $observer)
    {
        if ($this->request->getFullActionName() == 'checkout_cart_add') {
            $product = $observer->getProduct();
            $params = $this->request->getParams();
            if (isset($params['choosed_seats'])) {
                $selectedDate = $params['select_date'];
                $data[] = array(
                    'label' => 'Date',
                    'value' => $selectedDate
                );
                $observer->getProduct()->addCustomOption('additional_options', json_encode($data));
            }
            if (isset($params['choosed_seats'])) {
                $selectedSeats = $params['choosed_seats'];
                $data[] = array(
                    'label' => 'Selected Seats',
                    'value' => $selectedSeats
                );
                $observer->getProduct()->addCustomOption('additional_options', json_encode($data));
            }
        }
    }
}
