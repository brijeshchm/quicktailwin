/*!
 * Start Bootstrap - SB Admin 2 v3.3.7+1 (http://startbootstrap.com/template-overviews/sb-admin-2)
 * Copyright 2013-2016 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
$(function() {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent().parent().addClass('in').parent();

    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});
// above content is of sb-admin-2.js file

// **************
// SPINNER OBJECT
	var mainSpinner = (function(){
		var opts = {
		  lines: 13 // The number of lines to draw
		, length: 28 // The length of each line
		, width: 14 // The line thickness
		, radius: 42 // The radius of the inner circle
		, scale: 1 // Scales overall size of the spinner
		, corners: 1 // Corner roundness (0..1)
		, color: '#000' // #rgb or #rrggbb or array of colors
		, opacity: 0.25 // Opacity of the lines
		, rotate: 0 // The rotation offset
		, direction: 1 // 1: clockwise, -1: counterclockwise
		, speed: 1 // Rounds per second
		, trail: 60 // Afterglow percentage
		, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
		, zIndex: 2e9 // The z-index (defaults to 2000000000)
		, className: 'spinner' // The CSS class to assign to the spinner
		, top: '50%' // Top position relative to parent
		, left: '50%' // Left position relative to parent
		, shadow: false // Whether to render a shadow
		, hwaccel: false // Whether to use hardware acceleration
		, position: 'absolute' // Element positioning
		};
		var spinnerBkgd = document.getElementById('spinnerBkgd');
		var target = document.getElementById('spinnerCntr');
		var spinner = new Spinner(opts);
		return {
			start:function(){
				spinner.spin(target);
				spinnerBkgd.style.display = 'block';
			},
			stop:function(){
				spinner.stop();
				spinnerBkgd.style.display = 'none';
			}
		}
	})();
// SPINNER OBJECT
// **************

// ***********
// DATA TABLES
var recordCollection;
// $('.dob').datepicker();
$('.dob').datepicker({
    maxDate: 0,          // today allowed, future disabled
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    changeYear: true,
    yearRange: '1900:' + new Date().getFullYear()
});
var dataTablePermission = $('#datatable-permission')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
	"ajax":{
		url:"/developer/permission/getpermission",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();

var dataTableRolePermission = $('#datatable-role-permission')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
	"ajax":{
		url:"/developer/role-permission/getpermission",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();

var dataTableSeoKwd = $('#datatable-seo-kwd-assign')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
	"ajax":{
		url:"/developer/seo-kwd-assign/get-seo-kwd-assign",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();



var dataTableseafff = $('#datatable-assign-kwd-team')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
	"ajax":{
		url:"/developer/team-kwd-assign/get-team-assign-seo-keyword",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();



var dataTableAllTransactions = $('#datatable-all-transactions').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"searching":false,
	"ajax":{
		url:removeHashFromURL(window.location.href),
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();



var dataTableOccupation = $('#datatable-occupation')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
	"ajax":{
		url:"/developer/occupation/get-occupation",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();


var dataTableSeoCity = $('#datatable-seoCity')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
	"ajax":{
		url:"/developer/seoCity/get-seoCity",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();


var dataTableKeywordSellCounts = $('#dataTables-keywordSellCounts')
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"lengthMenu": [
            [10,25,50,100,250,500],
            ['10','25','50','100','250','500']
        ],
	"ajax":{
		url:"/developer/keywordSellCounts/get-keywordSellCounts",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();


var dataTableAllCategory = $('#dataTables-categories').on('draw.dt',function(e,settings){
	$('#dataTables-categories').find('[data-toggle="popover"]').popover({html:true,container:'body'});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"ordering":false,
	"paging":true,
	"ajax":{
		url:"/developer/get-parent-category",
		data:function(d){
			d.page = (d.start/d.length)+1;		 
			d.columns = null;
			d.order = null;
		}
	}
}).api();


var dataTableAllChild = $('#dataTables-child_categories').on('draw.dt',function(e,settings){
	$('#dataTables-child_categories').find('[data-toggle="popover"]').popover({html:true,container:'body'});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"ordering":false,
	"paging":true,
	"ajax":{
		url:"/developer/get-child-category",
		data:function(d){
			d.page = (d.start/d.length)+1;		 
			d.columns = null;
			d.order = null;
		}
	}
}).api();


/* var dataTableAllOrderHistory = $('#datatable-all-order-history').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"searching":false,
	"ajax":{
		//url:removeHashFromURL(window.location.href),
			url:"/developer/order-history",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();
			d.search['client_type']=$('*[name="search[client_type]"]').val();
			d.columns = null;
			d.order = null;
		}
	}
}).api();
 */

