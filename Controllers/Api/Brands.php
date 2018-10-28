<?php

class Shopware_Controllers_Api_Brands extends Shopware_Controllers_Api_Rest
{

    protected $resource;

    /**
     * 'Init' method is called inside the constructor
     *  of the top inheritance class 'Enlight_Class'
     */
    public function init()
    {
        $this->resource = \Shopware\Components\Api\Manager::getResource('Brand');
    }

    /**
     * Get list of brands
     *
     * GET /api/brands/
     */
    public function indexAction()
    {
        $filter = $this->Request()->getParam('filter', []);

        $result = $this->resource->getList($filter);

        //Api controllers inherit from the shopware_controllers api rest.
        //It extends the enlight_action_controller,but
        //overrides predispatch and postdispatch method through which it defines
        //details regarding views,setting headers and json_encoding the results from the resources
        $this->View()->assign($result);
        $this->View()->assign('success', true);
    }

    /**
     * Get one brand
     *
     * GET /api/brands/{id}
     */
    public function getAction()
    {
        $id = $this->Request()->getParam('id');

        $brand = $this->resource->getOne($id);

        $this->View()->assign('data', $brand);
        $this->View()->assign('success', true);
    }

    /**
     * Create new brand
     *
     * POST /api/brands/
     */
    public function postAction()
    {
        $brand = $this->resource->create($this->Request()->getPost());

        $location = $this->apiBaseUrl . 'brands/' . $brand->getId();
        $data = [
            'id' => $brand->getId(),
            'location' => $location,
        ];

        $this->View()->assign(['success' => true, 'data' => $data]);
        $this->Response()->setHeader('Location', $location);
    }

    /**
     * Update brand
     *
     * PUT /api/brands/{id}
     */
    public function putAction()
    {
        $id = $this->Request()->getParam('id');
        $params = $this->Request()->getPost();
        $brand = $this->resource->update($id, $params);

        $location = $this->apiBaseUrl . 'brands/' . $brand->getId();
        $data = [
            'id' => $brand->getId(),
            'location' => $location,
        ];

        $this->View()->assign(['success' => true, 'data' => $data]);
        $this->Response()->setHeader('Location', $location);
    }

    /**
     * Delete brand
     *
     * DELETE /api/brands/{id}
     */
    public function deleteAction()
    {
        $id = $this->Request()->getParam('id');

        $this->resource->delete($id);

        $this->View()->assign(['success' => true]);
    }
}
