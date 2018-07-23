<?php

namespace Dv\DiscountTitle\Plugin\Minicart;

use \Dv\DiscountTitle\Helper\Data as DvHelper;


class Name
{
    protected $dvhelper;
    protected $logger;
    protected $jsonHelper;

    public function __construct(DvHelper $dvhelper,
                                \Psr\Log\LoggerInterface $logger,
                                \Magento\Framework\Serialize\Serializer\Json $jsonHelper)
    {
        $this->dvhelper = $dvhelper;
        $this->logger = $logger;
        $this->jsonHelper = $jsonHelper;
    }

    public function aroundGetItemData($subject, $proceed, $item)
    {
        $result = $proceed($item);
        $result['product_name'] = $this->dvhelper->changeProductName($item);
        return $result;
    }
}