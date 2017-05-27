<?php
/**
 * Created by PhpStorm.
 * User: vtarasenkovs
 * Date: 5/24/17
 * Time: 4:13 PM
 */

namespace DashboardBundle\Interfaces;


interface CacheInterface
{
    public function get($id);

    public function save($data, $id);

    public function delete($id);
}