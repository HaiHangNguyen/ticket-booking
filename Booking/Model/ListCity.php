<?php
namespace Ticket\Booking\Model;

class ListCity extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var \Ticket\Directory\Model\City
     */
    protected $_directory;

    /**
     *
     * @param \Ticket\Directory\Model\City $directory
     */
    public function __construct(
        \Ticket\Directory\Model\City $directory
    ) {
        $this->_directory = $directory;
    }

    public function getAvailableTemplate()
    {
        $citys    = $this->_directory->getCollection();
        $listCity = [];
        foreach ($citys as $city) {
            $value = $city->getId();
            $cityName = $city->getName();
            $listCity[$city->getId()] = [
                'label' => $cityName,
                'value' => $value,
            ];
        }

        return $listCity;
    }

    /**
     * Get model option as array
     *
     * @return array
     */
    public function getAllOptions($withEmpty = true)
    {
        $options = $this->getAvailableTemplate();

        if ($withEmpty) {
            array_unshift(
                $options,
                [
                 'value' => null,
                 'label' => '-- Please Select --',
                ]
            );
        }

        return $options;
    }
}
