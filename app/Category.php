<?php

namespace App;

use App\Helper\Admin\View;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //Define table name
    protected $_table = 'categories';

    CONST DEFAULT_ROOT = 0;
    CONST ACTIVE_STATUS = 1;
    CONST INACTIVE_STATUS = 0;

    /**
     * Generate tree, except some ids
     * @param array $except
     * @return array
     */
    public static  function generateTree($except = []) {
        $result = [];
        $result[0] = 'Root';

        foreach($list = self::whereNotIn('id',$except)
                    ->orderBy('parent_id', 'asc')
                    ->orderBy('position', 'asc')
                    ->get() as $category)
        {
            $result[$category->id] = $category->name;
        }

        return $result;
    }

    /**
     * Generate tree menu
     * @param $except
     * @return string
     */
    public static function generateMenuHtml()
    {
        $list = self::orderBy('parent_id', 'asc')->orderBy('position', 'asc')->get()->toArray();
        $html = '';
        $html.= '<ul root>';
        foreach($list as $item) {
            if($item['parent_id'] == 0) {
                $html.= '<li>' . $item['name'] . self::_findBranch($item['id'], $list) . '</li>';
            }
        }
        $html.= '</ul>';

        return $html;
    }

    /**
     * Find branches and print out to html ul li
     * @param $parentId
     * @param array $list
     * @return string
     */
    protected static function _findBranch($parentId, array $list)
    {
        $html = '';
        $found = false;
        foreach($list as $item) {
            if($item['parent_id'] == $parentId) {
                $found = true;
                $html.= '<li>'. $item['name'] . self::_findBranch($item['id'], $list).'</li>';
            }
        }
        $found ? $html = '<ul>'.$html.'</ul>' : false;
        return $html;
    }

    /**
     * Get description of fields structure on creating, updating
     * @return array
     */
    public static function getFieldSource() {
        return [
            'name' => [
                'html' => [
                    'name' => 'name',
                    'required' => true,
                    'id' => 'title',
                    'type' => View::TEXT_TYPE,
                    'placeholder' => 'Enter category name'
                ]
            ],
            'short_description' => [
                'html' => [
                    'name' => 'short_description',
                    'required' => true,
                    'id' => 'short_description',
                    'type' => View::TEXT_AREA_TYPE,
                    'rows' => 4
                ]
            ],
            'description' => [
                'html' => [
                    'name' => 'description',
                    'required' => true,
                    'id' => 'description',
                    'type' => View::TEXT_AREA_TYPE,
                    'rows' => 5
                ]
            ],
            'parent_id' => [
                'html' => [
                    'name' => 'parent_id',
                    'required' => true,
                    'id' => 'parent_id',
                    'type' => View::SELECT_TYPE
                ],
                'options' => self::generateTree()
            ],
            'position' => [
                'html' => [
                    'name' => 'position',
                    'id' => 'position',
                    'type' => View::TEXT_TYPE,
                    'placeholder' => 'Enter position number',
                ]
            ],
            'status' => [
                'html' => [
                    'name' => 'status',
                    'id' => 'status',
                    'type' => View::CHECKBOX_TYPE,
                    'value' => 1
                ],
                'options' => [1 => 'Active', 0 => 'Inactive']
            ],
            'created_at' => [
                'html' => [
                    'name' => 'created_at',
                    'id' => 'created_at',
                    'type' => View::TEXT_TYPE
                ],
                'grid_only' => true
            ],
            'updated_at' => [
                'html' => [
                    'name' => 'created_at',
                    'id' => 'created_at',
                    'type' => View::TEXT_TYPE
                ],
                'grid_only' => true
            ],
        ];
    }
}
