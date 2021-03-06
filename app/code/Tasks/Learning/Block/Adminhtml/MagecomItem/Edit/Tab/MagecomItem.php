<?php
/**
 * Magecom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@magecom.net so we can send you a copy immediately.
 *
 * @category Magecom
 * @package Magecom_Module
 * @copyright Copyright (c) 2017 Magecom, Inc. (http://www.magecom.net)
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Tasks\Learning\Block\Adminhtml\MagecomItem\Edit\Tab;

/**
 * Class MagecomItem
 * @package Tasks\Learning\Block\Adminhtml\MagecomItem\Edit\Tab
 */
class MagecomItem extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Wysiwyg config
     *
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * Country options
     *
     * @var \Magento\Config\Model\Config\Source\Locale\Country
     */
    protected $_countryOptions;

    /**
     * Country options
     *
     * @var \Tasks\Learning\Model\Config\Status
     */
    protected $_status;

    /**
     * constructor
     *
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Config\Model\Config\Source\Locale\Country $countryOptions
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Tasks\Learning\Model\Config\Status $status
     * @param array $data
     */
    public function __construct(
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Config\Model\Config\Source\Locale\Country $countryOptions,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Tasks\Learning\Model\Config\Status $status,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_countryOptions = $countryOptions;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Tasks\Learning\Model\MagecomItem $item */
        $item = $this->_coreRegistry->registry('tasks_learning_magecomitem');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('magecomitem_');
        $form->setFieldNameSuffix('magecomitem');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Item Information'),
                'class' => 'fieldset-wide'
            ]
        );
        if ($item->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                ['name' => 'id']
            );
        }
        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'content',
            'editor',
            [
                'name' => 'content',
                'label' => __('Item Content'),
                'title' => __('Item Content'),
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Item Content'),
                'title' => __('Item Content'),
                'values' => $this->_status->toOptionArray(),
            ]
        );

        $fieldset->addField(
            'url_key',
            'text',
            [
                'name' => 'url_key',
                'label' => __('URL Key'),
                'title' => __('URL Key'),
            ]
        );


        $itemData = $this->_session->getData('tasks_learning_magecomitem_data', true);
        if ($itemData) {
            $item->addData($itemData);
        } else {
            if (!$item->getId()) {
                $item->addData($item->getDefaultValues());
            }
        }
        $form->addValues($item->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('MagecomItem');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
