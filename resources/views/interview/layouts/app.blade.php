 
<!DOCTYPE html>
<html lang="en-US"> 
<head>
<title>@yield('title')</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="@yield('keyword')" name="keywords">
<meta content="@yield('description')" name="description">
 
 
<link rel="icon" href="{{asset('client/images/favicon.png')}}" type="image/x-icon">
<link rel="stylesheet" href="{{asset('interview/css/tdcss.css')}}">
<link rel="stylesheet" href="{{asset('interview/lib/style.css')}}">
<link href='https://fonts.googleapis.com/css?family=Source%20Code%20Pro' rel='stylesheet'>
 
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ URL::current() }}" />
    <link rel="shortcut icon" href="{{asset('client/images/favicon.png')}}" type="image/png" />
    <meta http-equiv="content-language" content="en-IN">
    <meta name="classification" content="directory portal" />
    <meta name="distribution" content="local" />
    <meta content="All" name="WebCrawlers" />
    <meta content="All, FOLLOW" name="MSNBots" />
    <meta content="All" name="Googlebot-Image" />
    <meta content="All, FOLLOW" name="BINGBots" />
    <meta content="All, FOLLOW" name="YAHOOBots" />
    <meta content="All, FOLLOW" name="GoogleBots" />
    <meta name="copyright" content="Quick Dials">
    <meta name="author" content="Quick Dials" />
    <meta http-equiv="CACHE-CONTROL" content="PUBLIC" />
    <meta name="publisher" content="Quick Dials" />
    <meta name="identifier-URL" content="{{url('/')}}">
    <meta name="msvalidate.01" content="456AED0115D50D42C4F3A79DAB89D41D" />
    <!-- <meta name="p:domain_verify" content="6b026cb56a0cbb53c2811890ecdc5b07"/> -->
    <meta name="google-site-verification" content="O8A-LG3YpW7vOcPtVP9OuNrEcLfLf1kW2tTVpFpHNxM"   />
    <meta name="url" content="{{url('/')}}" />
    <meta name="DC.title" content="@yield('keyword')" />
    <meta name="distribution" content="global" />
    <meta name="geo.region" content="IN-UP" />
    <meta name="geo.placename" content="Noida" />
    <meta name="geo.position" content="28.5802;77.3181" />
    <meta name="ICBM" content="28.5802, 77.3181" />
    <meta name="robots" content="index, follow" />
    <meta name="Revisit-after" content="7 Days" />
    <meta property="og:locale" content="en_IN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:url" content="{{ URL::current() }}" />
    <meta property="og:site_name" content="Quick Dials" />
    <meta name="application-name" content="Quick Dials" />
    <meta property="fb:app_id" content="https://www.facebook.com/quickindofficial/" />
    <meta property="og:image" content="{{asset('client/images/favicon.png')}}" />
    <meta property="og:image:secure_url" content="{{asset('client/images/favicon.png')}}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    <meta property="og:image:alt" content="Quick Dials" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('title')" />
    <meta name="twitter:keyword" content="@yield('keyword')" />
    <meta name="twitter:description" content="@yield('description')" />
    <meta name="twitter:image" content="{{asset('client/images/small-logo.png')}}" />
    <meta name="twitter:url" content="{{ URL::current() }}" />

    <meta name="rating" content="general">
    <meta name="robots" content="ALL">
    <meta name="googlebot" content=" index, follow ">
    <meta name="bingbot" content=" index, follow ">
    <meta name="reply-to" content="info@quickdials.com">
    <meta name="expires" content="never">
    <link rel="alternate" href="https://www.quickdials.com/" hreflang="en-in" />
 
 
