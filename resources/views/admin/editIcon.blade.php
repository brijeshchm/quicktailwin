<?php echo View::make('admin/header');
 
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Icons : <?php echo $edit_data->keyword; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
			<div class="row">
                <div class="col-lg-12">
					@if(Session::has('success_msg'))
						<div class="alert alert-success">
							{{Session::get('success_msg')}}
						</div>
					@endif
					@if(Session::has('danger'))
						<div class="alert alert-danger">
							{{Session::get('danger')}}
						</div>
					@endif					
                    <div class="panel panel-info">
                        <div class="panel-body">
							<div class="nc-form row form-group">
								<form method="POST" onsubmit="return assignedKeywordController.keywordIconUpdate(this,<?php echo $edit_data->id ?>)" class="ng-pristine ng-valid" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="col-md-12">
										<h4><u>Icon Keyword:</u></h4>
									</div>				
									  
								  
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="icon">Icon:</label>
										<?php
										if(isset($edit_data) && $edit_data->icon !=''){
										$data = json_decode($edit_data->icon, true);
										 ?>
										 <img loading="lazy" src="<?php echo asset($data['src'])?>" width="100px" >
										<a href="/developer/keyword/icon_del/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5"><i class="fa fa-trash" aria-hidden="true" style="color:red"></i></a>
										<input type="hidden" class="" name="icon_del" value="{{ $edit_data->icon }}" >										
										<?php  }else{ ?>
									 
										<input type="file" class="form-control" name="icon" placeholder="Enter Icon" accept=".jpeg,.jpg,.png,.svg,.webp">
									 
										<?php  } ?>
										@if ($errors->has('icon'))
											<span class="help-block">
												<strong>{{ $errors->first('icon') }}</strong>
											</span>
										@endif
									</div>
									 
									
							 
									
									
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="" style="visibility:hidden">Submit:</label>
										<input type="submit" class="btn btn-info btn-block form-control">
									</div>
								</form>
							</div>
						 
							 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

			 	
			
				 <div class="row">
                <div class="col-lg-12">
					@if(Session::has('success_msg'))
						<div class="alert alert-success">
							{{Session::get('success_msg')}}
						</div>
					@endif
					@if(Session::has('danger'))
						<div class="alert alert-danger">
							{{Session::get('danger')}}
						</div>
					@endif					
                    <div class="panel panel-info">
                        <div class="panel-body">
							<div class="nc-form row form-group">
 <form id="bannerUploadForm" method="POST"
      action="{{ route('developer.banners.upload', $edit_data->id) }}"
      enctype="multipart/form-data">
    @csrf
    <div class="col-md-12">
        <h4><u>Banner Keyword:</u></h4>
    </div>

    {{-- Existing banners --}}
    <div class="col-md-12">
        <div class="row" id="existingBanners">
            @forelse($banner_data as $banner)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3" id="banner-{{ $banner->id }}">
                    <div class="banner-box" style="border:1px solid #eee;padding:8px;border-radius:6px;">
                        <img src="{{ asset($banner->image_path) }}" loading="lazy"
                             style="width:100%;height:100px;object-fit:cover;border-radius:4px;">

                        <select class="form-control form-control-sm mt-2 select2-client banner-client-select"
                                data-id="{{ $banner->id }}">
                            <option value="">-- No client linked --</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->business_slug }}"
                                    {{ $banner->client_slug === $c->business_slug ? 'selected' : '' }}>
                                    {{ $c->business_name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="d-flex gap-1 mt-2">
                            <button type="button" class="btn btn-success btn-sm flex-fill"
                                    onclick="updateBannerClient({{ $banner->id }})">
                                <i class="fa fa-save"></i> Save
                            </button>
                            <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteBanner({{ $banner->id }})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12"><p class="text-muted">No banners uploaded yet.</p></div>
            @endforelse
        </div>
    </div>

    {{-- Multiple upload --}}
    <div class="col-md-12 mt-3">
        <label for="banners">Upload Banners (multiple):</label>
        <input type="file" class="form-control" name="banners[]" id="banners"
               multiple accept=".jpeg,.jpg,.png,.svg,.webp">
        <small class="text-muted">Max 10 files, 2MB each. Link each banner to a client below.</small>
        <div id="bannerPreview" class="row mt-3"></div>
    </div>

    <div class="col-md-12 mt-3">
        <button type="submit" class="btn btn-info">
            <i class="fa fa-upload"></i> Upload Banners
        </button>
    </div>
</form>

{{-- Pass clients to JS as JSON for dynamic preview selects --}}
<script>
    window.clientsList = @json($clients);
</script>



								 
						
							</div>
						 
							 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

			 	
		 
        </div>
 
<script>
// $(document).ready(function () {

    // Initialize Select2 on existing banner selects
    // function initClientSelect(elem) {
    //     $(elem).select2({
    //         placeholder: 'Search & select client...',
    //         allowClear: true,
    //         width: '100%'
    //     });
    // }

    // $('.select2-client').each(function () { initClientSelect(this); });

    // ============ Build client <option> list for previews ============
    function buildClientOptions() {
        let html = '<option value="">-- No client linked --</option>';
        (window.clientsList || []).forEach(c => {
            html += `<option value="${c.business_slug}">${escapeHtml(c.business_name)}</option>`;
        });
        return html;
    }

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, m => ({
            '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
        }[m]));
    }

    // ============ Live Preview ============
    document.getElementById('banners').addEventListener('change', function (e) {
        const preview = document.getElementById('bannerPreview');
        preview.innerHTML = '';
        if (!e.target.files.length) return;

        Array.from(e.target.files).forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = ev => {
                const card = document.createElement('div');
                card.className = 'col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3';
                card.innerHTML = `
                    <div style="border:1px dashed #aaa;padding:8px;border-radius:6px;background:#fafafa;">
                        <img src="${ev.target.result}"
                             style="width:100%;height:100px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">
                        <small class="d-block text-truncate mt-1" title="${escapeHtml(file.name)}">
                            <strong>#${index + 1}</strong> ${escapeHtml(file.name)}
                        </small>
                        <select name="banner_clients[]"
                                class="form-control form-control-sm mt-2 select2-client preview-client-select ">
                            ${buildClientOptions()}
                        </select>
                    </div>`;
                preview.appendChild(card);
                // initClientSelect(card.querySelector('select'));
            };
            reader.readAsDataURL(file);
        });
    });

    // ============ Form Submit ============
    document.getElementById('bannerUploadForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const btn = form.querySelector('button[type=submit]');
        const orig = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Uploading...';

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json().then(d => ({ ok: res.ok, d })))
        .then(({ ok, d }) => {

		 
            if (d.data.status === 'success') {
               
				$('#messagemodel .modal-title').text("Uplaod Image");	
				$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.message+"</div>");			
				$('#messagemodel').modal({keyboard:false,backdrop:'static'});
				$('#messagemodel').css({'width':'100%'});
                location.reload();
            } else {
                const errs = d.errors ? Object.values(d.errors).flat().join('\n') : d.message;
                alert('Error:\n' + errs);
            }
        })
        .catch(err => alert('Network error: ' + err))
        .finally(() => { btn.disabled = false; btn.innerHTML = orig; });
    });
