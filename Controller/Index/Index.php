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
    private $_quoteFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */

    /**
     * @param \Magento\Framework\Controller\Result\JsonFactory
     */
    private $_jsonFactory;

    /**
     * @param \Magento\Framework\Serialize\Serializer\Json
     */
    private $_json;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Quote\Model\QuoteFactory $quoteFactory
    ) {
        $this->_pageFactory  = $pageFactory;
        $this->_json         = $json;
        $this->_jsonFactory  = $jsonFactory;
        $this->_quoteFactory = $quoteFactory;
        return parent:: __construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data     = $this->getRequest()->getContent();
        $response = $this->_json->unserialize($data);

        $quoteId = $response['quoteId'];
        $quote   = $this->_quoteRepository->get($quoteId);

        // Fill data
        $quote->setData('delivery_date', $response['date']);
        $quote->setData('delivery_comment', $response['comment']);

        // Save to quote table
        $this->_quoteRepository->save($quote);
        }
    }
}
