<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;

class ProductController extends AdminBaseController
{
    public function __construct() {
        /* This property is for generating default features */
        $this->_resourceName = 'product';
        parent::__construct();
    }

    /**
     * @return array
     */
    protected function _loadResourceFields() {
        return Category::getFieldSource();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $list = Product::get();

        return $this->_viewHelper->getGridView(
             array_merge(['fieldSources' => $this->_loadResourceFields(), 'list' => $list], $this->_defaultData)
        );
    }

    /*
     * Create new default page for category
     */
    public function create()
    {
        return view('admin.product.create',
            array_merge($this->_defaultData, [
                'title' => 'Create New Product'
            ])
        );
    }

    /*
     * Store data from update or new
     */
    public function store(Request $request)
    {
        $category = new Category();

        if($id = $request->id) {
            if(!$category = Category::find($id)) {
                throw new Exception('Category does not exist.');
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name'.($id ? ','.$id : ''),
            'description' => 'required|max:255',
            'short_description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect(url('/admin/category'))
//                ->withInput($request)
                ->withErrors($validator);
        }

        $category->name = $request->name;
        $category->short_description = $request->short_description;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id ? $request->parent_id : Category::DEFAULT_ROOT;
        $category->position = $request->position;
        $category->status = $request->status ? $request->status : Category::INACTIVE_STATUS;
        $category->save();

        if($id) {
            Session::flash('success_message', 'Category successfully updated.');
            return redirect('/admin/category/update/'.$id);
        }
        Session::flash('success_message', 'Category successfully added.');
        return redirect('/admin/category/create');
    }

    /**
     * Delete an object
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        try {
            if(!$category = Category::find($id)) {
                throw new Exception("Category does not exist.");
            }
            $category->delete();
            Session::flash('success_message', 'Category successfully deleted.');
            return redirect('/admin/category');
        } catch(Exception $ex) {
            Session::flash('success_message', $ex->getMessage());
            return redirect('/admin/category/index');
        }
    }

    /**
     * @param array $configuration
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id) {
        try {
            $category = Category::find($id);
            if(!$category) {
                throw new Exception('Category does not exist.');
            }
            return $this->_viewHelper->getUpdateView(
                array_merge($this->_defaultData, [
                    'category' => $category,
                    'fields' => $this->_loadResourceFields()
                ])
            );
        }
        catch (Exception $ex) {
            return redirect('admin/category');
        }
    }


    /**
     * Get tree of categories to help admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview() {
        return view('admin.category.preview',array_merge($this->_defaultData,[
            'title' => 'Preview Menu',
            'previewMenu' => Category::generateMenuHtml()
        ]));
    }

    /**
     * Upload images
     * @return mixed
     */
    public function upload(Request $request) {
        try {
            // getting all of the post data
            $file = ['image' => $request->file('image')];

            var_dump($file);die;
            // setting up rules
//            $rules = ['image' => 'required']; //mimes:jpeg,bmp,png and for max size max:10000
            // doing the validation, passing post data, rules and the messages
            $validator = Validator::make($file, []);
            if ($validator->fails()) {
                throw new Exception('Failed');
            }
            else {
                // checking file is valid.
                if (Input::file('Filename')->isValid()) {
                    $destinationPath = 'uploads'; // upload path
                    $extension = Input::file('Filename')->getClientOriginalExtension(); // getting image extension
                    $fileName = rand(11111,99999).'.'.$extension; // renameing image
                    Input::file('Filename')->move($destinationPath, $fileName); // uploading file to given path
                    // sending back with message
                    Session::flash('success', 'Upload successfully');
                    return Redirect::to('upload');
                }
                else {
                    // sending back with error message.
                    Session::flash('error', 'uploaded file is not valid');
                    return Redirect::to('upload');
                }
            }
        } catch(Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
