<?php

namespace Namespace\DiscountTitle\Plugin\Minicart;

use \Namespace\DiscountTitle\Helper\Data as Helper;


class Name
{
    protected $dvhelper;
    protected $logger;
    protected $jsonHelper;

    public function __construct(Helper $dvhelper,
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
