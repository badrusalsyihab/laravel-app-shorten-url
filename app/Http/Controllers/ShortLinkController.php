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
        dd($this->shortLink->getData());
        return view('front.pages.short_link', $this->shortLink->getData());
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


   
}
