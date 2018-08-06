<?php

namespace Namespace\DiscountTitle\Plugin\Cart;

use \Namespace\DiscountTitle\Helper\Data as Helper;

class Name
{

    protected $dvhelper;

    public function __construct(Helper $dvhelper)
    {
        $this->dvhelper = $dvhelper;
    }

    public function aroundGetProductName($item, $result)
    {
        $newName = $this->dvhelper->getQuoteItemName($item->getEntityId());
        if($newName) {
            $result = $newName;
        }
        return $result;
    }
}
