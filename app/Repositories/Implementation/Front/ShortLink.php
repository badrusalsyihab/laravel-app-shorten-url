<?php

namespace App\Repositories\Implementation\Front;

use App\Repositories\Implementation\BaseImplementation;
use App\Repositories\Contracts\Front\ShortLink as ShortLinkInterface;
use App\ShortLink as ShortLinkModels;
use App\Services\Response as ResponseService;
use DB;
use Carbon\Carbon;

class ShortLink implements ShortLinkInterface
{
    protected $shortLink;
    protected $message;
    protected $response;
  
    function __construct(ShortLinkModels $shortLink, ResponseService $response)
    {
        $this->shortLink = $shortLink;
    }

    /**
     * Get Data
     * @param $data
     * @return array
     */
    public function getData($data)
    {
        $params = [
            "order_by" => 'created_at',
        ];

        return $this->shortLink($params, 'desc', 'array', false);
    }


    /**
     * Store Data
     * @param $data
     * @return array
     */
    public function store($data)
    {
        try {

            DB::beginTransaction();
            
            if(!$this->storeData($data))
            {
                DB::rollBack();
                return $this->response->setResponse($this->message, false);
            }

            DB::commit();
            return $this->setResponse('Success store data', true);

        } catch (\Exception $e) {
            return $this->setResponse($e->getMessage(), false);
        }
    }


    /**
     * getDetail data
     * @param $data
     * @return array
     */
    public function getDetail($params)
    {
       $data = $this->shortLink($params, 'asc', 'array', true);
       return isset($data['link']) ? $data['link'] : ''; 
    }

    /**
     * Store Data Members
     * @param $data
     * @return array
     */
    protected function storeData($data)
    {
        try {

            $storeObj                       = $this->shortLink;

            if ($this->isEditMode($data))
            {
                $storeObj                   = $this->shortLink->find($data['id']);
                $storeObj->updated_at       = Carbon::now();
            }

			$storeObj->code             = isset($data['code']) ? $data['code'] : '';
            $storeObj->link       		= isset($data['link']) ? $data['link'] : '';
            $storeObj->created_at       = Carbon::now();
           
            if($storeObj->save())
            {
                return true;
            }

            return false;

        } catch (\Exception $e) {
            $this->message = $e->getMessage();
            return false;
        }
    }


    /**
     * Get All Data
     * Warning: this function doesn't redis cache
     * @param array $params
     * @return array
     */
    protected function shortLink($params = array(), $orderType = 'asc', $returnType = 'array', $returnSingle = false)
    {
        $shortLink = $this->shortLink->with([]);

        if(isset($params['id'])) {
            $shortLink->where('id', $params['id']);
        }


        if(isset($params['code'])) {
            $shortLink->where('code', $params['code']);
        }

        if(isset($params['order_by'])) {
            $shortLink->orderBy($params['order_by'], $orderType);
        }

        if(!$shortLink->count())
            return array();

        switch ($returnType) {
            case 'array':
                if(!$returnSingle) 
                {
                    return $shortLink->get()->toArray();
                } 
                else 
                {
                    return $shortLink->first()->toArray();
                }

            break;
        }
    }
    

    /**
     * Check need edit Mode or No
     * @param $data
     * @return bool
     */
    protected function isEditMode($data)
    {
        return isset($data['id']) && !empty($data['id']) ? true : false;
    }
}