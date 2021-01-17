<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml\District;

use Ticket\Directory\Controller\Adminhtml\District;

/**
 * Class Delete
 * @package Ticket\Directory\Controller\Adminhtml\District
 */
class Delete extends District
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $district = $this->_initObject();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($district) {
            try {
                $district->delete();
                $this->reInitObject();
                $this->messageManager->addSuccessMessage(__('The district is deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $resultRedirect->setPath('*/*/*');
    }
}
