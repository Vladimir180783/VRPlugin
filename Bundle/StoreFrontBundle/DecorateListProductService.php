<?php

namespace VRPlugin\Bundle\StoreFrontBundle;

use Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct;

/**
 * Class DecorateListProductService
 *
 * example of decorating an existing service ListProductInterface
 * default service is injected via constructor
 *
 * @package VRPlugin\Bundle\StoreFrontBundle
 */
class DecorateListProductService implements ListProductServiceInterface
{

    private $defaultservice;

    /**
     * DecorateListProductService constructor.
     * @param ListProductServiceInterface $defaultservice
     */
    public function __construct(ListProductServiceInterface $defaultservice)
    {
        $this->defaultservice = $defaultservice;
    }

    /**
     *
     * Returning array of ListProduct objects ,but unsets each with min stock equals to 0 ,
     *just as example of how decorated servis can be used
     *
     * @see \Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface::get()
     *
     * @param array $numbers
     * @param Struct\ProductContextInterface $context
     *
     * @return Struct\ListProduct[] indexed by the product order number
     */
    public function getList(array $numbers, Struct\ProductContextInterface $context)
    {
        // just to see how defult service works
        //return $this->defaultservice->getList($numbers, $context);

        //using default service to get products
        $existingProducts = $this->defaultservice->getList($numbers, $context);

        //return only products with minStock not equals 0
        foreach ($existingProducts as $key => $product) {

            if ($product->getMinStock() == 0)

                unset ($existingProducts[$key]);
        }

        return $existingProducts;


    }

    /**
     * Returns a full \Shopware\Bundle\StoreFrontBundle\Struct\ListProduct object.
     * A list product contains all required data to display products in small views like listings, sliders or emotions.
     *
     * @param string $number
     * @param Struct\ProductContextInterface $context
     *
     * @return Struct\ListProduct
     */
    public function get($number, Struct\ProductContextInterface $context)
    {
        // TODO: Implement get() method.
    }


}