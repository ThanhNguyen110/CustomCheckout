<?php

namespace AHT\CustomCheckout\Controller\Index;

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
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     */
    private $_quoteRepository;

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
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Quote\Model\QuoteFactory $quoteFactory
    ) {
        $this->_pageFactory     = $pageFactory;
        $this->_quoteRepository = $quoteRepository;
        $this->_json            = $json;
        $this->_jsonFactory     = $jsonFactory;
        $this->_quoteFactory    = $quoteFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // Get value from AJAX request
        $data     = $this->getRequest()->getContent();
        // Convert Json to Array
        $response = $this->_json->unserialize($data);

        $quoteId = $response['quoteId'];
        $quote   = $this->_quoteRepository->get($quoteId);

        // Fill data
        $quote->setData('delivery_date', $response['date']);
        $quote->setData('delivery_comment', $response['comment']);
        // Save to quote table
        $this->_quoteRepository->save($quote);
        return  var_dump($this->_quoteRepository->save($quote));
    }
}
