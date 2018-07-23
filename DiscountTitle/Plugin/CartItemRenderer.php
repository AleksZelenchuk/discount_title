<?php
namespace Dv\DiscountTitle\Plugin;
use \Magento\Quote\Model\Quote\Item\AbstractItem;
class CartItemRenderer
{
    protected $checkoutSession;
    protected $logger;
    protected $jsonHelper;
    protected $quoteRepository;
    protected $dvHelper;
    protected $item;

    public function __construct(\Dv\DiscountTitle\Helper\Data $dvHelper,
                                \Magento\Framework\Serialize\Serializer\Json $jsonHelper,
                                \Psr\Log\LoggerInterface $logger,
                                \Magento\Quote\Model\QuoteRepository $quoteRepository,
                                \Magento\Quote\Model\Quote\Item $item)
    {
        $this->dvHelper = $dvHelper;
        $this->logger = $logger;
        $this->jsonHelper = $jsonHelper;
        $this->quoteRepository = $quoteRepository;
        $this->item = $item;
    }

   /* public function beforeGetItem(\Magento\Checkout\Block\Cart\Item\Renderer $subject, $item) {

        //$newName = $this->dvHelper->changeProductName($item);
        //var_dump($newName);die;
        //$result->getProduct()->setName($newName);
        //$item->setName($newName);
        return [$item];
    }*/
}