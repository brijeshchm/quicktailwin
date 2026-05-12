@extends('business.layouts.app')
@section('title')
Profile Logo Quick Dials
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on Quick Dials and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
@endsection
@section('content')	
  <link rel="stylesheet" href="{{ asset('drag_drop/jquery.ezdz.min.css')}}">
  <main id="main" class="main">
    
                <style>
                  .help-block {
                    color: #ff0000;
                    position: relative;

                    margin-top: 61px;
                    display: block;
                    margin-left: -207px;
                  }

                  .certificate_form img {

                    width: 120px;
                  }
                </style>
                <style>
                  .award-box {
                    border: 1px solid #e0e0e0;
                    padding: 12px;
                    border-radius: 6px;
                    margin-bottom: 15px;
                    height: 215px;

                  }

                  .award-box label {
                    font-weight: 600;
                    margin-bottom: 6px;
                    display: block;
                  }

                  .award-preview img {
                    max-width: 100px;
                    border: 1px solid #ddd;
                    padding: 5px;
                  }

                  .pdf-box {
                    width: 100px;
                    height: 100px;
                    border: 1px solid #ddd;
                  }

                  .btn-sm {
                    height: 34px;
                  }
.profile .profile-edit img {
    max-width: 126px;
}

                  .logo-div {
    position: relative;
    width: 150px;
    height: 100px;
    font: bold 24px arial;
    line-height: 25px;
    color: lightgray;
    text-align: center;
    border: 10px dotted lightgray;
    border-radius: 20px;
    margin-top: 16px;
    display: flex;
    gap: 40px;
}
                </style>

    <section class="section profile">
      <div class="row">        
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body pt-3">            
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Profile Logo & Banner </button>
                </li>
                <li class="nav-item profile_success"></li>
              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">    
                  <!-- onsubmit="return profileController.saveProfileLogo(this,<?php echo (isset($client->id)? $client->id:""); ?>)"                   -->
              <form class="profile-logo" id="profileLogo" action="" method="POST" enctype="multipart/form-data" >
                            {{csrf_field()}}
              <input type="hidden" name="business_id" value="{{$client->id}}">
              <div class="row mb-3{{ $errors->has('logo') ? ' has-error' : '' }}">
              <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Company Logo </label>
              <div class="col-md-8 col-lg-9 ">
                         
              <?php
              $image = '#';
              if(!empty($client->logo)){
             
              $logo = unserialize($client->logo);            							
              $image = $logo['large']['src'];
              ?>
               <div class="logo-div"> 
						 <img loading="lazy" src="<?php echo asset('/'.$image); ?>" alt="Profile">
						<a href="{{url('business/profileLogo/logoDel/'.$client->id)}}" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
            </div>
						<?php  }else{ ?>                        
            <input type="file" class="form-control" name="logo" accept=".jpg,.jpeg,.png,.svg,.webp">
            @if ($errors->has('logo'))
						<span class="help-block">
							<strong><?php
								foreach ($errors->get('logo') as $message) {
									echo $message."<br>";
								}
							?></strong>
						</span>
					@endif
          <?php  } ?>
          </div>
                    </div>
                    <div class="row mb-3 {{ $errors->has('profile_pic') ? ' has-error' : '' }}">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Busness Banner</label>
                      <div class="col-md-8 col-lg-9">
                        <?php	
                        if(!empty($client->profile_pic)){
                        $profile_pic = unserialize($client->profile_pic);
                        ?>	
                        <div class="logo-div"> 
                        <img loading="lazy" src="<?php echo asset('/'.$profile_pic['large']['src']); ?>" alt="Profile">
                        <a href="{{url('business/profileLogo/profilePicDel/'.$client->id)}}" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                        <?php  }else{ ?>
                        <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept=".jpg,.jpeg,.png,.svg">
                        	@if ($errors->has('profile_pic'))
                      <span class="help-block">
                        <strong><?php
                          foreach ($errors->get('profile_pic') as $message) {
                            echo $message."<br>";
                          }
                        ?></strong>
                      </span>
                    @endif
                        <?php  } ?>
                      </div>
                    </div>

                    <!-- <div class="text-center">
                        <input type="hidden" name="profile_logo" value="profileLogo">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div> -->

                      <!-- <div id="pageLoader" style="display:none;">
                      <div class="loader"></div>
                    </div> -->
                  </form>

                </div>

                 
                
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>
  </main>


  <script type="text/javascript" src="{{asset('drag_drop/jquery-3.1.1.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('drag_drop/jquery.ezdz.min.js')}}"></script>
  <script>


    $('input[type="file"]').ezdz({
      text: 'Drag & Drop Image',
      validators: {
        maxWidth: 6000,
        maxHeight: 6000
      },
      reject: function (file, errors) {

        if (errors.mimeType) {
          alert(file.name + ' must be an image.');
        }
        if (errors.maxWidth) {
          alert('Max width exceeded is greater than 6000');
        }
        if (errors.maxHeight) {
          alert('Max height exceeded is greater than 6000');
        }
      }
    });

    // });

  </script>


  
  <script>
    let autoSaveTimer = null;

    const form = document.getElementById('profileLogo');

    form.addEventListener('change', function () {
      clearTimeout(autoSaveTimer);

      autoSaveTimer = setTimeout(() => {
        autoSaveForm();
      }, 800); // debounce
    });
    const clientId = "{{ isset($client->id) ? $client->id : '' }}";

    function autoSaveForm() {

      const formData = new FormData(form);
      showLoader();
      fetch("{{ url('business/saveProfileLogo') }}", {
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
      })
        .then(async (res) => {
          console.log(res);
          if (!res.ok) {
            // Validation error (422)
            const errorData = await res.json();
            throw errorData;
          }

          return res.json();
        })
        .then(data => {
          console.log(data.status)
          if (data.status) {

            console.log('Auto-saved ✔');
            hideLoader();
            if (!form.dataset.saved) {
              form.dataset.saved = "true";
              setTimeout(() => {
                // form.reset();              
                // form.dataset.saved = "";    
              }, 500);
            }


            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Successfully");
            $('#messaged .modal-body').html("<div class='alert alert-success'>" + data.msg + "</div>");
            $('#messaged').modal({ keyboard: false, backdrop: 'static' });
            $('#messaged').css({ 'width': '100%' });
            setInterval(function () {
              $("#messaged").modal("hide");
            }, 3000);

          } else {
            hideLoader();
            console.warn('Auto-save failed');
          }
        })
        .catch((err) => {

          hideLoader();

          if (err.errors) {

            let errorHtml = "<div class='alert alert-danger'><ul>";

            Object.keys(err.errors).forEach(function (key) {
              errorHtml += "<li>" + err.errors[key][0] + "</li>";
            });

            errorHtml += "</ul></div>";

            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Validation Error");
            $('#messaged .modal-body').html(errorHtml);

          } else {
            console.error("Unexpected Error:", err);
          }


        });
    }
  </script>

 @endsection