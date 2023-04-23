<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function AllBlog()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.blogs_all', compact('blogs'));
    }
    //End Method

    public function AddBlog()
    {
        $categories = BlogCategory::orderBy('blog_category', 'asc')->get();
        return view('admin.blogs.blogs_add', compact('categories'));
    } //End Method

    public function StoreBlog(Request $request)
    {

        $image = $request->file('blog_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(430, 327)->save('uploads/blog/' . $name_gen);

        $save_url = 'uploads/blog/' . $name_gen;


        Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'blog_image' => $save_url,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Blog Inserted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.blog')->with($notification);
    } //End Method

    public function EditBlog($id)
    {
        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'asc')->get();
        return view('admin.blogs.blogs_edit', compact('blogs', 'categories'));
    } //End Method

    public function UpdateBlog(Request $request)
    {
        $blog_id = $request->id;

        if ($request->file('blog_image')) {

            $image = $request->file('blog_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(430, 327)->save('uploads/blog/' . $name_gen);

            $save_url = 'uploads/blog/' . $name_gen;


            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Blog Updated with image Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('all.blog')->with($notification);
        } else {
            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
            ]);

            $notification = array(
                'message' => 'Blog Updated without image Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('all.blog')->with($notification);
        } // End Else
    } //End Method
    public function DeleteBlog($id)
    {
        $blogs = Blog::findOrFail($id);
        $img = $blogs->blog_image;

        unlink($img);

        Blog::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } //End Method

    public function BlogDetails($id)
    {
        $allblogs = Blog::latest()->limit(5)->get();
        $categories = BlogCategory::orderBy('blog_category', 'asc')->get();
        $blogs = Blog::findOrFail($id);
        return view('frontend.blog_details', compact('blogs', 'allblogs', 'categories'));
    } //End Method

    public function CategoryBlog($id)
    {
        $blogs = Blog::findOrFail($id);

        $blogpost = Blog::where('blog_category_id', $id)->orderBy('id', 'DESC')->get();
        $allblogs = Blog::latest()->limit(5)->get();
        $categories = BlogCategory::orderBy('blog_category', 'asc')->get();
        $categoryname = BlogCategory::findOrFail($id);
        return view('frontend.cat_blog_details', compact('blogpost', 'allblogs', 'categories', 'blogs','categoryname'));
    } //End Method

    public function HomeBlog(){
        $allblogs = Blog::latest()->get();
        $categories = BlogCategory::orderBy('blog_category', 'asc')->get();
        return view('frontend.blog', compact('allblogs', 'categories'));
    }//End Method
}
