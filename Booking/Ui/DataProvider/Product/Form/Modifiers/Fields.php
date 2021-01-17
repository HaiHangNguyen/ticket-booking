<?php

namespace Ticket\Booking\Ui\DataProvider\Product\Form\Modifiers;

use Ticket\Booking\Model\Product\Type\BookingProduct;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class Fields extends AbstractModifier
{
    protected $locator;
    protected $meta = [];
    protected $listCity;

    public function __construct(
        LocatorInterface $locator,
        \Ticket\Booking\Model\ListCity $listCity
    ) {
        $this->locator = $locator;
        $this->listCity = $listCity;
    }

    public function modifyMeta(array $meta)
    {
        $this->meta = $meta;
        $typeProduct = $this->locator->getProduct()->getData()['type_id'];
        if ($typeProduct == 'ticket_booking')
            $this->createTicketBookingField();
        return $this->meta;
    }

    public function createTicketBookingField()
    {
        $this->meta = array_replace_recursive(
            $this->meta,
            [
                'ticket_booking_configuration' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Ticket Booking Configuration'),
                                'componentType' => 'fieldset',
                                'dataScope' => 'data.product',
                                'collapsible' => false,
                                'sortOrder' => 2,

                            ],
                        ],
                    ],
                    'children' => [
                        'start_location' => $this->getStartLocationField(),
                        'end_location' => $this->getEndLocationField(),
                        'time' => $this->getTimePicker(),
                        'date' => $this->getDatePicker(),
                        'number_plate' => $this->getNumberPlateField(),
                        'info' => $this->getInfoField(),
                        'date_start' => $this->getDateStart()
                    ]
                ]
            ]
        );

        return $this;
    }

    public function getStartLocationField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => 'Start Location',
                        'componentType' => Field::NAME,
                        'formElement' => \Magento\Ui\Component\Form\Element\Select::NAME,
                        'options' => $this->listCity->getAllOptions(),
                        'dataScope' => 'start_location',
                        'dataType' => Text::NAME,
                        'sortOrder' => 10,
                    ],
                ],
            ],
        ];
    }

    public function getEndLocationField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => 'End Location',
                        'componentType' => Field::NAME,
                        'formElement' => \Magento\Ui\Component\Form\Element\Select::NAME,
                        'options' => $this->listCity->getAllOptions(),
                        'dataScope' => 'end_location',
                        'dataType' => Text::NAME,
                        'sortOrder' => 20,
                    ],
                ],
            ],
        ];
    }

    public function getTimePicker()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Field::NAME,
                        'component' => 'Ticket_Booking/js/time_picker',
                        'dataType' => Text::NAME,
                        'dataScope' => 'time',
                        'label' => 'Time',
                        'formElement' => Input::NAME,
                        'sortOrder' => 30,
                        'options' => [
                            'showsTime' => true,
                        ],
                        'validation' => [
                            'validate-no-empty' => true,
                        ],
                    ]
                ]
            ]
        ];
    }

    public function getDatePicker()
    {
        return [
//            'arguments' => [
//                'data' => [
//                    'config' => [
//                        'componentType' => Field::NAME,
//                        'component' => 'Magento_Ui/js/form/element/date',
//                        'elementTmpl' => 'ui/form/element/date',
//                        'dataType' => Text::NAME,
//                        'dataScope' => 'date',
//                        'label' => 'Date Off',
//                        'formElement' => Input::NAME,
//                        'sortOrder' => 40,
//                        'validation' => [
//                            'validate-date' => true,
//                            'validate-no-empty' => true,
//                        ],
//                    ]
//                ]
//            ]
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => 'Date Off',
                        'componentType' => Field::NAME,
                        'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                        'dataScope' => 'date',
                        'dataType' => Text::NAME,
                        'sortOrder' => 40,
                    ]
                ]
            ]
        ];
    }

    public function getNumberPlateField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => 'Number Plate',
                        'componentType' => Field::NAME,
                        'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                        'dataScope' => 'number_plate',
                        'dataType' => Text::NAME,
                        'sortOrder' => 70,
                    ],
                ],
            ],
        ];
    }

    public function getInfoField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => 'Info',
                        'componentType' => Field::NAME,
                        'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                        'dataScope' => 'info',
                        'dataType' => Text::NAME,
                        'sortOrder' => 60,
                    ],
                ],
            ],
        ];
    }

    public function getDateStart()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Field::NAME,
                        'component' => 'Magento_Ui/js/form/element/date',
                        'elementTmpl' => 'ui/form/element/date',
                        'dataType' => Text::NAME,
                        'dataScope' => 'date_start',
                        'label' => 'Date Start',
                        'formElement' => Input::NAME,
                        'sortOrder' => 40,
                        'validation' => [
                            'validate-date' => true,
                            'validate-no-empty' => true,
                        ],
                    ]
                ]
            ]
        ];
    }

    public function modifyData(array $data)
    {
        $product = $this->locator->getProduct();
        $productId = $product->getId();
        $startLocation = $product->getStartLocation();
        $endLocation = $product->getEndLocation();
        $time = $product->getTime();
        $date = $product->getDate();
        $numberPlate = $product->getNumberPlate();
        $info = $product->getInfo();
        $dateStart = $product->getDateStart();

        $data[$productId]['product']['start_location'] = $startLocation;
        $data[$productId]['product']['end_location'] = $endLocation;
        $data[$productId]['product']['time'] = date("h:m a", strtotime($time));
        $data[$productId]['product']['date'] = date("Y/m/d", strtotime($date));
        $data[$productId]['product']['number_plate'] = $numberPlate;
        $data[$productId]['product']['info'] = $info;
        $data[$productId]['product']['date_start'] = $dateStart;

        return $data;
    }
}
