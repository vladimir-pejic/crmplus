<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UrlController extends Controller
{
    public function shorten(Request $request) {
        $rules = ['long_url' => 'required|url'];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
            return Redirect::route('home')->with('error', 'Not a valid URL!');

        if(!empty($existing = Url::where('long_url', $request->long_url)->first())) {
            return Redirect::route('home')->with('success', '<b><a target="_blank" href="'.$existing->short_url.'">'.$existing->short_url.'</a>');
        } else {

            do {
                $url_code = Helpers::random(8);
            } while (!empty(Url::where('short_url', $url_code)->first()));

            $shortened = Url::create([
                'user_id' => Auth::check() ? Auth::user()->id : null,
                'long_url' => $request->long_url,
                'url_code' => $url_code,
                'short_url' => env('APP_URL') . '/' . $url_code
            ]);
            return Redirect::route('home')->with('success', '<b><a target="_blank" href="'.$shortened->short_url.'">'.$shortened->short_url.'</a>');
        }

    }

    public function getUrl($url_code) {
        try {
            return Redirect::to(Url::where('url_code', $url_code)->first()->long_url);
        } catch (\Exception $e) {
            return Inertia::render('404');
        }
    }
}
