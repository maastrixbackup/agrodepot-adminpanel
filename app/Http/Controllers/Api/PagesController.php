<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminPage;
use Illuminate\Http\Request;



class PagesController extends Controller
{
    public function Pages(Request $req, $pageId)
    {
        $pid = $pageId;
        $page_arr = array();
        $pages = AdminPage::find($pid);
        $page_arr['pid'] =  $pages->pid;
        $page_arr['page_slug'] =  $pages->page_slug;
        $page_arr['page_name'] =  $pages->page_name;
        $page_arr['meta_title'] =  $pages->meta_title;
        $page_arr['meta_key'] =  $pages->meta_key;
        $page_arr['meta_desc'] =  $pages->meta_desc;
        $page_arr['page_desc'] =  $pages->page_desc;

        return response()->json($page_arr);
    }
}
