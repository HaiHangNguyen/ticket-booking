<?php
/**
 * Copyright © 2019 Ticket. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Ticket_Kootoro extension
 * NOTICE OF LICENSE
 *
 * @category Ticket
 * @package Ticket_Kootoro
 */

namespace Ticket\Directory\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;

class DirectoryHelper extends AbstractHelper
{
    protected $wardResource;

    protected $districtResource;

    protected $cityResource;

    /**
     * DirectoryHelper constructor.
     *
     * @param Context $context
     * @param \Ticket\Directory\Model\ResourceModel\City $cityResource
     * @param \Ticket\Directory\Model\ResourceModel\District $districtResource
     * @param \Ticket\Directory\Model\ResourceModel\Ward $wardResource
     */
    public function __construct(
        Context $context,
        \Ticket\Directory\Model\ResourceModel\City $cityResource,
        \Ticket\Directory\Model\ResourceModel\District $districtResource,
        \Ticket\Directory\Model\ResourceModel\Ward $wardResource
    ) {
        $this->wardResource = $wardResource;
        $this->districtResource = $districtResource;
        $this->cityResource = $cityResource;
        parent::__construct($context);
    }

    public function getCityDefaultName($cityId)
    {
        return $this->cityResource->getDefaultNameById($cityId);
    }

    public function getDistrictDefaultName($districtId)
    {
        return $this->districtResource->getDefaultNameById($districtId);
    }

    public function getWardDefaultName($wardId)
    {
        return $this->wardResource->getDefaultNameById($wardId);
    }
}
