<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();

        return Inertia::render(
            'Blogs/Index',
            [
                'blogs' => $blogs
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Blogs/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required',
                'product_image' => 'required'
            ]);
            $file = $request->product_image;
            if($file){
                $image = $request->product_image;
                $imageName= $image->getClientOriginalName();
                $uniqueImageName = time().$imageName;
                $uploadPath = 'uploads/';
                $image->move($uploadPath,$uniqueImageName);
                $productImageUrl = $uploadPath.$uniqueImageName;
            }else{
                $productImageUrl = '';
            }
            Blog::create([
                'title' => $request->title,
                'content' => $request->content,
                'product_image' => $productImageUrl,
            ]);
            sleep(1);
            return redirect()->route('blogs.index')->with('message', 'Blog Created Successfully');
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return Inertia::render(
            'Blogs/Edit',
            [
                'blog' => $blog
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required'
        ]);

        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->save();
        sleep(1);

        return redirect()->route('blogs.index')->with('message', 'Blog Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        sleep(1);

        return redirect()->route('blogs.index')->with('message', 'Blog Delete Successfully');
    }
}
