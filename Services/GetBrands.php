<?php

namespace VRPlugin\Services;

use Shopware\Components\Model\ModelManager;

class GetBrands
{
    private $manager;

    /**
     * GetBrands constructor.
     * @param ModelManager $manager
     */
    public function __construct(ModelManager $manager)
    {
        $this->manager = $manager;
    }

    public function getBrands()
    {
        //get everything through doctrine ORM....
        $queryBuilder = $this->manager->createQueryBuilder();

        $queryBuilder->select(['brands'])->from('VRPlugin\Models\Brand','brands');

        $query = $queryBuilder->getQuery();

        $result = $query->setHydrationMode(1)->execute();

        return $result;

    }
}