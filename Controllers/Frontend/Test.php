<?php

class Shopware_Controllers_Frontend_Test extends Enlight_Controller_Action
{

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

    }
