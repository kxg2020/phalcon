<!DOCTYPE html>
<html>
<head>
  <title>旋猫猫之家</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  
  
  <link href="/public/css/bootstrap.css" rel="stylesheet" media="screen">
  <link href="/public/layer/skin/default/layer.css" rel="stylesheet" media="screen">
  <link href="/public/css/thin-admin.css" rel="stylesheet" media="screen">
  <link href="/public/css/font-awesome.css" rel="stylesheet" media="screen">
  <link href="/public/style/style.css" rel="stylesheet">
  <link href="/public/style/dashboard.css" rel="stylesheet">
  <link href="/public/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="/public/assets/js/html5shiv.js"></script>
  <script src="/public/assets/js/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<div class="container">
  <div class="top-navbar header b-b"> <a data-original-title="Toggle navigation" class="toggle-side-nav pull-left" href="#"><i class="icon-reorder"></i> </a>
    <div class="brand pull-left"> <a href="index.html"><img src="/public/images/logo.png" width="147" height="33"></a></div>
    <ul class="nav navbar-nav navbar-right  hidden-xs">
      <li class="dropdown user  hidden-xs"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="icon-male"></i> <span class="username">John Doe</span> <i class="icon-caret-down small"></i> </a>
        <ul class="dropdown-menu">
          <li><a href="user_profile.html"><i class="icon-user"></i> My Profile</a></li>
          <li><a href="fullCalendar.html"><i class="icon-calendar"></i> My Calendar</a></li>
          <li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>
          <li class="divider"></li>
          <li><a href="login.html"><i class="icon-key"></i> Log Out</a></li>
        </ul>
      </li>
    </ul>
    <form class="pull-right" >
      <input type="search" placeholder="Search..." class="search" id="search-input">
    </form>
  </div>
</div>
<div class="wrapper">
  <div class="left-nav">
    <div id="side-nav">
      <ul id="nav">
        <li class="current"> <a href="index.html"> <i class="icon-dashboard"></i> 我的首页 </a> </li>
        <li> <a href="#"> <i class="icon-table" ></i> 图片管理 <span class="label label-info pull-right"></span> <i class="arrow icon-angle-left"></i></a>
          <ul class="sub-menu">
            <li> <a href="<?= $this->url->get('backend/image/index') ?>"> <i class="icon-angle-right"></i> 图片列表 </a> </li>
            <li> <a href="<?= $this->url->get('backend/image/add') ?>"> <i class="icon-angle-right"></i> 图片添加 </a> </li>
          </ul>
        </li>
        <li> <a href="#"> <i class="icon-flag"></i> 文章管理 <span class="label label-info pull-right"></span> <i class="arrow icon-angle-left"></i></a>
          <ul class="sub-menu">
            <li> <a href="icons-new.html"> <i class="icon-angle-right"></i> 文章列表 </a> </li>
            <li> <a href="icons.html"> <i class="icon-angle-right"></i> 文章添加 </a> </li>
          </ul>
        </li>
        <li> <a href="gallery.html"> <i class="icon-picture"></i> Gallery </a> </li>
        <li> <a href="timeline.html"> <i class="icon-time"></i> Timeline </a> </li>
        <li> <a href="#"> <i class="icon-folder-open-alt"></i> Pages <span class="label label-info pull-right">5</span> <i class="arrow icon-angle-left"></i></a>
          <ul class="sub-menu">
            <li> <a href="login.html"> <i class="icon-angle-right"></i> Login </a> </li>
            <li> <a href="user_profile.html"> <i class="icon-angle-right"></i> User Profile </a> </li>
            <li> <a href="mailbox.html"> <i class="icon-angle-right"></i> Mailbox </a> </li>
            <li> <a href="fullCalendar.html"> <i class="icon-angle-right"></i> Calendar </a> </li>
            <li> <a href="404-page.html"> <i class="icon-angle-right"></i> 404-page </a> </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
  <div class="page-content">
    <div class="content container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="page-title">Dashboard <small>Statistics and more</small></h2>
        </div>
      </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="widget">
                <div class="widget-header"> <i class="icon-external-link"></i>
                    <h3> Multiple File Upload </h3>
                </div>
                <div class="widget-content">



                    <div class="panel-body">
                        <p>File Upload widget with multiple file selection, drag&amp;drop support, progress bars, validation and preview
                            images, audio and video for jQuery.</p>
                        <p>Supports cross-domain, chunked and resumable file uploads and client-side image resizing.<br>
                            Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports
                            standard HTML form file uploads.</p>
                        <div class="row" id="image_box">


                        </div>

                        <!-- The file upload form used as target for the file upload widget -->
                        <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data" class="">
                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                            <noscript>&lt;input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/" /&gt;</noscript>
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->

                            <div class="row fileupload-buttonbar">
                                <div class="col-lg-7">
                                    <div class="btn-toolbar">
                                        <!-- The fileinput-button span is used to style the file input field as button --><form method="post" action="<?= $this->url->get('backend/image/upload') ?>">
                                    <span class="btn btn-success fileinput-button" style="position: relative">
                                        <i class="icon-plus"></i>
                                        <span>点击上传.</span>
                                        <input style="position: absolute; top: 0;left: 0; opacity: 0;width: 100%;height: 100% " type="file" name="files" multiple="" id="file_upload">
                                    </span>
                                            <!-- The loading indicator is shown during file processing -->              </form>
                                        <span class="fileupload-loading" ></span>
                                    </div>
                                </div>
                                <!-- The global progress information -->
                                <div class="col-lg-5 fileupload-progress fade">
                                    <!-- The global progress bar -->
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                    </div>
                                    <!-- The extended global progress information -->
                                    <div class="progress-extended">&nbsp;</div>
                                </div>
                            </div>
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped">
                                <tbody class="files"></tbody>
                            </table>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>



    </div>
  </div>
