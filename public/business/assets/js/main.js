
$.ajaxSetup({	headers: {	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')	}	});
  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Sidebar toggle
   */
  if (select('.toggle-sidebar-btn')) {
    on('click', '.toggle-sidebar-btn', function(e) {
      select('body').classList.toggle('toggle-sidebar')
    })
  }

  /**
   * Search bar toggle
   */
  if (select('.search-bar-toggle')) {
    on('click', '.search-bar-toggle', function(e) {
      select('.search-bar').classList.toggle('search-bar-show')
    })
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Initiate tooltips
   */
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  /**
   * Initiate quill editors
   */
  if (select('.quill-editor-default')) {
    new Quill('.quill-editor-default', {
      theme: 'snow'
    });
  }

  if (select('.quill-editor-bubble')) {
    new Quill('.quill-editor-bubble', {
      theme: 'bubble'
    });
  }

  if (select('.quill-editor-full')) {
    new Quill(".quill-editor-full", {
      modules: {
        toolbar: [
          [{
            font: []
          }, {
            size: []
          }],
          ["bold", "italic", "underline", "strike"],
          [{
              color: []
            },
            {
              background: []
            }
          ],
          [{
              script: "super"
            },
            {
              script: "sub"
            }
          ],
          [{
              list: "ordered"
            },
            {
              list: "bullet"
            },
            {
              indent: "-1"
            },
            {
              indent: "+1"
            }
          ],
          ["direction", {
            align: []
          }],
          ["link", "image", "video"],
          ["clean"]
        ]
      },
      theme: "snow"
    });
  }
 
  /**
   * Initiate TinyMCE Editor
   */
  const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

   
   
    
jQuery(document).on('click', '#razor-pay-now', function (e) {   
 
    var total = (jQuery('form#razorpay-frm-payment').find('input#gst_total_amount').val() * 100);
    var merchant_order_id = jQuery('form#razorpay-frm-payment').find('input#merchant_order_id').val();
    var merchant_surl_id = jQuery('form#razorpay-frm-payment').find('input#surl').val();
    var merchant_furl_id = jQuery('form#razorpay-frm-payment').find('input#furl').val();
 
    var card_holder_name_id = jQuery('form#razorpay-frm-payment').find('input#billing-name').val();
    var merchant_total = total;
    var paid_amount = jQuery('form#razorpay-frm-payment').find('input#paid_amount').val();
    var merchant_amount = jQuery('form#razorpay-frm-payment').find('input#gst_total_amount').val();
    var gst_tax = jQuery('form#razorpay-frm-payment').find('input#gst_tax').val();

    var currency_code_id = jQuery('form#razorpay-frm-payment').find('input#currency').val();
      var key_id = jQuery('form#razorpay-frm-payment').find('input#RAZOR_KEY_ID').val();
    var store_name = 'Quick Dials Pvt Ltd';
    var store_description = 'Package Pay';
    var store_logo = 'https://www.quickdials.com/client/images/small-logo.jpg';
    var email = jQuery('form#razorpay-frm-payment').find('input#billing-email').val();
    var phone = jQuery('form#razorpay-frm-payment').find('input#billing-phone').val();
    var coins = jQuery('form#razorpay-frm-payment').find('input#coins').val();
    var client_id = jQuery('form#razorpay-frm-payment').find('input#client_id').val();
    var username = jQuery('form#razorpay-frm-payment').find('input#username').val();
    var billing_country = jQuery('form#razorpay-frm-payment').find('input#billing_country').val();
    var billing_state = jQuery('form#razorpay-frm-payment').find('input#billing_state').val();
    var city = jQuery('form#razorpay-frm-payment').find('input#city').val();    
    jQuery('.text-danger').remove();
    if(card_holder_name_id=="") {
      jQuery('input#billing-name').after('<small class="text-danger">Please enter full mame.</small>');
      return false;
    }
    if(email=="") {
      jQuery('input#billing-email').after('<small class="text-danger">Please enter valid email.</small>');
      return false;
    }
    if(phone=="") {
      jQuery('input#billing-phone').after('<small class="text-danger">Please enter valid phone.</small>');
      return false;
    }
    var razorpay_options = {
        key: key_id,
        amount: merchant_total,
        name: store_name,
        description: store_description,
        image: store_logo,
        netbanking: true,
        currency: currency_code_id,
        prefill: {
            name: card_holder_name_id,
            email: email,
            contact: phone
        },
        notes: {
            soolegal_order_id: merchant_order_id,
        },
        handler: function (transaction) {
            jQuery.ajax({
                url:'/business/razorPayCheckout',
                type: 'post',
                data: {razorpay_payment_id: transaction.razorpay_payment_id, merchant_order_id: merchant_order_id, merchant_surl_id: merchant_surl_id, merchant_furl_id: merchant_furl_id, card_holder_name_id: card_holder_name_id, merchant_total: merchant_total, merchant_amount: merchant_amount, currency_code_id: currency_code_id,pay:store_name,email:email,phone:phone,billing_country:billing_country,billing_state:billing_state,city:city,coins:coins,client_id:client_id,username:username,gst_tax:gst_tax,paid_amount:paid_amount}, 
                dataType: 'json',
                success: function (res) {		
				 
			 		var obj =  jQuery.parseJSON(res.data);				                
                   window.location = res.redirectURL+'?getpay='+obj.getpay+'&card_holder_name='+obj.card_holder_name+'&merchant_amount='+obj.merchant_amount+'&order_id='+obj.order_id+'&currency_code_id='+obj.currency_code+'&pay_to='+obj.pay_to+'&coins='+obj.coins+'&email='+obj.email+'&phone='+obj.phone+'&payment_id='+obj.razorpay_payment_id+'&billing_country='+obj.billing_country+'&billing_state='+obj.billing_state+'&city='+obj.city;
                }
            });
        },
        "modal": {
            "ondismiss": function () {
                
            }
        }
    };
    // obj        
    var objrzpv1 = new Razorpay(razorpay_options);
    objrzpv1.open();
        e.preventDefault();
});

  /**
   * Initiate Bootstrap validation check
   */
  var needsValidation = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(needsValidation)
    .forEach(function(form) {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })

  /**
   * Initiate Datatables
   */ 
   
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
		
		
		$(document).on('submit','.location_info',function(e){
		e.preventDefault();	
		$.ajax({
			type: "POST",
			url: '/business/saveLocationInformation',
			data: $('.location_info').serialize(),
			dataType: 'json',
			success: function(response) {	
			   
				if(response.status){					 
		 	    $("#messaged").modal("show");
                $('.imgclass').html('<img src="/public/images/success.png" style="width:100%;text-align: center;margin: auto;display: block;">');	
                $('.successhtml').html("<p class='text-center' style='font-weight: 600;'>" +response.result+"</p>");
				}else{
					  $("#messaged").modal("show");
			      $('.imgclass').html('<img src="/public/images/failed.png" style="width: 35%;text-align: center;margin: auto;display: block;">');	
                $('.failedhtml').html("<p class='text-center' style='font-weight: 600;'>" +response.result+"</p>");
				}
				
			},
			error:function(jqXHR, textStatus, errorThrown){
				var response = JSON.parse(jqXHR.responseText);	
				if(response.status){						 
				var errors = response.errors;						 
				$('.location_info').find('.form-group').removeClass('has-error');
				$('.location_info').find('.help-block').remove();
				for (var key in errors) {
				if(errors.hasOwnProperty(key)){	

				var el = $('.location_info').find('*[name="'+key+'"]');
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
	});
   
   	$(document).on('submit','.profileSave',function(e){
   	    
		e.preventDefault();	
		$.ajax({
			url: '/business/saveProfile',
			type: "POST",
			dataType: 'json',
			data: $('.profileSave').serialize(),
     
			success: function(response) {				
				if(response.status){					 
				// $('.profile_success').text(response.result);
                $("#messaged").modal("show");
                $('.imgclass').html('<img src="/public/images/success.png" style="width:100%;text-align: center;margin: auto;display: block;">');	
                $('.successhtml').html("<p class='text-center' style='font-weight: 600;'>" +response.result+"</p>");
               // $('#messagemodel').modal({backdrop:"static",keyboard:false});
                
				// removeValidationErrors($this);
				}else{
			     $("#messaged").modal("show");
			      $('.imgclass').html('<img src="/public/images/failed.png" style="width: 35%;text-align: center;margin: auto;display: block;">');	
                $('.failedhtml').html("<p class='text-center' style='font-weight: 600;'>" +response.result+"</p>");
				}
				
			},
			error:function(jqXHR, textStatus, errorThrown){
				var response = JSON.parse(jqXHR.responseText);	
				if(response.status){						 
				var errors = response.errors;						 
				$('.profileSave').find('.form-group').removeClass('has-error');
				$('.profileSave').find('.help-block').remove();
				for (var key in errors) {
				if(errors.hasOwnProperty(key)){	

				var el = $('.profileSave').find('*[name="'+key+'"]');
				$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
				el.closest('.form-group').addClass('has-error');
				}
				}
				//alert($this,response.errors);
				//showValidationErrors($this,response.errors);
				}else{
				alert('Something went wrong');
				}
			 
			}
		});
	});
   
		$('input[name="scrapLead"]').on('click', function() {
		const checkedValue = $('input[name="scrapLead"]:checked').val();
		if (checkedValue) {
         const clientId  = $(this).attr("data-clientId");	 			
         const leadId  = $(this).attr("data-leadId");	 	
		 console.log('clientId',clientId);
		 console.log('leadId',leadId);
		console.log(`Checked radio button: ${checkedValue}`);
	 
		$.ajax({
			type: "POST",
		 	url:"/business/scrapLead",
			data: {clientId: clientId,leadId:leadId,scrapValue:checkedValue},
			dataType: 'json',
			success: function(response) {				
				if(response.status){					 

				$("#basicModal_"+leadId).modal("hide");                        							 
				$("#messaged").modal("show");                        							 
				$('#messaged .modal-title').text("Scrap Lead");	
				$('#messaged .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
				$('#messaged').modal({keyboard:false,backdrop:'static'});
				$('#messaged').css({'width':'100%'});					

				setInterval(function() {
				$("#messaged").modal("hide");
				}, 3000);	
			}else{
				$("#messaged").modal("show");                        							 
				$('#messaged .modal-title').text("Scrap Lead");	
				$('#messaged .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");			
				$('#messaged').modal({keyboard:false,backdrop:'static'});
				$('#messaged').css({'width':'100%'});					


			}
			},
			error: function(response) {			 
			}
		});	

		} else {
		console.log('No radio button is checked');
		}
		});


  var businessController = (function(){
		return {
			checked_Ids:[],	
			editProfileInfo:function(THIS,id){			     
			var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/business/saveProfileInfo/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					  	
						if(data.status){
                           	$("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Profile Information");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});					
					 
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);	
						}else{
                               	$('#messaged .modal-title').text("Profile Information");	
						$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});	 	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
							var response = JSON.parse(jqXHR.responseText);	
							if(response.status){						 
							var errors = response.errors;						 
							$('.profile_info').find('.form-group').removeClass('has-error');
							$('.profile_info').find('.help-block').remove();
							for (var key in errors) {
							if(errors.hasOwnProperty(key)){	

							var el = $('.profile_info').find('*[name="'+key+'"]');
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}				 
							}else{
							alert('Something went wrong');
							}
			 
					}
				}); 
				 return false;	
			},
			editSaveSocials:function(THIS,id){			     
			var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/business/editSaveSocials/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					  	
						if(data.status){
                           	$("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Profile Information");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});					
					 
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);	
						}else{
                               	$('#messaged .modal-title').text("Profile Information");	
						$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});	 	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
							var response = JSON.parse(jqXHR.responseText);	
							if(response.status){						 
							var errors = response.errors;						 
							$('.profile_info').find('.form-group').removeClass('has-error');
							$('.profile_info').find('.help-block').remove();
							for (var key in errors) {
							if(errors.hasOwnProperty(key)){	

							var el = $('.profile_info').find('*[name="'+key+'"]');
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}				 
							}else{
							alert('Something went wrong');
							}
			 
					}
				}); 
				 return false;	
			},
			editSaveCertificate:function(THIS,id){			     
			var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/business/editSaveCertificate/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					  	
						if(data.status){
                           	$("#messaged").modal("show");                        							 
							$('#messaged .modal-title').text("Certificate");	
							$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});					
					 
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 2000);	
						}else{
							$('#messaged .modal-title').text("Certificate");	
							$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});	 	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
							var response = JSON.parse(jqXHR.responseText);	
							if(response.status){						 
							var errors = response.errors;						 
							$('.certificate_info').find('.form-group').removeClass('has-error');
							$('.certificate_info').find('.help-block').remove();
							for (var key in errors) {
							if(errors.hasOwnProperty(key)){	

							var el = $('.certificate_info').find('*[name="'+key+'"]');
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}				 
							}else{
							alert('Something went wrong');
							}
			 
					}
				}); 
				 return false;	
			},
			editSaveAward:function(THIS,id){			     
			var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/business/editSaveAward/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					  	
						if(data.status){
                           	$("#messaged").modal("show");                        							 
							$('#messaged .modal-title').text("Award");	
							$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});					
					 
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 2000);	
						}else{
							$('#messaged .modal-title').text("Award");	
							$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});	 	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
							var response = JSON.parse(jqXHR.responseText);	
							if(response.status){						 
							var errors = response.errors;						 
							$('.certificate_info').find('.form-group').removeClass('has-error');
							$('.certificate_info').find('.help-block').remove();
							for (var key in errors) {
							if(errors.hasOwnProperty(key)){	

							var el = $('.certificate_info').find('*[name="'+key+'"]');
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}				 
							}else{
							alert('Something went wrong');
							}
			 
					}
				}); 
				 return false;	
			},
			saveBusinessLocation:function(THIS,id){			     
			var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/business/saveBusinessLocation/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					  	
						if(data.status){
                        
						$("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Business Location");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});					
						dataTableAssignedZones.ajax.reload( null, false );  
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);	 
							 
						}else{
							$("#messaged").modal("show");                        							 
							$('#messaged .modal-title').text("Business Location");	
							$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});
								
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
							var response = JSON.parse(jqXHR.responseText);	
							if(response.status){						 
							var errors = response.errors;						 
							$('.buss_location').find('.form-group').removeClass('has-error');
							$('.buss_location').find('.help-block').remove();
							for (var key in errors) {
							if(errors.hasOwnProperty(key)){	
							var el = $('.buss_location').find('*[name="'+key+'"]');
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}				 
							}else{
							alert('Something went wrong');
							}
			 
					}
				}); 
				 return false;	
			},
			
			saveKeywordAssign:function(THIS,id){			     
			var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/business/saveKeywordAssign/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					  	
					if(data.status){
                        $("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Keyword Assign");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});					
						dataTableViewAllkeywords.ajax.reload( null, false );  
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);	 
							 
					}else{
							$("#messaged").modal("show");                        							 
							$('#messaged .modal-title').text("Keyword Assign");	
							$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});								
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
							var response = JSON.parse(jqXHR.responseText);	
							if(response.status){						 
							var errors = response.errors;						 
							$('.keyword_form').find('.form-group').removeClass('has-error');
							$('.keyword_form').find('.help-block').remove();
							for (var key in errors) {
							if(errors.hasOwnProperty(key)){	

							var el = $('.keyword_form').find('*[name="'+key+'"]');
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}				 
							}else{
							alert('Something went wrong');
							}
			 
					}
				}); 
				 return false;	
			},


			assignZoneDelete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/business/assignZone/delete/"+id,
					type:"GET",				 
					success:function(response){	
					 
					if(response.status){
						$("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Assign Zone Delete");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});					
						dataTableAssignedZones.ajax.reload( null, false );  
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);
					}else{
						$("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Assign Zone Delete");	
						$('#messaged .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});	
					}						
					},
					error:function(response){
					    ;			
						 alert('some error');
					}
				});
				}
			},
			
			
			assignKeywordDelete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/business/assignKeyword/delete/"+id,
					type:"GET",				 
					success:function(response){	
					 
					if(response.status){
						$("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Assign Keyword Delete");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});					
						dataTableViewAllkeywords.ajax.reload( null, false );  
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);
					}else{
						$("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Assign Keyword Delete");	
						$('#messaged .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});	
					}						
					},
					error:function(response){
					    ;			
						 alert('some error');
					}
				});
				}
			},		 

			freeSubscribe:function(THIS,id){			     
			var $this = $(THIS);
			var form = new FormData(THIS);	
				$.ajax({
					url:"/business/saveSubscribeFree/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					  	
					if(data.status){
                        $("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Free subscribed");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});					
				 
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);	 
						window.location.href = "/business/billing-history";	
						
					}else{
							$("#messaged").modal("show");                        							 
							$('#messaged .modal-title').text("Free subscribed");	
							$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});								
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
							var response = JSON.parse(jqXHR.responseText);	
							if(response.status){						 
							var errors = response.errors;						 
							$('.keyword_form').find('.form-group').removeClass('has-error');
							$('.keyword_form').find('.help-block').remove();
							for (var key in errors) {
							if(errors.hasOwnProperty(key)){	

							var el = $('.keyword_form').find('*[name="'+key+'"]');
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}				 
							}else{
							alert('Something went wrong');
							}
			 
					}
				}); 
				 return false;	
			},
			businessActiveStatus:function(THIS,id,val){			     
			var $this = $(THIS);
			var form = new FormData(THIS);	
			if(confirm('Are sure account active')){
				$.ajax({
					url:"/business/businessActiveStatus/"+id+"/"+val,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					  	
					if(data.status){
                        $("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Free subscribed");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});					
				 
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);	 
						window.location.href = "/business/billing-history";	
						
					}else{
							$("#messaged").modal("show");                        							 
							$('#messaged .modal-title').text("Free subscribed");	
							$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});								
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
							var response = JSON.parse(jqXHR.responseText);	
							if(response.status){						 
							var errors = response.errors;						 
							$('.keyword_form').find('.form-group').removeClass('has-error');
							$('.keyword_form').find('.help-block').remove();
							for (var key in errors) {
							if(errors.hasOwnProperty(key)){	

							var el = $('.keyword_form').find('*[name="'+key+'"]');
							$('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el);
							el.closest('.form-group').addClass('has-error');
							}
							}				 
							}else{
							alert('Something went wrong');
							}
			 
					}
				}); 
			}
				 return false;	
			},

			};
})();	
 
 
 
