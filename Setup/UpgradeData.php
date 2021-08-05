<?php

namespace AHT\CustomCheckout\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    public function __construct(
        EavSetup $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.10') < 0) {
            $setup->startSetup();
            $this->eavSetupFactory->updateAttribute(2, 27, 'is_required', 1);

            $arr = [
                'delivery_date'    => [
                    'type' => 'datetime',
                    'nullable' => false,
                    'comment' => 'Delivery Date',
                ],

                'delivery_comment' => [
                    'type' => 'text',
                    'nullable' => false,
                    'comment' => 'Delivery Comment',
                ]
            ];
            foreach ($arr as $key => $value) {
                $setup->startSetup()->getConnection()->addColumn($setup->startSetup()->getTable('quote'), $key, $value);
                $setup->startSetup()->getConnection()->addColumn($setup->startSetup()->getTable('sales_order'), $key, $value);
            }
            $setup->endSetup();
        }
    }
}
