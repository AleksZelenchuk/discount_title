<?php
namespace Dv\DiscountTitle\Helper;

use Braintree\Exception;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use \Magento\Framework\App\Helper\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $priceHelper;
    protected $checkoutSession;
    protected $logger;
    protected $jsonHelper;
    protected $itemManager;
    /**
     * Data constructor.
     * @param Context $context
     * @param PriceHelper $priceHelper
     */
    public function __construct(Context $context,
                                PriceHelper $priceHelper,
                                \Magento\Checkout\Model\Session $checkoutSession,
                                \Magento\Framework\Serialize\Serializer\Json $jsonHelper,
                                \Psr\Log\LoggerInterface $logger,
                                \Magento\Quote\Model\Quote\Item $itemManager)
    {
        parent::__construct($context);
        $this->priceHelper = $priceHelper;
        $this->checkoutSession = $checkoutSession;
        $this->logger = $logger;
        $this->jsonHelper = $jsonHelper;
        $this->itemManager = $itemManager;
    }

    public function changeProductName($item, $qty = null, $name = null)
    {
        if(!empty($item->getItemId())) {
                $product = !empty($item->getProduct()->getEntityId()) ? $item->getProduct() : $item;

                $primaryPrice = $product->getPrice();
                $formatedPrimaryPrice = $finalPrice = $this->priceHelper->currency(number_format($primaryPrice, 2), true, false);
                $finalPrice = $product->getFinalPrice();
                $productName = $product->getData('name');


                if ($name) {
                    $productName = $name;
                }

                if (!$qty) {
                    $qty = $item->getQty();
                }
                if ($primaryPrice > $finalPrice) {
                    $discountAmount = 100 - ($finalPrice / $primaryPrice) * 100;
                }

                $tierPrices = $product->getTierPrice();

                $fPrice = '';
                if (count($tierPrices) > 0) {
                    end($tierPrices);
                    $lastElKey = key($tierPrices);
                    if (!($qty < $tierPrices[0]['price_qty'])) {
                        foreach ($tierPrices as $index => $tierPrice) {
                            if ($qty >= $tierPrice['price_qty']) {
                                if ($index != $lastElKey) {
                                    if ($qty < $tierPrices[$index + 1]['price_qty']) {
                                        $fPrice = $tierPrice['website_price'];
                                    } else {
                                        continue;
                                    }
                                } else {
                                    $fPrice = $tierPrice['website_price'];
                                }
                            }
                        }
                        $discountAmount = 100 - ($fPrice / $primaryPrice) * 100;
                    }
                }

                if (!empty($discountAmount)) {
                    $roundPercent = $this->roundAmount($discountAmount);
                    $message = $product->getData('name') . __(" (Listenpreis: %1", $formatedPrimaryPrice) . " – " . __("Rabatt: %1%", $roundPercent) . ")";

                    return $message;
                }
                return $productName;
        }
    }

    public function roundAmount($amount)
    {
        return round($amount, 0);
    }
    public function getQuoteItemName($quoteItemId){
        try {
            return $this->itemManager->load($quoteItemId)->getName();
        }catch (Exception $e){
            return false;
        }
    }
}