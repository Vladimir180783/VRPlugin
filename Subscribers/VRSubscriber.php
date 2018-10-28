<?php

namespace VRPlugin\Subscribers;

use Enlight\Event\SubscriberInterface;


class VRSubscriber implements SubscriberInterface
{

    public static function getSubscribedEvents()
    {
       return [
           'Enlight_Controller_Action_PreDispatch_Frontend_Test' => 'OnPreDispatchTest'
       ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * Inserting statistics
     * regarding hits for  Shopware_Controllers_Frontend_Test controller paths
     *
     */
    public function OnPreDispatchTest(\Enlight_Event_EventArgs $args)
    {
        //method does not exist ,so magic method __call is being called....
        $controller = $args->getSubject();

        $conn = $controller->get('dbal_connection');

        $conn->insert('s_statistics_currentusers',
            [
                'remoteaddr' => $_SERVER['REMOTE_ADDR'],
                'page' => $_SERVER['REQUEST_URI'],
                'time' => date('Y-m-d H:i:s'),
            ]);
    }
}
