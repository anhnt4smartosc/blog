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
    CONST TEXT_TYPE = 'text';
    CONST TEXT_AREA_TYPE = 'textarea';
    CONST SELECT_TYPE = 'select';
    CONST MULTI_SELECT_TYPE = 'multiselect';
    CONST CHECKBOX_TYPE = 'checkbox';
    CONST RADIO_TYPE = 'radio';

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
            /* Default route of creating page in admin */
            'admin.layouts.default.create',
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
        /* Default route of creating page in admin */
        return $this->loadView(
            'admin.layouts.default.update',
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
    public function renderInputRequest($field, $value = null) {
        $html = '';
        $value = $value ? $value : '';
        $labelValue = $this->_getLabelValue($field);

        $label = '<label>'.$labelValue.'</label>';

        $fieldHtml = $field['html'];
        $arrString = $this->_getAttributeHtml($fieldHtml);

        switch($fieldHtml['type']) {
            case self::TEXT_TYPE : {
                $html.= $label . "<input ". $arrString ." value='". $value."'/>";
                break;
            }
            case self::TEXT_AREA_TYPE : {
                $html.= $label . "<textarea ". $arrString .">" . $value . "</textarea>";
                break;
            }
            case self::SELECT_TYPE : {
                if(sizeof($field['options']) > 0) {
                    $html.= $label . "<select ". $arrString." value='".$value."'>";
                    foreach ($field['options'] as $key => $option) {
                        $html.="<option value=".$key.">". $option."</option>";
                    }
                    $html.= "</select>";
                    break;
                }

                $html.= $label . ' <br/>'. '<em> No options </em>';
                break;
            }
            case self::RADIO_TYPE : {
                /* @Todo Implement later */
//                $html.= '<label><input '. $arrString.'/>' . $field['label'] .'</label>';
                break;
            }
            case self::CHECKBOX_TYPE : {
                /* Use checkbox without value */
                $html.= $label;
                $html.=
                    "<div class='checkbox'>".
                    "<label><input ". $arrString." ".($value == $fieldHtml['value'] ? 'checked' : ''). "/>" .$labelValue.'</label>".
                    "</div>';
                break;
            }
            case self::MULTI_SELECT_TYPE : {
                if(sizeof($field['options']) > 0) {
                    $html.= $label . "<select multiple ". $arrString.">";
                    foreach ($field['options'] as $key => $option) {
                        $html.="<option value=".$key.">". $option."</option>";
                    }
                    $html.= "</select>";
                    break;
                }
                $html.= $label . ' <br/>'. ' <em> No options </em> ';
                break;
            }
        }

        return $html;
    }

    /**
     * Get Grid header value
     * @param $field
     * @return string
     */
    public function renderGridHeader($field) {
        return $this->_getLabelValue($field);
    }

    /**
     * Return label value in form edit
     * @param $field
     * @return string
     */
    protected function _getLabelValue($field) {
        return isset($field['label']) && $field['label'] ? $field['label'] : ucwords(str_replace('_',' ', $field['html']['name']));
    }

    /**
     * Return value in grid base on option
     * @param $field
     * @param $value
     */
    public function getValue($field, $value) {

        if(
            isset($field['options']) &&
            isset($field['options'][$value]) &&
            ($field['options'][$value] || (is_numeric($field['options'][$value])))
        ) {
            return $field['options'][$value];
        }
        return $value;
    }
}