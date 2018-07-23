<?php
namespace Dv\DiscountTitle\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Dv\DiscountTitle\Helper\Data as DvHelper;

class ProductNameAfterAddtoCart implements ObserverInterface
{
    /**
     * @var \Dv\DiscountTitle\Helper\Data
     */
    protected $dvHelper;
    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $priceHelper;
    protected $checkoutSession;

    public function __construct(DvHelper $dvHelper, \Magento\Checkout\Model\Session $checkoutSession)
    {
        $this->dvHelper = $dvHelper;
        $this->checkoutSession = $checkoutSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote_item = $observer->getEvent()->getQuoteItem();
        $newName = $this->dvHelper->changeProductName($quote_item);

        if($newName) {
            $quote_item->setName($newName);
            $quote_item->getProduct()->setIsSuperMode(true);
        }
    }
}
