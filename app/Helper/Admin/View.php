<?php
/**
 * Created by PhpStorm.
 * User: anhnt01682
 * Date: 3/11/16
 * Time: 11:18 AM
 */

namespace App\Helper\Admin;

/**
 * To receive and modify configurations mapping to generate view
 * Class FormBuilder
 * @package App\Helper
 */
class View
{
    /**
     * @param $resourceName
     */
    public function __construct($resourceName) {
        $this->_resourceName = $resourceName;
    }

    /**
     * This is a method to load view and default data to all controller
     * Call this method on sub class
     * @param $viewName
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadView($viewName, $data = [])
    {
        return view($viewName, array_merge($data, ['viewHelper' => $this ]));
    }

    /**
     * Create a new page for creating resources
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateView($data = [])
    {
        //No need to pass any data
        return $this->loadView(
            'admin.'. strtolower($this->_resourceName) .'.create',
            array_merge($data, [
                //Here's the default data of views
                'title' => ucwords('Create new '. $this->_resourceName)
            ])
        );
    }

    /**
     * Create an update page for updating resources
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateView($data = []) {
        return $this->loadView(
            'admin.'. strtolower($this->_resourceName) .'.update',
            array_merge($data, [
                //Here's the default data of views
                'title' => ucwords('Update '. $this->_resourceName)
            ])
        );
    }

    /**
     * Create a default grid view of management table for resources
     * This function can use for flat table, no need to edit too many things
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getGridView($data = []) {
        return $this->loadView(
            'admin.'. strtolower($this->_resourceName) .'.index',
            array_merge($data, ['title' => ucwords($this->_resourceName. ' management')])
        );
    }

    protected function _getAttributeHtml($fieldHtml) {
        /* For add default style */
        $classControl = 'form-control';

        $attr = [];
        $fieldHtml['class'] =
            $fieldHtml['type'] != 'checkbox' ? (
                $classControl.' '.(
                    isset($fieldHtml['class']) &&
                    $fieldHtml['class'] &&
                    $fieldHtml['type'] != 'checkbox' ?
                        $fieldHtml['class'] : ''
                )) : '';


        foreach($fieldHtml as $key => $fieldProperty) {
            $attr [] = $key. '='."'{$fieldProperty}'";
        }
//        var_dump($attr);
        $arrString = implode(' ', $attr);

        return $arrString;
    }

    /**
     * Output html template of view
     * 'category_name' => [
            'class' => 'required', 'data-validation' => 'text'
            'label' => 'Category Name',
            'id' => 'category_name',
            'type' => 'text',
            'placeholder' => 'Enter category name'
        ],
     * @param $field
     */
    public function render($field, $is_default = true) {
        $html = '';

        $fieldHtml = $field['html'];
        $label = isset($field['label']) && $field['label'] ? '<label>' . $field['label'] . '</label>' : '';

        $arrString = $this->_getAttributeHtml($fieldHtml);

        switch($fieldHtml['type']) {
            case 'text' : {
                $html.= $label . "<input ". $arrString ."/>";
                break;
            }
            case 'textarea' : {
                $html.= $label . "<textarea ". $arrString ."></textarea>";
                break;
            }
            case 'select' : {
                if(sizeof($field['options']) > 0) {
                    $html.= $label . "<select ". $arrString.">";
                    foreach ($field['options'] as $key => $option) {
                        $html.="<option value=".$key.">". $option."</option>";
                    }
                    $html.= "</select>";
                }

                $html.= $label . ' <br/>'. '<em> No options </em>';
                break;
            }
            case 'radio' : {
                /* @Todo Implement later */
//                $html.= '<label><input '. $arrString.'/>' . $field['label'] .'</label>';
                break;
            }
            case 'checkbox' : {
                /* Use checkbox without value */
                $html.= "<label>" . $field['label']. "</label>";
                $html.= "<div class='checkbox'><label><input ". $arrString.'/>'.$field['label'].'</label></div>';
                break;
            }
            case 'multiselect' : {
                if(sizeof($field['options']) > 0) {
                    $html.= $label . "<select multiple ". $arrString.">";
                    foreach ($field['options'] as $key => $option) {
                        $html.="<option value=".$key.">". $option."</option>";
                    }
                    $html.= "</select>";
                }

                $html.= $label . ' <br/>'. ' <em> No options </em> ';
                break;
            }
        }

        return $html;
    }
}