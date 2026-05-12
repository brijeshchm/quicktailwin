
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
jQuery(document).ready(function($) {
	
  "use strict";
// ************
// X-CSRF-TOKEN
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
// X-CSRF-TOKEN
// ************


  $(document).on('click','.read-more',function(e){	  
		$(this).closest('article').find('span').show();
		$(this).closest('article').find('.read-less').removeClass('hide').show();
		$(this).hide();
	});
	$(document).on('click','.read-less',function(e){
		$(this).closest('article').find('span').hide();
		$(this).closest('article').find('.read-more').show();
		$(this).hide();
	});

  //Contact
  $('form.contactForm').submit(function() {
    var f = $(this).find('.form-group'),
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
          case 'required':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;
			case 'mobile':
            if (i.val() === '') {
              ferror = ierror = true;
			  
            }
            break;
          case 'minlen':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;

          case 'email':
            if (!emailExp.test(i.val())) {
              ferror = ierror = true;
            }
            break;

          case 'checked':
            if (! i.is(':checked')) {
              ferror = ierror = true;
            }
            break;

          case 'regexp':
            exp = new RegExp(exp);
            if (!exp.test(i.val())) {
              ferror = ierror = true;
            }
            break;
        }
        i.next('.validation').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    f.children('textarea').each(function() { // run all inputs

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
          case 'required':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;

          case 'minlen':
            if (i.val().length < parseInt(exp)) {
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
      url: "site/contact",
      data: str,
      success: function(response) {
        // alert(msg);
        if (response.status) {
          $("#sendmessage").addClass("show");
          $("#errormessage").removeClass("show");
          $('.contactForm').find("input, textarea").val("");
        } else {
          $("#sendmessage").removeClass("show");
          $("#errormessage").addClass("show");
          $('#errormessage').html(msg);
        }

      }
    });
    return false;
  });
  
  
  //enquery
  $('form.inquiryForm').submit(function() {
    var f = $(this).find('.form-group'),
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
          case 'mobile':
            if (i.val() === '') {
              ferror = ierror = true;
			  
            }
            break;

          case 'business':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;

			case 'name':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
			   
            }
            break;
			
			case 'city':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;

          case 'email':
            if (!emailExp.test(i.val())) {
              ferror = ierror = true;
            }
            break;

          case 'checked':
            if (! i.is(':checked')) {
              ferror = ierror = true;
            }
            break;

          case 'regexp':
            exp = new RegExp(exp);
            if (!exp.test(i.val())) {
              ferror = ierror = true;
            }
            break;
        }
        i.next('.validation').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    f.children('textarea').each(function() { // run all inputs

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
          case 'message':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;

          case 'minlen':
            if (i.val().length < parseInt(exp)) {
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
      url: "site/enquery",
      data: str,
      success: function(response) {
        
        if (response.status) {
          $("#sendinquiry").addClass("show");
          $("#errorinquiry").removeClass("show");
          $('.inquiryForm').find("input, textarea").val("");
        } else {
          $("#sendinquiry").removeClass("show");
          $("#errorinquiry").addClass("show");
          $('#errorinquiry').html(msg);
        }

      }
    });
    return false;
  });


 $('form.subscribe').submit(function() {
    var f = $(this).find('.form-group'),
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
          

          case 'subscribe-email':
            if (!emailExp.test(i.val())) {
              ferror = ierror = true;
            }
            break;

           
        }
        i.next('.validation').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    
    if (ferror) return false;
    else var str = $(this).serialize();
	 
    $.ajax({
      type: "POST",
      url: "site/subscribe",
      data: str,
      success: function(response) {
        
        if (response.status) {
          $("#sendsubscribe").addClass("show");
          $("#errorsubscribe").removeClass("show");
         
        } else {
          $("#sendsubscribe").removeClass("show");
          $("#errorsubscribe").addClass("show");
          $('#errorsubscribe').html(response);
        }

      }
    });
    return false;
  });
});
