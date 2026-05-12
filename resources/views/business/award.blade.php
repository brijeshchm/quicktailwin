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
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-edit">Award </button>
                                </li>

                                <li class="nav-item profile_success">
                                </li>


                            </ul>
                            <div class="tab-content pt-2">


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


                                    <form class="certificate_form" id="awardFrom" method="POST"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="business_id"
                                            value="{{ old('middle_name', (isset($client)) ? $client->id : "")}}">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="row">
                                            <!-- AWARD 1 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 1 *</label>
                                                    <input type="text" name="award_name1" class="form-control"
                                                        value="{{ old('award_name1', (isset($client)) ? $client->award_name1 : "")}}"
                                                        placeholder="Please Award name">

                                                    @php
                                                        $award_img1 = !empty($client->award_img1) ? json_decode($client->award_img1) : null;
                                                        $award1Path = $award_img1->large->src ?? '';
                                                        $award1Url = $award1Path ? asset($award1Path) : '';
                                                        $ext = strtolower(pathinfo($award1Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award1Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award1Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award1Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award1Url }}">
                                                            @endif

                                                            <a href="{{ url('business/award/award_img1/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm" title="Remove Award">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img1" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- AWARD 2 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 2</label>
                                                    <input type="text" name="award_name2" class="form-control"
                                                        value="{{ old('award_name2', (isset($client)) ? $client->award_name2 : "")}}"
                                                        placeholder="Please Award name 2">
                                                    @php
                                                        $award2file = !empty($client->award_img2) ? json_decode($client->award_img2) : null;
                                                        $award2Path = $award2file->large->src ?? '';
                                                        $award2Url = $award2Path ? asset($award2Path) : '';
                                                        $ext = strtolower(pathinfo($award2Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award2Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award2Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award2Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award2Url }}">
                                                            @endif
                                                            <a href="{{ url('business/award/award_img2/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img2" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- AWARD 3 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 3</label>
                                                    <input type="text" name="award_name3" class="form-control"
                                                        value="{{ old('award_name3', (isset($client)) ? $client->award_name3 : "")}}"
                                                        placeholder="Please Award name 3">
                                                    @php
                                                        $award3File = !empty($client->award_img3) ? json_decode($client->award_img3) : null;
                                                        $award3Path = $award3File->large->src ?? '';
                                                        $award3Url = $award3Path ? asset($award3Path) : '';
                                                        $ext = strtolower(pathinfo($award3Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award3Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award3Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award3Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award3Url }}">
                                                            @endif

                                                            <a href="{{ url('business/award/award_img3/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img3" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row">
                                            <!-- AWARD 4 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 4 *</label>
                                                    <input type="text" name="award_name4" class="form-control"
                                                        value="{{ old('award_name4', (isset($client)) ? $client->award_name4 : "")}}"
                                                        placeholder="Please Award name 4">
                                                    @php
                                                        $award4File = !empty($client->award_img4) ? json_decode($client->award_img4) : null;
                                                        $award4Path = $award4File->large->src ?? '';
                                                        $award4Url = $award4Path ? asset($award4Path) : '';
                                                        $ext = strtolower(pathinfo($award4Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award4Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award4Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award4Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award4Url }}">
                                                            @endif

                                                            <a href="{{ url('business/award/award_img4/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm" title="Remove Award">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img4" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- AWARD 5 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 5</label>
                                                    <input type="text" name="award_name5" class="form-control"
                                                        value="{{ old('award_name5', (isset($client)) ? $client->award_name5 : "")}}"
                                                        placeholder="Please Award name 5">
                                                    @php
                                                        $award5File = !empty($client->award_img5) ? json_decode($client->award_img5) : null;
                                                        $award5Path = $award5File->large->src ?? '';
                                                        $award5Url = $award5Path ? asset($award5Path) : '';
                                                        $ext = strtolower(pathinfo($award5Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award5Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award5Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award5Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award5Url }}">
                                                            @endif
                                                            <a href="{{ url('business/award/award_img5/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img5" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- AWARD 6 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 6</label>
                                                    <input type="text" name="award_name6" class="form-control"
                                                        value="{{ old('award_name6', (isset($client)) ? $client->award_name6 : "")}}"
                                                        placeholder="Please Award name 6">
                                                    @php
                                                        $award6File = !empty($client->award_img6) ? json_decode($client->award_img6) : null;
                                                        $award6Path = $award6File->large->src ?? '';
                                                        $award6Url = $award6Path ? asset($award6Path) : '';
                                                        $ext = strtolower(pathinfo($award6Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award6Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award6Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award6Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award6Url }}">
                                                            @endif
                                                            <a href="{{ url('business/award/award_img6/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img6" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <!-- AWARD 7 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 7 *</label>
                                                    <input type="text" name="award_name7" class="form-control"
                                                        value="{{ old('award_name7', (isset($client)) ? $client->award_name7 : "")}}"
                                                        placeholder="Please Award name 7">
                                                    @php
                                                        $award7File = !empty($client->award_img7) ? json_decode($client->award_img7) : null;
                                                        $award7Path = $award7File->large->src ?? '';
                                                        $award7Url = $award7Path ? asset($award7Path) : '';
                                                        $ext = strtolower(pathinfo($award7Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award7Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award7Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award7Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award7Url }}">
                                                            @endif

                                                            <a href="{{ url('business/award/award_img7/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm" title="Remove Award">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img7" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- AWARD 8 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 8</label>
                                                    <input type="text" name="award_name8" class="form-control"
                                                        value="{{ old('award_name8', (isset($client)) ? $client->award_name8 : "")}}"
                                                        placeholder="Please Award name 8">
                                                    @php
                                                        $award8File = !empty($client->award_img8) ? json_decode($client->award_img8) : null;
                                                        $award8Path = $award8File->large->src ?? '';
                                                        $award8Url = $award8Path ? asset($award8Path) : '';
                                                        $ext = strtolower(pathinfo($award8Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award8Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award8Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award8Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award8Url }}">
                                                            @endif
                                                            <a href="{{ url('business/award/award_img8/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img8" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- AWARD 9 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 9</label>
                                                    <input type="text" name="award_name9" class="form-control"
                                                        value="{{ old('award_name9', (isset($client)) ? $client->award_name9 : "")}}"
                                                        placeholder="Please Award name 9">
                                                    @php
                                                        $award9File = !empty($client->award_img9) ? json_decode($client->award_img9) : null;
                                                        $award9Path = $award9File->large->src ?? '';
                                                        $award9Url = $award9Path ? asset($award9Path) : '';
                                                        $ext = strtolower(pathinfo($award9Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award9Url)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award9Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award9Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award9Url }}">
                                                            @endif

                                                            <a href="{{ url('business/award/award_img9/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img9" class="form-control"
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

        // });

    </script>



    <script>
        let autoSaveTimer = null;

        const form = document.getElementById('awardFrom');

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
            fetch("{{ url('business/save-award-auto') }}", {
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
                    if (data.status) {
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