<script type='text/javascript'>
var stickyadstatus = "";
function fix_stickyad() {
  document.getElementById("stickypos").style.position = "sticky";
  var elem = document.getElementById("stickyadcontainer");
  if (!elem) {return false;}
  if (document.getElementById("skyscraper")) {
    var skyWidth = Number(getStyleValue(document.getElementById("skyscraper"), "width").replace("px", ""));  
    }
  else {
    var skyWidth = Number(getStyleValue(document.getElementById("right"), "width").replace("px", ""));  
  }
  elem.style.width = skyWidth + "px";
  if (window.innerWidth <= 992) {
    elem.style.position = "";
    elem.style.top = stickypos + "px";
    return false;
  }
  var stickypos = document.getElementById("stickypos").offsetTop;
  var docTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
  var adHeight = Number(getStyleValue(elem, "height").replace("px", ""));
  if (stickyadstatus == "") {
    if ((stickypos - docTop) < 60) {
      elem.style.position = "fixed";
      elem.style.top = "60px";
      stickyadstatus = "sticky";
      document.getElementById("stickypos").style.position = "sticky";

    }
  } else {
    if ((docTop + 60) - stickypos < 0) {  
      elem.style.position = "";
      elem.style.top = stickypos + "px";
      stickyadstatus = "";
      document.getElementById("stickypos").style.position = "static";
    }
  }
  if (stickyadstatus == "sticky") {
    if ((docTop + adHeight + 60) > document.getElementById("footer").offsetTop) {
      elem.style.position = "absolute";
      elem.style.top = (document.getElementById("footer").offsetTop - adHeight) + "px";
      document.getElementById("stickypos").style.position = "static";
    } else {
        elem.style.position = "fixed";
        elem.style.top = "60px";
        stickyadstatus = "sticky";
        document.getElementById("stickypos").style.position = "sticky";
    }
  }
}
function getStyleValue(elmnt,style) {
  if (window.getComputedStyle) {
    return window.getComputedStyle(elmnt,null).getPropertyValue(style);
  } else {
    return elmnt.currentStyle[style];
  }
}
</script>
</head>
<body>
<div class='card-2 topnav notranslate' id='topnav'>
  <div>
    <div class="bar left" style="width:100%;overflow:hidden;height:44px">
       <a href="javascript:void(0);" class="topnav-icons fa fa-menu hide-large left bar-item button active" onclick="open_menu('tutorials')" title="Menu"></a>
    
      <a class="bar-item logo-hover" href="{{url('')}}" ><img src="<?php echo asset('client/images/small-logo.png'); ?>" alt="Quick Dials" style="width: 140px;
    margin-top: -27px;"/></a>
      <a class="bar-item button" href="{{url('interviews/php-interview-question-answer')}}" title='php interview question answer'>PHP Interview header</a>
      <a class="bar-item button" href="{{url('interviews/mysql-interview-question-answer')}}" title='mysql-interview-question-answer'>Mysql Interview</a>
      <a class="bar-item button" href="{{url('interviews/technical-logic-question-answer')}}" title='technical-logic-question-answer'>Technical Logic</a>
      <a class="bar-item button" href="{{url('interviews/laravel-interview-question-answer')}}" title='laravel-interview-question-answer'>Laravel Interview</a>
      <a class="bar-item button" href="{{url('interviews/javascript-interview-question-answer')}}" title='javascript-interview-question-answer'>javascript</a>    
      <a class="bar-item button" href="{{url('interviews/reactjs-interview-question-answer')}}" title='reactjs-interview-question-answer'>reactjs</a> 
      <a class="bar-item button" href="{{url('interviews/restapi-interview-question-answer')}}" title='restapi-interview-question-answer'>Restapi </a>    
 
       
      
     
    </div>
     
    <div id='nav_references' class='bar-block card-2'>
      <span onclick='close_nav("references")' class='button xlarge right' style="position:absolute;right:0;font-weight:bold;">&times;</span>
       <br>
    </div>
    <div id='nav_exercises' class='bar-block card-2'>
      <span onclick='close_nav("exercises")' class='button xlarge right' style="position:absolute;right:0;font-weight:bold;">&times;</span>
       <br>
    </div>
  </div>
</div>

	
<div class='sidebar collapse' id='sidenav' style="top: 44px; display: none;">
  <div id='leftmenuinner'>    
           <div class='light-grey' id='leftmenuinnerinner'>
     <a href='javascript:void(0)' onclick='close_menu("tutorials")' class='button hide-large large display-topright' style='right:0px;padding:0px 12px;font-weight:bold;'>&times;</a> 
