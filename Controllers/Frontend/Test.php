<?php

class Shopware_Controllers_Frontend_Test extends Enlight_Controller_Action
{

    /**
     * @var \Shopware\Components\Api\Resource\Resource|\VRPlugin\Components\API\Resource\Brand
     */
    private $resource;

    /**
     * Shopware_Controllers_Frontend_Test constructor.
     * @param Enlight_Controller_Request_Request $request
     * @param Enlight_Controller_Response_Response $response
     * @throws Enlight_Event_Exception
     * @throws Enlight_Exception
     */

    public function __construct(Enlight_Controller_Request_Request $request, Enlight_Controller_Response_Response $response)
    {
        parent::__construct($request, $response);
        //set DI
        $this->resource = \Shopware\Components\Api\Manager::getResource('Brand');
    }

    /**
     * Disable the template loading
     */
    public function preDispatch()
    {
        $this->Front()->Plugins()->ViewRenderer()->setNoRender(true);

    }

    /**
     * Listing brands
     */
    public function listAction()
    {
        //this can be done via container also , no need to inject via constructor
        //$brands = $this->get('shopware.api.brand');
        $brands = $this->resource->getList(null);

        echo '<pre>';
        print_r($brands);
    }

    /**
     * Reads brand based on id
     */
    public function readAction()
    {
        $brands = $this->resource->getOne($this->Request()->getParam('id'));

        echo '<pre>';
        print_r($brands);
    }



    /**
     * Create brand
     */
    public function createAction()
    {
        $data = [
            'name' => 'Brand from api',
            'active' => true,
            'story' => 'I am created via api call no. ' . rand(0,10),
        ];
        $brand = $this->resource->create($data);
        echo "Created brand with id {$brand->getId()} named {$brand->getName()}";
    }

        /**
         * Update brand
         */
        public function updateAction()
    {
        $bundle = $this->resource->update($this->Request()->getParam('id'),
            [
                'story' => 'I am updated via upi',
                'active' => rand(0, 1)
            ]);

        echo $bundle->getActive() ? 'active' : 'inactive';
    }

        /**
         * Delete brand
         */
        public function deleteAction()
    {
        $this->resource->delete($this->Request()->getParam('id'));

        echo 'Brand was deleted';
    }

    /**
     * @throws Exception
     *
     * test action for decorating existing service list_product_service
     *
     */
        public function decorateAction()
        {

            //getting context
            $context = $this->container->get('shopware_storefront.context_service')->getShopContext();

            //array of order numbers in s_articles_details
            $array = ['SW10001','SW10002'];

            //returning from decorated service the list of products based on context and order numbers that are passed
            $result = $this->get('vrplugin_bundle_store_front.list_product_service')->getList($array, $context);


            echo '<pre>';
            var_dump($result);
        }

    }
