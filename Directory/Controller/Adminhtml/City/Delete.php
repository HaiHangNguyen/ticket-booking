<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml\City;

use Ticket\Directory\Controller\Adminhtml\City;

/**
 * Class Delete
 * @package Ticket\Directory\Controller\Adminhtml\City
 */
class Delete extends City
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $city = $this->_initObject();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($city) {
            try {
                $city->delete();
                $this->reInitObject();
                $this->messageManager->addSuccessMessage(__('The city is deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $resultRedirect->setPath('*/*/*');
    }
}
