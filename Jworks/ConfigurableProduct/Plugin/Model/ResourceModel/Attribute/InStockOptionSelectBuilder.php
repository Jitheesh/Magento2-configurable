<?php

namespace Jworks\ConfigurableProduct\Plugin\Model\ResourceModel\Attribute;

use Magento\CatalogInventory\Model\ResourceModel\Stock\Status;
use Magento\ConfigurableProduct\Model\ResourceModel\Attribute\OptionSelectBuilderInterface;
use Magento\Framework\DB\Select;

/**
 * Plugin for OptionSelectBuilderInterface to add stock status filter.
 */
class InStockOptionSelectBuilder
{
    /**
     * CatalogInventory Stock Status Resource Model.
     *
     * @var Status
     */
    private $stockStatusResource;
    
    /**
     * @param Status $stockStatusResource
     */
    public function __construct(Status $stockStatusResource)
    {
        $this->stockStatusResource = $stockStatusResource;
    }

    /**
     * Add stock status filter to select.
     *
     * @param OptionSelectBuilderInterface $subject
     * @param Select $select
     * @return Select
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetSelect(OptionSelectBuilderInterface $subject, Select $select)
    {
        $select->joinInner(
            ['stock' => $this->stockStatusResource->getMainTable()],
            'stock.product_id = entity.entity_id',
            ['stock.stock_status']
        );
        
        return $select;
    }
}
