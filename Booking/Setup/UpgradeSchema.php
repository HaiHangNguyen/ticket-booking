<?php

namespace Ticket\Booking\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (version_compare($context->getVersion(), '1.0.4') < 0) {
            $tableName = 'ticket_booking_seats';
            $table = $installer->getConnection()->newTable(
                $installer->getTable($tableName))
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'ID'
                )->addColumn(
                    'product_booking_item_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true],
                    'Product Id'
                )->addColumn(
                    'seats',
                    Table::TYPE_TEXT,
                    null,
                    [],
                    'Seats'
                )->addColumn(
                    'status',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true],
                    'Status'
                );
            $installer->getConnection()->createTable($table);
        }
        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            $tableName = 'ticket_booking_orders';
            $table = $installer->getConnection()->newTable(
                $installer->getTable($tableName))
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'ID'
                )
                ->addColumn(
                    'order_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Order ID'
                )
                ->addColumn(
                    'order_item_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Order item ID'
                )
                ->addColumn(
                    'order_item_name',
                    Table::TYPE_TEXT,
                    null,
                    [],
                    'Order item name'
                )->addColumn(
                    'order_item_amount',
                    Table::TYPE_DECIMAL,
                    null,
                    [],
                    'Order item amount'
                )->addColumn(
                    'order_item_type',
                    Table::TYPE_TEXT,
                    null,
                    [],
                    'Order item type'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Customer ID'
                )
                ->addColumn(
                    'customer_email',
                    Table::TYPE_TEXT,
                    null,
                    [],
                    'Customer email'
                )
                ->addColumn(
                    'customer_name',
                    Table::TYPE_TEXT,
                    null,
                    [],
                    'Customer name'
                )
                ->addColumn(
                    'time',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Time'
                )
                ->addColumn(
                    'date',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Date'
                )
                ->addColumn(
                    'slots',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Slots'
                )->addColumn(
                    'seats',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Seats'
                )->setComment('Product orders table');
            $installer->getConnection()->createTable($table);
        }
        if (version_compare($context->getVersion(), '1.0.5') < 0) {
            $tableName = 'ticket_booking_items';
            $table = $installer->getConnection()->newTable(
                $installer->getTable($tableName))
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'ID'
                )->addColumn(
                    'product_booking_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true],
                    'Product Id'
                )->addColumn(
                    'date',
                    Table::TYPE_DATE,
                    null,
                    ['nullable' => false],
                    'Date'
                )->setComment('Product orders table');

            $installer->getConnection()->createTable($table);
        }
    }
}
