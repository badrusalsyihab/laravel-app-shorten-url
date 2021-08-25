<?php

namespace App\Services\Bridge\Front;

use App\Repositories\Contracts\Front\ShortLink as ShortLinkInterface;

class ShortLink {
     protected $ShortLink;

     public function __construct(ShortLinkInterface $ShortLink)
     {
          $this->ShortLink = $ShortLink;
     }

     public function getData($params = []) {
          return $this->ShortLink->getData($params);
     }

     public function store($params = []) {
          return $this->ShortLink->store($params);
     }

     public function getDetail($params = []) {
        return $this->ShortLink->getDetail($params);
   }
   
}
