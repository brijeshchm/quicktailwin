@extends('business.layouts.app')
@section('title')
Gallary Picture Quick Dials
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on Estivaledge and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
@endsection
@section('content')	
  <link rel="stylesheet" href="{{ asset('drag_drop/jquery.ezdz.min.css')}}">
  <main id="main" class="main">
    <section class="section profile">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Gallery Picture</button>
                </li>
              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                  <!-- Profile Edit Form --> 
                    <?php if(!empty($client->pictures)):
                    $picture = unserialize($client->pictures);
                 
                    for($i=0;$i<21;$i++){
                    if(!isset($picture[$i])){
                    $picture[$i]['large']['name'] = '';
                    }
                    }
                    else:
                    for($i=0;$i<21;$i++){
                    $picture[$i]['large']['name'] = '';
                    }
                    endif; ?>
                  <form  id="imageform" method="post" enctype="multipart/form-data">
                     {{csrf_field()}}
                     <input type="hidden" name="business_id" value="{{$client->id}}">
                    <div class="row mb-3">
                        <?php for($i=0;$i<21;$i++){

                          
                      ?>
                      <div class="col-md-4 col-lg-4" id="image{{$i+1}}">
                      @if(empty($picture[$i]['large']['name']))
                      <input type="file" class="form-control fff" name="image{{$i+1}}" accept=".jpg,.jpeg,.png,.webp,.svg">
                      
                      @endif
                      <span class="img-help">
                        @if(isset($picture[$i]['large']['src'])&&!empty($picture[$i]['large']['src']))
                        <img loading="lazy" src="{{asset('/'.$picture[$i]['large']['src'])}}" style="height:75px;width:75px;">
                        <a href="javascript:void(0)" class="remove-thumbnail btn btn-danger btn-sm" data-srno="image{{$i+1}}" title="remove"><i class="bi bi-trash" aria-hidden="true"></i></a>
                        @endif
                      </span>
                       <div class="pt-2"></div>                        
                      </div>
                      <?php  } ?>
                    <!-- <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="fourth_form_submit" value="Save &amp; Exit">Save Changes</button>
                    </div> -->



                      <!-- <div id="pageLoader" style="display:none;">
                      <div class="loader"></div>
                    </div> -->


                  </form><!-- End Profile Edit Form -->
                </div>
              </div><!-- End Bordered Tabs -->
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  
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
          alert('Max width exceeded');
        }
        if (errors.maxHeight) {
          alert('Max height exceeded');
        }
      }
    });

    // });

  </script>



  <script>
    let autoSaveTimer = null;

    const form = document.getElementById('imageform');

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
      fetch("{{ url('business/saveGallary') }}", {
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