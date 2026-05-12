@extends('business.layouts.app')

@section('title')
  Certificate Quick Dials
@endsection
@section('keyword')
  Certificate

@endsection
@section('description')
  Find Only Certified Training Institutes, Coaching Centers near you on Quick Dials and Get Free counseling, Free Demo
  Classes, and Get Placement Assistence.
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
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Certificate
                  </button>
                </li>

                <li class="nav-item profile_success">
                </li>


              </ul>
              <div class="tab-content pt-2">



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
                </style>

                <div class="tab-pane fade show active pt-3" id="profile-edit">

                  <form class="certificate_form" id="certificateForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="business_id"
                      value="{{ old('middle_name', (isset($client)) ? $client->id : "")}}">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row">
                      <!-- pan no 1 -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Pan no</label>
                          <input type="text" name="pan_no" class="form-control"
                            value="{{ old('pan_no', (isset($client)) ? $client->pan_no : "")}}"
                            placeholder="Please pan no name">

                          @php
                            $pan_certificate = !empty($client->pan_certificate) ? json_decode($client->pan_certificate) : null;
                            $panPath = $pan_certificate->large->src ?? '';
                            $panUrl = $panPath ? asset($panPath) : '';
                            $ext = strtolower(pathinfo($panPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($panPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $panUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $panUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $panUrl }}">
                              @endif

                              <a href="{{ url('business/certificate/pan_certificate/' . $client->id) }}" class="btn btn-danger btn-sm"
                                title="Remove Award">
                                <i class="bi bi-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="pan_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>

                      <!-- ISO Certificate* -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>ISO Certificate*</label>
                          <input type="text" name="iso_no" class="form-control"
                            value="{{ old('iso_no', (isset($client)) ? $client->iso_no : "")}}"
                            placeholder="Please iso no">
                          @php
                            $isofile = !empty($client->iso_certificate) ? json_decode($client->iso_certificate) : null;
                            $isoPath = $isofile->large->src ?? '';
                            $isoUrl = $isoPath ? asset($isoPath) : '';
                            $ext = strtolower(pathinfo($isoPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($isoPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $isoUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $isoUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $isoUrl }}">
                              @endif
                              <a href="{{ url('business/certificate/iso_certificate/' . $client->id) }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="iso_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>
                      <!-- GST Certificate -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>GST No</label>
                          <input type="text" name="gst_no" class="form-control"
                            value="{{ old('gst_no', (isset($client)) ? $client->gst_no : "")}}"
                            placeholder="Please gst_no">
                          @php
                            $gstFile = !empty($client->gst_certificate) ? json_decode($client->gst_certificate) : null;
                            $gstPath = $gstFile->large->src ?? '';
                            $gstUrl = $gstPath ? asset($gstPath) : '';
                            $ext = strtolower(pathinfo($gstPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($gstPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $gstUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $gstUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $gstUrl }}">
                              @endif

                              <a href="{{ url('business/certificate/gst_certificate/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="gst_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>


                    </div>


                    <div class="row">
                      <!-- cin_no -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>CIN No</label>
                          <input type="text" name="cin_no" class="form-control"
                            value="{{ old('cin_no', (isset($client)) ? $client->cin_no : "")}}"
                            placeholder="Please cin no">
                          @php
                            $cinFile = !empty($client->cin_certificate) ? json_decode($client->cin_certificate) : null;
                            $cinPath = $cinFile->large->src ?? '';
                            $cinUrl = $cinPath ? asset($cinPath) : '';
                            $ext = strtolower(pathinfo($cinPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($cinPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $cinUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $cinUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $cinUrl }}">
                              @endif

                              <a href="{{ url('business/certificate/cin_certificate/' . $client->id) }}"
                                class="btn btn-danger btn-sm" title="Remove Award">
                                <i class="bi bi-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="cin_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>

                      <!-- msme_no -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>MSME No</label>
                          <input type="text" name="msme_no" class="form-control"
                            value="{{ old('msme_no', (isset($client)) ? $client->msme_no : "")}}"
                            placeholder="Please msme no">
                          @php
                            $msmeFile = !empty($client->msme_certificate) ? json_decode($client->msme_certificate) : null;
                            $msmePath = $msmeFile->large->src ?? '';
                            $msmeUrl = $msmePath ? asset($msmePath) : '';
                            $ext = strtolower(pathinfo($msmePath, PATHINFO_EXTENSION));
                          @endphp

                          @if($msmePath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $msmeUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $msmeUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $msmeUrl }}">
                              @endif
                              <a href="{{ url('business/certificate/msme_certificate/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="msme_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>

                      <!-- Certificate of Incorporation -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Certificate of Incorporation no</label>
                          <input type="text" name="coi_no" class="form-control"
                            value="{{ old('coi_no', (isset($client)) ? $client->coi_no : "")}}"
                            placeholder="Please Enter COI no">
                          @php
                            $coiFile = !empty($client->coi_certificate) ? json_decode($client->coi_certificate) : null;
                            $coiPath = $coiFile->large->src ?? '';
                            $coiUrl = $coiPath ? asset($coiPath) : '';
                            $ext = strtolower(pathinfo($coiPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($coiPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $coiUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $coiUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $coiUrl }}">
                              @endif

                              <a href="{{ url('business/certificate/coi_certificate/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="coi_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <!-- other_certificate1 -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Other certificate 1</label>

                          @php
                            $certificate1File = !empty($client->other_certificate1) ? json_decode($client->other_certificate1) : null;
                            $cert1Path = $certificate1File->large->src ?? '';
                            $cert1Url = $cert1Path ? asset($cert1Path) : '';
                            $ext = strtolower(pathinfo($cert1Path, PATHINFO_EXTENSION));
                          @endphp

                          @if($cert1Path)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $cert1Url }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $cert1Url }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $cert1Url }}">
                              @endif

                              <a href="{{ url('business/certificate/other_certificate1/' . $client->id) }}"
                                class="btn btn-danger btn-sm" title="Remove Award">
                                <i class="bi bi-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="other_certificate1" class="form-control"
                              accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>

                      <!-- Other Certificate 2 -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Other Certificate 2</label>

                          @php
                            $cert2File = !empty($client->other_certificate2) ? json_decode($client->other_certificate2) : null;
                            $other2Path = $cert2File->large->src ?? '';
                            $other2Url = $other2Path ? asset($other2Path) : '';
                            $ext = strtolower(pathinfo($other2Path, PATHINFO_EXTENSION));
                          @endphp

                          @if($other2Path)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $other2Url }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $other2Url }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $other2Url }}">
                              @endif
                              <a href="{{ url('business/certificate/other_certificate2/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="other_certificate2" class="form-control"
                              accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>
                      <!-- Other Certificate 3 -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Other Certificate 3</label>

                          @php
                            $other3File = !empty($client->other_certificate3) ? json_decode($client->other_certificate3) : null;
                            $other3Path = $other3File->large->src ?? '';
                            $other3Url = $other3Path ? asset($other3Path) : '';
                            $ext = strtolower(pathinfo($other3Path, PATHINFO_EXTENSION));
                          @endphp

                          @if($other3Url)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $other3Url }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $other3Url }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $other3Url }}">
                              @endif

                              <a href="{{ url('business/certificate/other_certificate3/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="other_certificate3" class="form-control"
                              accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>
                    </div>
                    <!-- <div id="pageLoader" style="display:none;">
                      <div class="loader"></div>
                    </div> -->

                  </form>







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
          alert('Max width exceeded is greater than 6000');
        }
        if (errors.maxHeight) {
          alert('Max height exceeded is greater than 6000');
        }
      }
    });    

  </script>



  <script>
    let autoSaveTimer = null;

    const form = document.getElementById('certificateForm');

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
      fetch("{{ url('business/save-certificate-auto') }}", {
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