<?php

class Shopware_Controllers_Frontend_GetBrandService extends Enlight_Controller_Action
{
    public function preDispatch()
    {
        $this->Front()->Plugins()->ViewRenderer()->setNoRender();
    }

    /**
     *
     * getting brands through custom service
     *
     * @throws Exception
     */
    public function indexAction()
    {
        $service = $this->get('vrplugin.services.get_brands');

        echo '<pre>';
        var_dump($service->getBrands());

    }


}