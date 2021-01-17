<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Model;

/**
 * Interface ValidatorInterface
 * @package Ticket\Directory\Model
 */
interface ValidatorInterface
{
    /**
     * Get require fields
     *
     * @return array
     */
    public function getRequiredUniqueFields();
}
