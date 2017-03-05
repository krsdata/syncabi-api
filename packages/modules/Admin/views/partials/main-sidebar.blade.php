<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar" style="height: auto;">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img alt="User Image" class="img-circle" src="{{ URL::asset('public/assets/dist/img/user2-160x160.jpg') }}">
      </div>
      <div class="pull-left info">
        <p>Udex</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      
      <li class="active treeview">
        <a href="{{ url('admin') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span> </i>
        </a>
          
      </li> 
      <li class="treeview {{ (isset($page_action) && $page_title=='Corporate Profile')?"active":'' }} ">
        <a href="#">
          <i class="fa fa-user"></i>
          <span>Manage Corporate Profile</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
           <li class="{{ (isset($page_action) && $page_action=='View Corporate Profile')?"active":'' }}"><a href="{{ route('corporateProfile')}}"><i class="fa  fa-list"></i> Corporate Profile </a></li>
        </ul>
      </li> 
      
      <li class="treeview {{ (isset($page_action) && $page_title=='Monthly Evaluation Report')?"active":'' }} ">
        <a href="{{url('admin/corporate-monthly-report')}}">
          <i class="fa fa-user"></i>
          <span>Monthly Evaluation Report</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
           <li class="{{ (isset($page_action) && $page_action=='Corporate monthly report')?"active":'' }}"><a href="{{ url('admin/corporate-monthly-report')}}"><i class="fa  fa-list"></i> View Report </a></li>
        </ul>
      </li> 



      <li class="treeview {{ (isset($page_action) && $page_title=='Candidate Directory')?"active":'' }} ">
        <a href="#">
          <i class="fa fa-user"></i>
          <span>Candidate Directory</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
           <li class="{{ (isset($page_action) && $page_action=='View Directory')?"active":'' }}"><a href="{{ url('admin/condidateDirectory')}}"><i class="fa  fa-list"></i>Candidate Directory</a></li>
        </ul>
      </li>  
      <li class="treeview {{ (isset($page_action) && $page_title=='User')?"active":'' }} ">
        <a href="#">
          <i class="fa fa-user"></i>
          <span>Manage Users</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <!-- <li class="{{ (isset($page_action) && $page_action=='Create User')?"active":'' }}" ><a href="{{ route('user.create')}}"><i class="fa fa-user-plus"></i> Create User</a></li>
           --><li class="{{ (isset($page_action) && $page_action=='View User')?"active":'' }}"><a href="{{ route('user')}}"><i class="fa  fa-list"></i> View User</a></li>
        </ul>
      </li>

      <li class="treeview {{ (isset($page_action) && $page_title=='Position')?"active":'' }} ">
        <a href="#">
          <i class="fa fa-user"></i>
          <span>Manage Position</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ (isset($page_action) && $page_action=='Create Position')?"active":'' }}" ><a href="{{ route('position.create')}}"><i class="fa fa-user-plus"></i> Create Position</a></li>
          <li class="{{ (isset($page_action) && $page_action=='View Position')?"active":'' }}"><a href="{{ route('position')}}"><i class="fa  fa-list"></i> View Position</a></li>
        </ul>
      </li>

      <li class="treeview {{ (isset($page_action) && $page_title=='Criteria')?"active":'' }} ">
        <a href="#">
          <i class="fa fa-user"></i>
          <span>Manage Criteria</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="{{ (isset($page_action) && $page_action=='Create Criteria')?"active":'' }}" ><a href="{{ route('criteria.create')}}"><i class="fa fa-user-plus"></i> Create Criteria</a></li>
          <li class="{{ (isset($page_action) && $page_action=='View Criteria')?"active":'' }}"><a href="{{ route('criteria')}}"><i class="fa  fa-list"></i> View Criteria</a></li>
        </ul>
      </li>  
      

      <li class="treeview {{ (isset($page_action) && $page_title=='Rating Feedback')?"active":'' }} ">
        <a href="#">
          <i class="fa fa-user"></i>
          <span>Manage Rating</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
           <li class="{{ (isset($page_action) && $page_action=='Rating')?"active":'' }}"><a href="{{ route('ratingFeedback')}}"><i class="fa  fa-list"></i> View Rating </a></li>
        </ul>
      </li>       

      <li class="treeview {{ (isset($page_action) && $page_title=='Default Criteria')?"active":'' }} ">
        <a href="#">
          <i class="fa fa-user"></i>
          <span>Default Evaluation Criteria</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="{{ (isset($page_action) && $page_action=='Create Default Criteria')?"active":'' }}" ><a href="{{ route('defaultCriteria.create')}}"><i class="fa fa-user-plus"></i> Create Default Criteria</a></li>
           <li class="{{ (isset($page_action) && $page_action=='View Default Criteria')?"active":'' }}"><a href="{{ route('defaultCriteria')}}"><i class="fa  fa-list"></i>Default Criteria </a></li>
        </ul>
      </li> 


    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
 
