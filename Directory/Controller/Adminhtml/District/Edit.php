<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml\District;

use Ticket\Directory\Controller\Adminhtml\District;
use Ticket\Directory\Model\DistrictFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Ticket\Directory\Block\Adminhtml\District\Edit as EditBlock;
use Magento\Framework\App\Cache\Type\Config;

/**
 * Class Edit
 * @package Ticket\Directory\Controller\Adminhtml\District
 */
class Edit extends District
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
     * @param DistrictFactory $districtFactory
     * @param Registry $registry
     * @param Config $config
     */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		DistrictFactory $districtFactory,
		Registry $registry,
        Config $config
	)
	{
		$this->_registry = $registry;
		parent::__construct($context, $resultPageFactory, $districtFactory, $config);
	}

	/**
	 * {@inheritdoc}
	 */
	public function execute()
	{
		$district = $this->_initObject();
		if (!$district) {
			$resultRedirect = $this->resultRedirectFactory->create();
			$resultRedirect->setPath('*');

			return $resultRedirect;
		}
		//Set entered data if was error when we do save
		$data = $this->_session->getData('district_form', true);
		if (!empty($data)) {
			$district->addData($data);
		}

		$this->_registry->register('current_district', $district);
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->_initAction();
		$resultPage->getConfig()->getTitle()->prepend($district->getId() ? __('Edit District \'%1\'', $district->getName()) : __('Create New District'));
		$resultPage->getLayout()->addBlock(EditBlock::class, 'district', 'content');

		return $resultPage;
	}
}
