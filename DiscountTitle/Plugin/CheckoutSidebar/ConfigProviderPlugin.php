<?php

namespace Dv\DiscountTitle\Plugin\CheckoutSidebar;

class ConfigProviderPlugin extends \Magento\Framework\Model\AbstractModel
{

    public function afterGetConfig(\Magento\Checkout\Model\DefaultConfigProvider $subject, array $result)
    {
        $items = $result['totalsData']['items'];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        for($i=0;$i<count($items);$i++){
            $quoteId = $items[$i]['item_id'];
            $quoteItem = $objectManager->create('\Magento\Quote\Model\Quote\Item')->load($quoteId);
            $items[$i]['name'] = $quoteItem->getName();
        }
        $result['totalsData']['items'] = $items;
        return $result;
    }

}
