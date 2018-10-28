<?php

namespace VRPlugin\Components\API\Resource;

use Shopware\Components\Api\Resource\Resource;

class Brand extends Resource
{
    /**
     * @param int $offset
     * @param string $filter
     * @return array
     */
    public function getList($filter)
    {
        $builder = $this->baseQuery();

        if(!empty($filter))
            $builder->where('brand.story = :story')->setParameter('story',$filter);

        $query = $builder->getQuery();

        $query->setHydrationMode($this->getResultMode());

        $brands=$query->execute();

        $totalResult = count($brands);

        return ['data' => $brands, 'total' => $totalResult];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        $result =  $this->baseQuery()
            ->where('brand.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->setHydrationMode($this->getResultMode())
            ->execute();

        if(count($result))
            return $result;

        throw new \Exception('Article with id=' . $id . ' does not exist');
    }

    /**
     * @param $data
     * @return \VRPlugin\Models\Brand
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create($data)
    {
        $brandInstance = new \VRPlugin\Models\Brand();
        $brandInstance->fromArray($data);

        $this->getManager()->persist($brandInstance);
        $this->getManager()->flush();

        return $brandInstance;

    }

    public function update($id , array $data)
    {
        $brand = $this->helperForUpdateAndDelete($id);

        $brand->fromArray($data);

        $this->getManager()->flush();

        return $brand;
    }

    public function delete($id)
    {
        $brand = $this->helperForUpdateAndDelete($id);

        $this->getManager()->remove($brand);
        $this->getManager()->flush();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder|\Shopware\Components\Model\QueryBuilder
     */
    private function baseQuery()
    {
        $builder = $this->getManager()->createQueryBuilder();

        $builder->select(['brand'])->from(\VRPlugin\Models\Brand::class, 'brand');

        return $builder;
    }

    /**
     * @param $id
     * @return null|object|\VRPlugin\Models\Brand
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function helperForUpdateAndDelete($id)
    {
        if (empty($id))
            throw new \Exception('Id is missing');

        $brand = $this->getManager()->find(\VRPlugin\Models\Brand::class, $id);

        if (!$brand)
            throw new \Exception('Brand does not exist');
        return $brand;
    }


}