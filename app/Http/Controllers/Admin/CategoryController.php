<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class CategoryController extends AdminBaseController
{
    public function __construct() {
        /* This property is for generating default features */
        $this->_resourceName = 'category';
        parent::__construct();
    }
    /*
     * List for grid page
     */
    public function index()
    {
        $categoryList = Category::get();

        return $this->_viewHelper->getGridView(
            array_merge(['categoryList' => $categoryList], $this->_defaultData)
        );
    }

    /*
     * Create new default page for category
     */
    public function create()
    {
//        return parent::create();

        $fieldSources = Category::getFieldSource();

        return $this->_viewHelper->getCreateView(
            array_merge($this->_defaultData, [ 'fields' => $fieldSources])
        );
    }

    /*
     * Store data from update or new
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'short_description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->short_description = $request->short_description;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();

        return redirect('/admin/category');
    }
}
