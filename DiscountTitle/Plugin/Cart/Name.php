<?php

namespace Dv\DiscountTitle\Plugin\Cart;

use \Dv\DiscountTitle\Helper\Data as DvHelper;

class Name
{

    protected $dvhelper;

    public function __construct(DvHelper $dvhelper)
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