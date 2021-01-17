<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml\Ward;

use Ticket\Directory\Controller\Adminhtml\Ward;

/**
 * Class NewAction
 * @package Ticket\Directory\Controller\Adminhtml\Ward
 */
class NewAction extends Ward
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
