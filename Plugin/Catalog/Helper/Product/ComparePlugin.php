<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   Ajax Compare
 */
namespace Boolfly\AjaxCompare\Plugin\Catalog\Helper\Product;

use Magento\Catalog\Helper\Product\Compare as HelperCompare;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\Helper\PostHelper;

/**
 * Class ComparePlugin
 *
 * @package Boolfly\AjaxCompare\Plugin\Catalog\Helper\Product
 * @see HelperCompare
 */
class ComparePlugin
{
    /**
     * @var PostHelper
     */
    protected $postHelper;

    /**
     * @var Http|RequestInterface
     */
    protected $request;

    /**
     * @var bool
     */
    protected $isComparePage;

    /**
     * Compare constructor.
     *
     * @param PostHelper       $postHelper
     * @param RequestInterface $request
     */
    public function __construct(
        PostHelper $postHelper,
        RequestInterface $request
    ) {
        $this->postHelper = $postHelper;
        $this->request = $request;
    }

    /**
     * Check Is Compare Page
     *
     * @return boolean
     */
    private function isComparePage()
    {
        if ($this->isComparePage === null) {
            $this->isComparePage = $this->request->getFullActionName() === 'catalog_product_compare_index';
        }

        return $this->isComparePage;
    }

    /**
     * Check Is Product Page
     *
     * @return boolean
     */
    private function isProductPage()
    {
        return $this->request->getFullActionName() === 'catalog_product_view';
    }

    /**
     * @param HelperCompare $subject
     * @param $result
     * @param Product $product
     * @return string
     */
    public function afterGetPostDataRemove(HelperCompare $subject, $result, $product)
    {
        return $this->isComparePage() ? $result : $this->postHelper->getPostData($subject->getRemoveUrl(), [
            ActionInterface::PARAM_NAME_URL_ENCODED => '',
            'product'   => $product->getId(),
            'isAjax'    =>  true,
            'showLoader' => true
        ]);
    }

    /**
     * @param HelperCompare $subject
     * @param $result
     * @return string
     */
    public function afterGetPostDataClearList(HelperCompare $subject, $result)
    {
        return $this->isComparePage() ? $result : $this->postHelper->getPostData($subject->getClearListUrl(), [
            ActionInterface::PARAM_NAME_URL_ENCODED => '',
            'isAjax'    =>  true,
            'showLoader' => true
        ]);
    }

    /**
     * @param HelperCompare $subject
     * @param $result
     * @param Product $product
     * @return string
     */
    public function afterGetPostDataParams(HelperCompare $subject, $result, $product)
    {
        return $this->isComparePage() ? $result : $this->postHelper->getPostData($subject->getAddUrl(), [
            'product' => $product->getId(),
            'isAjax' => true,
            'showLoader' => $this->isProductPage()
        ]);
    }
}
