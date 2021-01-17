<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ticket\Directory\Block\Adminhtml\Plugin\Order\Create\Form;

use Ticket\Directory\Block\Adminhtml\Plugin\Edit\Renderer\Directory;
use Magento\Framework\Data\Form;

/**
 * Class Address
 * @package Ticket\Directory\Block\Adminhtml\Plugin\Order\Create\Form
 */
class Address
{
    /**
     * After get Form
     *
     * @param \Magento\Sales\Block\Adminhtml\Order\Create\Form\Address $subject
     * @param Form $form
     * @return Form
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterGetForm(
        \Magento\Sales\Block\Adminhtml\Order\Create\Form\Address $subject,
        Form $form
    )
    {
        $renderer = $subject->getLayout()->createBlock(Directory::class)
            ->setHtmlIdPrefix($form->getHtmlIdPrefix())
            ->setHtmlNamePrefix($form->getHtmlNamePrefix())
            ->setFormValues($subject->getFormValues());

        $form->getElement('main')
            ->removeField('city')->removeField('city_id')
            ->removeField('district')->removeField('district_id')
            ->removeField('ward')->removeField('ward_id')
            ->removeField('region')
            ->removeField('directory')
            ->addField('directory', 'text', [], 'street')->setRenderer($renderer);

        $form->getElement('country_id')->setValue('VN');

        return $form;
    }
}
