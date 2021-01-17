<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Block\Adminhtml\Ward\Edit;

use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Ticket\Directory\Model\ResourceModel\District\CollectionFactory;

/**
 * Class Form
 *
 * @package Ticket\Directory\Block\Adminhtml\Ward\Edit
 */
class Form extends Generic
{
    /**
     * @var CollectionFactory
     */
    protected $_districtCollectionFactory;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param CollectionFactory $districtCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        CollectionFactory $districtCollectionFactory,
        array $data = []
    ) {
        $this->_districtCollectionFactory = $districtCollectionFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $form->setMethod('post');

        $ward = $this->retrieveModel();
        $dashboard = $form->addFieldset('base_fieldset', ['legend' => __('Ward Information')]);

        if ($ward->getId()) {
            $dashboard->addField('ward_id', 'hidden', ['name' => 'id']);
        }
        $disabled = !empty($ward->getId());

        $dashboard->addField(
            'district_id', 'select', [
            'name' => 'district_id',
            'label' => __('District'),
            'title' => __('District'),
            'values' => $this->_districtCollectionFactory->create()->toOptionArray(),
            'required' => true,
            'disabled' => $disabled
        ]);

        $dashboard->addField(
            'name', 'text', [
            'name' => 'name',
            'title' => __('Name'),
            'label' => __('Name'),
            'required' => true
        ]);

        $dashboard->addField(
            'default_name', 'text', [
            'name' => 'default_name',
            'title' => __('Full Name'),
            'label' => __('FullName'),
            'required' => true
        ]);

        $dashboard->addField(
            'code', 'text', [
            'name' => 'code',
            'title' => __('Code'),
            'label' => __('Code'),
            'required' => true,
            'disabled' => $disabled
        ]);

        $form->setValues($ward->getData());
        $this->setForm($form);
    }

    /**
     * Retrieve Model
     *
     * @return \Ticket\Guarantee\Model\Guarantee\Request
     */
    public function retrieveModel()
    {
        return $this->_coreRegistry->registry('current_ward');
    }
}
