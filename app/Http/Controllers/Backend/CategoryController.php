<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->with('parent_info')->get();
        return view('pages.backend.category.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        return view('pages.backend.category.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string|required',
            'summary' => 'string|nullable',
            'photo' => 'string|nullable',
            'status' => 'required|in:active,inactive',
            'is_parent' => 'sometimes|in:1',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $slug = Str::slug($request->title);
        if (Category::where('slug', $slug)->first() != null) {
            $slug = $slug . '-' . time();
        }

        Category::create([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'photo' => $request->photo,
            'status' => $request->status,
            'is_parent' => $request->is_parent,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('backend.category.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        return view('pages.backend.category.edit')->with('category', $category)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'string|required',
            'summary' => 'string|nullable',
            'photo' => 'string|nullable',
            'status' => 'required|in:active,inactive',
            'is_parent' => 'sometimes|in:1',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $slug = Str::slug($request->title);
        if (Category::where('slug', $slug)->first() != null) {
            $slug = $slug . '-' . time();
        }

        $category->update([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'photo' => $request->photo,
            'status' => $request->status,
            'is_parent' => $request->is_parent,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('backend.category.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category) {
            if ($category->is_parent == 1) {
                $child_cat = Category::where('parent_id', $category->id)->pluck('id');
                $category->delete();
                Category::whereIn('id', $child_cat)->delete();
            } else {
                $category->delete();
            }
            return redirect()->route('backend.category.index')->with('success', 'Category deleted successfully');
        } else {
            return redirect()->route('backend.category.index')->with('error', 'Category not found!!');
        }
    }

    public function getChildByParent(Request $request)
    {
        $categories = Category::where('parent_id', $request->parent_id)->orderBy('title', 'ASC')->get();
        return response()->json($categories);
    }
}