</div>
<div class="bottom-nav footer"> 2013 &copy; Thin Admin by Riaxe Systems. </div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/public/js/jquery.js"></script>
<script src="/public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/public/js/smooth-sliding-menu.js"></script>
<script class="include" type="text/javascript" src="/public/javascript/jquery191.min.js"></script>
<script class="include" type="text/javascript" src="/public/javascript/jquery.jqplot.min.js"></script>
<script src="/public/assets/sparkline/jquery.sparkline.js" type="text/javascript"></script>
<script src="/public/assets/sparkline/jquery.customSelect.min.js" ></script>
<script src="/public/assets/sparkline/sparkline-chart.js"></script>
<script src="/public/assets/sparkline/easy-pie-chart.js"></script>
<script src="/public/js/select-checkbox.js"></script>
<script src="/public/js/to-do-admin.js"></script>

<script src="/public/js/jquery-3.0.0.min.js"></script>
<script src="/public/layer/layer.js"></script>
<script src="/public/layer/laypage.js"></script>
<script src="/public/layer/layui.js"></script>
<script src="/public/js/jquery.html5upload.js"></script>
<script src="/public/js/xuanmaomao/upload-to-qiniu.js"></script>

<!--switcher html start-->
<div class="demo_changer active" style="right: 0px;">
  <div class="demo-icon"></div>
  <div class="form_holder">
    <div class="predefined_styles"> <a class="styleswitch" rel="a" href=""><img alt="" src="/public/images/a.jpg"></a> <a class="styleswitch" rel="b" href=""><img alt="" src="/public/images/b.jpg"></a> <a class="styleswitch" rel="c" href=""><img alt="" src="/public/images/c.jpg"></a> <a class="styleswitch" rel="d" href=""><img alt="" src="/public/images/d.jpg"></a> <a class="styleswitch" rel="e" href=""><img alt="" src="/public/images/e.jpg"></a> <a class="styleswitch" rel="f" href=""><img alt="" src="/public/images/f.jpg"></a> <a class="styleswitch" rel="g" href=""><img alt="" src="/public/images/g.jpg"></a> <a class="styleswitch" rel="h" href=""><img alt="" src="/public/images/h.jpg"></a> <a class="styleswitch" rel="i" href=""><img alt="" src="/public/images/i.jpg"></a> <a class="styleswitch" rel="j" href=""><img alt="" src="/public/images/j.jpg"></a> </div>
  </div>
</div>
<!--switcher html end-->
<script src="/public/assets/switcher/switcher.js"></script>
<script src="/public/assets/switcher/moderziner.custom.js"></script>

<link href="/public/assets/switcher/switcher.css" rel="stylesheet">
<link href="/public/assets/switcher/switcher-defult.css" rel="stylesheet">
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/a.css" title="a" media="all" />
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/b.css" title="b" media="all" />
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/c.css" title="c" media="all" />
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/d.css" title="d" media="all" />
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/e.css" title="e" media="all" />
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/f.css" title="f" media="all" />
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/g.css" title="g" media="all" />
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/h.css" title="h" media="all" />
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/i.css" title="i" media="all" />
<link rel="alternate stylesheet" type="text/css" href="/public/assets/switcher/j.css" title="j" media="all" />
</body>
</html>
