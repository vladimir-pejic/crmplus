<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Url;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
            $url = Url::where('url_code', $url_code)->first();
            $url->update(['clicks', $url->clicks++]);
            return Redirect::to($url->long_url);
        } catch (\Exception $e) {
            return Inertia::render('404');
        }
    }


    public function index()
    {
        return Inertia::render('Urls/Index', [
            'filters' => (new Request)->all('search', 'trashed'),
            'urls' => Url::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->filter((new Request)->only('search'))
                ->paginate()
        ]);
    }

    public function edit(Url $url)
    {
        return Inertia::render('Urls/Edit', [
            'url' => [
                'id' => $url->id,
                'url_code' => $url->url_code,
                'long_url' => $url->long_url,
                'short_url' => $url->short_url,
            ],
        ]);
    }

    public function update(Url $url)
    {
        request()->validate([
            'url_code' => ['required', 'max:50', Rule::unique('urls')->ignore($url->id)],
            'long_url' => ['required'],
        ]);

        $url->update([
            'url_code' => request()->input('url_code'),
            'short_url' => env('APP_URL') . '/' . request()->input('url_code'),
            'long_url' => request()->input('long_url')
        ]);

        return Redirect::route('urls.edit', $url)->with('success', 'URL updated.');
    }
}
