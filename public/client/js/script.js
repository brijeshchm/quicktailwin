$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

var fp = (function () {
	return {
		getFPF: function () {
			$('.closebtn').click();

			$.ajax({
				url: "/resetp",
				type: "GET",
				data: { action: "getFPF" },
				success: function (data, textStatus, jqXHR) {
					$('body').append(data);

					$('#pass-reset-modal').modal({ keyboard: false, backdrop: 'static' });
					$("#pass-reset-modal").on('hidden.bs.modal', function () {
						$(this).data('bs.modal', null);
						$('#pass-reset-modal').remove();
					});
				}
			});
			return false;
		},
		getOTPF: function (form) {
			var username = $(form).find('*[name="username"]').val();
			var mobile = $(form).find('*[name="mobile"]').val();
			if (username == '' || mobile == '') {
				return false;
			}

			$.ajax({
				url: "/resetp",
				type: "GET",
				data: { action: "getOTPF", username: username, mobile: mobile },
				success: function (data, textStatus, jqXHR) {
					$(form).find('.has-error:not(:last)').removeClass('has-error');
					$(form).find('.help-block:not(:last)').remove();
					if (typeof data.error !== 'undefined') {
						for (var i in data.error.fields) {
							$(form).find('*[name="' + i + '"]').closest('.form-group').addClass('has-error');
							$('<span class="help-block"><strong>' + data.error.fields[i] + '</strong></span>').insertAfter($(form).find('*[name="' + i + '"]'));
						}

						return;
					}

					$('#pass-reset-modal').modal('hide');
					$('body').append(data);
					$('#pr-otp-modal').modal({ keyboard: false, backdrop: 'static' });
					$("#pr-otp-modal").on('hidden.bs.modal', function () {
						$(this).data('bs.modal', null);
						$('#pr-otp-modal').remove();
					});
				}
			});
			return false;
		},
		submitOTPF: function (form) {
			var otp = $(form).find('*[name="otp"]').val();
			if (otp == '') {
				return false;
			}

			$.ajax({
				url: "/resetp",
				type: "GET",
				data: { action: "submitOTPF", otp: otp },
				success: function (data, textStatus, jqXHR) {
					$(form).find('.has-error:not(:last)').removeClass('has-error');
					$(form).find('.help-block:not(:last)').remove();
					if (typeof data.error !== 'undefined') {
						for (var i in data.error.fields) {
							$(form).find('*[name="' + i + '"]').closest('.form-group').addClass('has-error');
							$('<span class="help-block"><strong>' + data.error.fields[i] + '</strong></span>').insertAfter($(form).find('*[name="' + i + '"]'));
						}

						return;
					}

					$('#pr-otp-modal').modal('hide');
					$('body').append(data);
					$('#pr-conf-modal').modal({ keyboard: false, backdrop: 'static' });
					$("#pr-conf-modal").on('hidden.bs.modal', function () {
						$(this).data('bs.modal', null);
						$('#pr-conf-modal').remove();
					});
				}
			});
			return false;
		},
		close: function () {
			$('#pass-reset-modal').modal('hide');
		},
		closeotpf: function () {
			$('#pr-otp-modal').modal('hide');
		},
		closeconff: function () {
			$('#pr-conf-modal').modal('hide');
		}
	}
})();


