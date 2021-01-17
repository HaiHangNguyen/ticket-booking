<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml\Ward;

use Ticket\Directory\Controller\Adminhtml\Ward;

/**
 * Class Delete
 * @package Ticket\Directory\Controller\Adminhtml\Ward
 */
class Delete extends Ward
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $ward = $this->_initObject();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($ward) {
            try {
                $ward->delete();
                $this->reInitObject();
                $this->messageManager->addSuccessMessage(__('The ward is deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $resultRedirect->setPath('*/*/*');
    }
}
