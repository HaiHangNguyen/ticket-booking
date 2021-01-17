<?php
/**
 * Copyright © 2020 Ticket. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Ticket_Kootoro extension
 * NOTICE OF LICENSE
 *
 * @category Ticket
 * @package Ticket_Kootoro
 */

namespace Ticket\Directory\Setup\Patch\Data;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Api\AddressMetadataInterface;

class UpdateStreetMultilineCountPatch implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * AddCustomerUpdatedAtAttribute constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $customerSetup = $this->customerSetupFactory->create();
        $customerSetup->updateAttribute(AddressMetadataInterface::ENTITY_TYPE_ADDRESS, 'street', 'multiline_count', 1);

        $this->moduleDataSetup->endSetup();
    }
}
