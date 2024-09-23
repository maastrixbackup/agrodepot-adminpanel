<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminLang;

class AdminLangController extends Controller
{
    public function getLanguageLabels($language)
    {
        if (!in_array($language, ['en', 'roman'])) {
            return response()->json(['error' => 'Invalid language'], 400);
        }

        $labels = AdminLang::all()->mapWithKeys(function ($item) use ($language) {
            return [
                $item->numberstring => $item->{$language . '_label'}
            ];
        });

        return response()->json($labels);
    }
}
