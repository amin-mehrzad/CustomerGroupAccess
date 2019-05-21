<?php

namespace XCode\CustomerGroupAccess\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Install DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //$quote = 'quote';
        $orderTable = 'sales_order';
        $orderGridTable = 'sales_order_grid';

        //Order Grid table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'sales_representative',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Sales Representative Name'
                ]
            );

            $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderGridTable),
                'sales_representative',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Sales Representative Name'
                ]
            );

        $setup->endSetup();
    }
}