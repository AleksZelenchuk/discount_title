<?php
namespace Dv\DiscountTitle\Plugin\Cart;

use \Magento\Quote\Model\Quote\Item\AbstractItem;

class Totals
{
    protected $itemManager;

    public function __construct(\Magento\Quote\Model\Quote\Item $itemManager)
    {
        $this->itemManager = $itemManager;
    }

    public function afterGetItems(\Magento\Quote\Model\Cart\Totals $subject, $result)
    {
        if(isset($result) && !empty($result)){
            foreach ($result as $item){
                if($itemId = $item->getItemId()) {
                    $quoteItem = $this->itemManager->load($itemId);
                    $item->setName($quoteItem->getName());
                }
            }
        }
        return $result;
    }
}