var profileController = (function(){
		return {
			checked_Ids:[],	
			editPersonaleDetailsSave:function(THIS,id){
			  
			var $this = $(THIS);
			var form = new FormData(THIS);			 
				$.ajax({
					url:"/business/savePersonalDetails/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    	
						if(data.status){
						 $("#messaged").modal("show");      
                         $('#messaged .modal-title').text("Personal Details");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);
						}else{
						 
						$("#messaged").modal("show");      
                        $('#messaged .modal-title').text("Personal Details");	
						$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'}); 	
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					   // ;			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.personal_details').find('.form-group').removeClass('has-error');
                            $('.personal_details').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.personal_details').find('*[name="'+key+'"]');
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
		 saveProfileLogo:function(THIS,id){			  
			var $this = $(THIS);
			var form = new FormData(THIS);			 	 
				$.ajax({
					url:"/business/saveProfileLogo/"+id,
					type:"POST",					   
					dataType:"json",	
					data:form,
					cache: false,
					contentType: false, 
                    processData: false,                      
					success:function(data){
					    	
						if(data.status){
								$("#messaged").modal("show");                                                  							 
								$('#messaged .modal-title').text("Profile Logo");	
								$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
								$('#messaged').modal({keyboard:false,backdrop:'static'});
								$('#messaged').css({'width':'100%'});	
								setInterval(function() {
								$("#messaged").modal("hide");
								}, 3000);									 	
								window.location.href = "/business/profile-logo";			
						
						}else{
							$("#messaged").modal("show");                                                  							 
							$('#messaged .modal-title').text("Profile Logo");	
							$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});	                               
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
					   // ;			
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){ 
						
                            var errors = response.errors;						 
                            $('.profile-logo').find('.form-group').removeClass('has-error');
                            $('.profile-logo').find('.help-block').remove();
                            for (var key in errors) {
                            if(errors.hasOwnProperty(key)){	
                            
                            var el = $('.profile-logo').find('*[name="'+key+'"]');
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
		 
		 
		 
			};
})();		
 
 
var reviewController = (function(){
		return {
			checked_Ids:[],	
			 

		 getReviewEdit:function(id){			 
				$.ajax({
					url:"/business/review/editReview/"+id,
					type:"GET",
					success:function(response){
						$("#reviewModal").modal("show");
						$('#reviewModal .modal-body').html(response.html);					 
						var prevNextHtml = '';	 	
					 
						for(var i=0;i<recordCollection.length;i++){
							if(recordCollection[i]==id && recordCollection.length != 1){
								if(i==0){
									prevNextHtml += '<a style="background:#2A3F54;color:#fff;padding:6px 25px;" href="javascript:reviewController.getReviewEdit('+recordCollection[i+1]+')" class="btn" title="followUp">Next >></a>';
								}
								else if(i==(recordCollection.length-1)){
									prevNextHtml += '<a style="background:#2A3F54;color:#fff;" href="javascript:reviewController.getReviewEdit('+recordCollection[i-1]+')" class="btn" title="followUp"><< Previous</a>';
								}
								else{
									prevNextHtml += '<a style="background:#2A3F54;color:#fff;" href="javascript:reviewController.getReviewEdit('+recordCollection[i-1]+')" class="btn" title="followUp"><< Previous</a><a style="background:#2A3F54;color:#fff;padding:6px 25px;" href="javascript:reviewController.getReviewEdit('+recordCollection[i+1]+')" class="btn" title="followUp">Next >></a>';
								}
							}
						}
						$('#reviewModal .modal-title').html(prevNextHtml);
						$('#reviewModal').modal({keyboard:false,backdrop:'static'});
						$('#reviewModal .select2-container').css({'width':'100%'});
						//mainSpinner.stop();
					},
					error:function(response){
						//mainSpinner.stop();
					}
				});
				 
			},
			saveEditReview:function(id,THIS){
				var $this = $(THIS);
				$.ajax({
					url:'/business/review/update-review/'+id,
					type:"post",
					data:$this.serialize(),
					dataType:'json',
					success:function(response){
						if(response.status){
						 
						 
							alert('Review Update successfully');
							dataTableReview.ajax.reload( null, false );						 
							removeValidationErrors($this);
						}
						
						// mainSpinner.stop();
					},
					error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){
							showValidationErrors($this,response.errors);
						}else{
							alert('Something went wrong');
						}
						mainSpinner.stop();
					}
				});
				return false;
			},
			reviewDelete:function(id){
		 
			 	if( confirm("Are you sure you want to delete?") ) {	
				  
				$.ajax({
					url:"/business/review/delete/"+id,
					type:"GET",				 
					success:function(response){	
					 
					if(response.status){
						$("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Assign Zone Delete");	
						$('#messaged .modal-body').html("<div class='alert alert-success'>"+response.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});					
						dataTableReview.ajax.reload( null, false );  
						setInterval(function() {
						$("#messaged").modal("hide");
						}, 3000);
					}else{
						$("#messaged").modal("show");                        							 
						$('#messaged .modal-title').text("Assign Zone Delete");	
						$('#messaged .modal-body').html("<div class='alert alert-danger'>"+response.msg+"</div>");			
						$('#messaged').modal({keyboard:false,backdrop:'static'});
						$('#messaged').css({'width':'100%'});	
					}						
					},
					error:function(response){
					    ;			
						 alert('some error');
					}
				});
				}
			},
		 
		 
			};
})();		


var enquiryController  = (function(){
		return {
			checked_Ids:[],
			 
			getfollowUps:function(id){
				  showLoader();
				$.ajax({
					url:"/business/enquiry/follow-up/"+id,
					type:"GET",
					success:function(response){
					 
						$('#followUpModal').modal({keyboard:false,backdrop:'static'});
						$("#followUpModal").modal("show");
						$('#followUpModal .modal-body').html(response.html);
						 $('#expected_date_time').daterangepicker({
							singleDatePicker: true,
							autoUpdateInput: false,
							timePicker: true,
							minDate: new Date(),
							//autoUpdateInput: false,
							locale: {
								format: 'DD-MMMM-YYYY h:mm A'
							},
							singleClasses: "picker_2"
						});
						$('#expected_date_time').on('apply.daterangepicker', function(ev, picker) {
							$('#expected_date_time').val(picker.startDate.format('DD-MMMM-YYYY h:mm A'));
						});
					 
						dataTableFollowUps = $('#datatable-enquiry-followups').dataTable({
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
								url:"/business/enquiry/getfollowups/"+id,
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
									prevNextHtml += '<a style="background:#2A3F54;color:#fff;padding:6px 25px;" href="javascript:enquiryController.getfollowUps('+recordCollection[i+1]+')" class="btn" title="followUp">Next >></a>';
								}
								else if(i==(recordCollection.length-1)){
									prevNextHtml += '<a style="background:#2A3F54;color:#fff;" href="javascript:enquiryController.getfollowUps('+recordCollection[i-1]+')" class="btn" title="followUp"><< Previous</a>';
								}
								else{
									prevNextHtml += '<a style="background:#2A3F54;color:#fff;" href="javascript:enquiryController.getfollowUps('+recordCollection[i-1]+')" class="btn" title="followUp"><< Previous</a><a style="background:#2A3F54;color:#fff;padding:6px 25px;" href="javascript:enquiryController.getfollowUps('+recordCollection[i+1]+')" class="btn" title="followUp">Next >></a>';
								}
							}
						}
						
						$('#followUpModal .modal-title').html(prevNextHtml);
					 
					
						$('#followUpModal .select2-container').css({'width':'100%'});
					 
						 hideLoader();
					},
					error:function(response){
						 hideLoader();
					}
				});
				 
			},
			storeFollowUp:function(id,THIS){
				var $this = $(THIS);
  				showLoader();
				$.ajax({
					url:'/business/enquiry/store-follow-up/'+id,
					type:"post",
					data:$this.serialize(),
					dataType:'json',
					success:function(response){
						 hideLoader();
						if(response.status){
						 
							$this.find('*[name="remark"]').val('');
							alert('Follow Up created successfully');
							dataTableFollowUps.ajax.reload( null, false );
						 
							dataTableLeadDashboard.ajax.reload(function(){
								$('#datatable-lead-dashboard').find('[data-toggle="popover"]').popover({html:true,container:'body'});
							},false);
							dataTableViewAllStudent.ajax.reload(function(){
								$('#datatable-view-all-students').find('[data-toggle="popover"]').popover({html:true,container:'body'});
							},false);
						 
							removeValidationErrors($this);
						}
						if(response.demo_created){
							$this.closest('.x_content').html("<p style='font-size: 24px;font-weight:700;padding-top:20px;text-align:center;'>Lead successfully moved to Demo...</p>");
						}
						// mainSpinner.stop();
					},
					error:function(jqXHR, textStatus, errorThrown){
						var response = JSON.parse(jqXHR.responseText);
						if(response.status){
							showValidationErrors($this,response.errors);
						}else{
							alert('Something went wrong');
						}
						// mainSpinner.stop();
					}
				});
				return false;
			},
			getAllFollowUps:function(){
				//mainSpinner.start();
				dataTableFollowUps.ajax.reload( null, false );
				return false;
			},
			selectDeleteParmanent:function(){
				var $this = this;
				if(confirm("Are you sure Delete??")){
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
					url:"/business/assignLocation/selectAssignZoneDelete",
					type:"POST",
					dataType:"json",
					data:{
						ids:$this.checked_Ids
					},
					success:function(data,textStatus,jqXHR){
				    	if(data.status){					 				
							
							$("#messaged").modal("show");                        							 
							$('#messaged .modal-title').text("Business Location Delete");	
							$('#messaged .modal-body').html("<div class='alert alert-success'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});					

							setInterval(function() {
							$("#messaged").modal("hide");
							}, 3000);
							dataTableAssignedZones.ajax.reload(null,false);								 
						}else{

							$("#messaged").modal("show");                        							 
							$('#messaged .modal-title').text("Business Location Delete");	
							$('#messaged .modal-body').html("<div class='alert alert-danger'>"+data.msg+"</div>");			
							$('#messaged').modal({keyboard:false,backdrop:'static'});
							$('#messaged').css({'width':'100%'});	
								 
							}
					},
					error:function(jqXHR,textStatus,errorThrown){
						
					}
				});
			}
				return false;				
			},
			  
			getLeadfollowUps:function(id){
			//	mainSpinner.start();
				$.ajax({
					url:"/business/enquiry/follow-up/"+id,
					type:"GET",
					success:function(response){
						
						$('#followUpModal').modal({keyboard:false,backdrop:'static'});
						$("#followUpModal").modal("show");
						$('#followUpModal .modal-body').html(response.html);
						 $('#expected_date_time').daterangepicker({
							singleDatePicker: true,
							autoUpdateInput: false,
							timePicker: true,
							minDate: new Date(),
							//autoUpdateInput: false,
							locale: {
								format: 'DD-MMMM-YYYY h:mm A'
							},
							singleClasses: "picker_2"
						});
						$('#expected_date_time').on('apply.daterangepicker', function(ev, picker) {
							$('#expected_date_time').val(picker.startDate.format('DD-MMMM-YYYY h:mm A'));
						});
					 
						dataTableFollowUps = $('#datatable-enquiry-followups').dataTable({
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
								url:"/business/enquiry/getfollowups/"+id,
								data:function(d){
									d.page = (d.start/d.length)+1;
									d.columns = null;
									d.order = null;
									d.count = $(".follow-up-count").val();
								}
							}
						}).api(); 
						var prevNextHtml = '';	 	
					 
						 
						$('#followUpModal .modal-title').html(prevNextHtml);
						// $('#followUpModal').modal({keyboard:false,backdrop:'static'});
						$('#followUpModal .select2-container').css({'width':'100%'});
						//mainSpinner.stop();
					},
					error:function(response){
						//mainSpinner.stop();
					}
				});
				 
			},
			
			
		};
	})();
  
   
   
 	$(document).on('click','.remove-thumbnail',function(e){
		e.preventDefault();
		var srno = $(this).data('srno'); 
		var target = $('#'+srno); 
		target.prepend("<input type=\"file\" class=\"form-control\" name=\""+srno+"\" accept=\".jpg,.jpeg,.png,.webp,.svg\">");
		target.find('.img-help').remove();
	});	


	  function toggleDetails(element) {
            const detailsSection = element.previousElementSibling;
            detailsSection.classList.toggle('visible');
            element.textContent = detailsSection.classList.contains('visible') ? 'Hide details' : 'Show details';
        }

        function hideCard(element) {
            const card = element.closest('.enquiry-item');
            card.classList.add('hidden');
        }
 //$('.leaddf,.leaddt').datepicker({dateFormat:"yy-mm-dd"});
 
// ***********
// DATA TABLES
	var dataTableViewAllStudent = $('#datatable-view-all-students').dataTable({
		"fixedHeader": true,
		"processing":true,
		"serverSide":true,
		"paging":true,
		"responsive":true,
		"searching":false,
		"ajax":{
			url:"/business/get-enquiry",
			data:function(d){
				d.page = (d.start/d.length)+1;
				d.search['leaddf']=$('*[name="search[leaddf]"]').val();
			    d.search['leaddt']=$('*[name="search[leaddt]"]').val();	
				d.search['expdf']=$('*[name="search[expdf]"]').val();
			    d.search['expdt']=$('*[name="search[expdt]"]').val();

				d.search['service']=$('*[name="search[service][]"]').val();
			 
				var status = $('*[name="search[status][]"]').val();
				if(status!=null && status.length=='1' && status[0]==''){
					d.search['status']="";
				}else{
					d.search['status']=$('*[name="search[status][]"]').val();
				}
				d.columns = null;
				d.order = null;
			},
			dataSrc:function(json){
			    recordCollection = json.recordCollection; 
			    return json.data;
		    }
		}
	}).api();
	
	var dataTableLeadDashboard = $('#datatable-lead-dashboard').dataTable({
		"fixedHeader": true,
		"processing":true,
		"serverSide":true,
		"paging":true,
		"responsive":true,
		"searching":false,
		"ajax":{
			url:"/business/get-lead-follow",
			data:function(d){
				d.page = (d.start/d.length)+1;
				d.search['expdf']=$('*[name="search[expdf]"]').val();
			    d.search['expdt']=$('*[name="search[expdt]"]').val();
				d.search['service']=$('*[name="search[service][]"]').val();
			 
				var status = $('*[name="search[status][]"]').val();
				if(status!=null && status.length=='1' && status[0]==''){
					d.search['status']="";
				}else{
					d.search['status']=$('*[name="search[status][]"]').val();
				}	
				d.columns = null;
				d.order = null;
			},
			dataSrc:function(json){
			    recordCollection = json.recordCollection; 
			    return json.data;
		    }
		}
	}).api();
	
	
	var dataTableViewAllkeywords = $('#datatable-assigned-keywords').dataTable({
		"fixedHeader": true,
		"processing":true,
		"serverSide":true,
		"paging":true,
		"responsive":true,
		"searching":false,
		"ajax":{
			url:"/business/get-paginated-assigned-keywords",
			data:function(d){
				d.page = (d.start/d.length)+1;
				d.columns = null;
				d.order = null;
			}
		}
	}).api();
 



	
var dataTableAssignedZones = $('#datatable-assigned-zones').on('draw.dt',function(e,settings){
	//$('#datatable-assigned-zones').find('[data-toggle="popover"]').popover({html:true,container:'body'});
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
		url:"/business/get-assigned-zones",
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


	
var dataTableReview = $('#datatable-business-review').on('draw.dt',function(e,settings){
	//$('#datatable-assigned-zones').find('[data-toggle="popover"]').popover({html:true,container:'body'});
	$('#datatable-business-review').find('#check-all').on('change',function(){
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
		url:"/business/get-business-review",
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

   

	var dataTableViewAllhistory = $('#datatable-payment-billing-history').dataTable({
		"fixedHeader": true,
		"processing":true,
		"serverSide":true,
		"paging":true,
		"responsive":true,
		"searching":false,
		"ajax":{
			url:"/business/get-billing-history",
			data:function(d){
				d.page = (d.start/d.length)+1;
				d.columns = null;
				d.order = null;
			}
		}
	}).api();
	 

// 	$(document).on('click', '#invoiceBillingPdf', function () {

//     var id = $(this).data('sid');
 
//     var url = '/business/getinvoiceBillingPrintPdf?pid=' + id;

//     // Create hidden link
//     var link = document.createElement('a');
//     link.href = url;
//     link.download = ''; 
//     // document.body.appendChild(link);
//     link.click();
//     // document.body.removeChild(link);
// });

// $(document).on('click', '#invoiceBillingPdf', function (e) {
//     e.preventDefault();

//     const id = $(this).data('sid');
// alert(id);
//     const link = document.createElement('a');
//     link.href = `/business/getinvoiceBillingPrintPdf?pid=${id}`;
//     link.setAttribute('download', '');
//     link.style.display = 'none';
//     document.body.appendChild(link);
//     link.click();
//     document.body.removeChild(link);
// });



	$(document).on('click','#invoiceBillingPdf',function(e){
	  
		var THIS = $(this);

		var id   = THIS.data('sid'); 
			$.ajax({
			url:"/business/getinvoiceBillingPrintPdf",
			type:"GET",			
			data:{action:'getinvoicePrintPdf',pid:id},
			 
			success: function(response) {        		
				var printWindow = window.open('', '', 'width=700,height=500');
				printWindow.document.write(response);
				return false;

			}

			});	 

	}); 
	

	
  /**
   * Autoresize echart charts
   */
  const mainContainer = select('#main');
  if (mainContainer) {
    setTimeout(() => {
      new ResizeObserver(function() {
        select('.echart', true).forEach(getEchart => {
          echarts.getInstanceByDom(getEchart).resize();
        })
      }).observe(mainContainer);
    }, 200);
  }
  
 
  function removeValidationErrors($this){
      
      $this.find('.form-group').removeClass('has-error');
      $this.find('.help-block').remove(); 
      
      
  }
    function showValidationErrors($this,errors){
        $this.find('.form-group').removeClass('has-error');
        $this.find('.help-block').remove(); 
        for (var key in errors) { 
            if(errors.hasOwnProperty(key)){ 
                var el = $this.find('*[name="'+key+'"]');
                $('<span class="help-block"><strong>'+errors[key][0]+'</strong></span>').insertAfter(el); el.closest('.form-group').addClass('has-error'); 
            }    
        
        }
    }

	$(document).on('click','.assignedLeadsClick',function(e){
		e.preventDefault();	
		var $this = $(this);
		var assingId   = $(this).attr("data-assigned_leads");	
		$.ajax({
			type: "POST",
		 	url:"/business/readLead",
			data: {assingId: assingId},
			dataType: 'json',
			success: function(response) {				
				if(response.status){					 
					 $this.css('background-color', '#fff');			 
				}
			},
			error: function(response) {			 
			}
		});			
	});

	$(document).on('click','.favorite-icon',function(e){
		e.preventDefault();	
		var $this = $(this);
		if( confirm("Are you sure you want to favorite?") ) {	
			var assingId   = $(this).attr("data-favoritleads");	  
			$.ajax({
				type: "POST",
				url:"/business/favoritleads",
				data: {assingId: assingId},
				dataType: 'json',
				success: function(response) {				
					if(response.status){					 
						$this.css('background-color', '#fff');			 
					}
				},
				error: function(response) {
				
				}
			});	
		}		
	});



	$(document).on('change','#flexSwitchCheckChecked',function(e){
		e.preventDefault();	
		var clientId   = $(this).attr("data-client-id");	 
		const isChecked = $(this).is(':checked');
		$.ajax({
			type: "POST",
		 	url:"/business/pauseLead",
			data: {client_id: clientId,pauseLead: isChecked},
			dataType: 'json',
			success: function(response) {				
				if(response.status){					  
				 $(this).checked = !isChecked
				 
				}else{
					  
				}				
			},
			error: function(response) {
			 
			}
		});	
		
	});

	$(document).on('change','#pauseLeadChecked',function(e){
		e.preventDefault();	
		var clientId   = $(this).attr("data-client_id");	 
		const isChecked = $(this).is(':checked');
		$.ajax({
			type: "POST",
		 	url:"/business/pauseLead",
			data: {client_id: clientId,pauseLead: isChecked},
			dataType: 'json',
			success: function(response) {				
				if(response.status){					  
				 $(this).checked = !isChecked
				 
				}else{
					  
				}				
			},
			error: function(response) {			 
			}
		});	
		
	});


  $(document).ready(function(){  
  
		$('.leaddf').datepicker();
		$('.leaddt').datepicker();
		$('.expdf').datepicker();
		$('.expdt').datepicker();
	 
		$('.dob').datepicker({
		maxDate: 0,           
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '1900:' + new Date().getFullYear()
		});
		$(".select2-keyword").select2({
		theme: "bootstrap",
		placeholder: "Select Service",
		maximumSelectionSize: 6,
		containerCssClass: ":all:"
		});
		$(".select2-status").select2({
		theme: "bootstrap",
		placeholder: "Select Status",
		maximumSelectionSize: 6,
		containerCssClass: ":all:"
		});
});
  
  function showLoader() {
    $('#pageLoader').fadeIn(200);
}

function hideLoader() {
    $('#pageLoader').fadeOut(200);
}


	$(document).on('change','*[name="status"]',function(e){
	var $this = $(this);
	//if($this.find("option:selected").text()=="Not Interested"||$this.find("option:selected").text()=="Location Issue"){
	if(!$this.find("option:selected").data('value')){
	$('*[name="expected_date_time"]').prop({'disabled':true}).val('');
	}else{
	$('*[name="expected_date_time"]').prop({'disabled':false});
	}
	});

/*
})(); */