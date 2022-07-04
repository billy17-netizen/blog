<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function allBlogCategory(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $blog_category = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all', compact('blog_category'));
    }

    public function addBlogCategory(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('admin.blog_category.blog_category_add');
    }

    public function storeBlogCategory(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'blog_category' => 'required',
        ],[
            'blog_category.required' => 'Please enter blog category',
        ]);

        BlogCategory::insert([
            'blog_category' => $request->blog_category,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function editBlogCategory($id)
    {
        $blogCategory = BlogCategory::findOrFail($id);

        return view('admin.blog_category.blog_category_edit', compact('blogCategory'));
    }

    public function updateBlogCategory(Request $request): \Illuminate\Http\RedirectResponse
    {
        $blogCategory_id = $request->id;
        BlogCategory::findOrFail($blogCategory_id)->update([
            'blog_category' => $request->blog_category,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function deleteBlogCategory($id): \Illuminate\Http\RedirectResponse
    {
        $blogCategory = BlogCategory::findOrFail($id);
        $blogCategory->delete();
        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
