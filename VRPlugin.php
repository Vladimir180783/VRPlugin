<?php

namespace VRPlugin;

use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Plugin;

class VRPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function install(Plugin\Context\InstallContext $context)
    {
        $this->updateSchema();
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(Plugin\Context\UninstallContext $context)
    {
        $tool = new SchemaTool($this->container->get('models'));
        $classes = $this->getModelMetaData();
        $tool->dropSchema($classes);
    }

    private function updateSchema()
    {
        $tool = new SchemaTool($this->container->get('models'));
        $classes = $this->getModelMetaData();

        try {
            $tool->dropSchema($classes);
        } catch (\Exception $e) {
        }

        $tool->createSchema($classes);
        $this->createDemoData();
    }

    /**
     * @return array
     */
    private function getModelMetaData()
    {
        return [$this->container->get('models')->getClassMetadata(Models\Brand::class)];
    }

    private function createDemoData()
    {
        $connection = $this->container->get('dbal_connection');

        $connection->executeUpdate('DELETE FROM s_brands');

        for ($i = 1; $i < 20; ++$i) {
            $connection->insert(
                's_brands',
                [
                    'name' => 'Brand ' . $i,
                    'story' => 'Story about brand no. ' . $i,
                    'active' => true,
                ]
            );


        }
    }
}
