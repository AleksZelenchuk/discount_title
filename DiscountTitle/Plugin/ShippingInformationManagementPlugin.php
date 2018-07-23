<?php
namespace Dv\DiscountTitle\Plugin;

class ShippingInformationManagementPlugin
{
    protected $checkoutSession;
    protected $logger;
    protected $jsonHelper;
    protected $quoteRepository;
    protected $dvHelper;

    public function __construct(\Dv\DiscountTitle\Helper\Data $dvHelper,
                                \Magento\Quote\Model\QuoteRepository $quoteRepository)
    {
        $this->dvHelper = $dvHelper;
        $this->quoteRepository = $quoteRepository;
    }

    public function aroundSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        callable $proceed,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        $quote = $this->quoteRepository->getActive($cartId);
        $items = $quote->getAllVisibleItems();
        $result =  $proceed ($cartId, $addressInformation);
        foreach ($items as $item){
            $newName = $this->dvHelper->changeProductName($item);
            if($newName) {
                $item->setName($newName);
                $item->save();
            }
        }

        return $result;
    }
}