<?php

namespace App\Http\Controllers\Api;

use App\Models\FeaturedSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeaturedSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getFeaturedContent()
    {
        $data = FeaturedSection::latest()->get();
        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Content Not Found']);
        }
        $data = $data->map(function ($d) {
            return [
                'id' => $d->id,
                'english_title' => $d->english_title,
                'romanian_title' => $d->romanian_title,
                'image' => asset('uploads/featuredContent/' . $d->image),
                'link' => $d->link,
            ];
        });
        return response()->json(['status' => true, 'message' => 'Content Found', 'data' => $data]);
    }
}