var homeController = (function () {
	return {
		checked_Ids: [],
		saveEnquiry: function (THIS) {
			var $this = $(THIS),
				data = $this.serialize();

			$.ajax({
				url: "/client/lead/saveEnquiry",
				type: "POST",
				data: data,
				dataType: 'json',
				success: function (response, textStatus, jqXHR) {


					if (response.statusCode) {

						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/Thanks.png" style="width: 60%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('.successhtml').html("<p class='text-center' style='font-weight: 600;'>Your Submission has been received. <br> Our experts will reach out to you in the next 24 hours.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });

						$this.find('.jinp').removeClass('has-error');
						$this.find('.help-block').remove();


					} else {
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/message_alert.png" style="width: 30%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('.failedhtml').html("<p class='text-center'>Some Error Please Try again.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					var response = JSON.parse(jqXHR.responseText);
					if (response.status) {

						var errors = response.errors;
						$this.find('.form-inline').find('.jinp').removeClass('has-error');
						$this.find('.help-block').remove();
						for (var key in errors) {
							if (errors.hasOwnProperty(key)) {
								var el = $this.find('*[name="' + key + '"]');
								$('<span class="help-block"><strong>' + errors[key][0] + '</strong></span>').insertAfter(el);
								el.closest('.form-inline').find('.jinp').addClass('has-error');
							}
						}

					} else {
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/message_alert.png" style="width: 30%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('.failedhtml').html("<p class='text-center'>Some Error Please Try Again.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}

				}
			});
			return false;
		},
		savePopEnquiry: function (THIS) {
			var $this = $(THIS),
				data = $this.serialize();

			$.ajax({
				url: "/client/lead/saveEnquiry",
				type: "POST",
				data: data,
				dataType: 'json',
				success: function (response, textStatus, jqXHR) {


					if (response.statusCode) {

						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/Thanks.png" style="width: 60%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('.successhtml').html("<p class='text-center' style='font-weight: 600;'>Your Submission has been received. <br> Our experts will reach out to you in the next 24 hours.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });

						$this.find('.jinp').removeClass('has-error');
						$this.find('.help-block').remove();


					} else {
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/message_alert.png" style="width: 30%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('.failedhtml').html("<p class='text-center'>Some Error Please Try again.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					var response = JSON.parse(jqXHR.responseText);
					if (response.status) {

						var errors = response.errors;
						$this.find('.form-inline').find('.jinp').removeClass('has-error');
						$this.find('.help-block').remove();
						for (var key in errors) {
							if (errors.hasOwnProperty(key)) {
								var el = $this.find('*[name="' + key + '"]');
								$('<span class="help-block"><strong>' + errors[key][0] + '</strong></span>').insertAfter(el);
								el.closest('.form-inline').find('.jinp').addClass('has-error');
							}
						}

					} else {
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/message_alert.png" style="width: 30%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('.failedhtml').html("<p class='text-center'>Some Error Please Try Again.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}

				}
			});
			return false;
		},
		saveReview: function (THIS) {
			var $this = $(THIS),
				data = $this.serialize();
 
			$.ajax({
				url: "/review",
				type: "POST",
				data: data,
				dataType: 'json',
				success: function (response, textStatus, jqXHR) {
 
					if (response.status) {
 
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/Thanks.png" style="width: 60%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('#messagemodel h3').html('Your submission has been reviewed successfully.');
						$('.successhtml').html("<p class='text-center' style='font-weight: 600;'>Thank you for your valuable feedback. <br> Thank you for taking the time to share your review.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });

						$this.find('.jinp').removeClass('has-error');
						$this.find('.help-block').remove();


					} else {
						alert('errro');
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/message_alert.png" style="width: 30%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('.failedhtml').html("<p class='text-center'>Some Error Please Try again.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					var response = JSON.parse(jqXHR.responseText);
					if (response.status) {

						var errors = response.errors;
						$this.find('.form-inline').find('.jinp').removeClass('has-error');
						$this.find('.help-block').remove();
						for (var key in errors) {
							if (errors.hasOwnProperty(key)) {
								var el = $this.find('*[name="' + key + '"]');
								$('<span class="help-block"><strong>' + errors[key][0] + '</strong></span>').insertAfter(el);
								el.closest('.form-inline').find('.jinp').addClass('has-error');
							}
						}

					} else {

					 
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/message_alert.png" style="width: 30%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('h3').html('');
						$('.failedhtml').html("<p class='text-center' style='color:red;font-size: 22px;'>"+response.message+"</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}

				}
			});
			return false;
		},

		saveTwoEnquiry: function (THIS) {
			var $this = $(THIS),
				data = $this.serialize();
 
			 
			$.ajax({
				url: "/client/lead/saveTwoEnquiry",
				type: "POST",
				data: data,
				dataType: 'json',
				beforeSend: function () {
				$(".loaderForm").show();
			 
				},
				success: function (response, textStatus, jqXHR) {

					$(".loaderForm").hide();
				 

					if (response.statusCode) {
 
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						// $(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/public/images/Thanks.png" style="width: 100%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('.successhtml').html("<p class='text-center' style='font-weight: 600;'>Your Submission has been received. <br> Our experts will reach out to you in the next 24 hours.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });

						$this.find('.jinp').removeClass('has-error');
						$this.find('.help-block').remove();
						let currentStep = 0;
						if(currentStep > 0){
						steps[currentStep].classList.remove("active");
						indicators[currentStep].classList.remove("active");
						currentStep--;
						steps[currentStep].classList.add("active");
						indicators[currentStep].classList.add("active");
						}

					} else {
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/public/images/message_alert.png" style="width: 50%;text-align: center;margin: auto;display: block;" alt="message_alert">');
						$('.failedhtml').html("<p class='text-center'>Some Error Please Try again.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					  $(".loaderForm").hide();
					var response = JSON.parse(jqXHR.responseText);
					if (response.status) {

						var errors = response.errors;
						$this.find('.form-inline').find('.jinp').removeClass('has-error');
						$this.find('.help-block').remove();
						for (var key in errors) {
							if (errors.hasOwnProperty(key)) {
								var el = $this.find('*[name="' + key + '"]');
								$('<span class="help-block"><strong>' + errors[key][0] + '</strong></span>').insertAfter(el);
								el.closest('.form-inline').find('.jinp').addClass('has-error');
							}
						}

					} else {
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/public/images/message_alert.png" style="width: 50%;text-align: center;margin: auto;display: block;" alt="message_alert">');
						$('.failedhtml').html("<p class='text-center'>Some Error Please Try Again.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}

				}
			});
			return false;
		},
		saveEnquiryContact: function (THIS) {
			var $this = $(THIS),
				data = $this.serialize();
			$.ajax({
				url: "/client/lead/saveEnquiryContact",
				type: "POST",
				data: data,
				dataType: 'json',
				success: function (response, textStatus, jqXHR) {


					if (response.statusCode) {

						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/Thanks.png" style="width: 100%;text-align: center;margin: auto;display: block;" alt="Thanks">');
						$('.successhtml').html("<p class='text-center' style='font-weight: 600;'>Your Submission has been received. <br> Our experts will reach out to you in the next 24 hours.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });

						$this.find('.jinp').removeClass('has-error');
						$this.find('.help-block').remove();


					} else {
						$('.connectedclosebtn').click();
						$('.dealclosebtn').click();
						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/images/message_alert.png" style="width: 50%;text-align: center;margin: auto;display: block;" alt="message_alert">');
						$('.failedhtml').html("<p class='text-center'>Some Error Please Try again.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					var response = JSON.parse(jqXHR.responseText);
					if (response.status) {

						var errors = response.errors;
						$this.find('.contactForm').find('.form-group').removeClass('has-error');
						$this.find('.help-block').remove();
						for (var key in errors) {
							if (errors.hasOwnProperty(key)) {
								var el = $this.find('*[name="' + key + '"]');
								$('<span class="help-block"><strong>' + errors[key][0] + '</strong></span>').insertAfter(el);
								el.closest('.contactForm').find('.form-group').addClass('has-error');
							}
						}

					} else {

						$(".reset_lead_form").click();
						$("#messagemodel").modal();
						$('.imgclass').html('<img src="/public/images/message_alert.png" style="width: 50%;text-align: center;margin: auto;display: block;" alt="message_alert">');
						$('.failedhtml').html("<p class='text-center'>Some Error Please Try Again.</p>");
						$('#messagemodel').modal({ backdrop: "static", keyboard: false });
					}

				}
			});
			return false;
		},
	};
})();

function newsletter(THIS) {
	var $this = $(THIS);

	if ($this.find('input[name="email"]').val() == '') {
		return false;
	}

	$.ajax({
		url: $this.attr('action'),
		type: "POST",
		data: new FormData(THIS),
		contentType: false,
		cache: false,
		processData: false,
		success: function (response) {
			if (response.status) {
				$this.find('.nl_err').text(response.message);

				$this.find('input[name="reset"]').click();
			} else {

				$this.find('.nl_err').text(response.message);
			}
		},
		error: function (response) {
			alert("An error occured");
		}
	});
	return false;
}



function showCategory(parent_id, parent_slug) {

	$.ajax({
		type: "post",
		url: "/category/" + parent_slug,
		data: { parent_id: parent_id },
		success: function (response) {
			location.href = "/category/" + parent_slug;
		}
	});

}


function showKeywordsList(parent_id, parent_cat, child_id, child_cat) {

	$('#showKeywordsList .modal-title').text(parent_cat + "[" + child_cat + "]");
	$('#showKeywordsList').modal({ keyboard: false, backdrop: 'static' });
	var formToSend = $('<form><input name="parent_cat_id" value="' + parent_id + '" /><input name="child_cat_id" value="' + child_id + '" /></form>');
	var parentID = parent_id,
		childID = child_id,
		parentCat = parent_cat,
		childCat = child_cat;
	$.ajax({
		type: "GET",
		url: "/getKWList",
		dataType: 'json',
		data: formToSend.serialize(),
		success: function (response) {
			if (response.status) {

				var kwdsList = response.message;
				var i = 0;
				var subMenu = [];
				subMenu['list_one'] = '<div class="col-md-4"><ul>';
				subMenu['list_two'] = '<div class="col-md-4"><ul>';
				subMenu['list_three'] = '<div class="col-md-4"><ul>';
				for (var k in kwdsList) {
					i++;
					if (i == 1) {
						subMenu['list_one'] += "<li><a href=\"javascript:getCitiesOfKW('" + parentID + "','" + childID + "','" + parentCat + "','" + childCat + "','" + kwdsList[k]['keyword'] + "')\">" + kwdsList[k]['keyword'] + "</a></li>";
					}
					if (i == 2) {
						subMenu['list_two'] += "<li><a href=\"javascript:getCitiesOfKW('" + parentID + "','" + childID + "','" + parentCat + "','" + childCat + "','" + kwdsList[k]['keyword'] + "')\">" + kwdsList[k]['keyword'] + "</a></li>";
					}
					if (i == 3) {
						subMenu['list_three'] += "<li><a href=\"javascript:getCitiesOfKW('" + parentID + "','" + childID + "','" + parentCat + "','" + childCat + "','" + kwdsList[k]['keyword'] + "')\">" + kwdsList[k]['keyword'] + "</a></li>";
						i = 0;
					}
				}
				subMenu['list_one'] += '</ul></div>';
				subMenu['list_two'] += '</ul></div>';
				subMenu['list_three'] += '</ul></div><div class="clearfix"></div>';
				$('#showKeywordsList .modal-body').html(subMenu['list_one'] + subMenu['list_two'] + subMenu['list_three']);
			} else {

			}
		}
	});
}

function getCitiesOfKW(parent_id, child_id, parent_cat, child_cat, keyword) {

	var city = "delhi";
	searchKW = keyword;
	searchKW = searchKW.replace(/\s+/g, '-').toLowerCase();
	city = city.replace(/[_\s]+/g, '-').toLowerCase();
	location.href = "/" + city + "/" + searchKW;
}

function getCitiesOfKW_old(parent_id, child_id, parent_cat, child_cat, keyword) {
	$('#cityKWForm .modal-title').text(parent_cat + " -> " + child_cat + " -> " + keyword);
	$('#cityKWForm .home-search').val(keyword);
	$('#cityKWForm').modal({ keyboard: false, backdrop: 'static' });
	var formToSend = $('<form><input name="parent_cat_id" value="' + parent_id + '" /><input name="child_cat_id" value="' + child_id + '" /><input name="kw" value="' + keyword + '" /></form>');
	$.ajax({
		type: "GET",
		url: "/getCityKWList",
		dataType: 'json',
		data: formToSend.serialize(),
		success: function (response) {
			if (response.status) {
				var kwdsList = response.message;
				var html = "<option value=\"\">--Select the City--</option>";
				for (var k in kwdsList) {
					html += "<option value=\"" + (kwdsList[k]['city']).toLowerCase() + "\">" + kwdsList[k]['city'] + "</option>";
				}
				$('#cityKWForm .city').html(html);
			} else {

			}
		}
	});
}


function submitForm() {
	var data = $("#login-form").serialize();	 
	$.ajax({
		type: "POST",
		url: "/client-login",
		data: data,
		beforeSend: function () {
			$("#error").fadeOut();
			$("#btn-login").html("<span class=\"glyphicon glyphicon-transfer\"></span> &nbsp; sending ...");
		},
		success: function (data, textStatus, jqXHR) {
			if (data.statusCode && data.statusCode == 1) {
				$('.input-layout').replaceWith(data.data.payload);
				$("#btn-login").html('<span><span>Continue</span></span>');
				$('.input-layout').before(data.data.message);
			}
			else if (data.statusCode && data.statusCode == 2) {
				$("#btn-login").html('<img src="/public/client/images/btn-ajax-loader.gif" alt="loader" /> &nbsp; ' + data.data.message + ' ...');
				setTimeout(function () { window.location.href = "/business/dashboard"; }, 2000);
			}
			else {
				$(".alert").remove();
				$('#login-form').prepend('<div class="alert alert-danger">' + data.data.message + '</div>');
				$("#btn-login").html('<span><span>Continue</span></span>');
			}
		}
	});
	return false;
}

/**
 * Removing hash from the given url
 *
 * @param url
 * @return url without hash 
 */
function removeHashFromURL($url = null) {
	if ($url == null) return;
	return $url.substr(0, ($url.indexOf('#') == (-1)) ? $url.length : $url.indexOf('#'));
}



const countries = [{ "country_id": 101, "sortname": "IN", "country_name": "India", "phonecode": 91, "country_status": "1" }, { "country_id": 1, "sortname": "AF", "country_name": "Afghanistan", "phonecode": 93, "country_status": "1" }, { "country_id": 2, "sortname": "AL", "country_name": "Albania", "phonecode": 355, "country_status": "1" }, { "country_id": 3, "sortname": "DZ", "country_name": "Algeria", "phonecode": 213, "country_status": "1" }, { "country_id": 4, "sortname": "AS", "country_name": "American Samoa", "phonecode": 1684, "country_status": "1" }, { "country_id": 5, "sortname": "AD", "country_name": "Andorra", "phonecode": 376, "country_status": "1" }, { "country_id": 6, "sortname": "AO", "country_name": "Angola", "phonecode": 244, "country_status": "1" }, { "country_id": 7, "sortname": "AI", "country_name": "Anguilla", "phonecode": 1264, "country_status": "1" }, { "country_id": 8, "sortname": "AQ", "country_name": "Antarctica", "phonecode": 672, "country_status": "1" }, { "country_id": 9, "sortname": "AG", "country_name": "Antigua And Barbuda", "phonecode": 1268, "country_status": "1" }, { "country_id": 10, "sortname": "AR", "country_name": "Argentina", "phonecode": 54, "country_status": "1" }, { "country_id": 11, "sortname": "AM", "country_name": "Armenia", "phonecode": 374, "country_status": "1" }, { "country_id": 12, "sortname": "AW", "country_name": "Aruba", "phonecode": 297, "country_status": "1" }, { "country_id": 13, "sortname": "AU", "country_name": "Australia", "phonecode": 61, "country_status": "1" }, { "country_id": 14, "sortname": "AT", "country_name": "Austria", "phonecode": 43, "country_status": "1" }, { "country_id": 15, "sortname": "AZ", "country_name": "Azerbaijan", "phonecode": 994, "country_status": "1" }, { "country_id": 16, "sortname": "BS", "country_name": "Bahamas The", "phonecode": 1242, "country_status": "1" }, { "country_id": 17, "sortname": "BH", "country_name": "Bahrain", "phonecode": 973, "country_status": "1" }, { "country_id": 18, "sortname": "BD", "country_name": "Bangladesh", "phonecode": 880, "country_status": "1" }, { "country_id": 19, "sortname": "BB", "country_name": "Barbados", "phonecode": 1246, "country_status": "1" }, { "country_id": 20, "sortname": "BY", "country_name": "Belarus", "phonecode": 375, "country_status": "1" }, { "country_id": 21, "sortname": "BE", "country_name": "Belgium", "phonecode": 32, "country_status": "1" }, { "country_id": 22, "sortname": "BZ", "country_name": "Belize", "phonecode": 501, "country_status": "1" }, { "country_id": 23, "sortname": "BJ", "country_name": "Benin", "phonecode": 229, "country_status": "1" }, { "country_id": 24, "sortname": "BM", "country_name": "Bermuda", "phonecode": 1441, "country_status": "1" }, { "country_id": 25, "sortname": "BT", "country_name": "Bhutan", "phonecode": 975, "country_status": "1" }, { "country_id": 26, "sortname": "BO", "country_name": "Bolivia", "phonecode": 591, "country_status": "1" }, { "country_id": 27, "sortname": "BA", "country_name": "Bosnia and Herzegovina", "phonecode": 387, "country_status": "1" }, { "country_id": 28, "sortname": "BW", "country_name": "Botswana", "phonecode": 267, "country_status": "1" }, { "country_id": 29, "sortname": "BV", "country_name": "Bouvet Island", "phonecode": 55, "country_status": "1" }, { "country_id": 30, "sortname": "BR", "country_name": "Brazil", "phonecode": 55, "country_status": "1" }, { "country_id": 31, "sortname": "IO", "country_name": "British Indian Ocean Territory", "phonecode": 246, "country_status": "1" }, { "country_id": 32, "sortname": "BN", "country_name": "Brunei", "phonecode": 673, "country_status": "1" }, { "country_id": 33, "sortname": "BG", "country_name": "Bulgaria", "phonecode": 359, "country_status": "1" }, { "country_id": 34, "sortname": "BF", "country_name": "Burkina Faso", "phonecode": 226, "country_status": "1" }, { "country_id": 35, "sortname": "BI", "country_name": "Burundi", "phonecode": 257, "country_status": "1" }, { "country_id": 36, "sortname": "KH", "country_name": "Cambodia", "phonecode": 855, "country_status": "1" }, { "country_id": 37, "sortname": "CM", "country_name": "Cameroon", "phonecode": 237, "country_status": "1" }, { "country_id": 38, "sortname": "CA", "country_name": "Canada", "phonecode": 1, "country_status": "1" }, { "country_id": 39, "sortname": "CV", "country_name": "Cape Verde", "phonecode": 238, "country_status": "1" }, { "country_id": 40, "sortname": "KY", "country_name": "Cayman Islands", "phonecode": 1345, "country_status": "1" }, { "country_id": 41, "sortname": "CF", "country_name": "Central African Republic", "phonecode": 236, "country_status": "1" }, { "country_id": 42, "sortname": "TD", "country_name": "Chad", "phonecode": 235, "country_status": "1" }, { "country_id": 43, "sortname": "CL", "country_name": "Chile", "phonecode": 56, "country_status": "1" }, { "country_id": 44, "sortname": "CN", "country_name": "China", "phonecode": 86, "country_status": "1" }, { "country_id": 45, "sortname": "CX", "country_name": "Christmas Island", "phonecode": 61, "country_status": "1" }, { "country_id": 46, "sortname": "CC", "country_name": "Cocos (Keeling) Islands", "phonecode": 672, "country_status": "1" }, { "country_id": 47, "sortname": "CO", "country_name": "Colombia", "phonecode": 57, "country_status": "1" }, { "country_id": 48, "sortname": "KM", "country_name": "Comoros", "phonecode": 269, "country_status": "1" }, { "country_id": 49, "sortname": "CG", "country_name": "Congo", "phonecode": 242, "country_status": "1" }, { "country_id": 50, "sortname": "CD", "country_name": "Congo The Democratic Republic Of The", "phonecode": 242, "country_status": "1" }, { "country_id": 51, "sortname": "CK", "country_name": "Cook Islands", "phonecode": 682, "country_status": "1" }, { "country_id": 52, "sortname": "CR", "country_name": "Costa Rica", "phonecode": 506, "country_status": "1" }, { "country_id": 53, "sortname": "CI", "country_name": "Cote D\u0027Ivoire (Ivory Coast)", "phonecode": 225, "country_status": "1" }, { "country_id": 54, "sortname": "HR", "country_name": "Croatia (Hrvatska)", "phonecode": 385, "country_status": "1" }, { "country_id": 55, "sortname": "CU", "country_name": "Cuba", "phonecode": 53, "country_status": "1" }, { "country_id": 56, "sortname": "CY", "country_name": "Cyprus", "phonecode": 357, "country_status": "1" }, { "country_id": 57, "sortname": "CZ", "country_name": "Czech Republic", "phonecode": 420, "country_status": "1" }, { "country_id": 58, "sortname": "DK", "country_name": "Denmark", "phonecode": 45, "country_status": "1" }, { "country_id": 59, "sortname": "DJ", "country_name": "Djibouti", "phonecode": 253, "country_status": "1" }, { "country_id": 60, "sortname": "DM", "country_name": "Dominica", "phonecode": 1767, "country_status": "1" }, { "country_id": 61, "sortname": "DO", "country_name": "Dominican Republic", "phonecode": 1809, "country_status": "1" }, { "country_id": 62, "sortname": "TP", "country_name": "East Timor", "phonecode": 670, "country_status": "1" }, { "country_id": 63, "sortname": "EC", "country_name": "Ecuador", "phonecode": 593, "country_status": "1" }, { "country_id": 64, "sortname": "EG", "country_name": "Egypt", "phonecode": 20, "country_status": "1" }, { "country_id": 65, "sortname": "SV", "country_name": "El Salvador", "phonecode": 503, "country_status": "1" }, { "country_id": 66, "sortname": "GQ", "country_name": "Equatorial Guinea", "phonecode": 240, "country_status": "1" }, { "country_id": 67, "sortname": "ER", "country_name": "Eritrea", "phonecode": 291, "country_status": "1" }, { "country_id": 68, "sortname": "EE", "country_name": "Estonia", "phonecode": 372, "country_status": "1" }, { "country_id": 69, "sortname": "ET", "country_name": "Ethiopia", "phonecode": 251, "country_status": "1" }, { "country_id": 70, "sortname": "XA", "country_name": "External Territories of Australia", "phonecode": 61, "country_status": "1" }, { "country_id": 71, "sortname": "FK", "country_name": "Falkland Islands", "phonecode": 500, "country_status": "1" }, { "country_id": 72, "sortname": "FO", "country_name": "Faroe Islands", "phonecode": 298, "country_status": "1" }, { "country_id": 73, "sortname": "FJ", "country_name": "Fiji Islands", "phonecode": 679, "country_status": "1" }, { "country_id": 74, "sortname": "FI", "country_name": "Finland", "phonecode": 358, "country_status": "1" }, { "country_id": 75, "sortname": "FR", "country_name": "France", "phonecode": 33, "country_status": "1" }, { "country_id": 76, "sortname": "GF", "country_name": "French Guiana", "phonecode": 594, "country_status": "1" }, { "country_id": 77, "sortname": "PF", "country_name": "French Polynesia", "phonecode": 689, "country_status": "1" }, { "country_id": 78, "sortname": "TF", "country_name": "French Southern Territories", "phonecode": 262, "country_status": "1" }, { "country_id": 79, "sortname": "GA", "country_name": "Gabon", "phonecode": 241, "country_status": "1" }, { "country_id": 80, "sortname": "GM", "country_name": "Gambia The", "phonecode": 220, "country_status": "1" }, { "country_id": 81, "sortname": "GE", "country_name": "Georgia", "phonecode": 995, "country_status": "1" }, { "country_id": 82, "sortname": "DE", "country_name": "Germany", "phonecode": 49, "country_status": "1" }, { "country_id": 83, "sortname": "GH", "country_name": "Ghana", "phonecode": 233, "country_status": "1" }, { "country_id": 84, "sortname": "GI", "country_name": "Gibraltar", "phonecode": 350, "country_status": "1" }, { "country_id": 85, "sortname": "GR", "country_name": "Greece", "phonecode": 30, "country_status": "1" }, { "country_id": 86, "sortname": "GL", "country_name": "Greenland", "phonecode": 299, "country_status": "1" }, { "country_id": 87, "sortname": "GD", "country_name": "Grenada", "phonecode": 1473, "country_status": "1" }, { "country_id": 88, "sortname": "GP", "country_name": "Guadeloupe", "phonecode": 590, "country_status": "1" }, { "country_id": 89, "sortname": "GU", "country_name": "Guam", "phonecode": 1671, "country_status": "1" }, { "country_id": 90, "sortname": "GT", "country_name": "Guatemala", "phonecode": 502, "country_status": "1" }, { "country_id": 91, "sortname": "XU", "country_name": "Guernsey and Alderney", "phonecode": 44, "country_status": "1" }, { "country_id": 92, "sortname": "GN", "country_name": "Guinea", "phonecode": 224, "country_status": "1" }, { "country_id": 93, "sortname": "GW", "country_name": "Guinea-Bissau", "phonecode": 245, "country_status": "1" }, { "country_id": 94, "sortname": "GY", "country_name": "Guyana", "phonecode": 592, "country_status": "1" }, { "country_id": 95, "sortname": "HT", "country_name": "Haiti", "phonecode": 509, "country_status": "1" }, { "country_id": 96, "sortname": "HM", "country_name": "Heard and McDonald Islands", "phonecode": 672, "country_status": "1" }, { "country_id": 97, "sortname": "HN", "country_name": "Honduras", "phonecode": 504, "country_status": "1" }, { "country_id": 98, "sortname": "HK", "country_name": "Hong Kong S.A.R.", "phonecode": 852, "country_status": "1" }, { "country_id": 99, "sortname": "HU", "country_name": "Hungary", "phonecode": 36, "country_status": "1" }, { "country_id": 100, "sortname": "IS", "country_name": "Iceland", "phonecode": 354, "country_status": "1" }, { "country_id": 102, "sortname": "ID", "country_name": "Indonesia", "phonecode": 62, "country_status": "1" }, { "country_id": 103, "sortname": "IR", "country_name": "Iran", "phonecode": 98, "country_status": "1" }, { "country_id": 104, "sortname": "IQ", "country_name": "Iraq", "phonecode": 964, "country_status": "1" }, { "country_id": 105, "sortname": "IE", "country_name": "Ireland", "phonecode": 353, "country_status": "1" }, { "country_id": 106, "sortname": "IL", "country_name": "Israel", "phonecode": 972, "country_status": "1" }, { "country_id": 107, "sortname": "IT", "country_name": "Italy", "phonecode": 39, "country_status": "1" }, { "country_id": 108, "sortname": "JM", "country_name": "Jamaica", "phonecode": 1876, "country_status": "1" }, { "country_id": 109, "sortname": "JP", "country_name": "Japan", "phonecode": 81, "country_status": "1" }, { "country_id": 110, "sortname": "XJ", "country_name": "Jersey", "phonecode": 44, "country_status": "1" }, { "country_id": 111, "sortname": "JO", "country_name": "Jordan", "phonecode": 962, "country_status": "1" }, { "country_id": 112, "sortname": "KZ", "country_name": "Kazakhstan", "phonecode": 7, "country_status": "1" }, { "country_id": 113, "sortname": "KE", "country_name": "Kenya", "phonecode": 254, "country_status": "1" }, { "country_id": 114, "sortname": "KI", "country_name": "Kiribati", "phonecode": 686, "country_status": "1" }, { "country_id": 115, "sortname": "KP", "country_name": "Korea North", "phonecode": 850, "country_status": "1" }, { "country_id": 116, "sortname": "KR", "country_name": "Korea South", "phonecode": 82, "country_status": "1" }, { "country_id": 117, "sortname": "KW", "country_name": "Kuwait", "phonecode": 965, "country_status": "1" }, { "country_id": 118, "sortname": "KG", "country_name": "Kyrgyzstan", "phonecode": 996, "country_status": "1" }, { "country_id": 119, "sortname": "LA", "country_name": "Laos", "phonecode": 856, "country_status": "1" }, { "country_id": 120, "sortname": "LV", "country_name": "Latvia", "phonecode": 371, "country_status": "1" }, { "country_id": 121, "sortname": "LB", "country_name": "Lebanon", "phonecode": 961, "country_status": "1" }, { "country_id": 122, "sortname": "LS", "country_name": "Lesotho", "phonecode": 266, "country_status": "1" }, { "country_id": 123, "sortname": "LR", "country_name": "Liberia", "phonecode": 231, "country_status": "1" }, { "country_id": 124, "sortname": "LY", "country_name": "Libya", "phonecode": 218, "country_status": "1" }, { "country_id": 125, "sortname": "LI", "country_name": "Liechtenstein", "phonecode": 423, "country_status": "1" }, { "country_id": 126, "sortname": "LT", "country_name": "Lithuania", "phonecode": 370, "country_status": "1" }, { "country_id": 127, "sortname": "LU", "country_name": "Luxembourg", "phonecode": 352, "country_status": "1" }, { "country_id": 128, "sortname": "MO", "country_name": "Macau S.A.R.", "phonecode": 853, "country_status": "1" }, { "country_id": 129, "sortname": "MK", "country_name": "Macedonia", "phonecode": 389, "country_status": "1" }, { "country_id": 130, "sortname": "MG", "country_name": "Madagascar", "phonecode": 261, "country_status": "1" }, { "country_id": 131, "sortname": "MW", "country_name": "Malawi", "phonecode": 265, "country_status": "1" }, { "country_id": 132, "sortname": "MY", "country_name": "Malaysia", "phonecode": 60, "country_status": "1" }, { "country_id": 133, "sortname": "MV", "country_name": "Maldives", "phonecode": 960, "country_status": "1" }, { "country_id": 134, "sortname": "ML", "country_name": "Mali", "phonecode": 223, "country_status": "1" }, { "country_id": 135, "sortname": "MT", "country_name": "Malta", "phonecode": 356, "country_status": "1" }, { "country_id": 136, "sortname": "XM", "country_name": "Man (Isle of)", "phonecode": 44, "country_status": "1" }, { "country_id": 137, "sortname": "MH", "country_name": "Marshall Islands", "phonecode": 692, "country_status": "1" }, { "country_id": 138, "sortname": "MQ", "country_name": "Martinique", "phonecode": 596, "country_status": "1" }, { "country_id": 139, "sortname": "MR", "country_name": "Mauritania", "phonecode": 222, "country_status": "1" }, { "country_id": 140, "sortname": "MU", "country_name": "Mauritius", "phonecode": 230, "country_status": "1" }, { "country_id": 141, "sortname": "YT", "country_name": "Mayotte", "phonecode": 269, "country_status": "1" }, { "country_id": 142, "sortname": "MX", "country_name": "Mexico", "phonecode": 52, "country_status": "1" }, { "country_id": 143, "sortname": "FM", "country_name": "Micronesia", "phonecode": 691, "country_status": "1" }, { "country_id": 144, "sortname": "MD", "country_name": "Moldova", "phonecode": 373, "country_status": "1" }, { "country_id": 145, "sortname": "MC", "country_name": "Monaco", "phonecode": 377, "country_status": "1" }, { "country_id": 146, "sortname": "MN", "country_name": "Mongolia", "phonecode": 976, "country_status": "1" }, { "country_id": 147, "sortname": "MS", "country_name": "Montserrat", "phonecode": 1664, "country_status": "1" }, { "country_id": 148, "sortname": "MA", "country_name": "Morocco", "phonecode": 212, "country_status": "1" }, { "country_id": 149, "sortname": "MZ", "country_name": "Mozambique", "phonecode": 258, "country_status": "1" }, { "country_id": 150, "sortname": "MM", "country_name": "Myanmar", "phonecode": 95, "country_status": "1" }, { "country_id": 151, "sortname": "NA", "country_name": "Namibia", "phonecode": 264, "country_status": "1" }, { "country_id": 152, "sortname": "NR", "country_name": "Nauru", "phonecode": 674, "country_status": "1" }, { "country_id": 153, "sortname": "NP", "country_name": "Nepal", "phonecode": 977, "country_status": "1" }, { "country_id": 154, "sortname": "AN", "country_name": "Netherlands Antilles", "phonecode": 599, "country_status": "1" }, { "country_id": 155, "sortname": "NL", "country_name": "Netherlands The", "phonecode": 31, "country_status": "1" }, { "country_id": 156, "sortname": "NC", "country_name": "New Caledonia", "phonecode": 687, "country_status": "1" }, { "country_id": 157, "sortname": "NZ", "country_name": "New Zealand", "phonecode": 64, "country_status": "1" }, { "country_id": 158, "sortname": "NI", "country_name": "Nicaragua", "phonecode": 505, "country_status": "1" }, { "country_id": 159, "sortname": "NE", "country_name": "Niger", "phonecode": 227, "country_status": "1" }, { "country_id": 160, "sortname": "NG", "country_name": "Nigeria", "phonecode": 234, "country_status": "1" }, { "country_id": 161, "sortname": "NU", "country_name": "Niue", "phonecode": 683, "country_status": "1" }, { "country_id": 162, "sortname": "NF", "country_name": "Norfolk Island", "phonecode": 672, "country_status": "1" }, { "country_id": 163, "sortname": "MP", "country_name": "Northern Mariana Islands", "phonecode": 1670, "country_status": "1" }, { "country_id": 164, "sortname": "NO", "country_name": "Norway", "phonecode": 47, "country_status": "1" }, { "country_id": 165, "sortname": "OM", "country_name": "Oman", "phonecode": 968, "country_status": "1" }, { "country_id": 166, "sortname": "PK", "country_name": "Pakistan", "phonecode": 92, "country_status": "1" }, { "country_id": 167, "sortname": "PW", "country_name": "Palau", "phonecode": 680, "country_status": "1" }, { "country_id": 168, "sortname": "PS", "country_name": "Palestinian Territory Occupied", "phonecode": 970, "country_status": "1" }, { "country_id": 169, "sortname": "PA", "country_name": "Panama", "phonecode": 507, "country_status": "1" }, { "country_id": 170, "sortname": "PG", "country_name": "Papua new Guinea", "phonecode": 675, "country_status": "1" }, { "country_id": 171, "sortname": "PY", "country_name": "Paraguay", "phonecode": 595, "country_status": "1" }, { "country_id": 172, "sortname": "PE", "country_name": "Peru", "phonecode": 51, "country_status": "1" }, { "country_id": 173, "sortname": "PH", "country_name": "Philippines", "phonecode": 63, "country_status": "1" }, { "country_id": 174, "sortname": "PN", "country_name": "Pitcairn Island", "phonecode": 64, "country_status": "1" }, { "country_id": 175, "sortname": "PL", "country_name": "Poland", "phonecode": 48, "country_status": "1" }, { "country_id": 176, "sortname": "PT", "country_name": "Portugal", "phonecode": 351, "country_status": "1" }, { "country_id": 177, "sortname": "PR", "country_name": "Puerto Rico", "phonecode": 1787, "country_status": "1" }, { "country_id": 178, "sortname": "QA", "country_name": "Qatar", "phonecode": 974, "country_status": "1" }, { "country_id": 179, "sortname": "RE", "country_name": "Reunion", "phonecode": 262, "country_status": "1" }, { "country_id": 180, "sortname": "RO", "country_name": "Romania", "phonecode": 40, "country_status": "1" }, { "country_id": 181, "sortname": "RU", "country_name": "Russia", "phonecode": 70, "country_status": "1" }, { "country_id": 182, "sortname": "RW", "country_name": "Rwanda", "phonecode": 250, "country_status": "1" }, { "country_id": 183, "sortname": "SH", "country_name": "Saint Helena", "phonecode": 290, "country_status": "1" }, { "country_id": 184, "sortname": "KN", "country_name": "Saint Kitts And Nevis", "phonecode": 1869, "country_status": "1" }, { "country_id": 185, "sortname": "LC", "country_name": "Saint Lucia", "phonecode": 1758, "country_status": "1" }, { "country_id": 186, "sortname": "PM", "country_name": "Saint Pierre and Miquelon", "phonecode": 508, "country_status": "1" }, { "country_id": 187, "sortname": "VC", "country_name": "Saint Vincent And The Grenadines", "phonecode": 1784, "country_status": "1" }, { "country_id": 188, "sortname": "WS", "country_name": "Samoa", "phonecode": 684, "country_status": "1" }, { "country_id": 189, "sortname": "SM", "country_name": "San Marino", "phonecode": 378, "country_status": "1" }, { "country_id": 190, "sortname": "ST", "country_name": "Sao Tome and Principe", "phonecode": 239, "country_status": "1" }, { "country_id": 191, "sortname": "SA", "country_name": "Saudi Arabia", "phonecode": 966, "country_status": "1" }, { "country_id": 192, "sortname": "SN", "country_name": "Senegal", "phonecode": 221, "country_status": "1" }, { "country_id": 193, "sortname": "RS", "country_name": "Serbia", "phonecode": 381, "country_status": "1" }, { "country_id": 194, "sortname": "SC", "country_name": "Seychelles", "phonecode": 248, "country_status": "1" }, { "country_id": 195, "sortname": "SL", "country_name": "Sierra Leone", "phonecode": 232, "country_status": "1" }, { "country_id": 196, "sortname": "SG", "country_name": "Singapore", "phonecode": 65, "country_status": "1" }, { "country_id": 197, "sortname": "SK", "country_name": "Slovakia", "phonecode": 421, "country_status": "1" }, { "country_id": 198, "sortname": "SI", "country_name": "Slovenia", "phonecode": 386, "country_status": "1" }, { "country_id": 199, "sortname": "XG", "country_name": "Smaller Territories of the UK", "phonecode": 44, "country_status": "1" }, { "country_id": 200, "sortname": "SB", "country_name": "Solomon Islands", "phonecode": 677, "country_status": "1" }, { "country_id": 201, "sortname": "SO", "country_name": "Somalia", "phonecode": 252, "country_status": "1" }, { "country_id": 202, "sortname": "ZA", "country_name": "South Africa", "phonecode": 27, "country_status": "1" }, { "country_id": 203, "sortname": "GS", "country_name": "South Georgia", "phonecode": 500, "country_status": "1" }, { "country_id": 204, "sortname": "SS", "country_name": "South Sudan", "phonecode": 211, "country_status": "1" }, { "country_id": 205, "sortname": "ES", "country_name": "Spain", "phonecode": 34, "country_status": "1" }, { "country_id": 206, "sortname": "LK", "country_name": "Sri Lanka", "phonecode": 94, "country_status": "1" }, { "country_id": 207, "sortname": "SD", "country_name": "Sudan", "phonecode": 249, "country_status": "1" }, { "country_id": 208, "sortname": "SR", "country_name": "Suriname", "phonecode": 597, "country_status": "1" }, { "country_id": 209, "sortname": "SJ", "country_name": "Svalbard And Jan Mayen Islands", "phonecode": 47, "country_status": "1" }, { "country_id": 210, "sortname": "SZ", "country_name": "Swaziland", "phonecode": 268, "country_status": "1" }, { "country_id": 211, "sortname": "SE", "country_name": "Sweden", "phonecode": 46, "country_status": "1" }, { "country_id": 212, "sortname": "CH", "country_name": "Switzerland", "phonecode": 41, "country_status": "1" }, { "country_id": 213, "sortname": "SY", "country_name": "Syria", "phonecode": 963, "country_status": "1" }, { "country_id": 214, "sortname": "TW", "country_name": "Taiwan", "phonecode": 886, "country_status": "1" }, { "country_id": 215, "sortname": "TJ", "country_name": "Tajikistan", "phonecode": 992, "country_status": "1" }, { "country_id": 216, "sortname": "TZ", "country_name": "Tanzania", "phonecode": 255, "country_status": "1" }, { "country_id": 217, "sortname": "TH", "country_name": "Thailand", "phonecode": 66, "country_status": "1" }, { "country_id": 218, "sortname": "TG", "country_name": "Togo", "phonecode": 228, "country_status": "1" }, { "country_id": 219, "sortname": "TK", "country_name": "Tokelau", "phonecode": 690, "country_status": "1" }, { "country_id": 220, "sortname": "TO", "country_name": "Tonga", "phonecode": 676, "country_status": "1" }, { "country_id": 221, "sortname": "TT", "country_name": "Trinidad And Tobago", "phonecode": 1868, "country_status": "1" }, { "country_id": 222, "sortname": "TN", "country_name": "Tunisia", "phonecode": 216, "country_status": "1" }, { "country_id": 223, "sortname": "TR", "country_name": "Turkey", "phonecode": 90, "country_status": "1" }, { "country_id": 224, "sortname": "TM", "country_name": "Turkmenistan", "phonecode": 7370, "country_status": "1" }, { "country_id": 225, "sortname": "TC", "country_name": "Turks And Caicos Islands", "phonecode": 1649, "country_status": "1" }, { "country_id": 226, "sortname": "TV", "country_name": "Tuvalu", "phonecode": 688, "country_status": "1" }, { "country_id": 227, "sortname": "UG", "country_name": "Uganda", "phonecode": 256, "country_status": "1" }, { "country_id": 228, "sortname": "UA", "country_name": "Ukraine", "phonecode": 380, "country_status": "1" }, { "country_id": 229, "sortname": "AE", "country_name": "United Arab Emirates", "phonecode": 971, "country_status": "1" }, { "country_id": 230, "sortname": "UK", "country_name": "United Kingdom", "phonecode": 44, "country_status": "1" }, { "country_id": 231, "sortname": "USA", "country_name": "United States (US)", "phonecode": 1, "country_status": "1" }, { "country_id": 232, "sortname": "UM", "country_name": "United States Minor Outlying Islands", "phonecode": 1, "country_status": "1" }, { "country_id": 233, "sortname": "UY", "country_name": "Uruguay", "phonecode": 598, "country_status": "1" }, { "country_id": 234, "sortname": "UZ", "country_name": "Uzbekistan", "phonecode": 998, "country_status": "1" }, { "country_id": 235, "sortname": "VU", "country_name": "Vanuatu", "phonecode": 678, "country_status": "1" }, { "country_id": 236, "sortname": "VA", "country_name": "Vatican City State (Holy See)", "phonecode": 39, "country_status": "1" }, { "country_id": 237, "sortname": "VE", "country_name": "Venezuela", "phonecode": 58, "country_status": "1" }, { "country_id": 238, "sortname": "VN", "country_name": "Vietnam", "phonecode": 84, "country_status": "1" }, { "country_id": 239, "sortname": "VG", "country_name": "Virgin Islands (British)", "phonecode": 1284, "country_status": "1" }, { "country_id": 240, "sortname": "VI", "country_name": "Virgin Islands (US)", "phonecode": 1340, "country_status": "1" }, { "country_id": 241, "sortname": "WF", "country_name": "Wallis And Futuna Islands", "phonecode": 681, "country_status": "1" }, { "country_id": 242, "sortname": "EH", "country_name": "Western Sahara", "phonecode": 212, "country_status": "1" }, { "country_id": 243, "sortname": "YE", "country_name": "Yemen", "phonecode": 967, "country_status": "1" }, { "country_id": 244, "sortname": "YU", "country_name": "Yugoslavia", "phonecode": 38, "country_status": "1" }, { "country_id": 245, "sortname": "ZM", "country_name": "Zambia", "phonecode": 260, "country_status": "1" }, { "country_id": 246, "sortname": "ZW", "country_name": "Zimbabwe", "phonecode": 263, "country_status": "1" }];
         const globalIconUrl = "https://flagcdn.com/w40/in.png";

function setupDropdown(modal) {

    const input = modal.querySelector('.dropwn-input');
    const flagImg = modal.querySelector('.selectedFlag');
    const dropdownList = modal.querySelector('.dropdown-list');
    const clearIcon = modal.querySelector('.removeFlag');
    const countryCodeInput = modal.querySelector('.countryCode');

    if (!input) return; // safety check

    function renderList(filtered = countries) {
        dropdownList.innerHTML = '';
        filtered.forEach(country => {
            const item = document.createElement('div');
            item.className = 'dropdown-item';
            item.textContent = `${country.country_name} (+${country.phonecode})`;
            item.onclick = () => selectCountry(country);
            dropdownList.appendChild(item);
        });
    }

    function selectCountry(country) {
        const flag = `https://flagcdn.com/w40/${country.sortname.toLowerCase()}.png`;
        input.value = `+${country.phonecode}`;
        countryCodeInput.value = `+${country.phonecode}`;
        flagImg.src = flag;
        dropdownList.style.display = 'none';
        clearIcon.style.display = 'block';
    }

    function filterCountries() {
        const search = input.value.toLowerCase().replace('+', '');
        const filtered = countries.filter(c =>
            c.country_name.toLowerCase().includes(search) ||
            c.sortname.toLowerCase().includes(search) ||
            c.phonecode.toString().includes(search)
        );
        renderList(filtered);
        dropdownList.style.display = 'block';
    }

    function clearInput(e) {
        e.stopPropagation();
        input.value = '';
        countryCodeInput.value = '';
        flagImg.src = globalIconUrl;
        clearIcon.style.display = 'none';
        renderList();
        dropdownList.style.display = 'block';
    }

    async function autoDetectCountry() {
        try {
            let data;

            const stored = localStorage.getItem('ipData');
            if (stored) {
                data = JSON.parse(stored);
            } else {
                const res = await fetch('https://ipapi.co/json/');
                data = await res.json();
                localStorage.setItem('ipData', JSON.stringify(data));
            }

            const country = countries.find(
                c => c.sortname.toLowerCase() === data.country_code.toLowerCase()
            );

            if (country) selectCountry(country);

        } catch {
            selectCountry(countries.find(c => c.sortname === 'IN'));
        }
    }

    renderList();
    autoDetectCountry();

    input.addEventListener('input', filterCountries);
    clearIcon.addEventListener('click', clearInput);

    document.addEventListener('click', e => {
        if (!modal.contains(e.target)) dropdownList.style.display = 'none';
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.dropwn').forEach(setupDropdown);
});


(function ($) {
	$(document).ready(function () {


		$('#inputField').on('click', function () {
			const checkedValue = $('input[name="option"]:checked').val();
			if (checkedValue) {
				console.log(`Checked radio button: ${checkedValue}`);
				// Do something with the checked value
			} else {
				console.log('No radio button is checked');
			}
		});


		$('input[name="payment_mode_accepted[select_all]"]').on('change', function () {
			var k = this.checked ? true : false;
			if (k) {
				$(this).closest('.form-group').find('input[type="checkbox"]').prop('checked', true);
			} else {
				$(this).closest('.form-group').find('input[type="checkbox"]').prop('checked', false);
			}
		});

		$('.search-form').submit(function (e) {
			e.preventDefault();

			// var city = $(this).find('.location').val;

			var city = $(this).find('.location option:selected').val();
			// console.log(city);
			// var city = $(this).find('.location').attr('data-city');
			// var area  = $(this).find('.location').attr('data-area');
			// var zone  = $(this).find('.location').attr('data-zone');

			if (city != 'undefined') {
				var city = $(this).find('.city').val();
			}
 
			// var searchKW = $(this).find('.home-search').val();
		 	var searchKW = $(this).find('.home-search option:selected').val();
 

			localStorage.setItem('keyword', searchKW);
			localStorage.setItem('city', city);
			let cities = localStorage.getItem('cityData');
			cities = cities ? JSON.parse(cities) : [];
			cities.push(city);
			cities = [...new Set(cities)];
			localStorage.setItem('cityData', JSON.stringify(cities));

			if (searchKW) {
				let keywords = localStorage.getItem('keywordData'); 
				keywords = keywords ? JSON.parse(keywords) : [];
				keywords.push(searchKW);
				keywords = [...new Set(keywords)];
				localStorage.setItem('keywordData', JSON.stringify(keywords));
			}
			var message = '';
			if (searchKW == '') {
				if (searchKW == '') {
					return;
				}
				else if (searchKW != '') {
					message = "Please, <strong>select the city</strong> in which you are looking for <strong>" + $(this).find('input[name="search_kw"]').val() + "</strong>";
				}
				else if (searchKW == '') {
					message = "Please, <strong>enter the service</strong> for which you are looking";
				}
				$('#msgModal .modal-dialog').removeClass('modal-md').addClass('modal-sm');
				$('#msgModal .modal-body').html(message);
				$('#msgModal').modal({ keyboard: false, backdrop: 'static' });
				return;
			}
			//	var searchKW = $(this).find('.home-search').val();
			//var city = $(this).find('.city').val();		 
			searchKW = searchKW.replace(/\s+/g, '-').toLowerCase();		
			searchKW = searchKW.trim();
			if (city) {
				city = city.trim();
				city = city.replace(/[_\s]+/g, '-').toLowerCase();
				localStorage.setItem('city', city);				
				location.href = "/" + city + "/" + searchKW;
			} else {
				location.href = "/" + searchKW;
			}

		});

		// ONCLICK TO SEARCH RESULTS	 

			$(document).on('change', '.searchcity', function (e) {
			e.preventDefault();
			// $(this).closest('form').find(".home-search").val($(this).find('a').text());
			$(this).closest('form').find(".home-search").val();
 
			var closestForm = $(this).closest('form');
			if (closestForm.hasClass('search-form')) {
				closestForm.submit();
			}

			// $(this).closest('form').find(".ajax-suggest").hide();
			// $(this).closest('form').find(".ajax-suggest ul").html("");
		});
			$(document).on('change', '.home-search', function (e) {
			e.preventDefault();
			// $(this).closest('form').find(".home-search").val($(this).find('a').text());
			$(this).closest('form').find(".home-search").val();
 
			var closestForm = $(this).closest('form');
			if (closestForm.hasClass('search-form')) {
				closestForm.submit();
			}

			// $(this).closest('form').find(".ajax-suggest").hide();
			// $(this).closest('form').find(".ajax-suggest ul").html("");
		});



		$(document).on('click', '.ajax-suggest ul>li', function (e) {
			e.preventDefault();
			$(this).closest('form').find(".home-search").val($(this).find('a').text());

			var closestForm = $(this).closest('form');
			if (closestForm.hasClass('search-form')) {
				closestForm.submit();
			}

			$(this).closest('form').find(".ajax-suggest").hide();
			$(this).closest('form').find(".ajax-suggest ul").html("");
		});


		$(document).on('click', '.resultCode ul>li', function (e) {

			$(this).closest('form').find(".location").val($(this).find('a').attr("data-city"));
			$(this).closest('form').find('.location').attr('data-city', $(this).find('a').attr("data-city"));
			// $(this).closest('form').find('.location').attr('data-area', $(this).find('a').attr("data-area"));
			// $(this).closest('form').find('.location').attr('data-zone', $(this).find('a').attr("data-zone"));

			var closestForm = $(this).closest('form');
			if (closestForm.hasClass('search-form')) {
				closestForm.submit();
			}
			$(this).closest('form').find(".resultCode").hide();
		});

		$(document).on('click', '.keystore', function (e) {
		 
			e.preventDefault();
			var slug = $(this).attr('href');		 	
			slug = slug.replace(window.location.origin + '/', ''); 
			slug = slug.replace(/\s+/g, '-').toLowerCase();				
			text = slug.replace(/-/g, ' ');
 
			// capitalize first letter
			text = text.charAt(0).toUpperCase() + text.slice(1);		
			 	 
			localStorage.setItem('keyword', text);


			// var city = localStorage.getItem('city');		 
			var city = "";		 
			if (city) {
				window.location.href = "/" + city + "/" + slug;
			} else {
				window.location.href = "/" + slug;
			}
		});

		// ONCLICK TO SEARCH RESULTS	 
		$(document).on('click', '.cityCache', function (e) {
			e.preventDefault();
			localStorage.clear();
		});

		// SEARCHING KEYDOWN	 
		// $(".home-search").on('keydown',function(evt){	

		// 	if($(this).closest('form').find('.ajax-suggest ul>li').length>0){
		// 		if($(this).closest('form').find('.ajax-suggest ul li.active').length>0){
		// 			if(evt.keyCode == '38'){

		// 				if($(this).closest('form').find('.ajax-suggest ul li.active').is(':first-child')){
		// 					$(this).closest('form').find('.ajax-suggest ul li.active').removeClass('active');
		// 					$(this).closest('form').find('.ajax-suggest ul>li').last().addClass('active');
		// 				}else{
		// 					$(this).closest('form').find('.ajax-suggest ul li.active').removeClass('active').prev().addClass('active');
		// 				}
		// 			}
		// 			if(evt.keyCode == '40'){

		// 				if($(this).closest('form').find('.ajax-suggest ul li.active').is(':last-child')){
		// 					$(this).closest('form').find('.ajax-suggest ul li.active').removeClass('active');
		// 					$(this).closest('form').find('.ajax-suggest ul>li').first().addClass('active');
		// 				}else{
		// 					$(this).closest('form').find('.ajax-suggest ul li.active').removeClass('active').next().addClass('active');
		// 				}
		// 			}
		// 		}else{
		// 			$(this).closest('form').find('.ajax-suggest ul>li').first().addClass('active');
		// 		}
		// 	}
		// });

		// SEARCHING ENGINE		 
		$(".home-search").on('keyup', function (evt) {
			//console.log(evt.keyCode);
			// if(evt.keyCode == '38'||evt.keyCode == '40'){
			// 	$(this).val($('.ajax-suggest ul li.active>a').text());
			// 	return;
			// }
			var key = $(this).val();

			var yearly_subs_form = $(this).closest('form');
			$(this).closest('form').find(".resultCode").hide();
			if (key.length > 0) {
				$(this).closest('form').find(".ajax-suggest").show();
				$(this).closest('form').find(".ajax-suggest ul").html("<li><a href='#'>Loading...</a><li>");
				var $this = $(this);
				var formToSend = $('<form><input name="city" value="' + yearly_subs_form.find(".city").val() + '" /><input name="search_kw" value="' + yearly_subs_form.find(".home-search").val() + '" /></form>');

				$.ajax({
					type: "POST",
					url: '/kw/search',
					data: formToSend.serialize(),
					dataType: 'json',
					success: function (response) {
						if (response.status) {

							$this.closest('form').find(".ajax-suggest ul").html(response.message);
						} else {

							$this.closest('form').find(".ajax-suggest ul").html("<li><a href='#'>Nothing found...</a><li>");
						}
					}
				});
			} else {

				var keywordsData = JSON.parse(localStorage.getItem('keywordData'));
				let html = '';
				 
				if (keywordsData) {

					keywordsData.forEach(q => {
						html += `<li><a href='#'><i class='fa fa-search'></i>${q}</a></li>`;
					});
				}
				$(this).closest('form').find(".ajax-suggest").show();
				$(this).closest('form').find(".ajax-suggest ul").html(html);
			}
		});


		$(".cityList").on('keyup', function (evt) {
			var key = $(this).val();
			$(this).closest('form').find(".ajax-suggest").hide();
			if (key.length > 0) {

				$.ajax({
					url: "/getCityList",
					type: 'get',
					data: { id: key },
					success: function (data) {

						$('.city-result').html(data);

					}
				});
			} else {

				// var citiesData = JSON.parse(localStorage.getItem('cityData'));
				// if (citiesData) {

				// 	let cities = citiesData;
				// 	let searchInput = 'id';
				// 	let len = searchInput.length;
				// 	let resultDiv = document.createElement('div');
				// 	resultDiv.className = 'resultCode';

				// 	let clear = document.createElement('span');
				// 	clear.className = "cityCache";
				// 	clear.style.cssText = "cursor: pointer; margin-left: 54px; color: #0089ff;";
				// 	clear.textContent = "Clean All";
				// 	clear.addEventListener("click", function () {
				// 		localStorage.clear();
				// 		$('.city-result').html("");
				// 		document.getElementById("myclear").style.display = "flex";
				// 		setInterval(function () {						 
				// 		document.getElementById("myclear").style.display = "none";
				// 		}, 3000);
				// 	});

				// 	let ul = document.createElement('ul');
				// 	cities.forEach(city => {

				// 		let li = document.createElement('li');


				// 		let a = document.createElement('a');
				// 		a.setAttribute("data-city", city);
				// 		let pos = city.toLowerCase().indexOf(searchInput.toLowerCase());

				// 		a.textContent = city.charAt(0).toUpperCase() + city.slice(1);
				// 		li.appendChild(a);
				// 		ul.appendChild(li);
				// 	});

				// 	resultDiv.appendChild(clear);
				// 	resultDiv.appendChild(ul);
				// 	$('.city-result').html(resultDiv);

				// } else {

					$.ajax({
						url: "/getCityList",
						type: 'get',
						data: { id: key },
						success: function (data) {
							$('.city-result').html(data);

						}
					});
				// }

			}
		});

		// HANDLING REVIEW SUBMIT
		// PLAYING WITH STAR RATING	 
		$(document).on('mouseover', '.s_rating', function () {
			var s_rating = $(this).data('s_rating');
			var imageUrl = '/client/images/full-star.png';
			for (var i = 0; i < s_rating; ++i) {

				$('.s_rating[data-s_rating="' + (i + 1) + '"]').css('background-image', 'url(' + imageUrl + ')');
			}
		});

		$(document).on('mouseout', '.s_rating', function () {
			var s_rating = 0;
			if ($('.s_active').length) {
				s_rating = $('.s_active').data('s_rating');
			}
			var imageUrl = '/client/images/empty-star.png';
			for (var i = s_rating; i < 5; ++i) {

				$('.s_rating[data-s_rating="' + (i + 1) + '"]').css('background-image', 'url(' + imageUrl + ')');
			}
		});

		$(document).on('click', '.s_rating', function (e) {
			e.preventDefault();
			if ($('.s_active').length) {
				$('.s_active').removeClass('s_active');
			}
			$(this).addClass('s_active');
			$('input[name="s_rating"]').val($(this).data('s_rating'));
			// $('html, body').animate({
			// 	scrollTop: $("#wrt").offset().top - 130
			// }, 1000);
		 
		});

		$(document).on('click', '.c_trigger', function (e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $("#wrt").offset().top - 130
			}, 1000);
			$('.tab-content > div').removeClass('active in');
			$('.tab-content > #wrt').addClass('active in');
			$('.newtab > li').removeClass('active');
			$('.newtab > li > a[href="#wrt"]').parents('li').addClass('active');
		});

		$('#g_MapsModal').on('shown.bs.modal', function () {
			initMap();
		});

		$(document).on('click', '.loc_trigger', function (e) {
			e.preventDefault();
			$('#g_MapsModal').modal();

		});

		// LOGIN FORM VALIDATION		 
		if (typeof $.fn.validate == 'function') {
			$("#login-form").validate({
				errorElement: 'small',
				rules: {
					password: {
						required: true
					},
					/*email:{
						required:true,
						//email:true
					} */
					mobile: {
						required: true
					},
					/* otp:{
						required:true
					} */
				},
				messages: {
					password: {
						required: "Please enter your password"
					},
					/*email:{
						required:"Please enter your email",
						//email:"Enter valid email"
					} */
					mobile: {
						required: "Please enter the registered mobile"
					},
					/* otp:{
						required:"Please enter the OTP"
					} */
				},
				submitHandler: submitForm
			});
		}

		// ACTION TOOK PLACE WHEN CLICK ON '.REMOVE-THUMBNAIL'

		$(document).on('click', '.remove-thumbnail', function (e) {
			e.preventDefault();
			var srno = $(this).data('srno');
			var target = $('#' + srno);
			target.prepend("<input type=\"file\" class=\"form-control\" name=\"" + srno + "\">");
			target.find('.help-block').remove();
		});

		// TOGGLE HOURS OF OPERATION

		$(document).on('click', '.max-min', function () {
			$('.today').toggleClass('hide');
			$('.otherday').toggleClass('hide');
		});

		// TOGGLE FORMS ON BUSINESS OWNERS PAGE		 
		$(document).on('click', '.acc-head', function (e) {
			e.preventDefault();
			$this = $(this);
			$('.acc-body').slideUp();
			$this.next().slideToggle();
		});

		// ANIMATE PAGE SCROLL WHEN FILL THE BUSINESS FORM		 
		var forms_group = $('#forms_group');
		if (forms_group.length) {

			var offset = forms_group.offset();
			$('html, body').animate({
				scrollTop: offset.top - 60
			}, 400);
		}

		// HANDLING HOURS OF OPERATION TIME VALIDATION		 
		$(document).on('change', '.time-from', function () {
			var $this = $(this);
			var id = $this.attr('id');
			var corr_id = id.replace("[from]", "[to]");
			if ($this.val() == '') {
				$this.data('time', '');
				$('select[id="' + corr_id + '"]').val('');
				$('select[id="' + corr_id + '"]').data('time', '');
			}
			else if ($this.val() == '24:00') {
				$this.data('time', '24:00');
				$('select[id="' + corr_id + '"]').val('24:00');
				$('select[id="' + corr_id + '"]').data('time', '24:00');
			}
			else {
				if ($this.find('option:selected').data('time_in_min') > $('select[id="' + corr_id + '"]').find('option:selected').data('time_in_min')) {
					alert('Open time cannot be greater then close time');
					$this.val($this.data('time'));
				} else {
					$this.data($this.val());
				}
			}
		});
		$(document).on('change', '.time-to', function () {
			var $this = $(this);
			var id = $this.attr('id');
			var corr_id = id.replace("[to]", "[from]");
			if ($this.val() == '') {
				$this.data('time', '');
				$('select[id="' + corr_id + '"]').val('');
				$('select[id="' + corr_id + '"]').data('time', '');
			}
			else if ($this.val() == '24:00') {
				$this.data('time', '24:00');
				$('select[id="' + corr_id + '"]').val('24:00');
				$('select[id="' + corr_id + '"]').data('time', '24:00');
			}
			else {
				if ($this.find('option:selected').data('time_in_min') < $('select[id="' + corr_id + '"]').find('option:selected').data('time_in_min')) {
					alert('Open time cannot be greater then close time');
					$this.val($this.data('time'));
				} else {
					$this.data($this.val());
				}
			}
		});



		$(document).on('submit', '.location_info', function (e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: $('.location_info').attr('action'),
				data: $('.location_info').serialize(),
				dataType: 'json',
				success: function (response) {
					if (response.status) {
						$('.location_success').text(response.result);

					} else {
						alert(response.result);
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					var response = JSON.parse(jqXHR.responseText);
					if (response.status) {
						var errors = response.errors;
						$('.location_info').find('.form-group').removeClass('has-error');
						$('.location_info').find('.help-block').remove();
						for (var key in errors) {
							if (errors.hasOwnProperty(key)) {

								var el = $('.location_info').find('*[name="' + key + '"]');
								$('<span class="help-block"><strong>' + errors[key][0] + '</strong></span>').insertAfter(el);
								el.closest('.form-group').addClass('has-error');
							}
						}
					} else {
						alert(response.result);
					}

				}
			});
		});

		$(document).on('submit', '.contact_info', function (e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: $('.contact_info').attr('action'),
				data: $('.contact_info').serialize(),
				dataType: 'json',
				success: function (response) {
					if (response.status) {

						$('.contact_success').text(response.result);
					} else {
						alert(response.result);
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					var response = JSON.parse(jqXHR.responseText);
					if (response.status) {
						var errors = response.errors;
						$('.contact_info').find('.form-group').removeClass('has-error');
						$('.contact_info').find('.help-block').remove();
						for (var key in errors) {
							if (errors.hasOwnProperty(key)) {

								var el = $('.contact_info').find('*[name="' + key + '"]');
								$('<span class="help-block"><strong>' + errors[key][0] + '</strong></span>').insertAfter(el);
								el.closest('.form-group').addClass('has-error');
							}
						}

					} else {
						alert(response.result);
					}

				}
			});
		});
		$(document).on('submit', '.client_discussion', function (e) {
			e.preventDefault();

			$.ajax({
				type: "POST",
				url: $('.client_discussion').attr('action'),
				data: $('.client_discussion').serialize(),
				dataType: 'json',
				success: function (response) {
					if (response.status) {
						$('.discussion_success').text(response.result);
						dataTableViewAllDiscussion.ajax.reload(null, false);
					} else {
						alert(response.result);
					}

				},
				error: function (response) {
					alert("An error occured");
				}
			});

		});


		// MOBILE NO LIMIT
		$(document).find('input[name="mobile"]').attr('maxlength', 16);
		$(document).on('keydown', 'input[name="mobile"]', function (e) {
			if ($(this).val().length != 0 && e.keyCode == 13) {
				verifyDemo();
			}
			if ($(this).val().length == 0 && e.keyCode == 13) {
				event.preventDefault();
			}
			if ($(this).val().length == 0 && (e.keyCode == 48 || e.keyCode == 96)) {
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
		function removeValidationErrors($this) {
			$this.find('.form-group').removeClass('has-error');
			$this.find('.help-block').remove();
		}



		function showValidationErrors($this, errors) { 
			
			$this.find('.form-group').removeClass('has-error'); $this.find('.help-block').remove(); for (var key in errors) { if (errors.hasOwnProperty(key)) { var el = $this.find('*[name="' + key + '"]'); $('<span class="help-block"><strong>' + errors[key][0] + '</strong></span>').insertAfter(el); el.closest('.form-group').addClass('has-error'); } } 
		
		
		}


	});
})(jQuery);