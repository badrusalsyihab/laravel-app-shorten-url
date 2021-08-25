<?php

namespace App\Repositories\Contracts\Front;


interface ShortLink
{
    /**
     * @param $params
     * @return mixed
     */
    public function getData($params);

    /**
     * @param $params
     * @return mixed
     */
    public function store($params);

}
