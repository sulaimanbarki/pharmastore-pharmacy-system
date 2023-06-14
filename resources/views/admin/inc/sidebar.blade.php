<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('Backend') }}/dist/img/blank_profile.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->user_role->name }}</p>
      </div>
    </div>
    <!-- search form -->
   
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header"></li>
      <li>
        <a href="{{url('dashboard')}}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <li class="header"></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user"></i><span>User Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @if (Auth::user()->user_role->slug == "superadmin")
          <li><a href="{{url('useroles/')}}"><i class="fa fa-user-plus"></i> Add Users Role</a></li>
          @endif
          <li><a href="{{url('users/add')}}"><i class="fa fa-user-plus"></i> Add Users</a></li>
          <li><a href="{{url('users/list')}}"><i class="fa fa-list"></i>Users List</a></li>
        </ul>
      </li>
      <li class="header"></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-object-ungroup"></i> <span>Category</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="active"><a href="{{ url('category/add') }}"><i class="fa fa-plus"></i>Add Category</a></li>
          <li class="active"><a href="{{url('category/list')}}"><i class="fa fa-list"></i>Category List</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-object-group"></i><span>Medicine Groups</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('groups/add')}}"><i class="fa fa-plus"></i> Add Groups</a></li>
          <li class="active"><a href="{{url('groups/list')}}"><i class="fa fa-list"></i>Groups List</a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-square-o"></i><span>Medicine Generic</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('genericnames/add')}}"><i class="fa fa-plus"></i> Add Generic</a></li>
          <li class="active"><a href="{{url('genericnames/list')}}"><i class="fa fa-list"></i>Generic List</a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-industry"></i><span>Medicine Supplier</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('supplier/add')}}"><i class="fa fa-plus"></i> Add Supplier Names</a></li>
          <li class="active"><a href="{{url('supplier/list')}}"><i class="fa fa-list"></i>Suppliers List</a></li>
        </ul>
      </li>
      <li class="header"></li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-hospital-o"></i><span>Medicine</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
         

          <li class="active"><a href="{{url('product/add')}}"><i class="fa fa-plus"></i> Add Medicines</a></li>
          <li class="active"><a href="{{url('product/list')}}"><i class="fa fa-list"></i>Medicine List</a></li>

        </ul>
      </li>
      <li class="header"></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-calendar-check-o"></i><span>Medicine Order</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="active"><a href="{{url('order/new')}}"><i class="fa fa-list"></i>Place Order</a></li>
          <li class="active"><a href="{{url('order/list')}}"><i class="fa fa-calendar-times-o"></i>Order List</a></li>
        </ul>
      </li>

      <li class="header"></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-calendar-check-o"></i><span>Product Expire Info</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="active"><a href="{{url('product/oneMonthToexpire')}}"><i class="fa fa-calendar-minus-o"></i>Expire Winthin A Month List</a></li>
          <li class="active"><a href="{{url('product/expired')}}"><i class="fa fa-calendar-times-o"></i>Already Expired List</a></li>
        </ul>
      </li>

      <li class="header"></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-building-o"></i><span>Product Stock Info</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="active"><a href="{{url('product/stock-out')}}"><i class="fa fa-sign-out"></i>Stock Out List</a></li>
        </ul>
      </li>

      <li class="header"></li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-list-alt"></i><span>Supplier Invoice</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('supplier/supplier')}}"><i class="fa fa-plus"></i> Add Supplier Invoice</a></li>
          <li class="active"><a href="{{url('supplier/invoicelist')}}"><i class="fa fa-list"></i> Supplier Invoice List</a></li>
        </ul>
      </li>
      <li class="header"></li>


      <li class="treeview">
        <a href="#">
          <i class="fa fa-gears"></i><span>Settings</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('settings/')}}"><i class="fa fa-building"></i> Company Info</a></li>
          <li class="active"><a href="{{url('paymentmethods/')}}"><i class="fa fa-money"></i>Payments Method</a></li>
        </ul>
      </li>


      <li class="header"></li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>