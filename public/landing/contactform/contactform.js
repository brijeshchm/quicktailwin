jQuery(document).ready(function($) {
  "use strict";
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
  //Contact
   
  
  $('form.contactFormbanner').submit(function() {
	 
    var f = $(this).find('.val'),
      ferror = false,
      emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i;

    f.children('input').each(function() { // run all inputs

      var i = $(this); // current input
      var rule = i.attr('data-rule');

      if (rule !== undefined) {
        var ierror = false; // error flag for current input
        var pos = rule.indexOf(':', 0);
        if (pos >= 0) {
          var exp = rule.substr(pos + 1, rule.length);
          rule = rule.substr(0, pos);
        } else {
          rule = rule.substr(pos + 1, rule.length);
        }
 
        switch (rule) {
          case 'name':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break; 			 

			case 'kw_text':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;

          case 'mobile':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;

          case 'email':
            if (!emailExp.test(i.val())) {
              ferror = ierror = true;
            }
            break;

        
        }
        i.next('.validation').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    
	f.children('select').each(function() { // run all inputs

      var i = $(this); // current input
      var rule = i.attr('data-rule');

      if (rule !== undefined) {
        var ierror = false; // error flag for current input
        var pos = rule.indexOf(':', 0);
        if (pos >= 0) {
          var exp = rule.substr(pos + 1, rule.length);
          rule = rule.substr(0, pos);
        } else {
          rule = rule.substr(pos + 1, rule.length);
        }
 
        switch (rule) {
          case 'city_id':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break; 

           
        }
        i.next('.validation').html((ierror ? (i.attr('data-msg') != undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
 
    if (ferror) return false;
    else var str = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "/client/lead/add-lead",
      data: str,
      success: function(msg) {
        alert(msg);
        if (msg == 'OK') {
         
          $('.contactForm').find("input, textarea").val("");
			$this.find('.reset_lead_form').click();	 
		 
			$('#smsEmailModal').modal('hide');
			$('#msgModalpop .modal-dialog').removeClass('modal-sm').addClass('modal-md');
			$('#msgModalpop .modal-body').html("<div class='success'>Thanks for submitting your requirement. Respective Institutes will get back to you soon.</div>");
			$('#msgModalpop').modal({keyboard:false,backdrop:'static'});
        } else {
          $("#sendmessage").removeClass("show");
          $("#errormessage").addClass("show");
          $('#errormessage').html(msg);
        }

      },
	  error: function(response){	 
		var obj= (JSON.stringify(response.responseJSON));					 
		var objtext = (JSON.parse(obj));

		if(objtext.name){
		var vartext = objtext.name;					
		}else if(objtext.mobile){
		var vartext = objtext.mobile;							
		}else if(objtext.email){
		var vartext = objtext.email;							
		}else if(objtext){
		var vartext = "Some Error";	

		}


		mainSpinner.stop();
		$('#msgModal .modal-dialog').removeClass('modal-sm').addClass('modal-md');
		//$('#msgModal .modal-body').html("Please fill all the fields ff...");
		$('#msgModal .modal-body').html(vartext);
		$('#msgModal').modal({keyboard:false,backdrop:'static'});
		}
    });
    return false;
  });
  
  
  
    
    $(".select2-single").select2({
        theme: "bootstrap",
        placeholder: "Select a City",
        maximumSelectionSize: 6,
        containerCssClass: ":all:",
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
		
		// HANDLING REVIEW SUBMIT
		// **********************
	
  
  
// ***************
	// MOBILE NO LIMIT
		$(document).find('input[name="mobile"]').attr('maxlength',10);
		$(document).on('keydown','input[name="mobile"]',function(e){
			if($(this).val().length!=0 && e.keyCode==13){
				verifyDemo();
			}
			if($(this).val().length==0 && e.keyCode==13){
				event.preventDefault();
			}
			if($(this).val().length==0 && (e.keyCode == 48 || e.keyCode == 96)){
				e.preventDefault();
			}
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A,Ctrl+C,Ctrl+V, Command+A
				((e.keyCode === 65 || e.keyCode === 86 || e.keyCode === 67) && (e.ctrlKey === true || e.metaKey === true)) || 
				 // Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
	// MOBILE NO LIMIT
	// ***************
  
  
		$('.lead_form').submit(function(e){ 
			e.preventDefault();
			var $city = $(this).find('.city').val();
			//var $name = $(this).find('*[name="name"]').val();
			var $name = $(this).find('*[name="name"]').val();
			var $mobile = $(this).find('*[name="mobile"]').val();
			var $kw_text = $(this).find('*[name="kw_text"]').val();
			var $email = $(this).find('*[name="email"]').val();
			 
			if($name==''){
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Name. Please fill all the fields.");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;				
			}
			if($mobile==''){
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Mobile. Please fill all the fields.");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;				
			}
			/* if($email==''){
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Email. Please fill all the fields.");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;				
			} */
			 
			 if($city==''){
				 
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Please, <strong>select the city</strong> in which you are looking for");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;
			}
			if($kw_text ==''){			 
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Please, <strong>Search Course and Select</strong> in which you are interested in");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;
			}
			 
			var $this = $(this);
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: 'json',
				success: function(response) {
					//$(this).reset();
					if(response.status){
						  window.location = "https://www.quickdials.com/coaching/thank";						  
						$this.find('.reset_lead_form').click();						
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$('#smsEmailModal').modal('hide');
						$('#msgModalpop .modal-dialog').removeClass('modal-sm').addClass('modal-md');
						$('#msgModalpop .modal-body').html("<div class='success'>Thanks for submitting your requirement. Respective Institutes will get back to you soon.</div>");
						$('#msgModalpop').modal({keyboard:false,backdrop:'static'});
				
						 
						//alert(JSON.stringify(response.msg));
					}else{
						 
						document.write(JSON.stringify(response));
						//alert(response.msg);
					}
				},
				error: function(response){	
 
					var obj= (JSON.stringify(response.responseJSON));					 
					var objtext = (JSON.parse(obj));
 
					if(objtext.name){
					var vartext = objtext.name;					
					}else if(objtext.mobile){
						var vartext = objtext.mobile;							
					}else if(objtext.email){
						var vartext = objtext.email;							
					}else if(objtext){
						var vartext = "Some Error";	

					}				  
					 
					$('#msgModal .modal-dialog').removeClass('modal-sm').addClass('modal-md');
					//$('#msgModal .modal-body').html("Please fill all the fields ff...");
					$('#msgModal .modal-body').html(vartext);
					$('#msgModal').modal({keyboard:false,backdrop:'static'});
				}
			});
		});

		$('.lead_form_popup').submit(function(e){ 
			e.preventDefault();
			var $city = $(this).find('.city').val();
			//var $name = $(this).find('*[name="name"]').val();
			var $name = $(this).find('*[name="name"]').val();
			var $mobile = $(this).find('*[name="mobile"]').val();
			var $kw_text = $(this).find('*[name="kw_text"]').val();
			var $email = $(this).find('*[name="email"]').val();
			 
			if($name==''){
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Name. Please fill all the fields.");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;				
			}
			if($mobile==''){
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Mobile. Please fill all the fields.");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;				
			}
			/* if($email==''){
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Email. Please fill all the fields.");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;				
			} */
			 
			 if($city==''){
				 
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Please, <strong>select the city</strong> in which you are looking for");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;
			}
			if($kw_text ==''){			 
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html("Please, <strong>Search Course and Select</strong> in which you are interested in");
				$('#msgModal').modal({keyboard:false,backdrop:'static'});				
				return;
			}
			 
			var $this = $(this);
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: 'json',
				success: function(response) {
					//$(this).reset();
					if(response.status){
						
						$this.find('.reset_lead_form').click();						
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$('#smsEmailModal').modal('hide');
						$('#msgModalpop .modal-dialog').removeClass('modal-sm').addClass('modal-md');
						$('#msgModalpop .modal-body').html("<div class='success'>Thanks for submitting your requirement. Respective Institutes will get back to you soon.</div>");
						$('#msgModalpop').modal({keyboard:false,backdrop:'static'});
						
	 
						 
						//alert(JSON.stringify(response.msg));
					}else{
						 
						document.write(JSON.stringify(response));
						//alert(response.msg);
					}
				},
				error: function(response){	
 
					var obj= (JSON.stringify(response.responseJSON));					 
					var objtext = (JSON.parse(obj));
 
					if(objtext.name){
					var vartext = objtext.name;					
					}else if(objtext.mobile){
						var vartext = objtext.mobile;							
					}else if(objtext.email){
						var vartext = objtext.email;							
					}else if(objtext){
						var vartext = "Some Error";	

					}				  
					 
					$('#msgModal .modal-dialog').removeClass('modal-sm').addClass('modal-md');
					//$('#msgModal .modal-body').html("Please fill all the fields ff...");
					$('#msgModal .modal-body').html(vartext);
					$('#msgModal').modal({keyboard:false,backdrop:'static'});
				}
			});
		});
		
		
 
  
  
  

});