var dataTableAllOrderHistory = $('#datatable-all-order-history').on('draw.dt',function(e,settings){
	$('#datatable-all-order-history').find('[data-toggle="popover"]').popover({html:true,container:'body'});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"ordering":false,
	"paging":true,
	"ajax":{
		url:"/developer/order-history",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['client_type']=$('*[name="search[client_type]"]').val();		 
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();		 
			d.search['value']=$('*[name="search[value]"]').val();
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableTransactions = $('#datatable-transactions').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"searching":false,
	"ajax":{
		url:removeHashFromURL(window.location.href)+"/get-paginated-transactions",
		data:function(d){
			d.page = (d.start/d.length)+1;
			
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTablePaymentHistory = $('#datatable-payment-history').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"searching":false,
	"ajax":{
		url:removeHashFromURL(window.location.href)+"/get-paginated-payment-history",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();


var dataTableViewAllLeads = $('#datatable-meetings').on('draw.dt',function(e,settings){
	$('#datatable-meetings').find('[data-toggle="popover"]').popover({html:true,container:'body'});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"ordering":false,
	"paging":true,
	"ajax":{
		url:"/developer/clients/meetings",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['client_type']=$('*[name="search[client_type]"]').val();
			d.search['city']=$('*[name="search[city][]"]').val();
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();
			d.search['status']=$('*[name="search[status][]"]').val();
			d.search['user']=$('*[name="search[user]"]').val();
			d.search['value']=$('*[name="search[value]"]').val();
			d.columns = null;
			d.order = null;
		}
	}
}).api();


var dataTableCitylist = $('#datatable-citylist').on('draw.dt',function(e,settings){
	$('#datatable-citylist').find('[data-toggle="popover"]').popover({html:true,container:'body'});
	$('#datatable-citylist').find('#check-all').on('change',function(){
		if(this.checked){
			$('.check-box').prop('checked',true);
		}else{
			$('.check-box').prop('checked',false);
		}
	});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,	
	//"searching":true,	
	"ajax":{
		url:"/developer/cities/getcities",
		data:function(d){
			d.page = (d.start/d.length)+1;
			//d.search['value']=$('*[name="search[value]"]').val();
			d.columns = null;
			d.order = null;
		}
	}
}).api(); 
  	
var dataTableAssignedZones = $('#datatable-assigned-zones').on('draw.dt',function(e,settings){
	$('#datatable-assigned-zones').find('[data-toggle="popover"]').popover({html:true,container:'body'});
	$('#datatable-assigned-zones').find('#check-all').on('change',function(){
		if(this.checked){
			$('.check-box').prop('checked',true);
		}else{
			$('.check-box').prop('checked',false);
		}
	});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,	
	"lengthMenu": [ 10, 25, 50, 75, 100 ],	
	"ajax":{		 
		url:removeHashFromURL(window.location.href)+"/get-assigned-zones",
		data:function(d){
			d.page = (d.start/d.length)+1;		 	 
			d.columns = null;
			d.order = null;
		} 
		 
	}
}).api();

var dataTableAssignedAreas = $('#datatable-assigned-areas').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"searching":false,
	"ajax":{
		url:removeHashFromURL(window.location.href)+"/get-assigned-areas",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableArea = $('#datatable-area').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"ajax":{
		url:removeHashFromURL(window.location.href),
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableZone = $('#datatable-zone').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"ajax":{
		url:removeHashFromURL(window.location.href),
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableSEO = $('#datatable-seo').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"lengthMenu": [
            [10,25,50,100,250,500,1000],
            ['10','25','50','100','250','500','1000']
        ],
	"ajax":{
		url:location.href,
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();



var dataTableCategorySEO = $('#datatable-category-seo').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"ajax":{
		url:"/developer/category/seo",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();


var dataTableformType = $('#datatable-form-type').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"ajax":{
		url:"/developer/form-type/get-form-type",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTablehomeSlider = $('#datatable-home_slider').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"ajax":{
		url:"/developer/home_slider/get-home_slider",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableAuthor = $('#datatable-author').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"ajax":{
		url:"/developer/author/get-author",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();



var dataTableChildCategorySEO = $('#datatable-Childcategory-seo').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"responsive":true,
	"ajax":{
		url:"/developer/childcategory/seo",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();





var dataTableClients = $('#datatable-clients').on('draw.dt',function(e,settings){
	$('#datatable-clients').find('[data-toggle="popover"]').popover({html:true,container:'body'});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"fnInitComplete":function(){$('#datatable-clients').find('[data-toggle="popover"]').popover();},
	"ajax":{
		url:"/developer/clients/list/getclients",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['client_type']=$('*[name="search[client_type]"]').val();
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();
			d.search['city']=$('*[name="search[city][]"]').val();
			d.search['client_category']=$('*[name="search[client_category]"]').val();
			d.search['paid_status']=$('*[name="search[paid_status]"]').val();
			d.search['keyword']=$('*[name="search[keyword]"]').val();
			d.search['user']=$('*[name="search[user]"]').val();
			//d.search['value']=$('*[name="search[value]"]').val();
			d.columns = null;
			d.order = null;
			 return false;
		//alert(JSON.stringify(d.search['keyword']));
			 
		}
	}
}).api();
 
var dataTableAllLeads = $('#datatable-all-leads').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ajax":{
		url:location.href,
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['city']=$('*[name="search[city]"]').val();
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();
			d.search['course']=$('*[name="search[course]"]').val();
			d.columns = null;
			d.order = null;
		}
	}
}).api();
 

var dataTablePendingNewLeads = $('#datatable-new-leads').on('draw.dt',function(e,settings){
	$('#datatable-new-leads').find('[data-toggle="popover"]').popover({html:true,container:'body'});
	$('#datatable-new-leads').find('#check-all').on('change',function(){
		if(this.checked){
			$('.check-box').prop('checked',true);
		}else{
			$('.check-box').prop('checked',false);
		}
	});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,	
"lengthMenu": [ 10, 25, 50, 75, 100 ],	
	"ajax":{
		url:"/developer/getnewlead",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['city']=$('*[name="search[city][]"]').val();
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['calldf']=$('*[name="search[datet]"]').val();
			d.search['calldf']=$('*[name="search[calldf]"]').val();
			d.search['calldt']=$('*[name="search[calldt]"]').val();	
			d.search['expdf']=$('*[name="search[expdf]"]').val();
			d.search['expdt']=$('*[name="search[expdt]"]').val();
			d.search['assign_status']=$('*[name="search[assign_status]"]').val();
			d.search['course']=$('*[name="search[course][]"]').val();
			d.search['status']=$('*[name="search[status][]"]').val();
			d.search['lead_type']=$('*[name="search[lead_type]"]').val();
			d.search['user']=$('*[name="search[user]"]').val();			 
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			
			return json.data;
		}
		 
	}
}).api();

var dataTablePendingSeoReport = $('#datatable-seo-report').on('draw.dt',function(e,settings){
	$('#datatable-seo-report').find('[data-toggle="popover"]').popover({html:true,container:'body'});
	$('#datatable-seo-report').find('#check-all').on('change',function(){
		if(this.checked){
			$('.check-box').prop('checked',true);
		}else{
			$('.check-box').prop('checked',false);
		}
	});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,	
"lengthMenu": [ 10, 25, 50, 75, 100 ],	
	"ajax":{
		url:"/developer/seo-report",
		data:function(d){
			d.page = (d.start/d.length)+1;
			 
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();			 
			d.search['user']=$('*[name="search[user]"]').val();			 
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			
			return json.data;
		}
		 
	}
}).api();

function filterAjaxSeoWork(tableID,THIS){
		 
		var res = tableID.split("-");
		res = res.map(function($el){
			return $el.charAt(0).toUpperCase() + $el.slice(1);
		});
		res.shift();
		tableID = res.join('');
		tableID = "dataTable"+tableID;
		window[tableID].ajax.reload(null,false);
	//	alert(test); 
		//dataTablePendingLeadsDemos.ajax.reload(null,false);
		return false;
	}
var dataTablePendingSeoWork = $('#datatable-seo-work').on('draw.dt',function(e,settings){
	$('#datatable-seo-work').find('[data-toggle="popover"]').popover({html:true,container:'body'});
	$('#datatable-seo-work').find('#check-all').on('change',function(){
		if(this.checked){
			$('.check-box').prop('checked',true);
		}else{
			$('.check-box').prop('checked',false);
		}
	});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,	
"lengthMenu": [ 10, 25, 50, 75, 100 ],	
	"ajax":{
		url:"/developer/seo-work/get-seo-work",
		data:function(d){
			d.page = (d.start/d.length)+1;			 
			d.search['city']=$('*[name="search[city][]"]').val();		 
			d.search['course']=$('*[name="search[course][]"]').val();
			d.search['status']=$('*[name="search[status][]"]').val();		 
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();			 
			d.search['user']=$('*[name="search[user]"]').val();			 
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			
			return json.data;
		}
		 
	}
}).api();

var dataTableClassifiedProfile = $('#datatable-classified-profile').on('draw.dt',function(e,settings){
	$('#datatable-classified-profile').find('[data-toggle="popover"]').popover({html:true,container:'body'});
	$('#datatable-classified-profile').find('#check-all').on('change',function(){
		if(this.checked){
			$('.check-box').prop('checked',true);
		}else{
			$('.check-box').prop('checked',false);
		}
	});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,	
"lengthMenu": [ 10, 25, 50, 75, 100 ],	
	"ajax":{
		url:"/developer/classified-profile/get-classified-profile",
		data:function(d){
			d.page = (d.start/d.length)+1;
			 
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();			 
			d.search['user']=$('*[name="search[user]"]').val();			 
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			
			return json.data;
		}
		 
	}
}).api();



var dataTableLeadNotInterested = $('#datatable-lead-not-interested').on('draw.dt',function(e,settings){
	$('#datatable-lead-not-interested').find('[data-toggle="popover"]').popover({html:true,container:'body'});
}).dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"columnDefs":[
		{
			orderable:false,
			targets:[0]
		}
	],
	"lengthMenu": [
            [10,25,50,100,250,500,1000],
            ['10','25','50','100','250','500','1000']
        ],
	"fnInitComplete":function(){
		$('#datatable-lead-not-interested').find('[data-toggle="popover"]').popover({html:true,container:'body'});
		$('#datatable-lead-not-interested').find('#check-all').on('change',function(){
			if(this.checked){
				$('.check-box').prop('checked',true);
			}else{
				$('.check-box').prop('checked',false);
			}
		});
	},
	"ajax":{
			//url:"/developer/new-lead/not-interested",		
			url:"/developer/new-lead",			
		data:function(d){
		 
			$('#check-all').prop('checked',false);
			d.page = (d.start/d.length)+1;			 
			d.search['city']=$('*[name="search[city][]"]').val();
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();	
			d.search['expdf']=$('*[name="search[expdf]"]').val();
			d.search['expdt']=$('*[name="search[expdt]"]').val();
			d.search['assign_status']=$('*[name="search[assign_status]"]').val();
			d.search['course']=$('*[name="search[course][]"]').val();
			d.search['status']=$('*[name="search[status][]"]').val();
			d.search['lead_type']=$('*[name="search[lead_type]"]').val();
			d.search['user']=$('*[name="search[user]"]').val();		
			d.search['not_interested']=new String("1").valueOf();
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
function filterAjaxLeadData(tableID,THIS){
		 
		var res = tableID.split("-");
		res = res.map(function($el){
			return $el.charAt(0).toUpperCase() + $el.slice(1);
		});
		res.shift();
		tableID = res.join('');
		tableID = "datatable"+tableID;
		window[tableID].ajax.reload(null,false); 
		return false;
	}


var datatablePendingLeadsDashboard = $('#datatable-pending-leads-dashboard').on('draw.dt',function(e,settings){
	$('#datatable-pending-leads-dashboard').find('[data-toggle="popover"]').popover({html:true,container:'body'});
	$('#datatable-pending-leads-dashboard').find('#check-all').on('change',function(){
		if(this.checked){
			$('.check-box').prop('checked',true);
		}else{
			$('.check-box').prop('checked',false);
		}
	});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,	 
	"ajax":{
		url:"/developer/lead-dashboard/get-pending-leads-dashboard",
		 
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['city']=$('*[name="search[city][]"]').val();
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();
			d.search['course']=$('*[name="search[course][]"]').val();
			d.search['status']=$('*[name="search[status][]"]').val();
			d.search['lead_type']=$('*[name="search[lead_type]"]').val();
			//d.search['user']=$('*[name="search[user]"]').val();
			d.search['counsellor']=$('.counsellor-control').val();
			d.columns = null;
			d.order = null;
		},
		 dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		} 
	}
}).api();


var datatablePendingLeadsConversion = $('#datatable-pending-leads-conversion').on('draw.dt',function(e,settings){
	$('#datatable-pending-leads-conversion').find('[data-toggle="popover"]').popover({html:true,container:'body'});
	$('#datatable-pending-leads-conversion').find('#check-all').on('change',function(){
		if(this.checked){
			$('.check-box').prop('checked',true);
		}else{
			$('.check-box').prop('checked',false);
		}
	});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,	 
	"ajax":{
		url:"/developer/lead-conversion/get-pending-leads-conversion",
		 
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['city']=$('*[name="search[city][]"]').val();
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();
			d.search['course']=$('*[name="search[course][]"]').val();
			d.search['status']=$('*[name="search[status][]"]').val();
			d.search['lead_type']=$('*[name="search[lead_type]"]').val();
			//d.search['user']=$('*[name="search[user]"]').val();
			d.search['client']=$('*[name="search[client]"]').val();
			d.search['counsellor']=$('.counsellor-control').val();
			d.columns = null;
			d.order = null;
		},
		 dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		} 
	}
}).api();


var dataTablePushLeads = $('#datatable-push-leads').on('draw.dt',function(e,settings){
	$('#datatable-push-leads').find('[data-toggle="popover"]').popover({html:true,container:'body'});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ordering":false,
	"ajax":{
		url:removeHashFromURL(window.location.href),
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableViewAllKwds = $('#datatable-view-all-kwds').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"lengthMenu": [
            [10,25,50,100,250,500,1000],
            ['10','25','50','100','250','500','1000']
        ],
	"ajax":{
		url:"/developer/keyword/getkwds",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['city']=$('*[name="search[city]"]').val();
			d.search['pc']=$('*[name="search[pc]"]').val();
			d.search['cc']=$('*[name="search[cc]"]').val();
			d.search['cat']=$('*[name="search[cat]"]').val();
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableModeDetails = $('#datatable-modedetails').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ajax":{
		url:"/developer/mode/getmode",
		data:function(d){
			d.page = (d.start/d.length)+1;			 
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableBlogDetails = $('#datatable-blogdetails').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ajax":{
		url:"/developer/blog/getblogdetails",
		data:function(d){
			d.page = (d.start/d.length)+1;			 
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableTestimonialsDetails = $('#datatable-testimonialsdetails').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ajax":{
		url:"/developer/testimonials/gettestimonialsdetails",
		data:function(d){
			d.page = (d.start/d.length)+1;			 
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableBanksdetails = $('#datatable-banksdetails').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ajax":{
		url:"/developer/banks/getbanksdetails",
		data:function(d){
			d.page = (d.start/d.length)+1;			 
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableViewAllLeads = $('#datatable-view-paid-clients').on('draw.dt',function(e,settings){
	$('#datatable-view-paid-clients').find('[data-toggle="popover"]').popover({html:true,container:'body'});
})
.dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"ordering":false,
	"paging":true,
	"ajax":{
		url:"/developer/dashboard/get-paid-client",
		data:function(d){
			d.page = (d.start/d.length)+1;
			d.search['client_type']=$('*[name="search[client_type]"]').val();
			d.search['city']=$('*[name="search[city][]"]').val();
			d.search['datef']=$('*[name="search[datef]"]').val();
			d.search['datet']=$('*[name="search[datet]"]').val();
			d.search['amtf']=$('*[name="search[amtf]"]').val();
			d.search['amtt']=$('*[name="search[amtt]"]').val();
			d.search['client_cat']=$('*[name="search[client_cat]"]').val();
			d.search['paid_status']=$('*[name="search[paid_status]"]').val();
			d.search['user']=$('*[name="search[user]"]').val();
			d.columns = null;
			d.order = null;
		}
	}
}).api();

var dataTableViewAllLeads = $('#datatable-view-all-leads').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ajax":{
		url:removeHashFromURL(window.location.href)+"/getleads",
		data:function(d){
			d.page = (d.start/d.length)+1;
		}
	}
}).api();


 

var dataTableLeadBeneficiary = $('#datatable-lead-beneficiary').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"paging":true,
	"ajax":{
		url:location.href,
		data:function(d){
			d.page = (d.start/d.length)+1;
		}
	}
}).api();

var dataTableAssignedKeywords = $('#datatable-assigned-keywords').dataTable({
	"fixedHeader": true,
	"processing":true,
	"serverSide":true,
	"responsive":true,
	"paging":true,
	"ordering":false,
	"columnDefs":[
		{
			orderable:false,
			targets:[0]
		}
	],
	"fnInitComplete":function(){
		$('#datatable-assigned-keywords').find('#check-all').on('change',function(){
			if(this.checked){
				$('.check-box').prop('checked',true);
			}else{
				$('.check-box').prop('checked',false);
			}
		});
	},
	"ajax":{
		url:removeHashFromURL(window.location.href)+"/get-paginated-assigned-keywords",
		data:function(d){
			d.page = (d.start/d.length)+1;
			//d.search['value']=$('*[name="search[value]"]').val();
			d.columns = null;
			d.order = null;
		},
		dataSrc:function(json){
			recordCollection = json.recordCollection;
			return json.data;
		}
	}
}).api();
// var dataTableExample = $('#dataTables-example').DataTable({
	// responsive: true
// });
// DATA TABLES
// ***********

// ***************************
// ASSIGNED KEYWORD CONTROLLER
	var assignedKeywordController = (function(){
		return {
			checked_Ids:[],
			deleteSelectedAssignedKwds:function(){
				var $this = this;
				$this.checked_Ids = [];
				$('.check-box:checked').each(function(){
					//alert($(this).val());
					if(!(new String("on").valueOf() == $(this).val())){
						$this.checked_Ids.push($(this).val());
					}
				});
				if($this.checked_Ids.length == 0)
					return false;

				$.ajax({
					url:removeHashFromURL(window.location.href)+"/delete-selected-assigned-kwds",
					type:"POST",
					dataType:"json",
					data:{
						ids:$this.checked_Ids
					},
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							alert(data.data.message);
							dataTableAssignedKeywords.ajax.reload(null,false);
						}else{
							alert(data.data.message);
							dataTableAssignedKeywords.ajax.reload(null,false);
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert('Something went wrong');
					}
				});				
				return false;
			},
			updatePriceAssignedKwds:function(){
				$.ajax({
					url:removeHashFromURL(window.location.href)+"/update-price-assigned-kwds",
					type:"GET",
					dataType:"json",
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							alert(data.data.message);
							dataTableAssignedKeywords.ajax.reload(null,false);
						}else{
							alert(data.data.message);
							dataTableAssignedKeywords.ajax.reload(null,false);
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert('Something went wrong');
					}
				});				
				return false;				
			},
			
			keywordIconUpdate:function(THIS,id){			 
				
            var $this = $(THIS);
            var form = new FormData(THIS);

				$.ajax({
					"url":"/developer/keyword/updateIcon/"+id,
					"type":"POST",
					"data":form,
					"cache": false,
					"contentType": false, 
                    "processData": false,   
					"success":function(data,textStatus,jqXHR){
					 
						if(data.statusCode){
							mainSpinner.stop();
							$('#messageModal').show();
						
							$('#messageModal').find('.alert-success').html(data.data.message).show();							 
							dataTableViewAllKwds.ajax.reload(null,false);		
							// window.location.href ="/developer/keyword";

						}else{
							mainSpinner.stop();
						 alert(data.data.message);
						 
							$('#messageModal').find('.alert-danger').html(data.data.message).show();
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);						 
						if(response.status){						 
							var errors = response.errors;
							$this.find('.keyv').removeClass('has-error');
							$this.find('.help-block').remove();
							for (var key in errors) {								 
							if(errors.hasOwnProperty(key)){
							var el = $this.find('*[name="'+key+'"]');
							 
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}
						 
						}else{
							alert('Something went wrong');
						}
						mainSpinner.stop();
					}
				});
				return false;
			},
		};
	})();
// ASSIGNED KEYWORD CONTROLLER
// ***************************

// ************************
// ASSIGNED AREA CONTROLLER
	var assignedAreaController = (function(){
		return {
			submit:function(THIS){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.serialize();
				$.ajax({
					url:removeHashFromURL(window.location.href)+"/add-area-to-client",
					type:"POST",
					data:data,
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-success').removeClass('hide').html(data.data.message);
							$this.find('button[type="reset"]').click();
							dataTableAssignedAreas.ajax.reload(null,false);
						}else{
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);							
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-danger').removeClass('hide').html(data.data.message);
					}
				});
				return false;
			},
			delete:function(id){
				if(confirm("Are you sure ??")){
					mainSpinner.start();
					$.ajax({
						url:removeHashFromURL(window.location.href)+"/area/delete/"+id,
						type:"GET",
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								dataTableAssignedAreas.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTableAssignedAreas.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			},
			update:function(id){
				mainSpinner.start();
				$.ajax({
					url:removeHashFromURL(window.location.href)+"/edit-assigned-zone/"+id,
					type:"GET",
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							mainSpinner.stop();
							$('#editAssignedZone').remove();
							$('body').append(data.data.payload);
							$('#editAssignedZone').modal({keyboard:false,'backdrop':'static'});
						}else{
							mainSpinner.stop();
							alert(data.data.message);
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						mainSpinner.stop();
						alert('Something went wrong. Kindly, contact engineer.')
					}
				});
			},
			
			editZoneClient:function(id){
				mainSpinner.start();
				$.ajax({
					url:removeHashFromURL(window.location.href)+"/editZoneClient/edit-assigned-zone/"+id,
					type:"GET",
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							mainSpinner.stop();
							$('#editAssignedZone').remove();
							$('body').append(data.data.payload);
							$('#editAssignedZone').modal({keyboard:false,'backdrop':'static'});
						}else{
							mainSpinner.stop();
							alert(data.data.message);
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						mainSpinner.stop();
						alert('Something went wrong. Kindly, contact engineer.')
					}
				});
			}
		};
	})();


// ASSIGNED AREA CONTROLLERassignedZoneController 
 
	var assignedZoneController = (function(){
		return {
			submit:function(THIS,id){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.serialize();
				$.ajax({					 
					url:"/developer/clients/addZoneToClient/"+id,
					type:"POST",
					data:data,
					success:function(data,textStatus,jqXHR){					
					 console.log(data);
						if(data.status){
							 
							mainSpinner.stop();							 
							$this.find('button[type="reset"]').click();
							$('#messagemodel .modal-title').text("update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
							dataTableAssignedZones.ajax.reload(null,false);

							setInterval(function() {
							$("#messagemodel").modal("hide");
							}, 1000);
						}else{
							mainSpinner.stop();
							$('#messagemodel .modal-title').text("update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});							
						}  
						 
						
					},
					 error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);						 
						if(response.status){							
							var errors = response.errors;
							$('#assignedZone').find('.form-group').removeClass('has-error');
							$('#assignedZone').find('.help-block').remove();
							for (var key in errors) {								 
							if(errors.hasOwnProperty(key)){
							var el = $('#assignedZone').find('*[name="'+key+'"]');
							 
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}
							
						}else{
							alert('Something went wrong');
						}
						mainSpinner.stop();
					}
				});
				return false;
			},
			delete:function(id){
				if(confirm("Are you sure ??")){
					mainSpinner.start();
					$.ajax({
						url:removeHashFromURL(window.location.href)+"/zone/delete/"+id,
						type:"GET",
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								dataTableAssignedZones.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTableAssignedZones.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			},
			selectDeleteParmanent:function(){
				var $this = this;
				if (confirm("Are you sure Delete??")) {
					$this.checked_Ids = [];
					$('.check-box:checked').each(function(){
						if(!(new String("on").valueOf() == $(this).val())){
							$this.checked_Ids.push($(this).val());
						}
					});

					if($this.checked_Ids.length == 0){
						alert('Please select data to Delete Permanently!');
						return false;
					}	 
			 
					$.ajax({
						url:"/developer/assignLocation/selectAssignZoneDelete",
						type:"POST",
						dataType:"json",
						data:{
							ids:$this.checked_Ids
						},
						success:function(data,textStatus,jqXHR){
							if(data.status){					 				
								
								$("#messagemodel").modal("show");                        							 
								$('#messagemodel .modal-title').text("Business Location Delete");	
								$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
								$('#messagemodel').modal({keyboard:false,backdrop:'static'});
								$('#messagemodel').css({'width':'100%'});					

								setInterval(function() {
								$("#messagemodel").modal("hide");
								}, 3000);
								dataTableAssignedZones.ajax.reload(null,false);								 
							}else{

								$("#messagemodel").modal("show");                        							 
								$('#messagemodel .modal-title').text("Business Location Delete");	
								$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
								$('#messagemodel').modal({keyboard:false,backdrop:'static'});
								$('#messagemodel').css({'width':'100%'});	
									
								}
						},
						error:function(jqXHR,textStatus,errorThrown){
							
						}
					});
			}
				return false;				
			},

		};
	})();
// ASSIGNED ZONE CONTROLLER
// ************************
// *********************
// PERMISSION CONTROLLER
	var permissionController = (function(){
		return {
			submit:function(THIS){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.serialize();
				$.ajax({
					url:"/developer/permission",
					type:"POST",
					data:data,
					success:function(response){
						if(response.status){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-success').removeClass('hide').html('Permission added successfully');
							$this.find('button[type="reset"]').click();
							dataTablePermission.ajax.reload(null,false);
						}else{
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(response.errors);							
						}
					},
					error:function(response){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-danger').removeClass('hide').html('Permission not added');
					}
				});
				return false;
			},
			delete:function(id){
				if(confirm("Are you sure ??")){
					mainSpinner.start();
					$.ajax({
						url:"/developer/permission/delete/"+id,
						type:"GET",
						success:function(response){
							if(response.status){
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html('Permission deleted successfully');
								dataTablePermission.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(response.errors);							
								dataTablePermission.ajax.reload(null,false);
							}
						},
						error:function(response){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html('Permission not deleted');
						}
					});
				}
				return false;
			}
		};
	})();
// PERMISSION CONTROLLER
// *********************

// **************************
// ROLE PERMISSION CONTROLLER
	var rolePermissionController = (function(){
		return {
			submit:function(THIS){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.serialize();
 
				$.ajax({
					url:"/developer/role-permission",
					type:"POST",
					data:data,
					success:function(response){
						if(response.status){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-success').removeClass('hide').html('Permission added successfully');
							$this.find('button[type="reset"]').click();
							dataTableRolePermission.ajax.reload(null,false);
						}else{
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(response.errors);							
						}
					},
					error:function(response){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-danger').removeClass('hide').html('Permission not added');
					}
				});
				return false;
			},
			delete:function(id){
				if(confirm("Are you sure ??")){
					mainSpinner.start();
					$.ajax({
						url:"/developer/role-permission/delete/"+id,
						type:"GET",
						success:function(response){
							if(response.status){
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html('Permission deleted successfully');
								dataTableRolePermission.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(response.errors);							
								dataTableRolePermission.ajax.reload(null,false);
							}
						},
						error:function(response){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html('Permission not deleted');
						}
					});
				}
				return false;
			}
		};
	})();
// ROLE PERMISSION CONTROLLER
// **************************

// ***************
// ZONE CONTROLLER
	var zoneController = (function(){
		return {
			submit:function(THIS){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.serialize();
				$.ajax({
					url:"/developer/zone",
					type:"POST",
					data:data,
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-success').removeClass('hide').html(data.data.message);
							$this.find('button[type="reset"]').click();
							dataTableZone.ajax.reload(null,false);
						}else{
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);							
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-danger').removeClass('hide').html(data.data.message);
					}
				});
				return false;
			},
			delete:function(id){
				if(confirm("Are you sure ??")){
					mainSpinner.start();
					$.ajax({
						url:"/developer/zone/delete/"+id,
						type:"GET",
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								dataTableZone.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTableZone.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			}
		};
	})();
// ZONE CONTROLLER
// ***************

// ***************
// AREA CONTROLLER
	var areaController = (function(){
		return {
			submit:function(THIS){
				mainSpinner.start();
				var $this = $(THIS),
					data  = $this.serialize();
				$.ajax({
					url:"/developer/area",
					type:"POST",
					data:data,
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-success').removeClass('hide').html(data.data.message);
							//$this.find('button[type="reset"]').click();
							$this.find('input[name="area"]').val("");
							dataTableArea.ajax.reload(null,false);
						}else{
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);							
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-danger').removeClass('hide').html(data.data.message);
					}
				});
				return false;
			},
			delete:function(id){
				if(confirm("Are you sure ??")){
					mainSpinner.start();
					$.ajax({
						url:"/developer/area/delete/"+id,
						type:"GET",
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								dataTableArea.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTableArea.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			}
		};
	})();
// AREA CONTROLLER
// ***************

// ********************
// PUSH LEAD CONTROLLER
	var pushLeadController = (function(){
		return {
			delete:function(id){
				if(confirm("Are you sure ??")){
					mainSpinner.start();
					$.ajax({
						url:"/developer/push-lead/delete/"+id,
						type:"GET",
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								dataTablePushLeads.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTablePushLeads.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			},
			
			newleaddelete:function(id){
				if(confirm("Are you sure ??")){
					mainSpinner.start();
					$.ajax({
						url:"/developer/new-lead/delete/"+id,
						type:"GET",
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								alert('Successfully Deleted Leads');
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								dataTablePendingNewLeads.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTablePendingNewLeads.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							mainSpinner.stop();
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			},
			clientAssignleaddelete:function(id){
				if(confirm("Are you sure want to delete??")){
					mainSpinner.start();
					$.ajax({
						url:"/developer/clientAssignleaddelete/delete/"+id,
						type:"GET",
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								alert(data.data.message);
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								dataTableViewAllLeads.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTableViewAllLeads.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							mainSpinner.stop();
							alert(data.data.message);
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			},
			pushLead:function(id){
				 
				if(null==id){
					alert("Lead id cannot be null.");
					return false;
				}
				var pushedEl = $("td").find("[data-push='"+id+"']");
				if(pushedEl.is(':disabled') || (pushedEl.attr('disabled') == 'disabled')){
					return false;
				}
				pushedEl.attr('disabled','disabled');
				mainSpinner.start();
			 
				$.ajax({
					"url":"/developer/push-lead/push/"+id,
					"type":"GET",
					"success":function(data,textStatus,jqXHR){
						//alert(JSON.stringify(data)+" => "+textStatus+" => "+JSON.stringify(jqXHR));
					 
						if(data.statusCode){
							alert(data.data.message);
							pushedEl.attr('title','Pushed');
							pushedEl.text('Pushed');
							pushedEl.removeClass('btn-danger').addClass('btn-success');
							mainSpinner.stop();
							dataTablePendingNewLeads.ajax.reload(null,false);
							dataTablePushLeads.ajax.reload(null,false);
							
						}else{
							alert(data.data.message);
							mainSpinner.stop();
						}
					},
					 
					"error":function(jqXHR,textStatus,errorThrown){
						//alert(JSON.stringify(jqXHR)+" => "+textStatus+" => "+errorThrown);
						alert("Something went wrong !!");
						mainSpinner.stop();
					}
				});
				return false;
			},
			leadAssignModel:function(){
				//var checked_Ids = [];
				var $this = this;
				$this.checked_Ids = [];
				$('.check-box:checked').each(function(){
					//alert($(this).val());
					if(!(new String("on").valueOf() == $(this).val())){
						$this.checked_Ids.push($(this).val());
					}
				});
				if($this.checked_Ids.length == 0){
				    alert('Please select data for Assign to Client!');
					return false;
				}
				$('#leadAssignModel .alert').remove();
				$('#leadAssignModel').modal({backdrop:"static",keyboard:false});
				return false;
			},
			moveNotInterested:function(){
				var $this = this;
				$this.checked_Ids = [];
				$('.check-box:checked').each(function(){
					if(!(new String("on").valueOf() == $(this).val())){
						$this.checked_Ids.push($(this).val());
					}
				});
				if($this.checked_Ids.length == 0){
				    	alert('Please select data to move Not Intereseted!');
					return false;
				}
				mainSpinner.start();
				$.ajax({
					url:"/developer/new-lead/move-not-interested",
					type:"POST",
					dataType:"json",
					data:{
						ids:$this.checked_Ids
					},
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							dataTablePendingNewLeads.ajax.reload( null, false );
							dataTablePendingNewLeads.ajax.reload(function(){
								$('#datatable-new-leads').find('[data-toggle="popover"]').popover({html:true,container:'body'});
							},false);
							mainSpinner.stop();
							alert(data.data.message);
							 
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						
					}
				});
				return false;				
			},
			 moveToLeads:function(){
				var $this = this;
				$this.checked_Ids = [];
				$('.check-box:checked').each(function(){
					if(!(new String("on").valueOf() == $(this).val())){
						$this.checked_Ids.push($(this).val());
					}
				});
				if($this.checked_Ids.length == 0){
					alert('Please select data to move to lead !');
					return false;
				}
				mainSpinner.start();
				$.ajax({
					url:"/developer/new-lead/move-to-lead",
					type:"POST",
					dataType:"json",
					data:{
						ids:$this.checked_Ids
					},
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							dataTableLeadNotInterested.ajax.reload(null,false);
							dataTableLeadNotInterested.ajax.reload(function(){
								$('#datatable-lead-not-interested').find('[data-toggle="popover"]').popover({html:true,container:'body'});
							},false);
							mainSpinner.stop();
							alert(data.data.message);
						 
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						
					}
				});
				return false;				
			},
			
			selectDeleteParmanent:function(){
				var $this = this;
				$this.checked_Ids = [];
				$('.check-box:checked').each(function(){
					if(!(new String("on").valueOf() == $(this).val())){
						$this.checked_Ids.push($(this).val());
					}
				});
				if($this.checked_Ids.length == 0){
					alert('Please select data to Delete Permanently!');
					return false;
				}
				mainSpinner.start();
				$.ajax({
					url:"/developer/new-lead/selectDeleteParmanent",
					type:"POST",
					dataType:"json",
					data:{
						ids:$this.checked_Ids
					},
					success:function(data,textStatus,jqXHR){
				    	if(data.statusCode){
							mainSpinner.stop();
							alert(data.data.message);							 
							dataTableLeadNotInterested.ajax.reload(null,false);						 
							dataTablePendingNewLeads.ajax.reload(null,false);	
							 					 
					
							
							 
						}else{
								mainSpinner.stop();
								alert(data.data.message);	
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html('Not Deleted Permanently successfully...');							
								dataTableLeadNotInterested.ajax.reload(null,false);
								dataTablePendingNewLeads.ajax.reload(null,false);
							}
					},
					error:function(jqXHR,textStatus,errorThrown){
						
					}
				});
				return false;				
			},
			leadAssignToClient:function(){
				if($('#client_id').val() == '')
					return false;
				var $this = this;
				mainSpinner.start();
				$.ajax({
					url:"/developer/assignlead/push",
					type:"POST",
					dataType:"json",
					data:{
						client_id:$('#client_id').val(),
						ids:$this.checked_Ids
					},
						
					
					success:function(data,textStatus,jqXHR){
					
						if(data.status){	
						 	alert('Successfully Assigned Leads');	
								mainSpinner.stop();				 
							dataTablePendingNewLeads.ajax.reload(null,false);
											 
							$('#leadAssignModel .alert').remove();
							$('.assignsuccess').text("Successfully Assigned Leads");
							$('#client_id').val('');
							setTimeout(function(){
								$('#leadAssignModel').modal('hide');
							},2000);
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						
					}
				});
				return false;
			},
			
			leadAssignWithAPI:function(){
				//var checked_Ids = [];
				var $this = this;
				$this.checked_Ids = [];
				$('.check-box:checked').each(function(){
					//alert($(this).val());
					if(!(new String("on").valueOf() == $(this).val())){
						$this.checked_Ids.push($(this).val());
					}
				});
				if($this.checked_Ids.length == 0){
				    alert('Please select data for Assign to Client!');
					return false;
				}
				$('#leadAssignAPIModel .alert').remove();
				$('#leadAssignAPIModel').modal({backdrop:"static",keyboard:false});
				return false;
			},
			 
			leadAssignToClientByAPI:function(){
				if($('#clientid').val() == '')
					return false;
				var $this = this;
				mainSpinner.start();
				$.ajax({
					url:"/developer/assignleadAPI/push/",
					type:"POST",
					dataType:"json",
					data:{
						client_id:$('#clientid').val(),
						ids:$this.checked_Ids
					},
									
					success:function(data,textStatus,jqXHR){
						mainSpinner.stop();
						if(data.status){								
						 alert('Successfully Assigned Leads');		
					var strdata = data.leadslist;					 
						 $.ajax({
					url:"https://www.quickdials.com/apiddd/lead/add/",
					//url:"/apiddd/lead/add", //working
					//url:"http://182.18.170.106:8084/api/lead",
					type:"POST",
					dataType:"json",
					//Cache-Control: "no-cache", 
					//crossDomain: false,
					//headers: {'X-Requested-With': 'XMLHttpRequest'},		
					headers: {'Content-Type' : 'application/json'},  					
				data:strdata,
					/* data:{
						client_id:$('#clientid').val(),
						ids:$this.checked_Ids
					}, */
					success:function(data,textStatus,jqXHR){					
					alert(data);
					}
					});
					
					
			 
						 
							$('#leadAssignModel .alert').remove();
							$('.assignsuccess').text("Successfully Assigned Leads");
							$('#client_id').val('');
							setTimeout(function(){
								$('#leadAssignModel').modal('hide');
							},2000);
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						
					}
				});
				return false;
			},		 
			editNewLead:function(id){			 
				if(null==id){
					alert("lead id cannot be null.");
					return false;
				}
				mainSpinner.start();
				$.ajax({
					"url":"/developer/new-lead/update/"+id,
					"type":"GET",
					"success":function(data,textStatus,jqXHR){
						if(data.statusCode){
							mainSpinner.stop();
							$('body').append(data.data.payload);
							$('#newlead-edit-modal').modal({backdrop:'static',keyboard:false});
							$("#newlead-edit-modal").on('hidden.bs.modal', function () {
								$(this).data('bs.modal', null);
								$('#newlead-edit-modal').remove();
							});
							bindSelect2OnCity();
							bindSelect2OnAreaZone();
							$( ".select2_course" ).select2( {		 
							theme: "bootstrap",
							placeholder: "Select",
							maximumSelectionSize: 6,
							containerCssClass: ':all:'
							} );
							//bindSelect2OnCourse();							
							bindSelect2OnUser();
						}else{
							mainSpinner.stop();
							alert(data.data.message);
						}
					},
					"error":function(jqXHR,textStatus,errorThrown){
						mainSpinner.stop();
						alert(data.data.message);
					}
				});
				return false;
			},
			updateNewLead:function($this,id){
				if(null==id){
					alert("lead id cannot be null.");
					return false;
				}
				mainSpinner.start();
				$.ajax({
					"url":"/developer/new-lead/update/"+id,
					"type":"POST",
					"data":$($this).serialize(),
					"success":function(data,textStatus,jqXHR){
						if(data.statusCode){
							mainSpinner.stop();
							$('#newlead-edit-modal').find('.alert-danger').html("").hide();
							$('#newlead-edit-modal').find('.alert-success').html(data.data.message).show();							 
							dataTablePendingNewLeads.ajax.reload(null,false);		
							
						}else{
							 
							mainSpinner.stop();
							$('#newlead-edit-modal').find('.alert-success').html("").hide();
							$('#newlead-edit-modal').find('.alert-danger').html(data.data.message).show().removeClass('hide');
						}
					},
					"error":function(jqXHR,textStatus,errorThrown){						 
						alert(data.data.message);
						 
					}
				});
				return false;
			},
			updateKeywordBussiness:function(THIS){
							 
				mainSpinner.start();
				
            var $this = $(THIS);
            var form = new FormData(THIS);
				$.ajax({
					"url":"/developer/keyword/update",
					"type":"POST",
					"data":form,
					"cache": false,
					"contentType": false, 
                    "processData": false,   
					"success":function(data,textStatus,jqXHR){
						alert(data.data.message);
						if(data.statusCode){
							mainSpinner.stop();
							$('#messageModal').show();
						
							$('#messageModal').find('.alert-success').html(data.data.message).show();							 
							dataTableViewAllKwds.ajax.reload(null,false);		
							// window.location.href ="/developer/keyword";

						}else{
							mainSpinner.stop();
						 alert(data.data.message);
						 
							$('#messageModal').find('.alert-danger').html(data.data.message).show();
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);						 
						if(response.status){						 
							var errors = response.errors;
							$this.find('.keyv').removeClass('has-error');
							$this.find('.help-block').remove();
							for (var key in errors) {								 
							if(errors.hasOwnProperty(key)){
							var el = $this.find('*[name="'+key+'"]');
							 
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}
							 //alert($this,response.errors);
							//showValidationErrors($this,response.errors);
						}else{
							alert('Something went wrong');
						}
						mainSpinner.stop();
					}
				});
				return false;
			},
			editPushLead:function(id){
				if(null==id){
					alert("Push lead id cannot be null.");
					return false;
				}
				mainSpinner.start();
				$.ajax({
					"url":"/developer/push-lead/update/"+id,
					"type":"GET",
					"success":function(data,textStatus,jqXHR){
						if(data.statusCode){
							mainSpinner.stop();
							$('body').append(data.data.payload);
							$('#pushlead-edit-modal').modal({backdrop:'static',keyboard:false});
							$("#pushlead-edit-modal").on('hidden.bs.modal', function () {
								$(this).data('bs.modal', null);
								$('#pushlead-edit-modal').remove();
							});
							bindSelect2OnCity();
							bindSelect2OnAreaZone();
							bindSelect2OnCourse();
							bindSelect2OnSource();
							bindSelect2OnUser();
							$( ".select2_course" ).select2( {		 
							theme: "bootstrap",
							placeholder: "Select",
							maximumSelectionSize: 6,
							containerCssClass: ':all:'
							} );
						}else{
							mainSpinner.stop();
							alert(data.data.message);
						}
					},
					"error":function(jqXHR,textStatus,errorThrown){
						mainSpinner.stop();
						alert(data.data.message);
					}
				});
				return false;
			},
			closePushLeadEditModal:function(){
				$('#newlead-edit-modal').modal('hide');
				$('#assignkey-city-modal').modal('hide');
			},
			
			updatePushLead:function($this,id){
				if(null==id){
					alert("Push lead id cannot be null.");
					return false;
				}
				mainSpinner.start();
				$.ajax({
					"url":"/developer/push-lead/update/"+id,
					"type":"POST",
					"data":$($this).serialize(),
					"success":function(data,textStatus,jqXHR){
						if(data.statusCode){
							mainSpinner.stop();
							$('#pushlead-edit-modal').find('.alert-danger').html("").hide();
							$('#pushlead-edit-modal').find('.alert-success').html(data.data.message).show();
							dataTablePushLeads.ajax.reload(null,false);							
						}else{
							mainSpinner.stop();
							$('#pushlead-edit-modal').find('.alert-success').html("").hide();
							$('#pushlead-edit-modal').find('.alert-danger').html(data.data.message).show();
							dataTablePushLeads.ajax.reload(null,false);	
						}
					},
					"error":function(jqXHR,textStatus,errorThrown){
						mainSpinner.stop();
						alert(data.data.message);
						dataTablePushLeads.ajax.reload(null,false);	
					}
				});
				return false;
			},
			
			getLeadFollowupForm:function(id=null){
				mainSpinner.start();
				if(null==id){
					alert("Leads ID is null");
					return;
				}
								
				$.ajax({
					url:"/developer/lead/leadFollowupForm/"+id,
					type:"GET",
					data:{action:"getLeadFollowupForm"},
					success:function(data,textStatus,jqXHR){						
						if(data.statusCode){
								
							$('#lead-follow-modal .modal-body').html(data.data.payload);
							//$('body').html(data.data.payload);
							
							$('input[name="date_time"]').datetimepicker({
								format:'YYYY-MM-DD HH:mm:ss'
							});
							
							$('input[name="expected_date_time"]').datetimepicker({
								format:'YYYY-MM-DD HH:mm:ss',
									 
							});
							$( ".select2-single" ).select2( {		 
							theme: "bootstrap",
							placeholder: "Select",
							maximumSelectionSize: 6,
							containerCssClass: ':all:'
							} );
							$( ".select2_course" ).select2( {		 
							theme: "bootstrap",
							placeholder: "Select",
							maximumSelectionSize: 6,
							containerCssClass: ':all:'
							} );
							$( ".select2_status" ).select2( {		 
							theme: "bootstrap",
							placeholder: "Select",
							maximumSelectionSize: 6,
							containerCssClass: ':all:'
							} );
							bindSelect2OnAreaZone();
							$('#expected_date_time').on('apply.daterangepicker', function(ev, picker) {
							$('#expected_date_time').val(picker.startDate.format('DD-MMMM-YYYY h:mm A'));
							});
							//$('#lead-follow-modal').modal({keyboard:false,backdrop:'static'});
							//$("#lead-follow-modal").on('hidden.bs.modal', function () {
							//	$(this).data('bs.modal', null);
							//	$('#lead-follow-modal').remove();
							//});
							dataTableFollowUps = $('#datatable-lead-followUps').dataTable({
							"fixedHeader": true,
							"processing":true,
							"serverSide":true,
							"paging":false,
							"ordering":false,
							"searching":false,
							"lengthChange":false,
							"info":false,
							"autoWidth":false,
							"ajax":{
								url:"/developer/lead/getfollowups/"+id,
								data:function(d){
									d.page = (d.start/d.length)+1;
									d.columns = null;
									d.order = null;
									d.count = $(".follow-up-count").val();
								}
							}
						}).api();
						
						var prevNextHtml = '';	 						
						for(var i=0;i<recordCollection.length;i++){
							if(recordCollection[i]==id && recordCollection.length != 1){
								if(i==0){
									prevNextHtml += '<a style="background:#2A3F54;color:#fff;padding:6px 25px;" href="javascript:pushLeadController.getLeadFollowupForm('+recordCollection[i+1]+')" class="btn" title="followUp">Next >></a>';
								}
								else if(i==(recordCollection.length-1)){
									prevNextHtml += '<a style="background:#2A3F54;color:#fff;" href="javascript:pushLeadController.getLeadFollowupForm('+recordCollection[i-1]+')" class="btn" title="followUp"><< Previous</a>';
								}
								else{
									prevNextHtml += '<a style="background:#2A3F54;color:#fff;" href="javascript:pushLeadController.getLeadFollowupForm('+recordCollection[i-1]+')" class="btn" title="followUp"><< Previous</a><a style="background:#2A3F54;color:#fff;padding:6px 25px;margin-left: 4px;" href="javascript:pushLeadController.getLeadFollowupForm('+recordCollection[i+1]+')" class="btn" title="followUp">Next >></a>';
								}
							}
						}
						$('#lead-follow-modal .modal-title').html(prevNextHtml);
						$('#lead-follow-modal').modal({keyboard:false,backdrop:'static'});
						$('#lead-follow-modal .select2-container').css({'width':'100%'});
						mainSpinner.stop();
						
						}else{
							alert(data.data.message);
							mainSpinner.stop();
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert('Something went wrong !!');
						mainSpinner.stop();
					}
				});
			},
			submitLeadFollowupForm:function(id,THIS){				 
				var $this = $(THIS);
				//mainSpinner.start();
				$.ajax({
					url:"/developer/lead/submitLeadFollowup/"+id,
					type:"POST",
					data:$this.serialize(),
					success:function(data,textStatus,jqXHR){
										
						if(data.statusCode){
							mainSpinner.stop();
							alert(data.data.message);
							//$('#client-meeting-modal .form-group').find('*[name="remark"]').replaceWith(data.data.message);
							 
							$this.find('*[name="remark"]').val('');
							//$('.client-success').text(data.data.message);
							dataTableFollowUps.ajax.reload( null, false );							
							dataTablePendingNewLeads.ajax.reload(function(){
							$('#datatable-new-leads').find('[data-toggle="popover"]').popover({html:true,container:'body'});
							},false);
							datatablePendingLeadsDashboard.ajax.reload(function(){
							$('#datatable-pending-leads-dashboard').find('[data-toggle="popover"]').popover({html:true,container:'body'});
							},false);	 
							removeValidationErrors($this);
							$('.select2_single').select2({
							theme: "bootstrap",
							placeholder: "Select",
							maximumSelectionSize: 6,
							containerCssClass: ':all:'
							});
							
							
						}else{
							alert(data.message);
							$('.client-error').text(data.message);
							mainSpinner.stop();
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);						 
						if(response.status){						 
							var errors = response.errors;
							$this.find('.form-group').removeClass('has-error');
							$this.find('.help-block').remove();
							for (var key in errors) {								 
							if(errors.hasOwnProperty(key)){
							var el = $this.find('*[name="'+key+'"]');
							 
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}
							 //alert($this,response.errors);
							//showValidationErrors($this,response.errors);
						}else{
							alert('Something went wrong');
						}
						mainSpinner.stop();
					}
				});				
				return false;
			},
			getAllFollowUps:function(){
				//mainSpinner.start();
				dataTableFollowUps.ajax.reload( null, false );
				return false;
			},
			
		};
	})();
// PUSH LEAD CONTROLLER
// ********************

// ********************
// PUSH LEAD CONTROLLER
	var keywordController = (function(){
		return {
			 		  
			seoReportPopup:function(id=null){
				mainSpinner.start();
				if(null==id){
					alert("Keyword ID is null");
					return;
				}
								
				$.ajax({
					url:"/developer/seo-report-popup/"+id,
					type:"GET",
					data:{action:"getLeadFollowupForm"},
					success:function(data,textStatus,jqXHR){						
						if(data.statusCode){
								
							$('#lead-follow-modal .modal-body').html(data.data.payload);
							//$('body').html(data.data.payload);
							
					  
					   
							dataTableFollowUps = $('#datatable-lead-followUps').dataTable({
							"fixedHeader": true,
							"processing":true,
							"serverSide":true,
							"paging":false,
							"ordering":false,
							"searching":false,
							"lengthChange":false,
							"info":false,
							"autoWidth":false,
							"ajax":{
								url:"/developer/lead/getfollowups/"+id,
								data:function(d){
									d.page = (d.start/d.length)+1;
									d.columns = null;
									d.order = null;
									d.count = $(".follow-up-count").val();
								}
							}
						}).api();
						
					 
						$('#lead-follow-modal .modal-title').html('Report');
						$('#lead-follow-modal').modal({keyboard:false,backdrop:'static'});
						$('#lead-follow-modal .select2-container').css({'width':'100%'});
						mainSpinner.stop();
						
						}else{
							alert(data.data.message);
							mainSpinner.stop();
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert('Something went wrong !!');
						mainSpinner.stop();
					}
				});
			},
			 updateMetaInformation:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/seo/updateMetaInformation/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Meta Information");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("Meta Information");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			 updateAboutKeyword:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/seo/updateAboutKeyword/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("About Keyword");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("About Keyword");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			 updatePageContent:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/seo/updatePageContent/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("About Keyword");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("About Keyword");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			 updateFaqKeyword:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/seo/updateFaqKeyword/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("FAQ Keyword");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("FAQ Keyword");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	

		seoStatus:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Yes?")){		
				 
				$.ajax({
					url:"/developer/keyword/seoStatus/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 ;			
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
					 
							dataTableViewAllKwds.ajax.reload(null,false);	
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					    ;			
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to No?")){		
				 
				$.ajax({
					url:"/developer/keyword/seoStatus/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 ;			
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableViewAllKwds.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					  	
						 alert('some error');
					}
				});
				}
				}
			}
			
		};
	})();

	var blogController = (function(){
		return {		 		  
			 
			 saveBlog:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);			 
				$.ajax({
					url:"/developer/blog/addBlog",
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Blog Add");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
						 	window.location.href ="/developer/blog/blogdetails";
						}else{
							$('#messagemodel .modal-title').text("Meta Information");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			 updateBlogMeta:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/blog/updateBlogMeta/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Meta Information");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
						 
						}else{
							$('#messagemodel .modal-title').text("Meta Information");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			 updateAboutBlog:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/blog/updateAboutBlog/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("About Blog");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("About Blog");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			 updatePageContent:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/blog/updatePageContent/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Blog Desciption");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("Blog Desciption");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			 updateBlogImage:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/blog/updateBlogImage/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Blog Image");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("Blog Image");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			 updateFaqBlog:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/blog/updateFaqBlog/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("FAQ Blog");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("FAQ Blog");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			
		};
	})();
// PUSH LEAD CONTROLLER
// ********************

// *************
// CLIENT OBJECT
	var client = (function(){
		return {
			getClientRF:function(id=null){
				if(null==id){
					alert("Client ID is null");
					return;
				}
				$.ajax({
					url:"/developer/clients/remark/"+id,
					type:"POST",
					data:{action:"getClientRF"},
					success:function(data,textStatus,jqXHR){
						$('body').append(data);
						$('#client-remark-modal').modal({keyboard:false,backdrop:'static'});
						$("#client-remark-modal").on('hidden.bs.modal', function () {
							$(this).data('bs.modal', null);
							$('#client-remark-modal').remove();
						});
					}
				});
				return false;
			},
			 
			 
			submitClientRF:function(form){
				var clientRemark = $(form).find('*[name="client-remark"]').val();
				var id = $(form).find('*[name="client-id"]').val();
				//alert(clientRemark+" => "+id);
				if(clientRemark=='' || clientRemark.match(/([\|-])+/g)){
					return false;
				}
				/* var formData = new FormData();
				formData.append('action','submitClientRF');
				formData.append('client-remark',clientRemark); */
				$.ajax({
					url:"/developer/clients/remark/"+id,
					type:"POST",
					data:{action:'submitClientRF',clientRemark:clientRemark},
					success:function(data,textStatus,jqXHR){
						if(textStatus=='success'){
							$('#client-remark-modal .form-group').find('*[name="client-remark"]').replaceWith("inserted successfully");
							$('#client-remark-modal').find('[type="reset"]').click();
							$('#client-remark-modal').find('.alert').append(data+"<br>");
							jQuery('#datatable-clients,#datatable-view-paid-clients').find('[data-stud_id="'+id+'"]').attr('data-content',data).data('bs.popover').setContent();
						}
					}
				});				
				return false;
			},
			submitClientDiscussion:function(form){
				var clientRemark = $(form).find('*[name="clientremark"]').val();
				var id = $(form).find('*[name="client-id"]').val();
				//alert(clientRemark+" => "+id);
				if(clientRemark=='' || clientRemark.match(/([\|-])+/g)){
					return false;
				}
			 
				$.ajax({
					url:"/developer/clients/discussion/"+id,
					type:"POST",
					data:{action:'submitClientDiscussion',clientRemark:clientRemark},
					success:function(data,textStatus,jqXHR){					 
						//alert(data);
						 if(textStatus=='success'){
							 
							$('#success-remark').html("<div class='alert alert-success'>inserted successfully</div>");
							$('#client-remark').append(data+"<br>");
							submitClientDiscussion.ajax.reload(null,false);
							//$('#client-remark-modal').find('[type="reset"]').click();
							//$('#client-remark-modal').find('.alert').append(data+"<br>");							//jQuery('#datatable-clients,#datatable-view-paid-clients').find('[data-stud_id="'+id+'"]').attr('data-content',data).data('bs.popover').setContent();
						} 
					}
				});				
				return false;
			},
			submitClientPayOrder:function(THIS){					
				//$(".payOrder").attr("disabled", true);
				var $this = $(THIS),
					data  = $this.serialize();				  
				$.ajax({
					url:"/developer/clients/payment",					 
					type:"POST",
					data:data,					 
					success:function(data,textStatus,jqXHR){					 
						 var response = JSON.parse(jqXHR.responseText);	
						 if(response.status){	
						alert('Client Order payment successfully');		
					 
						 	 
							$('#success-payment').html("<div class='alert alert-success'>Client Order payment successfully !!</div>");						 
							dataTablePaymentHistory.ajax.reload(null,false);
							 
						} 
					},
					error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);					
					 if(response.status){						 
							var errors = response.errors;
							$('.order_validation').find('.form-group').removeClass('has-error');
							$('.order_validation').find('.help-block').remove();
							for (var key in errors) {								 
							if(errors.hasOwnProperty(key)){
							var el = $('.order_validation').find('*[name="'+key+'"]');							 
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}
							 
						}else{
							alert('Something went wrong');
						} 
						mainSpinner.stop();
					}
					
					
				});				
				return false;
			},

			updateClientPayOrder:function(THIS){				 
				var $this = $(THIS),
					data  = $this.serialize();			 
					//var data  = $(this).serialize();
			// alert(data);
				$.ajax({
					url:"/developer/order-history/update",					 
					type:"POST",
					data:data,					 
					success:function(data,textStatus,jqXHR){					 
						var response = JSON.parse(jqXHR.responseText);	
 		
						 if(response.status==true){	
						alert('Client Order payment successfully');						 
							$('#success-payment_update').html("<div class='alert alert-success'>Client Order payment successfully !!</div>");						 
							dataTablePaymentHistory.ajax.reload(null,false);
							 
						} 
					},
					error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);					
					 if(response.status){						 
							var errors = response.errors;
							$('.updateorder_validation').find('.form-group').removeClass('has-error');
							$('.updateorder_validation').find('.help-block').remove();
							for (var key in errors) {								 
							if(errors.hasOwnProperty(key)){
							var el = $('.updateorder_validation').find('*[name="'+key+'"]');							 
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}
							 
						}else{
							alert('Something went wrong');
						} 
						mainSpinner.stop();
					}
					
					
				});				
				return false;
			},
			getClientMeetingForm:function(id=null){
				if(null==id){
					alert("Client ID is null");
					return;
				}
				$.ajax({
					url:"/developer/clients/meeting/"+id,
					type:"GET",
					data:{action:"getClientMeetingForm"},
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							$('body').append(data.data.payload);
							$('input[name="date_time"]').datetimepicker({
								format:'YYYY-MM-DD HH:mm:ss'
							});
							
							$('input[name="expected_date_time"]').datetimepicker({
								format:'YYYY-MM-DD HH:mm:ss',
									 
							});							
							$( ".select2-single" ).select2( {		 
							theme: "bootstrap",
							placeholder: "Select",
							maximumSelectionSize: 6,
							containerCssClass: ':all:'
							});
							$('#expected_date_time').on('apply.daterangepicker', function(ev, picker) {
							$('#expected_date_time').val(picker.startDate.format('DD-MMMM-YYYY h:mm A'));
							});
							$('#client-meeting-modal').modal({keyboard:false,backdrop:'static'});
							$("#client-meeting-modal").on('hidden.bs.modal', function () {
								$(this).data('bs.modal', null);
								$('#client-meeting-modal').remove();
							});
							dataTableTeleCollerFollowups = $('#tele-coller-followups').dataTable({
							"fixedHeader": true,
							"processing":true,
							"serverSide":true,
							"paging":false,
							"ordering":false,
							"searching":false,
							"lengthChange":false,
							"info":false,
							"autoWidth":false,
							"ajax":{
								url:"/developer/clients/meeting/getTeleCollerFollowups/"+id,
								data:function(d){
									d.page = (d.start/d.length)+1;
									d.columns = null;
									d.order = null;
									d.count = $(".follow-up-count").val();
								}
							}
						}).api();
						}else{
							alert(data.data.message);
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert('Something went wrong !!');
					}
				});
				
			},
			submitClientMeetingForm:function(id,THIS){				 
				var $this = $(THIS);
				mainSpinner.start();					
				$.ajax({
					url:"/developer/clients/storemeeting/"+id,
					type:"POST",
					data:$this.serialize(),
					success:function(data,textStatus,jqXHR){					 
						if(data.statusCode){
							mainSpinner.stop();
							alert(data.data.message);
							//$('#client-meeting-modal .form-group').find('*[name="remark"]').replaceWith(data.data.message);
							$('#client-meeting-modal').find('[type="reset"]').click();
							$('.client-success').text(data.data.message);							
							dataTableTeleCollerFollowups.ajax.reload(null,false);
							dataTableMeetings.ajax.reload(null,false);
							//jQuery('#datatable-clients,#datatable-view-paid-clients').find('[data-client_id_meeting="'+id+'"]').attr('data-content',data.data.payload).data('bs.popover').setContent();
							
						}else{
							alert(data.message);
							$('.client-error').text(data.message);
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);					
					 if(response.status){						 
							var errors = response.errors;
							$this.find('.form-group').removeClass('has-error');
							$this.find('.help-block').remove();
							for (var key in errors) {								 
							if(errors.hasOwnProperty(key)){
							var el = $this.find('*[name="'+key+'"]');							 
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}
							 
						}else{
							alert('Something went wrong');
						} 
						 
						
						mainSpinner.stop();
					}
					
					
				});				
				return false;
			},
			closeClientRF:function(){
				$('#client-remark-modal').modal('hide');
			},
			closeClientMeetingForm:function(){
				$('#client-meeting-modal').modal('hide');
			},
			closeClientAllMeetingsModal:function(){
				$('#client-all-meetings-modal').modal('hide');
			},
			viewAllMeetings:function(id=null){
				if(null==id){
					alert("Client ID is null");
					return;
				}
				$.ajax({
					url:"/developer/clients/all-meetings/"+id,
					type:"GET",
					data:{},
					success:function(data,textStatus,jqXHR){
						if(data.statusCode){
							$('body').append(data.data.payload);
							$('#client-all-meetings-modal').modal({keyboard:false,backdrop:'static'});
							$("#client-all-meetings-modal").on('hidden.bs.modal', function () {
								$(this).data('bs.modal', null);
								$('#client-all-meetings-modal').remove();
							});
						}else{
							alert(data.data.message);
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert('Something went wrong !!');
					}
				});
			},
			pushLead:function(id){
				if(null==id){
					alert("Meeting id cannot be null.");
					return false;
				}
				var pushedEl = $("td").find("[data-push='"+id+"']");
				if(pushedEl.is(':disabled') || (pushedEl.attr('disabled') == 'disabled')){
					return false;
				}
				pushedEl.attr('disabled','disabled');
				mainSpinner.start();
				$.ajax({
					"url":"/developer/clients/meeting/status/"+id,
					"type":"GET",
					"success":function(data,textStatus,jqXHR){
						//alert(JSON.stringify(data)+" => "+textStatus+" => "+JSON.stringify(jqXHR));
						if(data.statusCode){
							alert(data.data.message);
							pushedEl.attr('title','Done');
							pushedEl.text('Status');
							pushedEl.removeClass('btn-danger').addClass('btn-success');
							mainSpinner.stop();
							
						}else{
							alert(data.data.message);
							mainSpinner.stop();
						}
					},
					"error":function(jqXHR,textStatus,errorThrown){
						//alert(JSON.stringify(jqXHR)+" => "+textStatus+" => "+errorThrown);
						alert("Something went wrong !!");
						mainSpinner.stop();
					}
				});
				return false;
			},
			clientTransactionDelete:function(id){
				if(confirm("Are you sure want to delete??")){
					mainSpinner.start();
					$.ajax({
						url:"/developer/clientTransactionDelete/delete/"+id,
						type:"GET",
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								alert(data.data.message);
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								dataTableAllTransactions.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTableAllTransactions.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							mainSpinner.stop();
							alert(data.data.message);
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			},
			clientOrderHistoryDelete:function(id){
				if(confirm("Are you sure want to delete??")){
					mainSpinner.start();
					$.ajax({
						url:"/developer/clientOrderHistoryDelete/delete/"+id,
						type:"GET",
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								 
								alert(data.data.message);
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								dataTableAllOrderHistory.ajax.reload(null,false);
								dataTablePaymentHistory.ajax.reload(null,false);
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTableAllOrderHistory.ajax.reload(null,false);
								dataTablePaymentHistory.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							mainSpinner.stop();
							alert(data.data.message);
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			},
			clientOrderHistoryStatus:function(id){
				if(confirm("Are you sure want to Invoice active and update client paid ??")){
			 
			 
					$.ajax({
						url:"/developer/clientOrderHistoryStatus/status/"+id,
						type:"GET",
                        
						success:function(data,textStatus,jqXHR){
							if(data.statusCode){
								mainSpinner.stop();
								alert(data.data.message);
								$('.alert').addClass('hide');
								$('.alert-success').removeClass('hide').html(data.data.message);
								//dataTableAllOrderHistory.ajax.reload(null,false);
								dataTablePaymentHistory.ajax.reload(null,false);
					 
							}else{
								mainSpinner.stop();
								$('.alert').addClass('hide');
								$('.alert-danger').removeClass('hide').html(data.data.message);							
								dataTableAllOrderHistory.ajax.reload(null,false);
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
					//		mainSpinner.stop();
							alert(data.data.message);
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
					});
				}
				return false;
			},
		}
	})();
// CLIENT OBJECT
// *************





var userController = (function(){
	return {
		 
		saveRegister:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/developer/saveRegister",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					 
						if (data.status) {	
						 
						$('#messagemodel .modal-title').text("list-users");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						//removeValidationErrors($this);
						window.location.href ="/developer/list-users"; 
							
						}else{
							$('#messagemodel .modal-title').text("list-users");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $this.find('.form-group').removeClass('has-error');
                            $this.find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $this.find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
						 					 
						}else{
							$('.alert').addClass('hide');
							$('.alert-danger').removeClass('hide').html(data.data.message);
						}
						 
					}
				}); 
				 return false;	
			},	


	};
})();




var occupationController = (function(){
		return {
			checked_Ids:[],				  
			saveOccupation:function(THIS){	
			  var $this = $(THIS);
			  var form = new FormData(THIS);	
	 
				$.ajax({
					url:"/developer/occupationSave",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					  
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("occupation");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/occupation"; 
							
						}else{
							$('#messagemodel .modal-title').text("occupation");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.occupation_form').find('.form-group').removeClass('has-error');
                            $('.occupation_form').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.occupation_form').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveOccupation:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 
				$.ajax({
					url:"/developer/occupationEditSave/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("occupation");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/occupation";
						}else{
							$('#messagemodel .modal-title').text("Course Content");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/occupation/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 
					if(response.status){
						$('#messagemodel .modal-title').text("occupation Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableOccupation.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("occupation Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
			 
				$.ajax({
					url:"/developer/occupation/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
				 
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableOccupation.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
				 
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
			 
				$.ajax({
					url:"/developer/occupation/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 	
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableOccupation.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
				}
			}
			
	};
	})(); 

 

var seoCityController = (function(){
		return {
			checked_Ids:[],				  
			saveSeoCity:function(THIS){	
			  var $this = $(THIS);
			  var form = new FormData(THIS);	
	 
				$.ajax({
					url:"/developer/saveSeoCity",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					  
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("seoCity");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/seoCity"; 
							
						}else{
							$('#messagemodel .modal-title').text("seoCity");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.city_form').find('.form-group').removeClass('has-error');
                            $('.city_form').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.city_form').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveSeoCity:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 
				$.ajax({
					url:"/developer/seoCity/editSaveSeoCity/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("seoCity");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("Course Content");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/seoCity/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 
					if(response.status){
						$('#messagemodel .modal-title').text("seoCity Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableSeoCity.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("seoCity Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
			 
				$.ajax({
					url:"/developer/seoCity/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
				 
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableSeoCity.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
				 
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
			 
				$.ajax({
					url:"/developer/seoCity/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 	
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableSeoCity.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
				}
			}
			
	};
	})(); 

 

var seoWorkController = (function(){
		return {
			checked_Ids:[],				  
			saveSeoWork:function(THIS){	
			  var $this = $(THIS);
			  var form = new FormData(THIS);		 
				$.ajax({
					url:"/developer/seo-work/saveSeoWork",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					  
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/seo-work"; 
							
						}else{
							$('#messagemodel .modal-title').text("Seo Work");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.seo_work').find('.form-group').removeClass('has-error');
                            $('.seo_work').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.seo_work').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveSeoWork:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 
				$.ajax({
					url:"/developer/seo-work/editSaveSeoWork/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/seo-work";
						}else{
							$('#messagemodel .modal-title').text("Course Content");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/seo-work/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 
					if(response.status){
						$('#messagemodel .modal-title').text("SEO Work Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTablePendingSeoWork.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("seoCity Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
			 
				$.ajax({
					url:"/developer/seo-work/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
				 
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableSeoCity.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
				 
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
			 
				$.ajax({
					url:"/developer/seoCity/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 	
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableSeoCity.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
				}
			}			 
			
	};
	})(); 

var classifiedProfileController = (function(){
		return {
			checked_Ids:[],				  
			saveClassifiedProfile:function(THIS){	
			  var $this = $(THIS);
			  var form = new FormData(THIS);		 
				$.ajax({
					url:"/developer/classified-profile/saveClassifiedProfile",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					  
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/classified-profile"; 
							
						}else{
							$('#messagemodel .modal-title').text("Seo Work");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.classified_profile').find('.form-group').removeClass('has-error');
                            $('.seoclassified_profile_work').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.classified_profile').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveClassifiedProfile:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 
				$.ajax({
					url:"/developer/classified-profile/editSaveClassifiedProfile/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/classified-profile";
						}else{
							$('#messagemodel .modal-title').text("Course Content");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/classified-profile/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 
					if(response.status){
						$('#messagemodel .modal-title').text("SEO Work Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableClassifiedProfile.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("seoCity Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
			}			 
			
	};
	})(); 

var formTypeController = (function(){
		return {
			checked_Ids:[],				  
			saveFormType:function(THIS){	
			  var $this = $(THIS);
			  var form = new FormData(THIS);		 
				$.ajax({
					url:"/developer/form-type/saveFormType",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					  
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/form-type"; 
							
						}else{
							$('#messagemodel .modal-title').text("Seo Work");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.form-type').find('.form-group').removeClass('has-error');
                            $('.form-type').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.form-type').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveFormType:function(THIS,id){	
			  var $this = $(THIS);
			   alert(id);
			var form = new FormData(THIS);	
			
				$.ajax({
					url:"/developer/form-type/editSaveFormType/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/form-type";
						}else{
							$('#messagemodel .modal-title').text("form type");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/form-type/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 
					if(response.status){
						$('#messagemodel .modal-title').text("SEO Work Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableformType.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("seoCity Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
			 
				$.ajax({
					url:"/developer/form-type/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
				 
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableformType.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
				 
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
			 
				$.ajax({
					url:"/developer/form-type/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 	
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableformType.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
				}
			}				 
			
	};
	})(); 

 
var homeSliderController = (function(){
		return {
			checked_Ids:[],				  
			saveSlider:function(THIS){	
			  var $this = $(THIS);
			  var form = new FormData(THIS);		 
				$.ajax({
					url:"/developer/home_slider/saveSlider",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					  
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/home_slider"; 
							
						}else{
							$('#messagemodel .modal-title').text("Seo Work");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.form-type').find('.form-group').removeClass('has-error');
                            $('.form-type').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.form-type').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveSlider:function(THIS,id){	
			  var $this = $(THIS);
			 
			var form = new FormData(THIS);	
			
				$.ajax({
					url:"/developer/home_slider/editSaveSlider/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/home_slider";
						}else{
							$('#messagemodel .modal-title').text("form type");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/home_slider/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 
					if(response.status){
						$('#messagemodel .modal-title').text("SEO Work Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTablehomeSlider.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("seoCity Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
			 
				$.ajax({
					url:"/developer/home_slider/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
				 
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTablehomeSlider.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
				 
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
			 
				$.ajax({
					url:"/developer/home_slider/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 	
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTablehomeSlider.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
				}
			}				 
			
	};
	})(); 

 
 
var AuthorController = (function(){
		return {
			checked_Ids:[],				  
			saveAuthor:function(THIS){	
			  var $this = $(THIS);
			  var form = new FormData(THIS);		 
				$.ajax({
					url:"/developer/author/saveAuthor",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					  
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/author"; 
							
						}else{
							$('#messagemodel .modal-title').text("Seo Work");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.form-type').find('.form-group').removeClass('has-error');
                            $('.form-type').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.form-type').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveAuthor:function(THIS,id){	
			  var $this = $(THIS);
			 
			var form = new FormData(THIS);	
			
				$.ajax({
					url:"/developer/author/editSaveAuthor/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("Seo Work");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/author";
						}else{
							$('#messagemodel .modal-title').text("form type");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/author/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 
					if(response.status){
						$('#messagemodel .modal-title').text("SEO Work Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAuthor.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("seoCity Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
			 
				$.ajax({
					url:"/developer/author/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
				 
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAuthor.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
				 
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
			 
				$.ajax({
					url:"/developer/author/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 	
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAuthor.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
				}
			}				 
			
	};
	})(); 

 
	

var keywordSellCountController = (function(){
		return {
			checked_Ids:[],				  
			saveKeywordSellCount:function(THIS){	
			  var $this = $(THIS);
			  var form = new FormData(THIS);	
	 
				$.ajax({
					url:"/developer/saveKeywordSellCount",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					  
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("keyword sell count");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/keyword_sell_count"; 
							
						}else{
							$('#messagemodel .modal-title').text("keyword sell count");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.keywordSell_form').find('.form-group').removeClass('has-error');
                            $('.keywordSell_form').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.keywordSell_form').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			editSaveKeywordSellCount:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 
				$.ajax({
					url:"/developer/keyword_sell_count/editSaveKeywordSellCount/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("keyword sell count");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/keyword_sell_count";
						}else{
							$('#messagemodel .modal-title').text("keyword sell count");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/keyword_sell_count/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 
					if(response.status){
						$('#messagemodel .modal-title').text("keyword_sell_count Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableKeywordSellCounts.ajax.reload( null, false );   
						setInterval(function() {
						$("#messagemodel").modal("hide");
						}, 1000);
					}else{
							$('#messagemodel .modal-title').text("keyword_sell_count Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
			 
				$.ajax({
					url:"/developer/keyword_sell_count/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
				 
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableKeywordSellCounts.ajax.reload( null, false );   
						setInterval(function() {
						$("#messagemodel").modal("hide");
						}, 1000);
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
				 
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
			 
				$.ajax({
					url:"/developer/keyword_sell_count/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 	
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableKeywordSellCounts.ajax.reload( null, false );   
						setInterval(function() {
						$("#messagemodel").modal("hide");
						}, 1000);
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 	
						 alert('some error');
					}
				});
				}
				}
			}
			
	};
	})(); 

	  

var CategoryController = (function(){
		return {
			checked_Ids:[],				  
			saveCategory:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/developer/categorySave",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					 	
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("doctor");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/category"; 
							
						}else{
							$('#messagemodel .modal-title').text("doctor");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.speciality_form').find('.form-group').removeClass('has-error');
                            $('.speciality_form').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.speciality_form').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCategory:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 
				$.ajax({
					url:"/developer/categoryEditSave/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					   		
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("FAQs");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/category";
						}else{
							$('#messagemodel .modal-title').text("Course Content");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					    ;			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/category/delete/"+id,
					type:"GET",
				 
					success:function(response){	
				 	
					if(response.status){
						$('#messagemodel .modal-title').text("doctor Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAllCategory.ajax.reload(null, false );   
					}else{
							$('#messagemodel .modal-title').text("doctor Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					    ;			
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
				 // 
				$.ajax({
					url:"/developer/category/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
				 	
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAllCategory.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					   		
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
				 // 
				$.ajax({
					url:"/developer/category/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 ;			
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAllCategory.ajax.reload(null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					    ;			
						 alert('some error');
					}
				});
				}
				}
			},			
			updateAboutCategory:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/updateAboutCategory/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("About Keyword");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("About Keyword");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
			  	
			
	};
	})(); 
	
	

	 
var ClientController = (function(){
		return {
			checked_Ids:[],		
			editSavePersonalDetails:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 
				$.ajax({
					url:"/developer/clients/editSavePersonalDetails/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 console.log(data);
						if(data.status){						 					
						// $('#messagemodel .modal-title').text("update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
					 
						}else{
							$('#messagemodel .modal-title').text("Course Content");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){					     			
						var response = JSON.parse(jqXHR.responseText);					 
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							$('#messagemodel .modal-title').text("Update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});	
						}
						 
					}
				}); 
				 return false;	
			},
			ediSaveBusinessInfo:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);				 
				$.ajax({
					url:"/developer/clients/ediSaveBusinessInfo/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 console.log(data);
						if(data.status){						 					
						// $('#messagemodel .modal-title').text("update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							 
							setInterval(function() {
							$("#messagemodel").modal("hide");
							}, 1000);
							//window.location.reload();
						}else{
							$('#messagemodel .modal-title').text("Course Content");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){					     			
						var response = JSON.parse(jqXHR.responseText);
						console.log(response);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							$('#messagemodel .modal-title').text("Update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});	
						}
						 
					}
				}); 
				 return false;	
			},

		 	 
		 
			 
			uploadClientKeyword:function(THIS,id){	
			var $this = $(THIS);
			var form = new FormData(THIS);				 
				$.ajax({
					url:"/developer/clients/uploadClientGallery/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					
						if(data.status){						 					
						$('#messagemodel .modal-title').text("update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
						setInterval(function() {
						$("#messagemodel").modal("hide");
						}, 1000);
						}else{
							$('#messagemodel .modal-title').text("Course Content");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){					     			
						var response = JSON.parse(jqXHR.responseText);
						console.log(response);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							$('#messagemodel .modal-title').text("Update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});	
						}
						 
					}
				}); 
				 return false;	
			},			 	 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/category/delete/"+id,
					type:"GET",
				 
					success:function(response){	
					 	
					if(response.status){
						$('#messagemodel .modal-title').text("doctor Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAllCategory.ajax.reload(null, false );  
						setInterval(function() {
						$("#messagemodel").modal("hide");
						}, 1000); 
					}else{
							$('#messagemodel .modal-title').text("doctor Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					    		
						 $('#messagemodel .modal-title').text("doctor Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
			 
				$.ajax({
					url:"/developer/category/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 ;			
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAllCategory.ajax.reload(null, false);   
						setInterval(function() {
						$("#messagemodel").modal("hide");
						}, 1000);
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					    ;			
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
				 
				$.ajax({
					url:"/developer/category/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
				 
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAllCategory.ajax.reload( null, false );   
						setInterval(function() {
						$("#messagemodel").modal("hide");
						}, 1000);
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					    ;			
						 alert('some error');
					}
				});
				}
				}
			},
			 

			
	};
	})(); 
	
	



var ChildController = (function(){
		return {
			checked_Ids:[],				  
			saveCategory:function(THIS){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/developer/categorySave",
					type:"POST",					   
					dataType:"json",
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,             
					success:function(data){	
					 	
						if(data.status){	
						 
						$('#messagemodel .modal-title').text("doctor");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/category"; 
							
						}else{
							$('#messagemodel .modal-title').text("doctor");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					  	
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.speciality_form').find('.form-group').removeClass('has-error');
                            $('.speciality_form').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.speciality_form').find('*[name="'+key+'"]');
                            $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
                            el.closest('.form-group').addClass('has-error');
                            }
                            }
						
							//showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},

			editSaveCategory:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
			 
				$.ajax({
					url:"/developer/categoryEditSave/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					  
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("FAQs");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							window.location.href ="/developer/category";
						}else{
							$('#messagemodel .modal-title').text("Course Content");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					  	
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},
			updateAboutChildCategory:function(THIS,id){	
			  var $this = $(THIS);
			var form = new FormData(THIS);	
		 
				$.ajax({
					url:"/developer/updateAboutChildCategory/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					 cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					 	
						if(data.status){	
					 					
						$('#messagemodel .modal-title').text("About Keyword");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
							removeValidationErrors($this);
							//window.location.href ="/developer/seoCity";
						}else{
							$('#messagemodel .modal-title').text("About Keyword");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});		 
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					 
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
							showValidationErrors($this,response.errors);						 
						}else{
							alert('Something went wrong');
						}
						 
					}
				}); 
				 return false;	
			},	
		 	 
			 
			delete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/developer/category/delete/"+id,
					type:"GET",
				 
					success:function(response){	
				 
					if(response.status){
						$('#messagemodel .modal-title').text("doctor Delete");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAllCategory.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("doctor Delete");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					 
						 alert('some error');
					}
				});
				}
			},
			status:function(id,val){		 
			 if(val==true){
				if(confirm("Are you sure you want to change the status to Active?")){		
				 
				$.ajax({
					url:"/developer/child_category/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 ;			
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAllChild.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					    ;			
						 alert('some error');
					}
				});
				}
				
				}else{
					if(confirm("Are you sure you want to change the status to Inactive?")){		
				 
				$.ajax({
					url:"/developer/child_category/status/"+id+"/"+val,
					type:"GET",					
					success:function(response){	
					 ;			
					if(response.status){
						$('#messagemodel .modal-title').text("status successfully update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
						dataTableAllChild.ajax.reload( null, false );   
					}else{
							$('#messagemodel .modal-title').text("Status successfully update");	
							$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
							$('#messagemodel').modal({keyboard:false,backdrop:'static'});
							$('#messagemodel').css({'width':'100%'});
					}						
					},
					error:function(response){
					  	
						 alert('some error');
					}
				});
				}
				}
			}
			
	};
	})(); 
	
	

var childIdHolder = (function(){
	var child_category_id = null;
	return {
		getChildCategoryID: function(){
			return this.child_category_id;
		},
		setChildCategoryID: function(id){
			this.child_category_id = id;
		}
	}
})();

var clientCategory = {
	addClientCategory:function(THIS){
		var $this = $(THIS);
		$this.find('.has-error').removeClass('has-error');
		if($this.find('input[name="client_category_name"]').val()==""){
			$this.find('input[name="client_category_name"]').parent('.form-group').addClass('has-error');
			return false;
		}
		$.ajax({
			url: $this.attr('action'),
			type: "POST",
			//data: $this.serialize(),
			data: new FormData(THIS),
			//dataType: 'json',
			contentType:false,
			cache:false,
			processData:false,
			success: function(response) {
				if(response.status){
					var image = '<i class="fa fa-times" style="color:red" aria-hidden="true"></i>';
					if(typeof response.clientCategory['image']!='undefined'){
						image = '<i class="fa fa-check" style="color:green" aria-hidden="true"></i>';
					}
					//dataTableExample.row.add([response.clientCategory['id'],response.clientCategory['name'],image,'<a href="javascript:void(0)"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a>','<a href="javascript:void(0)" onclick="return clientCategory.deleteClientCategory('+response.clientCategory['id']+',this)"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>']).draw(false);
					dataTableAssignedKeywords.ajax.reload(null,false);
					$this.find('input[name="reset_client_category"]').click();
				}else{
					alert(response.message);
				}
			},
			error: function(response) {
				alert("An error occured");
			}
		});		
		//alert($this.attr('action'));
		return false;
	},
	deleteClientCategory:function(id,THIS){
		$this = $(THIS);
		if(id==''){
			return false;
		}
		$.ajax({
			type: "GET",
			url: '/developer/clients/delete_client_category/'+id,
			dataType: 'json',
			success: function(response) {
				if(response.status){
					//dataTableExample.row($this.parents('tr')).remove().draw();
					dataTableAssignedKeywords.ajax.reload(null,false);
					alert('deleted: '+response.clientCategory.name);
				}else{
					alert(response.message);
				}
			},
			error: function(response) {
				alert("An error occured");
			}
		});			
		return false;
	}
};

var keyword = {
	city:null,
	parent_cat:null,
	child_cat:null,
	kw:null,
	position:null,
	submitCountBasedSubsForm:function(count_based_subs_form){
		$.ajax({
			type: "POST",
			url: count_based_subs_form.attr('action'),
			data: count_based_subs_form.serialize(),
			dataType: 'json',
			success: function(response) {
				if(response.statusCode){
					count_based_subs_form.find('#leads_remaining').val(response.data.payload.leads_remaining);
					alert(response.data.message);
				}else{
					alert(response.data.message);
				}
			},
			error: function(response) {
				alert("An error occured");
			}
		});		
	},
	submitMaxKWForm:function(max_kw_form){
		$.ajax({
			type: "POST",
			url: max_kw_form.attr('action'),
			data: max_kw_form.serialize(),
			dataType: 'json',
			success: function(response) {
				if(response.status){
					alert(response.message);
				}else{
					alert(response.message);
				}
			},
			error: function(response) {
				alert("An error occured");
			}
		});		
	},
	submitYearlySubsForm:function(yearly_subs_form){
		$.ajax({
			type: "POST",
			url: yearly_subs_form.attr('action'),
			data: yearly_subs_form.serialize(),
			dataType: 'json',
			success: function(response) {
				//alert(JSON.stringify(response.result));
				if(response.status){
					alert(response.message);
				}else{
					alert(response.message);
				}
				//dataTableExample.row.add([response.result['id'],]).draw(false);
			},
			error: function(response) {
				alert("An error occured");
			}
		});		
	},
	submitBalForm:function(balance_amt_form){
		$.ajax({
			type: "POST",
			url: balance_amt_form.attr('action'),
			data: balance_amt_form.serialize(),
			dataType: 'json',
			success: function(response) {
				//alert(JSON.stringify(response.result));
				if(response.status){
					alert(response.message);
				}else{
					alert(response.message);
				}
				dataTableTransactions.ajax.reload(null,false);
				//dataTableExample.row.add([response.result['id'],]).draw(false);
			},
			error: function(response) {
				alert("An error occured");
			}
		});		
	},
	submitKWForm:function(kw_form){
		//alert(kw_form.attr('action'));
		$.ajax({
			type: "POST",
			url: kw_form.attr('action'),
			data: kw_form.serialize(),
			//dataType: 'json',
			success: function(response) {	 	
				 
				if(response.status){
					 	dataTableAssignedKeywords.ajax.reload(null,false);
						alert("Keyword Added Successfully");
						$('#kw_form').find('.reset_kw_submit').click();
						$('#kw_form').find('.keyword_m').val(null).trigger('change');
						$('#kw_form').find('.city').val(null).trigger('change');
						$('#kw_form').find('*[name="zone_id"]').val(null).trigger('change');
						$('#kw_form').find('*[name="parent"]').val(null).trigger('change');
						$('#kw_form').find('*[name="child"]').val(null).trigger('change');
						$('#kw_form').find('*[name="kw"]').val(null).trigger('change');
						$('#kw_form').find('*[name="position"]').val(null).trigger('change');
						
						  
						
					
				}else{
					alert('Assigned keyword must be unique');
				}
				//dataTableExample.row.add([response.result['id'],]).draw(false);
			},
			error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);	 						
						if(response.status){						 
							var errors = response.errors;
							$('#kw_form').find('.form-group').find('.col-md-2').removeClass('has-error');
							$('#kw_form').find('.form-group').find('.help-block').remove();
							//$this.find('.form-group').removeClass('has-error');
							//$this.find('.help-block').remove();
							for (var key in errors) {								 
							if(errors.hasOwnProperty(key)){
							var el = $('#kw_form').find('*[name="'+key+'"]');							 
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.col-md-2').addClass('has-error');
							}
							}
							 //alert($this,response.errors);
							//showValidationErrors($this,response.errors);
						}else{
							alert('Something went wrong');
						}
						mainSpinner.stop();
					}
		});
	},
	setProperties:function(field,value){
	var client_id= $('#clientIDASSKW').val();	 
 
		switch(field){
			case 'city':
				this.city = value;
				//this.parent_cat = this.zone = this.child_cat = this.kw = this.position = null;
				var data = {
					'city':this.city
				};
				$.post(
					"/developer/clients/get/city/"+this.city,
					data,
					function(response,status){
						if(response.status){
							var html = "<option value=''>Select Zone</option>";
							//var html = "";
							for(var i in response.result){
								html += "<option value='"+response.result[i]['id']+"'>"+response.result[i]['zone']+"</option>";
							}
							$('.zone').html(html);
							$('.zone').html(html).select2({
								theme: "bootstrap",
								placeholder: "Select Parent",
								maximumSelectionSize: 6,
								containerCssClass: ':all:'
							});
							
						}
						/* else{
							alert("No Parent Category Found");
						} */
					}
				);		
			break;
			case 'zone':
				this.zone = value;
				 
				if(''==this.zone){
					return;
				}
				//this.child_cat = this.kw = this.position = null;
				var data = {
					'city':this.city,
					'zone':this.zone,
				};
				$.post(
					"/developer/clients/get/zone/"+this.zone,
					data,
					function(response,status){
						if(response.status){							 
							
						}else{
							alert("No Child Category Found");
						}
					}
				);				
			break;
			case 'parent_cat':
				this.parent_cat = value;
				if(''==this.parent_cat){
					return;
				}
				// if(null==this.city){
				// 	alert('please select city');
				// }				
				// if(null==this.zone){
				// 	alert('please select Zone');
				// }
				//this.child_cat = this.kw = this.position = null;
				var data = {
					// 'city':this.city,
					'parent_cat':this.parent_cat
				};
				$.post(
					"/developer/clients/get/parent_cat/"+this.parent_cat,
					data,
					function(response,status){
						if(response.status){
							var html = "<option value=''>Select Child</option>";
							for(var i in response.result){
								html += "<option value='"+response.result[i]['id']+"'>"+response.result[i]['child_category']+"</option>";
							}
							$('.child').html(html).select2({
								theme: "bootstrap",
								placeholder: "Select Child",
								maximumSelectionSize: 6,
								containerCssClass: ':all:'
							});
						}else{
							alert("No Child Category Found");
						}
					}
				);				
			break;
			case 'child_cat':
				this.child_cat = value;				
				
				if(''==this.child_cat){
					return;
				}
				//this.kw = this.position = null;
				var data = {
				//	'city':this.city,
					'parent_cat':this.parent_cat,
					'child_cat':this.child_cat
				};
				$.post(
					"/developer/clients/get/child_cat/"+this.child_cat,
					data,
					function(response,status){
						
						if(response.status){							
							var html = "<option value=''>Select Keyword</option>";
						 
							for(var i in response.result){
								html += "<option value='"+response.result[i]['id']+"'>"+response.result[i]['keyword']+"</option>";
							}
							
							 
							 $('.kw').html(html);
							 
						}else{
							alert("No Keyword Found");
						}
					}
				);				
			break;
			case 'kw':
				this.kw = value;
				if(''==this.kw){
					return;
				}			
 			
				// if(null==this.city){
				// 	alert('please select city');
				// }
				
				// if(null==this.zone){
				// 	alert('please select Zone');
				// }
			//	this.position = null;
				var data = {
					'client_id':client_id,					 
					'parent_cat':this.parent_cat,
					'child_cat':this.child_cat,
					'kw':this.kw
				};
				$.post(
					"/developer/clients/get/kw/"+this.kw,
					data,
					function(response,status){
					 
						if(response.status){
							var html = "<option value=''>Select Position</option>";
							for(var i in response.result){
								$selected = '';
								if(i=='preferred'){
									$selected = 'selected';
								}
								html += "<option value='"+i+"' "+$selected+">"+response.result[i]+"</option>";
							}
							$('.position').html(html).select2({
								theme: "bootstrap",
								placeholder: "Select Position",
								maximumSelectionSize: 6,
								containerCssClass: ':all:'
							});
							$('.position').trigger('change');
						}else{
							alert("No Position Found");
						}
					}
				);				
			break;
			case 'position':
				this.position = value;
				if(''==this.position){
					return;
				}
				var data = {
					'city':this.city,
					'parent_cat':this.parent_cat,
					'child_cat':this.child_cat,
					'kw':this.kw,
					'position':this.position
				};
				$.post(
					"/developer/clients/get/position/"+this.position,
					data,
					function(response,status){
						if(response.status){
							$('.price').val(response.result['price']);
						}else{
							alert("No Price Found");
						}
					}
				);				
			break;
		}
	},
	getProperties:function(){
		return this.city;
	},
	/**
	 * Show resource update form
	 *
	 * @param $target_id - record id the has to be updated
	 * @param THIS - record reference at client side
	 */
	editAssignedKeyword:function($target_id, THIS){
		 
		$.ajax({
			"url":removeHashFromURL(window.location.href)+"/edit-assigned-keyword/"+$target_id,
			"type":"GET",
			"success":function(data,textStatus,jqXHR){
				$('#deleteClient .modal-content').html(data.html);
				$('#deleteClient').modal({backdrop:'static',keyboard:false});
				$('.select2-single').select2({
					theme: "bootstrap",
					placeholder: "Select",
					maximumSelectionSize: 6,
					containerCssClass: ':all:'
				});
			},
			"error":function(jqXHR,textStatus,errorThrown){
				alert('Something went wrong !!');
			}
		});
	},
	/**
	 *
	 *
	 */
	updateAssignedKeyword:function(kw_form){
		$.ajax({
			type: "POST",
			url: kw_form.attr('action'),
			data: kw_form.serialize(),
			dataType: 'json',
			success: function(response) {
				//alert(JSON.stringify(response.result));
				if(response.status){
					alert(response.result);
					dataTableAssignedKeywords.ajax.reload(null,false);
					$('#deleteClient').modal('hide');
					//alert("Assigned Keyword Updated Successfully");
				}else{
					alert(response.message);
				}
				//dataTableExample.row.add([response.result['id'],]).draw(false);
			},
			error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);	 						
						if(response.status){						 
							var errors = response.errors;
							$('#update-assigned-keyword').find('.form-group').removeClass('has-error');
							$('#update-assigned-keyword').find('.form-group').find('.help-block').remove();
							//$this.find('.form-group').removeClass('has-error');
							//$this.find('.help-block').remove();
							for (var key in errors) {								 
							if(errors.hasOwnProperty(key)){
							var el = $('#update-assigned-keyword').find('*[name="'+key+'"]');							 
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}
							 //alert($this,response.errors);
							//showValidationErrors($this,response.errors);
						}else{
							alert('Something went wrong');
						}
						mainSpinner.stop();
					}
		});		
	}
};

// RETURN "CLIENT DELETE" OBJECT
// *****************************
var deleClient = (function(){
	var client_ID = null,
		html1 = null,
		restoreError = null,
		restoreSuccess = null,
		delSuccess = null,
		delError = null,
		html2 = null,
		currentRow = null;
	return {
		setClientID: function(id,currentRow,action){
		 
			this.client_ID = id;
			this.currentRow = currentRow;
			this.kwText = $(currentRow).closest('tr').find("td:eq(1)").text();
			this.html1 = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Delete Client</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Are you sure to delete client having id: \""+this.client_ID+"\" ??</p>\
					<div class=\"radio\">\
						<label><input type=\"radio\" name=\"optradio\" value=\"soft\" checked>Soft Delete</label>\
					</div>\
					<div class=\"radio\">\
						<label><input type=\"radio\" name=\"optradio\" value=\"hard\">Hard Delete</label>\
					</div>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" id=\"confirmDeleteClient\" onclick=\"deleClient.confirmDeleteClient()\" class=\"btn btn-default\">Confirm</button>\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\
				</div>\
			";
			this.html2 = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Delete Client</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Are you sure to permanently delete client having id: \""+this.client_ID+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" id=\"confirmHardDelete\" onclick=\"deleClient.confirmHardDelete()\" class=\"btn btn-default\">Yes</button>\
					<button type=\"button\" id=\"notConfirmHardDelete\" onclick=\"deleClient.notConfirmHardDelete()\" class=\"btn btn-default\">No</button>\
				</div>\
			";
			this.delError = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Delete Client</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Client not deleted having id: \""+this.client_ID+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\
				</div>\
			";
			this.delSuccess = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Delete Client</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Keyword deleted successfully having name: \""+this.kwText+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\
				</div>\
			";
			this.restoreError = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Restore Client</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Client not restored having id: \""+this.client_ID+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\
				</div>\
			";
			this.restoreSuccess = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Restore Client</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Client restored successfully having id: \""+this.client_ID+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\
				</div>\
			";
			this.restore = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Restore Client</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Are you sure to restore delete client having id: \""+this.client_ID+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" id=\"confirmRestore\" onclick=\"deleClient.confirmRestore()\" class=\"btn btn-default\">Yes</button>\
					<button type=\"button\" id=\"notConfirmRestore\" onclick=\"deleClient.notConfirmRestore()\" class=\"btn btn-default\">No</button>\
				</div>\
			";
			this.hdelete = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Delete Client</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Are you sure to permanently delete client having id: \""+this.client_ID+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" id=\"confirmHardDelete\" onclick=\"deleClient.confirmHardDelete()\" class=\"btn btn-default\">Yes</button>\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">No</button>\
				</div>\
			";
			this.del_kw = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Delete Keyword</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Are you sure to delete keyword having id: \""+this.client_ID+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" id=\"confirmHardDelete\" onclick=\"deleClient.confirmKWDelete()\" class=\"btn btn-default\">Confirm</button>\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">No</button>\
				</div>\
			";
			this.delKWError = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Delete Keyword</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Keyword not deleted having id: \""+this.client_ID+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\
				</div>\
			";
			this.delKWSuccess = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Delete Keyword</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Keyword deleted successfully having id: \""+this.client_ID+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\
				</div>\
			";
			this.del_ass_kw = "\
				<div class=\"modal-header\">\
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
					<h4 class=\"modal-title\">Delete Assigned Keyword</h4>\
				</div>\
				<div class=\"modal-body\">\
					<p>Are you sure to delete keyword having name: \""+this.kwText+"\" ??</p>\
				</div>\
				<div class=\"modal-footer\">\
					<button type=\"button\" id=\"confirmHardDelete\" onclick=\"deleClient.confirmAssKWDelete()\" class=\"btn btn-default\">Confirm</button>\
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">No</button>\
				</div>\
			";
			this.init(action);
		},
		init: function(action){
			var formContent = null;
			switch(action){
				case 'delete':
				formContent = this.html1;
				break;
				case 'restore':
				formContent = this.restore;
				break;
				case 'hdelete':
				formContent = this.hdelete;
				break;
				case 'del_kw':
				formContent = this.del_kw;
				break;
				case 'del_ass_kw':
				formContent = this.del_ass_kw;
				break;
				case 'view_kw':
				formContent = "\
					<div class=\"modal-header\">\
						<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
						<h4 class=\"modal-title\">Keyword Details</h4>\
					</div>\
					<div class=\"modal-body\">\
					</div>\
					<div class=\"modal-footer\">\
						<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\
					</div>\
				";
				$.get(
					"/developer/keyword/view_kw_detail/"+this.client_ID,
					function(response,status){
						if(response.status){
							//alert(JSON.stringify(response.clientsList));
							//document.write(JSON.stringify(response.bkts));
							var kwd = response.kwDetails;
							//alert(kwd);
							//var formContent = "";
							var modalBody = '<table class="table table-bordered table-striped table-hover"><tr style="background:#337AB7;color:#FFF;"><th>Item</th><th>Value</th></tr>';
							modalBody += '<tr><td><strong>ID</td><td>'+kwd['id']+'</td></tr>';
							modalBody += '<tr><td>Keyword</td><td>'+kwd['keyword']+'</td></tr>';
						//	modalBody += '<tr><td>City</td><td>'+kwd['city']+'</td></tr>';
							//modalBody += '<tr><td>KW with City</td><td>'+kwd['keyword_with_city']+'</td></tr>';
							modalBody += '<tr><td>Category</td><td>'+kwd['category']+'</td></tr>';
							modalBody += '<tr><td>Parent Category</td><td>'+kwd['parent_category']+'</td></tr>';
							modalBody += '<tr><td>Child Category</td><td>'+kwd['child_category']+'</td></tr>';
							//modalBody += '<tr><td>Diamond Price</td><td>'+kwd['premium_price']+'</td></tr>';
							//modalBody += '<tr><td>Platinum Price</td><td>'+kwd['platinum_price']+'</td></tr>';
							//modalBody += '<tr><td>Royal Price</td><td>'+kwd['royal_price']+'</td></tr>';
						//	modalBody += '<tr><td>King Price</td><td>'+kwd['king_price']+'</td></tr>';
							//modalBody += '<tr><td>Preferred Price</td><td>'+kwd['preferred_price']+'</td></tr>';
							modalBody += '<tr><td>Diamond Sold On</td><td>'+kwd['diamond_pos_sold']+'</td></tr>';
							modalBody += '<tr><td>Platinum Sold On</td><td>'+kwd['platinum_pos_sold']+'</td></tr>';
						//	modalBody += '<tr><td>Royal Sold On</td><td>'+kwd['royal_pos_sold']+'</td></tr>';
						//	modalBody += '<tr><td>King Sold On</td><td>'+kwd['king_pos_sold']+'</td></tr>';
						//	modalBody += '<tr><td>Preferred Sold On</td><td>'+kwd['preferred_pos_sold']+'</td></tr>';
							//modalBody += '<tr><td>Buckets</td><td>'+response.bkts+'</td></tr>';
							modalBody += '<tr><td>Buckets</td><td>'+response.searchBucketCityZone+'</td></tr>';
							modalBody += '<tr><td>Releted Keyword</td><td>'+response.searchRelatedKeyword+'</td></tr>';
							modalBody += '</table>';
							$('#deleteClient .modal-body').html(modalBody);							
							dataTableViewAllKwds.ajax.reload(null,false);
						}else{
							//$('#deleteClient .modal-content').html(delError);
						}
					}
				);				
				break;
			}
			if(formContent){
				$('#deleteClient .modal-content').html(formContent);
				$('#deleteClient').modal({keyboard:false,backdrop:'static'});
				
			}
		},
		confirmAssKWDelete: function(){
			var delSuccess = this.delSuccess;
			var delError = this.delError;
			var currentRow = this.currentRow;
			$.get(
				"/developer/clients/delkw/"+this.client_ID,
				function(response,status){
					if(response.status){
						$('#deleteClient .modal-content').html(delSuccess);
						//dataTableExample.row(currentRow.parents('tr')).remove().draw();
						dataTableAssignedKeywords.ajax.reload(null,false);
					}else{
						$('#deleteClient .modal-content').html(delError);
					}
				}
			);			
		},
		confirmDeleteClient: function(){
			var checkedBox = $('[name="optradio"]:checked').val();
			var delSuccess = this.delSuccess;
			var delError = this.delError;
			var currentRow = this.currentRow;
			if("soft"===checkedBox){
				//$('#deleteClient').modal('hide');
				$.get(
					"/developer/clients/sdelete/"+this.client_ID,
					function(response,status){
						if(response.status){
							//alert(response.msg);
							$('#deleteClient .modal-content').html(delSuccess);
							//dataTableExample.row(currentRow.parents('tr')).remove().draw();
							dataTableAssignedKeywords.ajax.reload(null,false);
							dataTableViewAllKwds.ajax.reload(null,false);
							dataTableClients.ajax.reload(null,false);
						}else{
							$('#deleteClient .modal-content').html(delError);
						}
					}
				);
			}
			if("hard"===checkedBox){
				$('#deleteClient .modal-content').html(this.html2);
			}			
		},
		confirmHardDelete: function(){
			var delSuccess = this.delSuccess;
			var delError = this.delError;
			var currentRow = this.currentRow;
			$.get(
				"/developer/clients/hdelete/"+this.client_ID,
				function(response,status){
					if(response.status){
						//alert(response.msg);
						$('#deleteClient .modal-content').html(delSuccess);
						//dataTableExample.row(currentRow.parents('tr')).remove().draw();
						dataTableAssignedKeywords.ajax.reload(null,false);
						dataTableViewAllKwds.ajax.reload(null,false);
						dataTableClients.ajax.reload(null,false);
					}else{
						$('#deleteClient .modal-content').html(delError);
					}
				}
			);
		},
		notConfirmHardDelete: function(){
			$('#deleteClient .modal-content').html(this.html1);
		},
		notConfirmRestore: function(){
			$('#deleteClient').modal('hide');
		},
		confirmRestore: function(){
			var restoreSuccess = this.restoreSuccess;
			var restoreError = this.restoreError;
			var currentRow = this.currentRow;
			$.get(
				"/developer/clients/restore/"+this.client_ID,
				function(response,status){
					if(response.status){
						$('#deleteClient .modal-content').html(restoreSuccess);
						//dataTableExample.row(currentRow.parents('tr')).remove().draw();
						dataTableAssignedKeywords.ajax.reload(null,false);
					}else{
						$('#deleteClient .modal-content').html(restoreError);
					}
				}
			);			
		},
		confirmKWDelete: function(){
			var delKWSuccess = this.delKWSuccess;
			var delKWError = this.delKWError;
			var currentRow = this.currentRow;
			$.get(
				"/developer/keyword/delete/"+this.client_ID,
				function(response,status){
					if(response.status){
						$('#deleteClient .modal-content').html(delKWSuccess);
						//dataTableExample.row(currentRow.parents('tr.child').prev()).remove().draw();
						dataTableAssignedKeywords.ajax.reload(null,false);
						dataTableViewAllKwds.ajax.reload(null,false);
					}else{
						$('#deleteClient .modal-content').html(delKWError);
					}
				}
			);			
		},
		
		
		
	}
})();

function checkAll(id){
	if(null==id){
		return;
	}
	$('#'+id+' input[type="checkbox"]').prop('checked',true);
}

function unCheckAll(id){
	if(null==id){
		return;
	}
	$('#'+id+' input[type="checkbox"]').prop('checked',false);
}

function showBucket(kw=null, bucket=null){
	if(kw==null||bucket==null)
		return;
	$.get(
		"/developer/keyword/bucket/"+kw+"/"+bucket,
		function(response,status){
			if(response.status){
				//alert(JSON.stringify(response.clientsList));
				//document.write(JSON.stringify(response.bkts));
				//var kwd = response.kwDetails[0];
				//var formContent = "";
				var modalBody = response.modalBody;
				$('#deleteClient .modal-body').html(modalBody);
			}else{
				//$('#deleteClient .modal-content').html(delError);
			}
		}
	);	
}

function showBucketcz(kw=null,cityid=null, zoneid=nul,bucket=null){
	if(kw==null||bucket==null)
		return;
	$.get(
		"/developer/keyword/showBucketcz/"+kw+"/"+cityid+"/"+zoneid+"/"+bucket,
		function(response,status){
			if(response.status){
				
				var htmls = response.message;	
 				
				$('body').append(htmls);
				$('#assignkey-bucket-modal-show').modal({backdrop:'static',keyboard:false});
				$("#assignkey-bucket-modal-show").on('hidden.bs.modal', function () {
				$(this).data('bs.modal', null);
				$('#assignkey-bucket-modal-show').remove();
				});
				
				 
			}else{
				//$('#deleteClient .modal-content').html(delError);
			}
		}
	);	
}


function searchBucketCityZone(kw=null){
	if(kw==null)
		return;
	 
	$.get(
		"/developer/keyword/bucketCityZone/"+kw,
		function(response,status){
			if(response.status){
				//alert(JSON.stringify(response.clientsList));
				//document.write(JSON.stringify(response.bkts));
				//var kwd = response.kwDetails[0];
				//var formContent = "";
				 
				//alert(JSON.stringify(response.message));
				var html = response.message;	
 				
				$('body').append(html);
				$('#assignkey-city-modal').modal({backdrop:'static',keyboard:false});
				$("#assignkey-city-modal").on('hidden.bs.modal', function () {
				$(this).data('bs.modal', null);
				$('#assignkey-city-modal').remove();
				});
				//$('#deleteClient').html(html);
			}else{
				//$('#deleteClient .modal-content').html(delError);
			}
		}
	);	
}




function searchRelatedKeyword(kw=null){
	if(kw==null)
		return;
	 
	$.get(
		"/developer/keyword/relatedKeyword/"+kw,
		function(response,status){
			if(response.status){
				//alert(JSON.stringify(response.clientsList));
				//document.write(JSON.stringify(response.bkts));
				//var kwd = response.kwDetails[0];
				//var formContent = "";
				 
				//alert(JSON.stringify(response.message));
				var html = response.message;	
 				
				$('body').append(html);
				$('#assignkey-city-modal').modal({backdrop:'static',keyboard:false});
				$("#assignkey-city-modal").on('hidden.bs.modal', function () {
				$(this).data('bs.modal', null);
				$('#assignkey-city-modal').remove();
				});
				//$('#deleteClient').html(html);
			}else{
				//$('#deleteClient .modal-content').html(delError);
			}
		}
	);	
}


function showBucketViewCityZone(kw=null){
	if(kw==null)
		return;
 
			var assigncity_id = $('#assigncity_id').val();
			var assignone_id = $('#assignarea_zone').val();
			 
	$.get(
		"/developer/keyword/showBucketViewCityZone/"+kw+"/"+assigncity_id+"/"+assignone_id,
		function(response,status){
			if(response.status){
				var html = response.bkts;	
					$('body').append(html);
				$('#assignkey-bucket-modal').modal({backdrop:'static',keyboard:false});
				$("#assignkey-bucket-modal").on('hidden.bs.modal', function () {
				$(this).data('bs.modal', null);
				$('#assignkey-bucket-modal').remove();
				});
			 
				 
			}else{
				//$('#showBucketViewCityZone .modal-content').html(delError);
			}
		}
	);	
}
 

function deleteCity(id,THIS){
	var $this = $(THIS);
	if(id!=''){
		if(confirm("Sure to delete City !!")){
			$.get(
				"/developer/cities/delete/"+id,
				function(response,status){
					if(response.status){
						alert(response.msg);
						//dataTableExample.row($this.parents('tr')).remove().draw();
						dataTableCitylist.ajax.reload(null,false);
					}
				}
			);
		}
	}
}

function updateCity(id,THIS){
	var $this = $(this);	 
	if(id!=''){
		$.get(
			"/developer/cities/updatecity/"+id,
			function(response,status){				 
				if(response.status){
					$('#updateCityModal .modal-body').html(response.msg);
					$('#updateCityModal').modal();
				}
			}
		);
	}	
}

function deleteParentCategory(id,THIS){
	var $this = $(THIS);
	if(id!=''){
		if(confirm("Sure to delete Parent Category !!")){
			$.get(
				"/developer/parent_category/delete/"+id,
				function(response,status){
					if(response.status){
						alert(response.msg);
						//$this.closest('tr').remove();
						//dataTableExample.row($this.parents('tr')).remove().draw();
						dataTableAssignedKeywords.ajax.reload(null,false);
					}
				}
			);
		}
	}
}

function updateParentCategory(id,THIS){
	var $this = $(this);
	if(id!=''){
		$.get(
			"/developer/parent_category/update_parent_category/"+id,
			function(response,status){
				if(response.status){
					$('#updateParentCategoryModal .modal-body').html(response.msg);
					$('#updateParentCategoryModal').modal();
				}
			}
		);
	}	
}

function deleteChildCategory(id,THIS){
	var $this = $(THIS);
	if(id!=''){
		if(confirm("Sure to delete Child Category !!")){
			$.get(
				"/developer/child_category/delete/"+id,
				function(response,status){
					if(response.status){
						alert(response.msg);
						//$this.closest('tr').remove();
						//dataTableExample.row($this.parents('tr')).remove().draw();
						dataTableAssignedKeywords.ajax.reload(null,false);
					}
				}
			);
		}
	}
}

function updateChildCategory(id,THIS){
	var $this = $(this);
	if(id!=''){
		$.get(
			"/developer/child_category/update_child_category/"+id,
			function(response,status){
				if(response.status){
					//$('#updateChildCategoryModal .modal-body').html(response.msg);
					$('#updateChildCategoryModal input[name="id"]').val(response.child.id);
					$('#updateChildCategoryModal select[name="parent_category_id"]').val(response.child.parent_category_id).trigger("change");
					$('#updateChildCategoryModal input[name="child_category"]').val(response.child.child_category);
					$('#updateChildCategoryModal').modal();
				}
			}
		);
	}	
}

function deleteKeywordSellCount(id,THIS){
	var $this = $(THIS);
	if(id!=''){
		if(confirm("Sure to delete Keyword Category and Count !!")){
			$.get(
				"/developer/keyword_sell_count/delete/"+id,
				function(response,status){
					if(response.status){
						alert(response.msg);
						//$this.closest('tr').remove();
						//dataTableExample.row($this.parents('tr')).remove().draw();
						dataTableAssignedKeywords.ajax.reload(null,false);
					}
				}
			);
		}
	}
}

function deleteClient(id,THIS,action){
	var $this = $(THIS);
	deleClient.setClientID(id,$this,action);
}

function deleteKeyword(id,THIS,action){
	var $this = $(THIS);
	deleClient.setClientID(id,$this,action);	
}

function deleteAssignedKW(id,THIS,action){
	var $this = $(THIS);
	 
	deleClient.setClientID(id,$this,action);	
}

function leadRepost(id=null){
	if(null==id){
		alert("Lead id cannot be null.");
		return;
	}
	
	$.ajax({
		"url":"/developer/lead/repost/"+id,
		"type":"GET",
		"success":function(data,textStatus,jqXHR){
			//alert(JSON.stringify(data)+" => "+textStatus+" => "+JSON.stringify(jqXHR));
			alert("Lead Repost done successfully");
		},
		"error":function(jqXHR,textStatus,errorThrown){
			//alert(JSON.stringify(jqXHR)+" => "+textStatus+" => "+errorThrown);
			alert("Lead Repost done successfully");
		}
	});
}

/* function deleteKeyword(id,THIS){
	var $this = $(THIS);
	if(id!=''){
		if(confirm("Sure to delete Keyword !!")){
			$.get(
				"/developer/keyword/delete/"+id,
				function(response,status){
					if(response.status){
						alert(response.msg);
						//$this.closest('tr').remove();
						dataTableExample.row($this.parents('tr')).remove().draw();
					}
				}
			);
		}
	}
} */

 



function updateKeyword(id,THIS){
	var $this = $(this);
	if(id!=''){
		$.get(
			"/developer/keyword/update_keyword/"+id,
			function(response,status){
				if(response.status){
				    
				    //console.log(response.keyword.related_keyword);
				    //var matches = serializedData.match(response.keyword); 
  
				    //console.log(unserialize(response.keyword.related_keyword));
				    
                //const serializedData = response.keyword.related_keyword;
                // const regex = /a:(\d+):\{(.*?)\}/;
                // const matches = serializedData.match(regex);
                // const length = matches[1]; 
                // const elements = matches[2].split(';');
                
                //const unserializedData = unserialize(serializedData);
                //console.log(unserializedData);
                // const values = Object.values(unserializedData); 
                //    console.log(values);
					//$('#updateKeywordModal .modal-body').html(response.msg);
					$('#updateKeywordModal input[name="id"]').val(response.keyword.id);
					//$('#updateKeywordModal select[name="city_id"]').val(response.keyword.city_id).trigger("change");
					$('#updateKeywordModal select[name="category"]').val(response.keyword.category).trigger("change");
					if(response.keyword.premium_price != "0" && response.keyword.premium_price != ""){
						$('#updateKeywordModal input[name="premium_price"]').val(response.keyword.premium_price);
					}
					if(response.keyword.platinum_price != "0" && response.keyword.platinum_price != ""){
						$('#updateKeywordModal input[name="platinum_price"]').val(response.keyword.platinum_price);
					}
					if(response.keyword.royal_price != "0" && response.keyword.royal_price != ""){
						$('#updateKeywordModal input[name="royal_price"]').val(response.keyword.royal_price);
					}
					if(response.keyword.king_price != "0" && response.keyword.king_price != ""){
						$('#updateKeywordModal input[name="king_price"]').val(response.keyword.king_price);
					}
					if(response.keyword.preferred_price != "0" && response.keyword.preferred_price != ""){
						$('#updateKeywordModal input[name="preferred_price"]').val(response.keyword.preferred_price);
					}
					childIdHolder.setChildCategoryID(response.keyword.child_category_id);
					
					$('#updateKeywordModal select[name="parent_category_id"]').val(response.keyword.parent_category_id).trigger("change");
                    
                    
					//$('#updateKeywordModal select[name="child_category_id"]').val(response.keyword.child_category_id).trigger("change");
			//	$('#updateKeywordModal select[name="related_keyword[]"]').val(values).trigger("change"); 
				//	console.log(response.keyword.related_keyword);
					$('#updateKeywordModal input[name="keyword"]').val(response.keyword.keyword);
					$('#updateKeywordModal').modal();
				}
			}
		);
	}	
}



function unserialize(serializedString) {
    const regex = /a:(\d+):\{(.*?)\}/;
    const matches = serializedString.match(regex);
    const result = {};

    if (matches) {
        const length = matches[1]; // Number of elements in the array
        const elements = matches[2].split(';');

        for (let i = 0; i < elements.length; i++) {
            const result = elements[i].trim();
            
            // if (element) {
            //     const keyValueMatch = element.match(/i:(\d+);s:\d+:"(.*?)"/);
               
            //     if (keyValueMatch) {
            //         const key = parseInt(keyValueMatch[1], 10);
            //         // console.log(key);
            //         //const value = keyValueMatch[2];
            //         result[key] = value;
            //     }
            // }
        }
    }
    return result;
}
function invoiceEdit(id,THIS){
	var $this = $(this); 
	if(id!=''){
		$.get(
			"/developer/clients/geteditpayment/"+id,
			function(response,status){
				if(response.status){
					
					 
					//$('#updateKeywordModal .modal-body').html(response.msg);
					$('#updateInvoiceModal input[name="id"]').val(response.paymentHistory.id);
					//$('#updateKeywordModal select[name="city_id"]').val(response.keyword.city_id).trigger("change");
					$('#updateInvoiceModal input[name="package_name"]').val(response.paymentHistory.package_name);
					$('#updateInvoiceModal input[name="paid_amount"]').val(response.paymentHistory.paid_amount);
					/* if(response.keyword.premium_price != "0" && response.keyword.premium_price != ""){
						$('#updateInvoiceModal input[name="premium_price"]').val(response.keyword.premium_price);
					}
					if(response.keyword.platinum_price != "0" && response.keyword.platinum_price != ""){
						$('#updateInvoiceModal input[name="platinum_price"]').val(response.keyword.platinum_price);
					}
					if(response.keyword.royal_price != "0" && response.keyword.royal_price != ""){
						$('#updateInvoiceModal input[name="royal_price"]').val(response.keyword.royal_price);
					}
					if(response.keyword.king_price != "0" && response.keyword.king_price != ""){
						$('#updateInvoiceModal input[name="king_price"]').val(response.keyword.king_price);
					}
					if(response.keyword.preferred_price != "0" && response.keyword.preferred_price != ""){
						$('#updateInvoiceModal input[name="preferred_price"]').val(response.keyword.preferred_price);
					}
					childIdHolder.setChildCategoryID(response.keyword.child_category_id);
					
					$('#updateInvoiceModal select[name="parent_category_id"]').val(response.keyword.parent_category_id).trigger("change");

					//$('#updateKeywordModal select[name="child_category_id"]').val(response.keyword.child_category_id).trigger("change");
					
					$('#updateInvoiceModal input[name="keyword"]').val(response.keyword.keyword); */
					$('#updateInvoiceModal').modal();
				}
			}
		);
	}	
}

function deleteBusinessKeyword(id,THIS){
	var $this = $(THIS);
	if(id!=''){
		if(confirm("Sure to delete Business Keyword !!")){
			$.get(
				"/developer/business_keyword/delete/"+id,
				function(response,status){
					if(response.status){
						alert(response.msg);
						//$this.closest('tr').remove();
						//dataTableExample.row($this.parents('tr')).remove().draw();
						dataTableAssignedKeywords.ajax.reload(null,false);
					}
				}
			);
		}
	}
}

function updateBusinessKeyword(id,THIS){
	var $this = $(this);
	if(id!=''){
		$.get(
			"/developer/business_keyword/update_keyword/"+id,
			function(response,status){
				if(response.status){
					var childCategories = response.businessKeyword.childCategories,
					    keywords        = response.businessKeyword.keywords;
					//$('#updateKeywordModal .modal-body').html(response.msg);
					$('#updateBusinessKeywordModal input[name="id"]').val(response.businessKeyword.id);
					
/* 					var child_categories = response.child_category,
					    html             = '';
					for(var a in child_categories){
						html += '<option value="'+child_categories[a].id+'">'+child_categories[a].child_category+'</option>';
					}					
					$('#updateKeywordModal select[name="child_category_id"]').html(html).trigger("change"); */
					//childIdHolder.setChildCategoryID(response.keyword.child_category_id);
					
					$('#updateBusinessKeywordModal select[name="city_id"]').val(response.businessKeyword.city_id);
					$('#updateBusinessKeywordModal select[name="parent_category_id"]').select2('val',response.businessKeyword.parent_category_id);
					var html = '';
					for(var a in childCategories){
						html += '<option value="'+childCategories[a].id+'">'+childCategories[a].child_category+'</option>';
					}					
					$('#updateBusinessKeywordModal select[name="child_category_id"]').html(html).val(response.businessKeyword.child_category_id);
					html = '';
					for(var a in keywords){
						html += '<option value="'+keywords[a].id+'">'+keywords[a].keyword+'</option>';
					}					
					$('#updateBusinessKeywordModal select[name="keyword_id"]').html(html).val(response.businessKeyword.keyword_id);

					//$('#updateKeywordModal select[name="child_category_id"]').val(response.keyword.child_category_id).trigger("change");
					
					//$('#updateBusinessKeywordModal input[name="keyword"]').val(response.keyword.keyword);
					$('#updateBusinessKeywordModal').modal();
				}
			}
		);
	}	
}

function initDatePicker(){
	var xDate = $(".x_date");
	var yDate = $(".y_date");
	//var client_type = $('.client_type').val();
	xDate.datepicker({
		dateFormat:"yy-mm-dd",
		//minDate:"+0D",
		onSelect: function(newdate) {
			var myDate = new Date(newdate);
			var client_type = $('.client_type').val();
			 
			if(client_type=="Gold"){
				myDate.setMonth(myDate.getMonth() + 6);
				myDate.setDate(myDate.getDate() - 1);				
			}else if(client_type=="Diamond"){
				myDate.setFullYear(myDate.getFullYear() + 1);
				myDate.setDate(myDate.getDate() - 1);				
			}else if(client_type=="Platinum"){
				myDate.setFullYear(myDate.getFullYear() + 1);
				myDate.setDate(myDate.getDate() - 1);				
			}
			
			/* else{
				myDate.setFullYear(myDate.getFullYear() + 1);
				myDate.setDate(myDate.getDate() - 1);
			} */
			yDate.val($.datepicker.formatDate('yy-mm-dd', myDate));
			yDate.focus();
		}	
	});	
		yDate.datepicker({
		dateFormat:"yy-mm-dd",
		});
	
}

function initDateInvoiceclient(){	 
	var xDate = $(".x_date");
	var yDate = $(".y_date");
	//var client_type = $('.client_type').val();
	xDate.datepicker({
		dateFormat:"yy-mm-dd",
		//minDate:"+0D",
		onSelect: function(newdate) {
			var myDate = new Date(newdate);
			var client_type = $('.package_status').val();
			 
			if(client_type=="Gold"){
				myDate.setMonth(myDate.getMonth() + 6);
				myDate.setDate(myDate.getDate() - 1);				
			}else if(client_type=="Diamond"){
				myDate.setFullYear(myDate.getFullYear() + 1);
				myDate.setDate(myDate.getDate() - 1);				
			}else if(client_type=="Platinum"){
				myDate.setFullYear(myDate.getFullYear() + 1);
				myDate.setDate(myDate.getDate() - 1);				
			}
			
			/* else{
				myDate.setFullYear(myDate.getFullYear() + 1);
				myDate.setDate(myDate.getDate() - 1);
			} */
			yDate.val($.datepicker.formatDate('yy-mm-dd', myDate));
			yDate.focus();
		}	
	});
 
		yDate.datepicker({
		dateFormat:"yy-mm-dd",
		});
	
}
function initDateInvoiceclientupdate(){	 
 
	var xDate = $(".expired_from");
	var yDate = $(".expired_on");
	 
	xDate.datepicker({
		dateFormat:"yy-mm-dd",
		//minDate:"+0D",
		onSelect: function(newdate) {
			var myDate = new Date(newdate);
			var client_type = $('.package_name').val();		 
			if(client_type=="Gold"){
				myDate.setMonth(myDate.getMonth() + 6);
				myDate.setDate(myDate.getDate() - 1);				
			}else if(client_type=="Diamond"){
				myDate.setFullYear(myDate.getFullYear() + 1);
				myDate.setDate(myDate.getDate() - 1);				
			}else if(client_type=="Platinum"){
				myDate.setFullYear(myDate.getFullYear() + 1);
				myDate.setDate(myDate.getDate() - 1);				
			}
			
			/* else{
				myDate.setFullYear(myDate.getFullYear() + 1);
				myDate.setDate(myDate.getDate() - 1);
			} */
			yDate.val($.datepicker.formatDate('yy-mm-dd', myDate));
			yDate.focus();
		}	
	});
 
		yDate.datepicker({
		dateFormat:"yy-mm-dd",
		});
	
}




function handlingPaiAmt() {
	
	var paid_amount = jQuery('#paid_amount');
	var paid_am= parseInt(paid_amount.val());

	var coins = jQuery('#coins_per_lead');
    
	if( paid_am <= 0 ){
		alert("paid amount Cannot be Empty");
		paid_am.val("");

	}
	 

	if (1000 <= paid_am && paid_am < 2000) {

     var coinAmt = parseInt(paid_am/0.90);
  
    $('#coins_per_lead').val(coinAmt);
	 

	}else if (2000 <= paid_am && paid_am < 4000) {
 
     var coinAmt = parseInt(paid_am/0.86);
    $('#coins_per_lead').val(coinAmt);
	 

	}else if (4000 <= paid_am && paid_am < 6000) {
 
     var coinAmt = parseInt(paid_am/0.84);
    $('#coins_per_lead').val(coinAmt);
	 

	}else  if (6000 <= paid_am && paid_am < 8000) {
 
     var coinAmt = parseInt(paid_am/0.82);
    $('#coins_per_lead').val(coinAmt);
	 

	}else if (8000 <= paid_am && paid_am < 10000) {
 
     var coinAmt = parseInt(paid_am/0.80);
    $('#coins_per_lead').val(coinAmt);
	 

	}else if (10000 <= paid_am && paid_am < 15000) {
  
     var coinAmt = parseInt(paid_am/0.78);
    $('#coins_per_lead').val(coinAmt);	 

	}else if (15000 <= paid_am && paid_am < 20000) {
 
     var coinAmt = parseInt(paid_am/0.75);
    $('#coins_per_lead').val(coinAmt);
	 

	}else if (20000 <= paid_am && paid_am < 40000) {
 
     var coinAmt = parseInt(paid_am/0.70);
    $('#coins_per_lead').val(coinAmt);
	 

	}else if (40000 <= paid_am && paid_am < 50000) {
 
     var coinAmt = parseInt(paid_am/0.65);
    $('#coins_per_lead').val(coinAmt); 

	}else if (50000 <= paid_am && paid_am <= 100000) {
 
     var coinAmt = parseInt(paid_am/0.60);
    $('#coins_per_lead').val(coinAmt);
	} 
    else if (100000 <= paid_am && paid_am <= 999999) {
 
     var coinAmt = parseInt(paid_am/0.49);
    $('#coins_per_lead').val(coinAmt);
	} 
}

function handlingFee() {
	
	var paid_amount = jQuery('#paid_amount');
	var c = jQuery('#coins_per_lead');

	var paid_am= parseInt(paid_amount.val());
 
	var cost_le= parseInt(cost_per_lead.val()); 
	var total_lead = parseInt(paid_am/cost_le);
	var actualamt = $('#leadscount').val(total_lead);
	if( paid_am <= 0 ){
		alert("paid amount Cannot be Empty");
		paid_amount.val("");

	}

	else if (cost_le > paid_am) {
		alert("cost lead cannot be more than paid amount");
		cost_le.val("0");

	}
    
}

function generateNewPass(){
	$.ajax({
		type:"GET",
		url:location.href+"/sendpass",
		dataType:"json",
		success:function(response){
			if(response.status){
				//alert(JSON.stringify(response));
				var modalContent = "\
					<div class=\"modal-header\">\
						<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\
						<h4 class=\"modal-title\">Send Password</h4>\
					</div>\
					<div class=\"modal-body\">\
						<p>Username: "+response.username+"<br>Password: "+response.password+"</p>\
					</div>\
					<div class=\"modal-footer\">\
						<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\
					</div>\
				";
				$('#generalPopup .modal-content').html(modalContent);
				$('#generalPopup').modal({keyboard:false,backdrop:'static'});
			}
		},
		error:function(){
			alert('Unable to process request...');
		}
	});
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function exportClients(){
			$('#export-clients').find('input[name="search[client_type]"]').val(getParameterByName('search%5Bclient_type%5D'));
			$('#export-clients').find('input[name="search[city]"]').val($('*[name="search[city][]"]').val());		 
			$('#export-clients').find('input[name="search[datef]"]').val(getParameterByName('search%5Bdatef%5D'));
			$('#export-clients').find('input[name="search[datet]"]').val(getParameterByName('search%5Bdatet%5D'));
			$('#export-clients').find('input[name="search[user]"]').val(getParameterByName('search%5Buser%5D'));
			$('#export-clients').find('input[name="search[paid_status]"]').val(getParameterByName('search%5Bpaid_status%5D'));
			$('#export-clients').find('input[name="search[client_category]"]').val(getParameterByName('search%5Bclient_category%5D'));
			$('#export-clients').find('input[name="search[value]"]').val($('input[type="search"]').val());
			return true;
}

function exportLeads(){
	 
			$('#export-leads').find('input[name="search[city]"]').val($('*[name="search[city][]"]').val());		 
			$('#export-leads').find('input[name="search[datef]"]').val(getParameterByName('search%5Bdatef%5D'));
			$('#export-leads').find('input[name="search[datet]"]').val(getParameterByName('search%5Bdatet%5D'));		 
			$('#export-leads').find('input[name="search[course]"]').val($('*[name="search[course][]"]').val());		
			$('#export-leads').find('input[name="search[status]"]').val($('*[name="search[status][]"]').val());		
			$('#export-leads').find('input[name="search[lead_type]"]').val(getParameterByName('search%5Blead_type%5D'));
			$('#export-leads').find('input[name="search[user]"]').val(getParameterByName('search%5Buser%5D'));
			$('#export-leads').find('input[name="search[value]"]').val($('input[type="search"]').val());
			return true;
}
function getorderhistoryexcel(){
			$('#export-orderhistory').find('input[name="search[client_type]"]').val(getParameterByName('search%5Bclient_type%5D'));
			$('#export-orderhistory').find('input[name="search[datef]"]').val(getParameterByName('search%5Bdatef%5D'));
			$('#export-orderhistory').find('input[name="search[datet]"]').val(getParameterByName('search%5Bdatet%5D'));			 
			$('#export-orderhistory').find('input[name="search[value]"]').val($('input[type="search"]').val());
			return true;
}

function exportKwds(){
			$('#export-kwds').find('input[name="search[city]"]').val(getParameterByName('search%5Bcity%5D'));
			$('#export-kwds').find('input[name="search[pc]"]').val(getParameterByName('search%5Bpc%5D'));
			$('#export-kwds').find('input[name="search[cc]"]').val(getParameterByName('search%5Bcc%5D'));
			$('#export-kwds').find('input[name="search[cat]"]').val(getParameterByName('search%5Bcat%5D'));
			$('#export-kwds').find('input[name="search[value]"]').val($('input[type="search"]').val());
			return true;
}

function bindSelect2OnCity(){
	$("*[name=\"city_id\"]").select2({
		theme: "bootstrap",
		placeholder: "Select a City",
		maximumSelectionSize: 6,
		containerCssClass: ":all:",
		allowClear:true,
		ajax: {
			url: "/developer/cities/getajaxcities",
			dataType: 'json',
			delay: 250,
			data: function(params) {
				return {
					q: params.term
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data.cities, function(obj) {
						return {
							id: obj.city,
							text: obj.city
						};
					})
				}
			},
			cache: true
		}
	});	
}

function bindSelect2OnAreaZone(){
	$("*[name=\"area_zone\"]").select2({
		theme: "bootstrap",
		placeholder: "Find Area...",
		maximumSelectionSize: 10,
		containerCssClass: ":all:",
		allowClear:true,
		ajax: {
			url: "/developer/area/get-ajax-areas",
			dataType: 'json',
			delay: 250,
			data: function(params) {
				return {
					q: params.term,
					city: $('*[name="city_id"]').val()
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data.areas, function(obj) {
						// return {
						// 	id: obj.id,
						// 	text: obj.zone+" "+"("+obj.area+")"
						// };


						  return {
                                    id: obj.zone_id,
                                    text:
                                        (obj.zone ? obj.zone + '' : '') +                                       
                                        (obj.pincode ? ', ' + obj.pincode : '')
                                };
					})
				}
			},
			cache: true
		}
	});
}

function bindSelect2OnCourse(){
	$("*[name=\"kw_text\"]").select2({
		theme: "bootstrap",
		placeholder: "Find Course...",
		maximumSelectionSize: 10,
		containerCssClass: ":all:",
		allowClear:true,
		ajax: {
			url: "/developer/kw/search/cc",
			dataType: 'json',
			delay: 250,
			data: function(params) {
				return {
					q: params.term,
					city: $('*[name="city_id"]').val()
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data.areas, function(obj) {
						return {
							id: obj.keyword,
							text: obj.keyword
						};
					})
				}
			},
			cache: true
		}
	});
}

function bindSelect2OnSource(){
	$("*[name=\"source\"]").select2({
		theme: "bootstrap",
		placeholder: "Select Source...",
		maximumSelectionSize: 10,
		containerCssClass: ":all:",
		allowClear:true
	});
}

function bindSelect2OnUser(){ 
	$("*[name=\"search[created_by]\"],*[name=\"created_by\"]").select2({
		theme: "bootstrap",
		placeholder: "Select User",
		maximumSelectionSize: 10,
		containerCssClass: ":all:",
		allowClear:true,
		ajax: {
			url: "/developer/user/search",
			dataType: 'json',
			delay: 250,
			data: function(params) {
				return {
					q: params.term
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data.users, function(obj) {
						return {
							id: obj.id,
							text: obj.first_name+" "+((obj.last_name==null)?"":obj.last_name)
						};
					})
				}
			},
			cache: true
		}
	});
}
	
// ****************
// HELPER FUNCTIONS
	/**
	 * Removing hash from the given url
	 *
	 * @param url
	 * @return url without hash 
	 */
	function removeHashFromURL($url=null){
		if($url==null) return;
		return $url.substr(0,($url.indexOf('#')==(-1))?$url.length:$url.indexOf('#'));
	}
// HELPER FUNCTIONS
// ****************

$(document).ready(function(){
	
	// INCLUDE CSRF TOKEN IN HEADER IN EACH REQUEST
	// ********************************************
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	
	 $(document).on('change','.counsellor-control',function(){
		datatablePendingLeadsDashboard.ajax.reload(null,false);
	});
	 

	$(document).on('change','*[name="state_id"]',function(e){
			 
			e.preventDefault();
			var $this = $(this),
				val = $this.val(); 
		 
			mainSpinner.start();
			$.ajax({
				"url":"/developer/state/get-cityes/"+val,
				"type":"GET",
				"success":function(data,textStatus,jqXHR){
					if(data.statusCode){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-success').removeClass('hide').html(data.data.message);
						var payload = data.data.payload;
						var $html = "";
						if(payload.length>0){
							var $html = "<option value=''>Select City</option>";						 
							for(var i in payload){
								$html += "<option value='"+payload[i].id+"'>"+payload[i].city+"</option>";
							}						 
							$('*[name="cityid"]').html($html);
						}					
					}else{
						mainSpinner.stop();
						alert(data.data.message);				
					}
				},
				"error":function(jqXHR,textStatus,errorThrown){
					mainSpinner.stop();
					alert("Something went wrong !!");
				}
			});
		});
		

	// *************get/city**********
	// DOCUMENT ON CHANGE CITY
		$(document).on('change','*[name="cityid"]',function(e){			 
			e.preventDefault();
			var $this = $(this),
			val = $this.val();		 
			mainSpinner.start();
			$.ajax({
				"url":"/developer/zone/get-zones/"+val,
				"type":"GET",
				"success":function(data,textStatus,jqXHR){
					if(data.statusCode){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-success').removeClass('hide').html(data.data.message);
						var payload = data.data.payload;
						var $html = "";
						if(payload.length>0){
							var $html = "<option value=''>Select Zone</option><option value='Other'>Other</option>";
						 
							for(var i in payload){
								$html += "<option value='"+payload[i].id+"'>"+payload[i].zone+"</option>";
							}						 
							$('*[name="zone_id"]').html($html);
						}					
					}else{
						mainSpinner.stop();
						alert(data.data.message);				
					}
				},
				"error":function(jqXHR,textStatus,errorThrown){
					mainSpinner.stop();
					alert("Something went wrong !!");
				}
			});
		});
		

	// ***********************
	// DOCUMENT ON CHANGE CITY
		$(document).on('change','*[name="assigncity_id"]',function(e){
			 
			e.preventDefault();
			var $this = $(this),
				val = $this.val();
				var kwID = $('#asskwid').val();
				 
			/* if(val==null || val=='' || $.isNumeric(val)){
				$('*[name="assignarea_zone"]').html("");
				return;
			} */
			mainSpinner.start();
			$.ajax({
				"url":"/developer/keyword/assigin-get-zones/"+val+"/"+kwID,
				"type":"GET",
				"success":function(data,textStatus,jqXHR){
					if(data.statusCode){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-success').removeClass('hide').html(data.data.message);
						var payload = data.data.payload;
						if(payload.length>0){
							 
							  $payload = "<option value=''>Select Zone</option>";							 
							$('*[name="assignarea_zone"]').html(payload);
						}					
					}else{
						mainSpinner.stop();
						alert(data.data.message);				
					}
				},
				"error":function(jqXHR,textStatus,errorThrown){
					mainSpinner.stop();
					alert("Something went wrong !!");
				}
			});
		});
		
		
	// DOCUMENT ON CHANGE CITY
	// ***********************
	
	// ***********************
	// DOCUMENT ON CHANGE ZONE
		$(document).on('change','*[name="zone_id"]',function(e){
			e.preventDefault();
			var $this = $(this),
				val = $this.val();
			if(val==null || val==''){
				$('*[name="area_id"]').html("");
				return;
			}			
			if(val == 'Other'){
				$(".show_otherInput").html('<input class="form-control" value="" name="other" style="   margin-top: 20px;">');
			}else{
				 
				$(".show_otherInput").html('');
			}

			mainSpinner.start();
			$.ajax({
				"url":"/developer/area/get-areas/"+val,
				"type":"GET",
				"success":function(data,textStatus,jqXHR){
					if(data.statusCode){
						mainSpinner.stop();
						$('.alert').addClass('hide');
						$('.alert-success').removeClass('hide').html(data.data.message);
						var payload = data.data.payload;
						if(payload.length>0){
							var $html = "<option value=''>Select Area</option>";
							for(var i in payload){
								$html += "<option value='"+payload[i].id+"'>"+payload[i].area+"</option>";
							}
							$('*[name="area_id"]').html($html);
						}					
					}else{
						mainSpinner.stop();
						alert(data.data.message);				
					}
				},
				"error":function(jqXHR,textStatus,errorThrown){
					mainSpinner.stop();
					alert("Something went wrong !!");
				}
			});
		});
	// DOCUMENT ON CHANGE ZONE
	// ***********************
	 

	// ********************
	// PILLS AUTO SELECTION
		/**
		 * Store the currently selected tab's hash value in url
		 */
		$("ul.nav-pills > li > a").on("shown.bs.tab", function(e) {
		  var id = $(e.target).attr("href").substr(1);
		  window.location.hash = id;
		});

		/**
		 * On load/reload of the page: switch to the currently selected tab
		 */
		var hash = window.location.hash;
		$('#client-update-pills a[href="' + hash + '"]').tab('show');	
	// PILLS AUTO SELECTION 
	// ********************
	
	// ***********************
	// ALL CLIENTS DATE PICKER
		$('.fromDate,.toDate').datepicker({dateFormat:"yy-mm-dd"});
		$('.calldt,.calldf').datepicker({dateFormat:"yy-mm-dd"});
		$('.datef,.datet').datepicker({dateFormat:"yy-mm-dd"});
		$('.expdf,.expdt').datepicker({dateFormat:"yy-mm-dd"});
		$('.leaddf,.leaddt').datepicker({dateFormat:"yy-mm-dd"});
	//ALL CLIENTS DATE PICKER
	// ***********************
	
	// **************
	// EXPORT CLIENTS
		/* $('#export-clients').submit(function(e){
			e.preventDefault();
			$(this).find('input[name="search[client_type]"]').val(getParameterByName('search%5Bclient_type%5D'));
			$(this).find('input[name="search[city]"]').val(getParameterByName('search%5Bcity%5D'));
			$(this).find('input[name="search[datef]"]').val(getParameterByName('search%5Bdatef%5D'));
			$(this).find('input[name="search[datet]"]').val(getParameterByName('search%5Bdatet%5D'));
			$(this).find('input[name="search[client_category]"]').val(getParameterByName('search%5Bclient_category%5D'));
			$(this).find('input[name="search[value]"]').val($('input[type="search"]').val());
			return true;
		}); */
	// EXPORT CLIENTS
	// **************

	// ***************
	// SELECT2 ON CITY
	bindSelect2OnCity();
	// SELECT2 ON CITY 
	// ***************
	
	// ********************
	// SELECT2 ON AREA_ZONE 
	bindSelect2OnAreaZone();
	// SELECT2 ON AREA_ZONE 
	// ********************
	
	// ********************
	// SELECT2 ON KW_SEARCH
	bindSelect2OnCourse();
	// SELECT2 ON KW_SEARCH
	// ********************
	
	//**********************
	// HANDLING COURSE FIELD
		// ONCLICK TO SEARCH RESULTS
		// *************************
		$(document).on('click','.ajax-suggest ul>li',function(e){
			e.preventDefault();
			$(this).closest('form').find(".home-search").val($(this).find('a').text());
			//$(".home-search").closest('form').submit();
			var closestForm = $(this).closest('form');
			if(closestForm.hasClass('search-form')){
				closestForm.submit();
			}
			$(this).closest('form').find(".ajax-suggest").hide();
			$(this).closest('form').find(".ajax-suggest ul").html("");
		});
		
		// SEARCHING KEYDOWN
		// *****************
		$(".home-search").on('keydown',function(evt){
			if($(this).closest('form').find('.ajax-suggest ul>li').length>0){
				if($(this).closest('form').find('.ajax-suggest ul li.active').length>0){
					if(evt.keyCode == '38'){
						//alert(38)
						if($(this).closest('form').find('.ajax-suggest ul li.active').is(':first-child')){
							$(this).closest('form').find('.ajax-suggest ul li.active').removeClass('active');
							$(this).closest('form').find('.ajax-suggest ul>li').last().addClass('active');
						}else{
							$(this).closest('form').find('.ajax-suggest ul li.active').removeClass('active').prev().addClass('active');
						}
					}
					if(evt.keyCode == '40'){
						//alert(40)
						if($(this).closest('form').find('.ajax-suggest ul li.active').is(':last-child')){
							$(this).closest('form').find('.ajax-suggest ul li.active').removeClass('active');
							$(this).closest('form').find('.ajax-suggest ul>li').first().addClass('active');
						}else{
							$(this).closest('form').find('.ajax-suggest ul li.active').removeClass('active').next().addClass('active');
						}
					}
				}else{
					$(this).closest('form').find('.ajax-suggest ul>li').first().addClass('active');
				}
			}
		});
		
		// SEARCHING ENGINE
		// ****************
		$(".home-search").on('keyup',function(evt){
			if(evt.keyCode == '38'||evt.keyCode == '40'){
				$(this).val($('.ajax-suggest ul li.active>a').text());
				return;
			}
			var key = $(this).val();
			var yearly_subs_form = $(this).closest('form');
			if(key!=""){
				$(this).closest('form').find(".ajax-suggest").show();
				$(this).closest('form').find(".ajax-suggest ul").html("<li><a href='#'>Loading...</a><li>");
				var $this = $(this);
				var formToSend = $('<form><input name="city" value="'+yearly_subs_form.find(".city").val()+'" /><input name="search_kw" value="'+yearly_subs_form.find(".home-search").val()+'" /></form>');
				$.ajax({
					type: "POST",
					url: '/developer/kw/search',
					data: formToSend.serialize(),
					dataType: 'json',
					success: function(response) {
						if(response.status){
							//alert(JSON.stringify(response.message));
							$this.closest('form').find(".ajax-suggest ul").html(response.message);
						}else{
							//alert(response.message);
							$this.closest('form').find(".ajax-suggest ul").html("<li><a href='#'>Nothing found...</a><li>");	
						}
					}
				});	
			}else{
				$(this).closest('form').find(".ajax-suggest").hide();
				$(this).closest('form').find(".ajax-suggest ul").html("");
			}
		});
	// HANDLING COURSE FIELD
	//**********************

	// ***********************************
	// ASSIGNED ZONE AREAS FORM SUBMISSION
		$(document).on('submit','#assignedZoneAreas',function(e){
			e.preventDefault();
			mainSpinner.start();
			var $this = $(this);
			$.ajax({
				type: "POST",
				url: removeHashFromURL(window.location.href)+"/update-assigned-zone-areas",
				data: $(this).serialize(),
				dataType: 'json',
				success: function(data,textStatus,jqXHR) {
					if(data.statusCode){
						mainSpinner.stop();
						$('#editAssignedZone .alert').addClass('hide');
						$('#editAssignedZone .alert-success').html(data.data.message).removeClass('hide');
						$('#editAssignedZone').animate({ scrollTop: 0 }, 'slow');
					}else{
						mainSpinner.stop();
						$('#editAssignedZone .alert').addClass('hide');
						$('#editAssignedZone .alert-danger').html(data.data.message).removeClass('hide');
						$('#editAssignedZone').animate({ scrollTop: 0 }, 'slow');
					}
				},
				error: function(jqXHR,textStatus,errorThrown){
					mainSpinner.stop();
					alert('Something went wrong. Kindly contact engineer.');
				}
			});
			return false;
		});
	// ASSIGNED ZONE AREAS FORM SUBMISSION
	// ***********************************
	
	// ********************
	// LEAD FORM SUBMISSION
		$('.lead_form').submit(function(e){
			e.preventDefault();
			var $city = $(this).find('.city').val();
			var $name = $(this).find('*[name="name"]').val();
			var $mobile = $(this).find('*[name="mobile"]').val();
			var $kw_text = $(this).find('*[name="kw_text"]').val();
			if($city==''&&$kw_text!=''){
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Kindly, <strong>select the city</strong> in which you are looking for <strong>"+$(this).find('.home-search').val()+"</strong>");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;
			}
			if($name==''||$mobile==''||$kw_text==''){
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("City, Name, Mobile, Course Interested are mandatory. Please fill all the fields.");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;				
			}
			mainSpinner.start();
			var $this = $(this);
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: 'json',
				success: function(response) {
					//$(this).reset();
					if(response.status){
						mainSpinner.stop();
						$this.find('.reset_lead_form').click();
						$this.find('.city').val(null).trigger('change');
						$this.find('*[name="area_zone"]').val(null).trigger('change');
						$('.dealclosebtn').click();
						$('#smsEmailModal').modal('hide');
						$('#msgModal .modal-dialog').removeClass('modal-sm').addClass('modal-md');
						$('#msgModal .modal-body').html("Thanks for submitting your requirement. Respective Institutes will get back to you soon.");
						$('#msgModal').modal({keyboard:false,backdrop:'static'});
						//alert(JSON.stringify(response.msg));
					}else{
						mainSpinner.stop();
						document.write(JSON.stringify(response));
						//alert(response.msg);
					}
				},
				error: function(jqXHR,textStatus,errorThrown){
					mainSpinner.stop();
					var b = 'Some Error Email not send';
					for(var a in jqXHR.responseJSON){
						b+=jqXHR.responseJSON[a][0];
					}
					$('#msgModal .modal-dialog').removeClass('modal-sm').addClass('modal-md');
					$('#msgModal .modal-body').html(b);
					$('#msgModal').modal({keyboard:false,backdrop:'static'});
				}
			});
		});
	// LEAD FORM SUBMISSION
	// ********************
	
	// SELECT ALL CHECKBOX
	// *******************
	$('input[name="payment_mode_accepted[select_all]"]').on('change',function(){
		var k = this.checked?true:false;
		if(k){
			$(this).closest('.form-group').find('input[type="checkbox"]').prop('checked',true);
		}else{
			$(this).closest('.form-group').find('input[type="checkbox"]').prop('checked',false);
		}
	});
	// *******************
	// SELECT ALL CHECKBOX
	
	// PASSWORD EYE
	// ************
	$('.pass-eye').on('mouseenter',function(){
		$('input[name="password"],input[name="password_confirmation"]').attr("type","text");
	});
	$('.pass-eye').on('mouseout',function(){
		$('input[name="password"],input[name="password_confirmation"]').attr("type","password");
	});
	
	// MATCH HEIGHT
	// ************
	$('.match_ht').matchHeight();

	// DATE PICKER INITIALIZATION
	// **************************
	initDatePicker();
	
	//
	// **********************************************
	$(document).on('change','.city',function(e){
		e.preventDefault();
		
		keyword.setProperties('city',$(this).val());
		//alert(keyword.getProperties());
	});
	
	$(document).on('change','.zone',function(e){
		e.preventDefault();
		keyword.setProperties('zone',$(this).val());
		 
	});
	$(document).on('change','.parent',function(e){
		e.preventDefault();
		keyword.setProperties('parent_cat',$(this).val());
		//alert(keyword.getProperties());
	});
	$(document).on('change','.child',function(e){
		e.preventDefault();
		keyword.setProperties('child_cat',$(this).val());
		//alert(keyword.getProperties());
	});
	$(document).on('change','.kw',function(e){
		e.preventDefault();
		keyword.setProperties('kw',$(this).val());
		//alert(keyword.getProperties());
	});
	$(document).on('change','.position',function(e){
		e.preventDefault();
		keyword.setProperties('position',$(this).val());
		//alert(keyword.getProperties());
	});
	$(document).on('submit','#kw_form',function(e){
		e.preventDefault();
		keyword.submitKWForm($(this));
		//alert(keyword.getProperties());
	});
	$(document).on('submit','#update-assigned-keyword',function(e){
		e.preventDefault();
		keyword.updateAssignedKeyword($(this));
		//alert(keyword.getProperties());
	});
	$(document).on('submit','#balance_amt_form',function(e){
		e.preventDefault();
		keyword.submitBalForm($(this));
		//alert(keyword.getProperties());
	});
	$(document).on('submit','#yearly_subs_form',function(e){
		e.preventDefault();
		keyword.submitYearlySubsForm($(this));
		//alert(keyword.getProperties());
	});
	$(document).on('submit','#max_kw_form',function(e){
		e.preventDefault();
		keyword.submitMaxKWForm($(this));
		//alert(keyword.getProperties());
	});
	$(document).on('submit','#count_based_subscription_form',function(e){
		e.preventDefault();
		keyword.submitCountBasedSubsForm($(this));
		//alert(keyword.getProperties());
	});

	$(document).on('change','.client_type',function(e){
		e.preventDefault();
		var $value = $(this).val();
		initDatePicker();
		$.ajax({
			type: "POST",
			url: $('#submitClientType').attr('action'),
			data: $('#submitClientType').serialize(),
			dataType: 'json',
			success: function(response) {
				//alert(JSON.stringify(response.result));
				if(response.status){
					if("general" == $value){
						/* $('#ass_kw_wrapper').hide();
						$('#yearly_subs').hide();
						$('#max_kw').hide(); */
						$('#yearly_subs').hide();
						$('#ass_kw_wrapper').show();
						$('#max_kw').show();
						$('#leads_count').hide();
					}
					else if("lead_based" == $value){
						$('#yearly_subs').hide();
						$('#ass_kw_wrapper').show();
						$('#max_kw').hide();
						$('#leads_count').hide();
					}
					else if("free_subscription" == $value){
						$('#yearly_subs').show();
						$('#ass_kw_wrapper').show();
						$('#max_kw').show();
						$('#leads_count').hide();
					}
					else if("count_based_subscription" == $value){
						$('#yearly_subs').hide();
						$('#ass_kw_wrapper').show();
						$('#max_kw').hide();
						$('#leads_count').show();
					}
					
					else if("Gold" == $value){
						$('#yearly_subs').hide();
						$('#ass_kw_wrapper').show();
						$('#max_kw').hide();
						$('#leads_count').show();
					}
					else if("Diamond" == $value){
						$('#yearly_subs').hide();
						$('#ass_kw_wrapper').show();
						$('#max_kw').hide();
						$('#leads_count').show();
					}
					else if("Platinum" == $value){
						$('#yearly_subs').hide();
						$('#ass_kw_wrapper').show();
						$('#max_kw').hide();
						$('#leads_count').show();
					}
					else{
						$('#yearly_subs').hide();
						$('#ass_kw_wrapper').show();
						$('#max_kw').hide();
						$('#leads_count').show();
					}
					alert(response.message);
				}else{
					alert(response.message);
				}
				//dataTableExample.row.add([response.result['id'],]).draw(false);
			},
			error: function(response) {
				alert("An error occured");
			}
		});
		/* if($(this).val() == 'general'){
			$('#ass_kw_wrapper').hide();
		}else{
			$('#ass_kw_wrapper').show();
		} */
	});

	 
	
	$(document).on('change','.assign_client',function(e){
		e.preventDefault();
		var $value = $(this).val();
	 
		$.ajax({
			type: "POST",		 
			url:"/developer/clients/assignClientToEmployee/"+$value,
			data: $('#submitAssignClient').serialize(),
			dataType: 'json',
			success: function(response) {
				 
				if(response.status){ 
					alert(response.message);
				}else{
					alert(response.message);
				}
				 
			},
			error: function(response) {
				alert("An error occured");
			}
		});
		 
	});
	
	
	$(document).on('change','.conversion_status',function(e){
		e.preventDefault();
		var $value = $('#client_id').val();		  
		$.ajax({
			type: "POST",
			 
			url:"/developer/clients/clientConversionStatus/"+$value,
			data: $('#submitConversionClient').serialize(),
			dataType: 'json',
			success: function(response) {
				 
				if(response.status){ 
					$('#messagemodel .modal-title').text("update");	
						$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messagemodel').modal({keyboard:false,backdrop:'static'});
						$('#messagemodel').css({'width':'100%'});
				}else{
					$('#messagemodel .modal-title').text("Status successfully update");	
					$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
					$('#messagemodel').modal({keyboard:false,backdrop:'static'});
					$('#messagemodel').css({'width':'100%'});
				}
				 
			},
			error: function(response) {
				$('#messagemodel .modal-title').text("Status successfully update");	
					$('#messagemodel .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");		
					$('#messagemodel').modal({keyboard:false,backdrop:'static'});
					$('#messagemodel').css({'width':'100%'});
			}
		});
		 
	});
	
	$(document).on('change','.active_status',function(e){
		e.preventDefault();
		var $value = $(this).val();
		mainSpinner.start();
		$.ajax({
			type: "POST",
			url: $('#submitActiveStatus').attr('action'),
			data: $('#submitActiveStatus').serialize(),
			dataType: 'json',
			success: function(data,textStatus,jqXHR) {
				//alert(JSON.stringify(response.result));
				if(data.status){
					alert(data.message);
				}else{
					alert(data.message);
				}
				mainSpinner.stop();
			},
			error: function(jqXHR,textStatus,errorThrown) {
				alert("An error occured");
				mainSpinner.stop();
			}
		});
	});
	$(document).on('change','.certified_status',function(e){
		e.preventDefault();
		var $value = $(this).val();
		mainSpinner.start();
		$.ajax({
			type: "POST",
			url: $('#submitCertifiedStatus').attr('action'),
			data: $('#submitCertifiedStatus').serialize(),
			dataType: 'json',
			success: function(data,textStatus,jqXHR) {
				//alert(JSON.stringify(response.result));
				if(data.status){
					alert(data.message);
				}else{
					alert(data.message);
				}
				mainSpinner.stop();
			},
			error: function(jqXHR,textStatus,errorThrown) {
				alert("An error occured");
				mainSpinner.stop();
			}
		});
	});

	
	$(document).on('change','.trusted_status',function(e){
		e.preventDefault();
		var $value = $(this).val();
		mainSpinner.start();
		$.ajax({
			type: "POST",
			url: $('#submitTrustedStatus').attr('action'),
			data: $('#submitTrustedStatus').serialize(),
			dataType: 'json',
			success: function(data,textStatus,jqXHR) {
				//alert(JSON.stringify(response.result));
				if(data.status){
					alert(data.message);
				}else{
					alert(data.message);
				}
				mainSpinner.stop();
			},
			error: function(jqXHR,textStatus,errorThrown) {
				alert("An error occured");
				mainSpinner.stop();
			}
		});
	});

	
	$(document).on('change','.gst_status',function(e){
		e.preventDefault();
		var $value = $(this).val();
		mainSpinner.start();
		$.ajax({
			type: "POST",
			url: $('#submitGSTtatus').attr('action'),
			data: $('#submitGSTtatus').serialize(),
			dataType: 'json',
			success: function(data,textStatus,jqXHR) {
				//alert(JSON.stringify(response.result));
				if(data.status){
					alert(data.message);
				}else{
					alert(data.message);
				}
				mainSpinner.stop();
			},
			error: function(jqXHR,textStatus,errorThrown) {
				alert("An error occured");
				mainSpinner.stop();
			}
		});
	});


	// **************************************************************************************
	// DISABLING EXPECTED DATE AND TIME WHEN SELECTED STATUS IS "NOT INTERESTED OR LOC ISSUE"
		$(document).on('change','*[name="status"]',function(e){
			var $this = $(this);
			if($this.find("option:selected").text()=="Joined"){
				$('.joindLead').show();
			}else{				
				$('.joindLead').hide();
				
			}
			//if($this.find("option:selected").text()=="Not Interested"||$this.find("option:selected").text()=="Location Issue"){
				
				
			if(!$this.find("option:selected").data('value')){
				$('*[name="expected_date_time"]').prop({'disabled':true}).val('');
			}else{
				$('*[name="expected_date_time"]').prop({'disabled':false});
			}
		});
	// DISABLING EXPECTED DATE AND TIME WHEN SELECTED STATUS IS "NOT INTERESTED OR LOC ISSUE"
	// **************************************************************************************
	
	$(document).on('change','.paid_status',function(e){
		e.preventDefault();
		var $value = $(this).val();
		mainSpinner.start();
		$.ajax({
			type: "POST",
			url: $('#submitPaidStatus').attr('action'),
			data: $('#submitPaidStatus').serialize(),
			dataType: 'json',
			success: function(data,textStatus,jqXHR) {
				//alert(JSON.stringify(response.result));
				if(data.status){
					alert(data.message);
				}else{
					alert(data.message);
				}
				mainSpinner.stop();
			},
			error: function(jqXHR,textStatus,errorThrown) {
				alert("An error occured");
				mainSpinner.stop();
			}
		});
	});
	
	$(document).on('change','.package_status',function(e){
		e.preventDefault();
		var $value = $(this).val();
		mainSpinner.start();
		initDateInvoiceclient();
		$.ajax({
			type: "POST",
			url: $('#submitPackageStatus').attr('action'),
			data: $('#submitPackageStatus').serialize(),
			dataType: 'json',
			success: function(data,textStatus,jqXHR) {
				//alert(JSON.stringify(response.result));
				if(data.status){					 
					alert(data.message);
					window.location.reload();
					//window.location=document.location.href;     
				}else{
					alert(data.message);
				}
				mainSpinner.stop();
			},
			error: function(jqXHR,textStatus,errorThrown) {
				alert("An error occured");
				mainSpinner.stop();
			}
		});
	});
	
	// MANAGING PRICING FIELDS BASED ON KEYWORD CATEGORY
	// *************************************************
	$('select.category').val("Category 1").trigger("change");
	$('.premium_price,.platinum_price,.royal_price,.king_price,.preferred_price').hide();
	$(document).on('change','.category',function(e){
		e.preventDefault();
		var $this = $(this);
		if($this.val()=='Category 1'||$this.val()=='Category 2'||$this.val()=='Category 3'){
			$('.premium_price,.platinum_price,.royal_price,.king_price,.preferred_price').hide();
		}
		if($this.val()=='Category X'){
			$('.premium_price,.platinum_price,.royal_price,.king_price,.preferred_price').show();
		}
	});
	
	// REMOVING EVENTS WHEN CLOSING "DELETE CLIENT MODAL"
	// **************************************************
	/* $('#deleteClient').on('hide.bs.modal',function(){
		$('#confirmDeleteClient,#confirmHardDelete,#notConfirmHardDelete').off();
	}); */
	
	// ACTION TOOK PLACE WHEN CLICK ON '.REMOVE-THUMBNAIL'
	// ***************************************************
	$(document).on('click','.remove-thumbnail',function(e){
		e.preventDefault();
		var srno = $(this).data('srno'); 
		var target = $('#'+srno); 
		//alert($(this).data('srno'));
		target.prepend("<input type=\"file\" class=\"form-control\" name=\""+srno+"\">");
		target.find('.img-help').remove();
	});	

// ACTION TOOK PLACE WHEN CLICK ON '.remove-blog-image'
	// ***************************************************
	$(document).on('click','.remove-blog-image',function(e){
		e.preventDefault();
		var srno = $(this).data('srno'); 
	//	var target = $(srno); 
//alert(target);
		 
		srno.prepend("<input type=\"file\" class=\"form-control\" name=\""+srno+"\">");
		srno.find('.blog-block').remove();
	});
	
	$(document).on('change','#parent_category_id',function(){
		//alert($(this).val());
		var $this = $(this),
			id    = $this.val(),
			html  = '<option value="">Select Category</option>';
		if(id!=''){
			$.get(
				"/developer/keyword/getChildCategories/"+id,
				function(response,status){
					if(response.status){
						var child_categories = response.child_category;
						//alert(JSON.stringify(child_categories));
						for(var a in child_categories){
							html += '<option value="'+child_categories[a].id+'">'+child_categories[a].child_category+'</option>';
						}
						//$('#child_category_id').html(html).trigger('change');
						$('#child_category_id').html(html);
					}
				}
			);
		}		
	});
	
	$(document).on('change','#update_parent_category_id',function(e){
		//alert($(this).val());
		var $this = $(this),
			id    = $this.val(),
			html  = '';
		if(id!=''){
			$.get(
				"/developer/keyword/getChildCategories/"+id,
				function(response,status){
					if(response.status){
						var child_categories = response.child_category;
						//alert(JSON.stringify(child_categories));
						for(var a in child_categories){
							html += '<option value="'+child_categories[a].id+'">'+child_categories[a].child_category+'</option>';
						}
						$('#update_child_category_id').html(html).trigger('change');
						if(childIdHolder.getChildCategoryID() == null || typeof childIdHolder.getChildCategoryID() == "undefined"){}
						else{
							$('#update_child_category_id').val(childIdHolder.getChildCategoryID()).trigger('change');
							childIdHolder.setChildCategoryID(null);
						}
					}
				}
			);
		}		
	});
	
	$(document).on('change','#child_category_id',function(){
		var $this = $(this),
			id    = $this.val(),
			html  = '';
		if(id!=''){
			$.get(
				"/developer/business_keyword/getKeywords/"+id,
				function(response,status){
					if(response.status){
						var keywords = response.keywords;
						//alert(JSON.stringify(child_categories));
						for(var a in keywords){
							html += '<option value="'+keywords[a].id+'">'+keywords[a].keyword+'</option>';
						}
						//$('#child_category_id').html(html).trigger('change');
						$('#keyword_id').html(html);
					}
				}
			);
		}		
	});
	
	// HANDLING HOURS OF OPERATION TIME VALIDATION
	// *******************************************
	$(document).on('change','.time-from',function(){
		var $this = $(this);
		var id = $this.attr('id');
		var corr_id = id.replace("[from]", "[to]");
		if($this.val()==''){
			$this.data('time','');
			$('select[id="'+corr_id+'"]').val('');
			$('select[id="'+corr_id+'"]').data('time','');
		}
		else if($this.val()=='24:00'){
			$this.data('time','24:00');
			$('select[id="'+corr_id+'"]').val('24:00');
			$('select[id="'+corr_id+'"]').data('time','24:00');
		}
		else{
			if($this.find('option:selected').data('time_in_min') > $('select[id="'+corr_id+'"]').find('option:selected').data('time_in_min')){
				alert('Open time cannot be greater then close time');
				$this.val($this.data('time'));
			}else{
				$this.data($this.val());
			}
		}
	});
	$(document).on('change','.time-to',function(){
		var $this = $(this);
		var id = $this.attr('id');
		var corr_id = id.replace("[to]", "[from]");
		if($this.val()==''){
			$this.data('time','');
			$('select[id="'+corr_id+'"]').val('');
			$('select[id="'+corr_id+'"]').data('time','');
		}
		else if($this.val()=='24:00'){
			$this.data('time','24:00');
			$('select[id="'+corr_id+'"]').val('24:00');
			$('select[id="'+corr_id+'"]').data('time','24:00');
		}
		else{
			if($this.find('option:selected').data('time_in_min') < $('select[id="'+corr_id+'"]').find('option:selected').data('time_in_min')){
				alert('Open time cannot be greater then close time');
				$this.val($this.data('time'));
			}else{
				$this.data($this.val());
			}
		}
	});
	
 
		 
  $(document).on('click','#paymentPrint',function(e){
	  
		var THIS = $(this);

		var id   = THIS.data('sid'); 
			$.ajax({
			url:"/developer/clients/getpaymentPrint",
			type:"POST",			
			data:{action:'getPaymentPrint',pid:id},
			 
			success: function(response) {        		
				var printWindow = window.open('', '', 'width=700,height=500');
				printWindow.document.write(response);
				return false;

			}

			});	 

	}); 
	$(document).on('click','#invoicePrintPdf',function(e){
	  
		var THIS = $(this);

		var id   = THIS.data('sid'); 
			$.ajax({
			url:"/developer/clients/getinvoicePrintPdf",
			type:"POST",			
			data:{action:'getinvoicePrintPdf',pid:id},
			 
			success: function(response) {        		
				var printWindow = window.open('', '', 'width=700,height=500');
				printWindow.document.write(response);
				return false;

			}

			});	 

	}); 
	$(document).on('click','#proformaPrintPdf',function(e){
	  
		var THIS = $(this);

		var id   = THIS.data('sid'); 
			$.ajax({
			url:"/developer/clients/getproformaPrintPdf",
			type:"POST",			
			data:{action:'getproformaPrintPdf',pid:id},
			 
			success: function(response) {        		
				var printWindow = window.open('', '', 'width=700,height=500');
				printWindow.document.write(response);
				return false;

			}

			});	 

	}); 
		
	$(document).on('change','*[name="role"]',function(){
			var val = $(this).val();
			if(val=='')
				return;
			 
			mainSpinner.start();
			$.ajax({
				url:'/developer/role-permission/'+val,
				type:"GET",
				dataType:'json',
				success:function(data,textStatus,jqXHR){
					if(data.status){
						$('#capabilities').html(data.html);
						$('#capabilities').trigger('chosen:updated');
					}
					mainSpinner.stop();
				},
				error:function(jqXHR, textStatus, errorThrown){}
			});
		});
		
		//Handling Payment related fields

	if("cash" == jQuery('#stud-payment_mode option:selected').val()){ 
		jQuery('#stud-payment_bank, #stud-card_no, #stud-paytm, #stud-neft,#stud-chq_no').closest('.form-group').hide();
		jQuery('.hide-mode').hide();
		jQuery('.cheque').hide();
	}
	if("cheque" == jQuery('#stud-payment_mode option:selected').val()){
		jQuery('#stud-payment_bank, #stud-card_no, #stud-paytm, #stud-neft').closest('.form-group').hide();
		jQuery('.hide-mode').hide();
	}
 
	var mode = jQuery('#stud-payment_mode option:selected').val();	
	
	switch(mode){
		case 'cash':
		jQuery('#stud-payment_bank, #stud-card_no, #stud-paytm, #stud-neft,#stud-chq_no').closest('.form-group').hide();
		jQuery('.hide-mode').hide();
		jQuery('.cheque').hide();
		break;
		case 'all':
		case 'online':
		case 'cheque':
			//jQuery('#stud-payment_bank, #stud-card_no, #stud-paytm, #stud-neft').closest('.form-group').hide();
			jQuery('#stud-chq_no').closest('.form-group').show(function(){
				jQuery('#stud-payment_bank, #stud-card_no, #stud-paytm,#stud-neft').closest('.form-group').hide();
				jQuery('.cheque').show();
			});
			break;
		case 'bank':
			jQuery('#stud-bank').closest('.form-group').show(function(){
				jQuery('#stud-chq_no, #stud-paytm, #stud-neft,#stud-neft,#stud-website,#stud-edc,#stud-paytmqr,#stud-googlepay,#stud-cheque').closest('.form-group').hide();
			});
			break;
		case 'paytm':
			jQuery('#stud-paytm').closest('.form-group').show(function(){
				jQuery('#stud-payment_bank, #stud-chq_no, #stud-card_no, #stud-neft,#stud-website,#stud-edc,#stud-paytmqr,#stud-googlepay,#stud-cheque,#stud-bank').closest('.form-group').hide();
			});
			break;
		case 'neft':
			jQuery('#stud-neft').closest('.form-group').show(function(){
				jQuery('#stud-payment_bank, #stud-chq_no, #stud-card_no, #stud-paytm,#stud-website,#stud-edc,#stud-paytmqr,#stud-googlepay,#stud-cheque,#stud-bank').closest('.form-group').hide();
			});
			break;
	}
	
	jQuery('#stud-payment_mode').change(function(){
		
		
		if("cash" == jQuery(this).val()){
			jQuery('.hide-mode').hide();
		}else{
			var mode = jQuery(this).val();

			jQuery('.hide-mode').hide(function(){
				jQuery('.'+mode).show();
			});			
		}
	});
		
		
		
	
	
	
	/*  assigin all keyword */
	$('#btnRight').click(function (e) {
		  $('select').moveToListAndDelete('#source', '#destination');
		  e.preventDefault();
		});
		$('#btnAllRight').click(function (e) {
			 
		  $('select').moveAllToListAndDelete('#source', '#destination');
		  e.preventDefault();
		});
		$('#btnLeft').click(function (e) {
		  $('select').moveToListAndDelete('#destination', '#source');
		  e.preventDefault();
		});
		$('#btnAllLeft').click(function (e) {
		  $('select').moveAllToListAndDelete('#destination', '#source');
		  e.preventDefault();
		});
		
		$('#kw_form').submit(function(){
			$('#destination option').prop('selected',true);
			return true;
		}); 
		$('#demo-form2').submit(function(){
			$('#destination option').prop('selected',true);
			return true;
		}); 
		
		 $.fn.moveToList = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option:selected');
        if (opts.length == 0) {
            alert("Nothing to move");
        }

        $(destinationList).append($(opts).clone());
    };

    //Moves all items from sourceList to destinationList
    $.fn.moveAllToList = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option');
        if (opts.length == 0) {
            alert("Nothing to move");
        }

        $(destinationList).append($(opts).clone());
    };

    //Moves selected item(s) from sourceList to destinationList and deleting the
    // selected item(s) from the source list
    $.fn.moveToListAndDelete = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option:selected');
        if (opts.length == 0) {
            alert("Nothing to move");
        }

        $(opts).remove();
        $(destinationList).append($(opts).clone());
    };

    //Moves all items from sourceList to destinationList and deleting
    // all items from the source list
    $.fn.moveAllToListAndDelete = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option');
        if (opts.length == 0) {
            alert("Nothing to move");
        }

        $(opts).remove();
        $(destinationList).append($(opts).clone());
    };

    //Removes selected item(s) from list
    $.fn.removeSelected = function (list) {
        var opts = $(list + ' option:selected');
        if (opts.length == 0) {
            alert("Nothing to remove");
        }

        $(opts).remove();
    };

    //Moves selected item(s) up or down in a list
    $.fn.moveUpDown = function (list, btnUp, btnDown) {
        var opts = $(list + ' option:selected');
        if (opts.length == 0) {
            alert("Nothing to move");
        }

        if (btnUp) {
            opts.first().prev().before(opts);
        } else if (btnDown) {
            opts.last().next().after(opts);
        }
    };
	
		$('.select2_single').select2({
					theme: "bootstrap",
					placeholder: "Select",
					maximumSelectionSize: 6,
					containerCssClass: ':all:'
				});
				
				

		
		
		
});

	
	// ************************
// REMOVE VALIDATION ERRORS
	function removeValidationErrors($this){
		$this.find('.form-group').removeClass('has-error');
		$this.find('.help-block').remove();
	}
// REMOVE VALIDATION ERRORS
// **********************
		
	function showValidationErrors($this,errors){		 
		$this.find('.form-group').removeClass('has-error');
		$this.find('.help-block').remove();
		for (var key in errors) {
			if(errors.hasOwnProperty(key)){
				var el = $this.find('*[name="'+key+'"]');			 
				$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
				el.closest('.form-group').addClass('has-error');
			}
		}
	}
		
	function isNumericKeyCheck(e){
		var keyCode = e.keyCode || e.charCode;
		if(keyCode>=48&&keyCode<=57)
		return true;
		else
		return false;
		}