<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml\District;

use Ticket\Directory\Controller\Adminhtml\District;

/**
 * Class NewAction
 * @package Ticket\Directory\Controller\Adminhtml\District
 */
class NewAction extends District
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
