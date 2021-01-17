<?php


namespace Ticket\Booking\Setup;


use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Form\Factory;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Store\Model\StoreManagerInterface;


class UpgradeData implements UpgradeDataInterface
{
    protected $EavSetup;
    protected $config;
    protected $storeManager;
    protected $attributeResource;
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        StoreManagerInterface $storeManager,
        Config $eavConfig,
        Attribute $attributeResource
    )
    {
        $this->attributeResource = $attributeResource;
        $this->config = $eavConfig;
        $this->EavSetup = $eavSetupFactory;
        $this->storeManager = $storeManager;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if ( version_compare($context->getVersion(), '1.0.4', '<' )){
            $eavSetup = $this->EavSetup->create(['setup' => $setup]);
            $eavSetup->addAttribute( \Magento\Catalog\Model\Product::ENTITY,
                'start_location',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => false,
                    'required' => true,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'unique' => false,
                    'apply_to' => 'ticket_booking',
                ]
            )->addAttribute( \Magento\Catalog\Model\Product::ENTITY,
                'end_location',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => false,
                    'required' => true,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'unique' => false,
                    'apply_to' => 'ticket_booking',
                ]
            );
        }
        if ( version_compare($context->getVersion(), '1.0.3', '<' )){
            $eavSetup = $this->EavSetup->create(['setup' => $setup]);
            $fieldList = [
                'price',
                'special_price',
                'special_from_date',
                'special_to_date',
                'minimal_price',
                'cost',
                'tier_price',
                'weight',
            ];

            foreach ($fieldList as $field) {
                $applyTo = explode(
                    ',',
                    $eavSetup->getAttribute(\Magento\Catalog\Model\Product::ENTITY, $field, 'apply_to')
                );
                if (!in_array('ticket_booking', $applyTo)) {
                    $applyTo[] = 'ticket_booking';
                    $eavSetup->updateAttribute(
                        \Magento\Catalog\Model\Product::ENTITY,
                        $field,
                        'apply_to',
                        implode(',', $applyTo)
                    );
                }
            }
        }
        if ( version_compare($context->getVersion(), '1.0.1', '<' )) {
            $eavSetup = $this->EavSetup->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'time',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => false,
                    'required' => true,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'unique' => false,
                    'apply_to' => 'ticket_booking',
                ]
            )->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'date',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => false,
                    'required' => true,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'unique' => false,
                    'apply_to' => 'ticket_booking',
                ]
            )->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'number_plate',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => false,
                    'required' => true,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'unique' => false,
                    'apply_to' => 'ticket_booking',
                ]
            )->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'info',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => false,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'unique' => false,
                    'apply_to' => 'ticket_booking',
                ]
            )->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'date_start',
                [
                    'type' => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => false,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'unique' => false,
                    'apply_to' => 'ticket_booking',
                ]
            );
        }
    }
}
