<?php
namespace Dv\DiscountTitle\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Dv\DiscountTitle\Helper\Data as DvHelper;

class BeforeOrderSave implements ObserverInterface
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
    protected $logger;

    public function __construct(DvHelper $dvHelper,
                                \Magento\Checkout\Model\Session $checkoutSession,
                                \Psr\Log\LoggerInterface $logger)
    {
        $this->dvHelper = $dvHelper;
        $this->checkoutSession = $checkoutSession;
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getQuote()->getAllItems();

        foreach ($quote as $item) {
            $newName = $this->dvHelper->changeProductName($item);
            if($newName) {
                $item->setName($newName);
                $item->getProduct()->setIsSuperMode(true);
            }
        }
    }
}