<h2 class="left"> </h2>
<a target="_top" href="{{url('interviews/php-interview-question-answer')}}">PHP Interview Question Answer index</a>
<a target="_top" href="{{url('interviews/mysql-interview-question-answer')}}">Mysql Interview Question Answer</a>
<a target="_top" href="{{url('interviews/technical-logic-question-answer')}}">Technical Logic Question Answer</a>
<a target="_top" href="{{url('interviews/laravel-interview-question-answer')}}">Laravel Interview Question Answer</a>
<a target="_top" href="{{url('interviews/javascript-interview-question-answer')}}">Javascript Interview Question Answer</a>
<a target="_top" href="{{url('interviews/reactjs-interview-question-answer')}}">Reactjs Interview Question Answer</a>
<a target="_top" href="{{url('interviews/restapi-interview-question-answer')}}">Rest API Interview Question Answer</a> 
 
  
      <br><br>
    </div>
 
    </div>
</div>

    @yield('content')





<div id="footer" class="footer container white">

<hr>

<div style="overflow:auto">
  <div class="bottomad">
    <!-- BottomMediumRectangle -->
    <!--<pre>bottom_medium_rectangle, all: [970,250][300,250][336,280]</pre>-->
    <div id="snhb-bottom_medium_rectangle-0" style="padding:0 10px 10px 0;float:left;width:auto;"></div>
    <!-- adspace bmr -->
    <!-- RightBottomMediumRectangle -->
    <!--<pre>right_bottom_medium_rectangle, desktop: [300,250][336,280]</pre>-->
    <div id="snhb-right_bottom_medium_rectangle-0" style="padding:0 10px 10px 0;float:left;width:auto;"></div>
  </div>
</div>

<hr>
 
 
 
<div class="container light-grey padding" id="err_sent" style="display:none;position:relative">
<span onclick="this.parentElement.style.display='none'" class="button display-topright">&times;</span>     
<h2>Thank You For Helping Us!</h2>
<p>Your message has been sent to tutorial.</p>
</div>

<div class="row center small">
<div class="col l3 m6 s12">
<div class="top10">
<h4>Page</h4>

<a target="_top" href="{{url('interviews/php-interview-question-answer') }}">PHP Interview Question Answer </a><br>
<a target="_top" href="{{url('interviews/mysql-interview-question-answer')}}">Mysql Interview Question Answer</a><br>
<a target="_top" href="{{url('interviews/technical-logic-question-answer') }}">Technical Logic Question Answer</a><br>
<a target="_top" href="{{url('interviews/laravel-interview-question-answer')}}">Laravel Interview Question Answer</a><br>
<a target="_top" href="{{url('interviews/javascript-interview-question-answer')}}">Javascript Interview Question Answer</a><br>
<a target="_top" href="{{url('interviews/reactjs-interview-question-answer')}}">Reactjs Interview Question Answer</a><br>
<a target="_top" href="{{url('interviews/restapi-interview-question-answer')}}">Rest API Interview Question Answer</a> <br>
 
</div>
</div>
<div class="col l3 m6 s12">
<div class="top10">
<h4>Topice</h4>
<span>Array Define</span><br>
<span>CSS Define</span><br>
<span>laravel installation</span><br>
<span>SQL Reference</span><br>
<span>Python Reference</span><br>
  
 
</div>
</div>
<div class="col l3 m6 s12">
<div class="top10">
<h4>Project</h4>
<span>PHP Insert/Update/Delete</span><br>
<span>Laravel Insert/Update/Delete</span><br>
<span>Codeigniter Insert/Update/Delete</span><br>
 
</div>
</div>
<div class="col l3 m6 s12">
<div class="top10">
<h4>Web Certificates</h4>
<span>HTML Certificate</span><br>
 
 

</div>
</div>        
</div>        

<hr>
 
 
</div>
</div>




<script src="{{url('interview/lib/tutorial_footer.js')}}"></script>
 
</body>

 
</html>
