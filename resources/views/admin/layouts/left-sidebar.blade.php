<div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
        <li class="sidebar-search">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
            <!-- /input-group -->
        </li>
        <li>
            <a href="{{ $base_url.'/admin'}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
        </li>
        <li>
            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Categories<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ $base_url.'/admin/category'}}">Grid</a>
                </li>
                <li>
                    <a href="{{ $base_url.'/admin/category/preview'}}">Preview</a>
                </li>
                <li>
                    <a href="{{ $base_url.'/admin/category/create'}}">Create New</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Products<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="{{ $base_url.'/admin/product'}}">Grid</a>
                </li>
                <li>
                    <a href="{{ $base_url.'/admin/product/create'}}">Create New</a>
                </li>
            </ul>
        </li>
    </ul>
</div>