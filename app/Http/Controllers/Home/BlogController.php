<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;


class BlogController extends Controller
{
    public function allBLog()
    {
        $blog = Blog::latest()->get();

        return view('admin.blogs.blogs_all', compact('blog'));
    }

    public function addBlog()
    {
        $blog_category = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('admin.blogs.blogs_add',compact('blog_category'));
    }

    public function storeBLog(Request $request): \Illuminate\Http\RedirectResponse
    {

        if ($request->hasFile('blog_image')) {
            $image = $request->file('blog_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(430, 327)->save(public_path('/upload/blog/' . $name_gen));
            $save_url = '/upload/blog/' . $name_gen;

            Blog::insert([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        }
            $notification = array(
                'message' => 'Blog Inserted Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.blog')->with($notification);
    }

    public function editBLog($id)
    {
        $blogs = Blog::findOrFail($id);
        $blog_category = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('admin.blogs.blogs_edit', compact('blogs','blog_category'));
    }

    public function updateBLog(Request $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->hasFile('blog_image')) {
            $image = $request->file('blog_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(430, 327)->save(public_path('/upload/blog/' . $name_gen));
            $save_url = '/upload/blog/' . $name_gen;

            Blog::where('id', $request->id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
                'updated_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Blog Updated with Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.blog')->with($notification);
        }//end if

        Blog::where('id', $request->id)->update([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Blog Updated without Image Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog')->with($notification);
    }

    public function deleteBLog($id): \Illuminate\Http\RedirectResponse
    {
        $blogs = Blog::findOrFail($id);
        $img = public_path($blogs->blog_image);
        unlink($img);
        $blogs->delete();

        $notification = array(
            'message' => 'Blog Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function blogDetails($id)
    {
        $blogCategory = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $allBlogs = Blog::latest()->limit(5)->get();
        $blogs = Blog::findOrFail($id);
        return view('frontend.blogs_details', compact('blogs','allBlogs','blogCategory'));
    }

    public function categoryBlog($id): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $blogpost = Blog::where('blog_category_id', $id)->orderBy('id', 'DESC')->get();
        $blogCategory = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $allBlogs = Blog::latest()->limit(5)->get();
        $categoryName = BlogCategory::findOrFail($id);
        return view('frontend.cat_blog_details', compact('blogpost','blogCategory','allBlogs','categoryName'));
    }

    public function homeBlog()
    {
        $allBlogs = Blog::latest()->get();
        $blogCategory = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('frontend.blog', compact('allBlogs','blogCategory'));
    }
}
