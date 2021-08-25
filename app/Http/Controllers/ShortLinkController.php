<?php

namespace App\Http\Controllers;

use App\Services\Bridge\Front\ShortLink as ShortLinkServices;
use App\Services\Response as ResponseService;
use Illuminate\Http\Request;
use Validator;
use Redirect;

class ShortLinkController extends Controller
{
    protected $shortLink;
    protected $response;

    public function __construct(ShortLinkServices $shortLink, ResponseService $response)
    {
        $this->response = $response;
        $this->shortLink = $shortLink;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['shortLinks'] = $this->shortLink->getData();
        return view('front.pages.short_link', $data);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validateStore($request));

        if ($validator->fails()) {
            //TODO: case fail
            return Redirect::back()->withErrors([$validator->errors()->first()]);

        } else {
            //TODO: case pass
            $store = $this->shortLink->store($request->except(['_token']));
            if($store)
            return Redirect::back()->withSuccess('Shorten Link Generated Successfully!');

            return Redirect::back()->withErrors(['Please try again..']);
            
        }
    }


     /**
     * Validator
     * @param $request
     */
    protected function validateStore($request = array())
    {
        $rules = [
        	'link' => 'required|url'
        ];

        return $rules;
    }


    /**
     * Show detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        return redirect($this->shortLink->getDetail(['code' => $code]));
    }


   
}
