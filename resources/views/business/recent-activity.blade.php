@extends('business.layouts.app')
@section('title')
    Recent Activity Quick Dials
@endsection
@section('keyword')
    Recent Activity
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
                                        data-bs-target="#profile-edit">Recent Activity </button>
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
<style>
/* ═══════════════════════════════════════════
   RECENT ACTIVITY CARD DESIGN
═══════════════════════════════════════════ */
.recent-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    transition: box-shadow 0.2s ease, transform 0.2s ease;
    height: 100%;
}
.recent-card:hover {
    box-shadow: 0 8px 24px -8px rgba(0, 0, 0, 0.1);
}

/* Header */
.recent-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom: 14px;
    margin-bottom: 16px;
    border-bottom: 1px dashed #e5e7eb;
}
.recent-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    font-weight: 700;
    font-size: 13px;
}
.recent-title {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #1f2937;
}

/* Media area */
.recent-media {
    margin-bottom: 16px;
}

/* Upload dropzone (when no image) */
.upload-dropzone {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 160px;
    padding: 20px;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    background: #f9fafb;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}
.upload-dropzone:hover {
    border-color: #6366f1;
    background: #eef2ff;
}
.upload-icon {
    font-size: 32px;
    color: #6366f1;
    margin-bottom: 8px;
}
.upload-text {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
}
.upload-hint {
    font-size: 11px;
    color: #9ca3af;
}

/* Preview (when image exists) */
.media-preview {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
}
.media-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}
.pdf-wrap {
    position: relative;
}
.pdf-box {
    width: 100%;
    height: 200px;
    display: block;
}
.view-pdf {
    position: absolute;
    bottom: 8px;
    left: 8px;
    font-size: 12px;
    border-radius: 8px;
    backdrop-filter: blur(4px);
    background: rgba(255, 255, 255, 0.9) !important;
    border: 1px solid #e5e7eb !important;
}

/* Remove button (top-right of preview) */
.btn-remove {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(220, 38, 38, 0.95);
    color: #ffffff;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    backdrop-filter: blur(4px);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}
.btn-remove:hover {
    background: #b91c1c;
    color: #ffffff;
    transform: scale(1.05);
}

/* Modern form fields */
.recent-fields {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.form-group-modern {
    display: flex;
    flex-direction: column;
}
.form-label-modern {
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.form-control-modern {
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 14px;
    color: #1f2937;
    background: #ffffff;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.form-control-modern:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
    outline: none;
}
.form-control-modern::placeholder {
    color: #9ca3af;
}
textarea.form-control-modern {
    resize: vertical;
    min-height: 80px;
}

/* Mobile */
@media (max-width: 576px) {
    .recent-card { padding: 14px; }
    .media-img, .pdf-box { height: 180px; }
    .upload-dropzone { min-height: 140px; }
}
</style>

                                <div class="tab-pane fade show active pt-3" id="profile-edit">


                                    <form class="certificate_form" id="awardFrom" method="POST"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="business_id"
                                            value="{{ old('business_id', (isset($client)) ? $client->id : "")}}">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                  


<div class="row">
    @for($i = 1; $i <= 6; $i++)
        @php
            // Dynamic field names — works for recent_img1...recent_img6
            $imgField   = "recent_img{$i}";
            $nameField  = "recent_name{$i}";
            $paraField  = "recent_paragraph{$i}";

            // Decode stored image JSON
            $recentImg  = !empty($client->$imgField) ? json_decode($client->$imgField) : null;
            $recentPath = $recentImg->large->src ?? '';
            $recentUrl  = $recentPath ? asset($recentPath) : '';
            $ext        = strtolower(pathinfo($recentPath, PATHINFO_EXTENSION));

            // First one is required, rest optional
            $isRequired = ($i === 1);

            // Badge number (01, 02, 03...)
            $badgeNum   = str_pad($i, 2, '0', STR_PAD_LEFT);
        @endphp

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="recent-card">

                {{-- ── HEADER ── --}}
                <div class="recent-card-header">
                    <span class="recent-badge">{{ $badgeNum }}</span>
                    <h6 class="recent-title">
                        Recent Activity {{ $i }}
                        @if($isRequired) <span class="text-danger">*</span> @endif
                    </h6>
                </div>

                {{-- ── IMAGE / FILE AREA ── --}}
                <div class="recent-media">
                    @if($recentPath)
                        <div class="media-preview">
                            @if($ext === 'pdf')
                                <div class="pdf-wrap">
                                    <embed src="{{ $recentUrl }}" type="application/pdf" class="pdf-box">
                                    <a href="{{ $recentUrl }}" target="_blank" class="btn btn-light btn-sm view-pdf">
                                        <i class="bi bi-eye"></i> View PDF
                                    </a>
                                </div>
                            @else
                                <img loading="lazy"
                                     src="{{ $recentUrl }}"
                                     alt="Recent activity {{ $i }}"
                                     class="media-img">
                            @endif

                            <a href="{{ url("business/recent/{$imgField}/{$client->id}") }}"
                               class="btn-remove"
                               title="Remove"
                               >
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    @else
                        <label for="recent_img{{ $i }}_input" class="upload-dropzone">
                            <i class="bi bi-cloud-arrow-up upload-icon"></i>
                            <span class="upload-text">Click to upload</span>
                            <small class="upload-hint">JPG, PNG, WEBP — max 5MB</small>
                            <input type="file"
                                   id="recent_img{{ $i }}_input"
                                   name="{{ $imgField }}"
                                   class="d-none preview-input"
                                   accept=".jpg,.jpeg,.png,.webp"
                                   @if($isRequired) required @endif>
                        </label>
                    @endif
                </div>

                {{-- ── FIELDS ── --}}
                <div class="recent-fields">
                    <div class="form-group-modern">
                        <label class="form-label-modern">Activity Name</label>
                        <input type="text"
                               name="{{ $nameField }}"
                               class="form-control form-control-modern"
                               value="{{ old($nameField, $client->$nameField ?? '') }}"
                               placeholder="e.g. Event title {{ $i }}"
                               @if($isRequired) required @endif>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">Description</label>
                        <textarea name="{{ $paraField }}"
                                  class="form-control form-control-modern"
                                  rows="3"
                                  placeholder="Briefly describe this activity...">{{ old($paraField, $client->$paraField ?? '') }}</textarea>
                    </div>
                </div>

            </div>
        </div>
    @endfor
</div>



                                  


                                    

 


                                   

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
            fetch("{{ url('business/save-recent-activity-auto') }}", {
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