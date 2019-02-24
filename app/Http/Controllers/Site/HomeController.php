<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Yangqi\Htmldom\Htmldom;

class HomeController extends SiteController
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!empty($this->domainUser)) {
            if ( strtotime($this->domainUser->end_at) < time() && ($this->emailUser != 'vn3ctran@gmail.com')) {
                return redirect(route('admin_dateline'));
            }
        }
        return view('site.default.index');
    }
}
