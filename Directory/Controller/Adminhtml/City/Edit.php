<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml\City;

use Ticket\Directory\Controller\Adminhtml\City;
use Ticket\Directory\Model\CityFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Ticket\Directory\Block\Adminhtml\City\Edit as EditBlock;
use Magento\Framework\App\Cache\Type\Config;

/**
 * Class Edit
 * @package Ticket\Directory\Controller\Adminhtml\City
 */
class Edit extends City
{
	/**
	 * @var Registry
	 */
	protected $_registry;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CityFactory $cityFactory
     * @param Config $config
     * @param Registry $registry
     */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		CityFactory $cityFactory,
        Config $config,
		Registry $registry
	)
	{
		$this->_registry = $registry;
		parent::__construct($context, $resultPageFactory, $cityFactory, $config);
	}

	/**
	 * {@inheritdoc}
	 */
	public function execute()
	{
		$city = $this->_initObject();
		if (!$city) {
			$resultRedirect = $this->resultRedirectFactory->create();
			$resultRedirect->setPath('*');

			return $resultRedirect;
		}
		//Set entered data if was error when we do save
		$data = $this->_session->getData('city_form', true);
		if (!empty($data)) {
			$city->addData($data);
		}

		$this->_registry->register('current_city', $city);
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->_initAction();
		$resultPage->getConfig()->getTitle()->prepend($city->getId() ? __('Edit City \'%1\'', $city->getName()) : __('Create New City'));
		$resultPage->getLayout()->addBlock(EditBlock::class, 'city', 'content');

		return $resultPage;
	}
}
