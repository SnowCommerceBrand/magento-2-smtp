<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Smtp
 * @copyright   Copyright (c) 2017-2018 Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\Smtp\Ui\Component\Listing\Column;

use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class ViewAction
 * @package Mageplaza\Smtp\Ui\Component\Listing\Column
 */
class ViewAction extends Column
{
    /**
     * @var \Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder
     */
    private $actionUrlBuilder;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item['subject'] = iconv_mime_decode($item['subject'], 0, 'UTF-8');
                $name = $this->getData('name');

                $item[$name]['view'] = [
                    'href' => '#',
                    'label' => __('View'),
                    'class' => 'action-menu-item mpview',
                    'confirm' => [
                        'title' => __('Resend %1', $item['subject']),
                        'message' => __('Are you sure you want to resend the <strong>%1</strong>?', $item['subject'])
                    ]
                ];

                $item[$name]['resend'] = [
                    'href' => $this->urlBuilder->getUrl('adminhtml/smtp/email', ['id' => $item['id']]),
                    'label' => __('Resend'),
                    'class' => 'action-menu-item mpresend',
                    'confirm' => [
                        'title' => __('Resend %1', $item['subject']),
                        'message' => __('Are you sure you want to resend the <strong>%1</strong>?', $item['subject'])
                    ]
                ];

                $item[$name]['delete'] = [
                    'href' => $this->urlBuilder->getUrl('adminhtml/smtp/delete', ['id' => $item['id']]),
                    'label' => __('Delete'),
                    'class' => 'action-menu-item mpdelete',
                    'confirm' => [
                        'title' => __('Delete %1', $item['subject']),
                        'message' => __('Are you sure you want to delete the <strong>%1</strong>?', $item['subject'])
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
