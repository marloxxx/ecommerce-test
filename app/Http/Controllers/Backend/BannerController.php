<?php

namespace App\Http\Controllers\Backend;

use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('pages.backend.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateBanner($request);

        $validatedData['slug'] = $this->createUniqueSlug($request->title);

        Banner::create($validatedData);

        return redirect()->route('backendbanner.index')->with('success', 'Banner created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('pages.backend.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validatedData = $this->validateBanner($request, $banner->id);

        $validatedData['slug'] = $this->createUniqueSlug($request->title, $banner->id);

        $banner->update($validatedData);

        return redirect()->route('backendbanner.index')->with('success', 'Banner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('backendbanner.index')->with('success', 'Banner deleted successfully');
    }

    private function validateBanner(Request $request, $id = null)
    {
        return $request->validate([
            'title' => 'string|required|max:50',
            'description' => 'string|nullable',
            'photo' => $id ? 'nullable|mimes:jpg,jpeg,png' : 'required|mimes:jpg,jpeg,png',
            'status' => 'required|in:active,inactive',
        ]);
    }

    private function createUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $additionalCondition = $id ? ',' . $id : '';

        if (Banner::where('slug', $slug)->where('id', '<>', $id)->exists()) {
            $slug .= '-' . time();
        }

        return $slug;
    }
}
