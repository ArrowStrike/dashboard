<?php
/**
 * Created by PhpStorm.
 * User: vtarasenkovs
 * Date: 5/24/17
 * Time: 4:20 PM
 */

namespace DashboardBundle\Services;


use DashboardBundle\Interfaces\CacheInterface;

class CacheLiteService implements CacheInterface
{

    protected $cache;

    public function __construct($lifeTime)
    {
        $this->cache = new \Cache_Lite(
            ['lifeTime' => $lifeTime]
        );
    }

    public function get($id)
    {
        return $this->cache->get($id);
    }

    public function save($data, $id)
    {
        return $this->cache->save($data, $id);
    }

    public function delete($id)
    {
        return $this->cache->remove($id);
    }

}