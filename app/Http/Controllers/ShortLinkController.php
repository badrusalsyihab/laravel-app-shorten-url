<?php

namespace App\Http\Controllers;

use App\Services\Bridge\Front\ShortLink as ShortLinkServices;
use App\Services\Response as ResponseService;
use Illuminate\Http\Request;

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
        //
        dd($request->all());
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
