<?php
namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        return view('categories.index', [
            'categories' => Category::all(),
            'user' => $this->user,
            'title' => 'Categories',
        ]);
    }

    public function create()
    {
        return view('categories.create', [
            'user' => $this->user,
            'title' => 'Add category',
        ]);
    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('categories.edit', [
                'category' => $category,
                'title' => 'Edit category',
                'user' => $this->user,
            ]);
        } catch (ModelNotFoundException $e) {
            \Session::flash('flash_error', 'Edit failed. The category cannot be found.');
        }
        return redirect('/categories');
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'category_name' => 'required|max:255',
                'category_desc' => 'required',
                'category_image' => 'required|mimes:jpg,jpeg,gif,png',
            ]);
            $category = new Category;
            $category->assign($request);
            \Session::flash('flash_success', 'Category creation successful!');
        } catch (Exception $e) {
            \Session::flash('flash_error', 'Category creation failed.');
        }
        return redirect('/categories');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_name' => 'required|max:255',
            'category_desc' => 'required',
            'category_image' => 'mimes:jpg,jpeg,gif,png',
        ]);
        $category = Category::find(intval($id));
        $category->assign($request);
        return redirect('/categories');
    }

    public function destroy(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            \Session::flash('flash_success', 'Delete successful!');
        } catch (ModelNotFoundException $e) {
            \Session::flash('flash_error', 'Delete failed. The category cannot be found.');
        }
        return redirect('/categories');
    }
}
