<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //Define table name
    protected $_table = 'categories';

    /**
     * Generate source tree
     */
    public static  function generateTree() {
        $categoryList = self::get();

        $result = [];
        foreach($categoryList as $category) {
            $result[$category->id] = $category->title;
        }

        return $result;
    }

    /**
     * Get description of fields structure on creating, updating
     * @return array
     */
    public static function getFieldSource($option = 'create') {
        return [
            'title' => [
                'html' => [
                    'name' => 'name',
                    'class' => 'required',
                    'id' => 'title',
                    'type' => 'text',
                    'placeholder' => 'Enter category name'
                ],
                'label' => 'Name'
            ],
            'short_description' => [
                'html' => [
                    'name' => 'short_description',
                    'class' => 'required',
                    'id' => 'short_description',
                    'type' => 'textarea',
                    'rows' => 4
                ]
                ,
                'label' => 'Short Description'
            ],
            'description' => [
                'html' => [
                    'name' => 'description',
                    'class' => 'required',
                    'id' => 'description',
                    'type' => 'textarea',
                    'rows' => 5
                ]
                ,
                'label' => 'Description'
            ],
            'parent_id' => [
                'html' => [
                    'name' => 'parent_id',
                    'class' => 'required',
                    'id' => 'parent_id',
                    'type' => 'multiselect'
                ]
                ,
                'label' => 'Parents',
                'options' => self::generateTree()
            ],
            'status' => [
                'html' => [
                    'name' => 'status',
                    'id' => 'status',
                    'type' => 'checkbox'
                ],
                'label' => 'Active'
            ],
        ];
    }
}