// });

// ============ Update Client for Existing Banner ============
function updateBannerClient(id) {
    const select = document.querySelector(`.banner-client-select[data-id="${id}"]`);
    const slug = select.value;

    fetch(`/developer/keyword/banner/${id}/client`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ client_slug: slug })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {

			$('#messagemodel .modal-title').text("Client slug Image");	
				$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.message+"</div>");			
				$('#messagemodel').modal({keyboard:false,backdrop:'static'});
				$('#messagemodel').css({'width':'100%'});


            $(select).next('.select2').find('.select2-selection').css('border-color', '#28a745');
            setTimeout(() => {
                $(select).next('.select2').find('.select2-selection').css('border-color', '');
            }, 1500);
        } else {
            alert(data.message || 'Failed to save');
        }
    })
    .catch(err => alert('Error: ' + err));
}

// ============ Delete Banner ============
function deleteBanner(id) {
    if (!confirm('Delete this banner?')) return;
    fetch(`/developer/keyword/banner/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success'){
			
			$('#messagemodel .modal-title').text("Client Delete banner Image");	
				$('#messagemodel .modal-body').html("<div class='alert alert-success'>"+data.message+"</div>");			
				$('#messagemodel').modal({keyboard:false,backdrop:'static'});
				$('#messagemodel').css({'width':'100%'});

			document.getElementById(`banner-${id}`).remove();
}else{ alert(data.message); }
    });
}



// $('.select2-client').select2({
//     ajax: {
//         url: '/api/clients/search',
//         dataType: 'json',
//         delay: 250,
//         data: params => ({ q: params.term }),
//         processResults: data => ({ results: data.map(c => ({ id: c.business_slug, text: c.business_name })) })
//     },
//     minimumInputLength: 2,
//     placeholder: 'Search client...',
//     allowClear: true
// });
</script> 
         

<?php echo View::make('admin/footer'); ?>
