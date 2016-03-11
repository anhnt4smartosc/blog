<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Admin\View as View;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests;

class AdminBaseController extends Controller
{
    /**
     * @var Array contains default configs, value, ... for Admin
     */
    protected $_defaultData = [];

    /**
     * To generate default component
     */
    protected $_resourceName;

    /**
     * @var View $_viewHelper
     */
    protected $_viewHelper;

    /*
     * Construct
     */
    public function __construct() {
        $this->_init();
    }

    /*
     * Init function, helpers, data, maybe more ...
     */
    protected function _init() {
        /* Load default helper */
        $this->_loadHelper();
        /* Load default data */
        $this->_loadDefaultData();
    }

    /*
     * Load default helper
     */
    protected function _loadHelper()
    {
        /* @var View $this->_viewHelper */
        $this->_viewHelper = new View($this->_resourceName);
    }

    /**
     * Load default data for Admin
     */
    protected function _loadDefaultData()
    {
        $this->_defaultData = [
            'base_skin_url' => url('skin/admin'),
            'base_url' => url('')
        ];
    }

    /*
     * Default action of admin router
     */
    public function index() {
        return $this->_viewHelper->loadView('admin.dashboard', array_merge($this->_defaultData, ['title' => 'Dashboard']));
    }


    /**
     * @param array $configuration
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return $this->_viewHelper->getCreateView($this->_defaultData);
    }

    /**
     * @param array $configuration
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($fields = []) {
        return $this->_viewHelper->getUpdateView($fields);
    }
}
