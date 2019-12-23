<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   Ajax Compare
 */
namespace Boolfly\AjaxCompare\Plugin;

use Magento\Catalog\Controller\Product\Compare;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class ProductCompareControllerPlugin
 *
 * @package Boolfly\AjaxCompare\Plugin\Catalog\Helper
 * @see \Magento\Catalog\Controller\Product\Compare\Clear
 * @see \Magento\Catalog\Controller\Product\Compare\Add
 */
class ProductCompareControllerPlugin
{
    /**
     * @var Json
     */
    private $resultJson;

    /**
     * ProductCompareControllerPlugin constructor.
     *
     * @param Json $resultJson
     */
    public function __construct(
        Json $resultJson
    ) {
        $this->resultJson = $resultJson;
    }

    /**
     * @param Compare $subject
     * @param ResultInterface $result
     * @return ResultInterface
     */
    public function afterExecute(Compare $subject, ResultInterface $result)
    {
        if ($subject->getRequest()->getParam('isAjax', false)) {
            return $this->resultJson->setData([
                'errors' => false,
                'messages' => __('Success')
            ]);
        }

        return $result;
    }
}
