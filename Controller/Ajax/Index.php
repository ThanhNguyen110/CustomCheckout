<?php

namespace AHT\CustomCheckout\Controller\Ajax;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     */
    private $quoteFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Quote\Model\QuoteFactory $quoteFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->json = $json;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->quoteFactory = $quoteFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getContent();
        $response = $this->json->unserialize($data);
        var_dump($response);

        if (!empty($response)) {
            $quote = $this->quoteFactory->create();
            $obj = $quote->load($response['quoteId']);
            $obj->setData('delivery_date', $response['date']);
            $obj->setData('delivery_comment', $response['comment']);
            $quote->save($obj);

            var_dump($quote->getData());
        }
    }
}
