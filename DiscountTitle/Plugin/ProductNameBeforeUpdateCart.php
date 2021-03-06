<?php
namespace Namespace\DiscountTitle\Plugin;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use \Magento\Framework\Message\ManagerInterface ;
use \Namespace\DiscountTitle\Helper\Data as Helper;

class ProductNameBeforeUpdateCart
{

    /**
     * @var ManagerInterface
     */
    protected $_messageManager;

    /**
     * @var \Magento\Quote\Model\Quote
     */
    protected $quote;

    /**
     * @var \Namespace\DiscountTitle\Helper\Data
     */
    protected $dvHelper;
    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $priceHelper;

    /**
     * ProductNameAfterAddtoCart constructor.
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param ManagerInterface $messageManager
     * @param Helper $dvHelper
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        ManagerInterface $messageManager,
        Helper $dvHelper
    ) {
        $this->quote = $checkoutSession->getQuote();
        $this->_messageManager = $messageManager;
        $this->dvHelper = $dvHelper;
    }

    public function beforeupdateItems(\Magento\Checkout\Model\Cart $subject,$data)
    {
        $quote = $subject->getQuote();
        foreach($data as $key=>$value){
            $item = $quote->getItemById($key);
            if($item) {
                $itemQty = $value['qty'];
                $newName = $this->dvHelper->changeProductName($item, $itemQty);;
                if ($newName) {
                    $item->setName($newName);
                    $item->getProduct()->setIsSuperMode(true);
                }
            }
        }
        return [$data];

    }
}
