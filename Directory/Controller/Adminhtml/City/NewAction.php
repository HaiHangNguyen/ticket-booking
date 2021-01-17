<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml\City;

use Ticket\Directory\Controller\Adminhtml\City;

/**
 * Class NewAction
 * @package Ticket\Directory\Controller\Adminhtml\City
 */
class NewAction extends City
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
