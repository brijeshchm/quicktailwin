@extends('business.business.layouts.app')
@section('title','Profile')
@section('content')

<div class="animate-fade-in max-w-5xl space-y-4 md:space-y-6"><div><h1 class="font-display text-xl font-bold md:text-3xl">

{{ $tabs[$tab] }}
</h1>


</div>

<div>

<div id="autoSaveStatus"></div>

</div>
 <div class="md:hidden"><select onchange="window.location=this.value" class="form-input h-12 bg-white text-base font-medium shadow-sm">

 @foreach($tabs as $key=>$label)

 <option value="{{ route('profile',['tab'=>$key]) }}" @selected($tab===$key)>{{ $label }}</option>@endforeach

</select>

</div>


 @if($tab==='seo')

 <form id="updateBusinessMeta" action="{{ route('updateBusiness.meta') }}" method="POST" class="card space-y-6 p-6" x-data="{title:@js($client->meta_title),description:@js($client->meta_description)}">

 @csrf

 <input type="hidden" name="redirect_tab" value="seo">

 <div><h3 class="font-display text-lg font-semibold">Search Engine Optimization</h3><p class="mt-1 text-sm text-slate-500">Control how your business appears in search results.</p></div>

 <div><label class="mb-2 flex justify-between text-sm font-medium"><span>Meta Title</span><span class="text-xs text-slate-400" x-text="title.length+'/60'" ></span></label>

 <input name="meta_title" x-model="title" maxlength="60" class="form-input auto-save-field" placeholder="Best Plumber in New York | Acme Plumbing" value="{{ old('meta_title', (isset($client)) ? $client->meta_title : "")}}"></div>



 <div><label class="mb-2 flex justify-between text-sm font-medium"><span>Meta Description</span><span class="text-xs text-slate-400" x-text="description.length+'/160'"></span></label>

 <textarea name="meta_description" x-model="description" maxlength="160" class="form-input form-textarea auto-save-field min-h-[110px]" placeholder="Acme Plumbing offers 24/7 emergency services...">{{ old('meta_description', (isset($client)) ? $client->meta_description : "")}}</textarea></div>


  <div class="space-y-2"><label class="text-sm font-medium">Business intro</label>

  <textarea name="business_intro" id="overview" rows="6" class="form-input form-textarea summernote" placeholder="Detailed history, mission, and services offered...">{{ old('business_intro', (isset($client)) ? $client->business_intro : "")}}</textarea>


</div>



 <div class="flex justify-end border-t pt-5"><button class="btn btn-primary"><i data-lucide="save" class="h-4 w-4"></i>Save SEO Details</button></div></form>

@endif
</div>
<div
    id="toast-container"
    class="pointer-events-none fixed right-4 top-4 z-[9999] flex w-full max-w-sm flex-col gap-2"
></div>

<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>

<script>
var clientId = {{ isset($client->id) ? $client->id : 'null' }};

// ── Quill editor ──
const quill = new Quill('.summernote', {
    theme: 'snow',
    placeholder: 'Detailed history, mission, and services offered...',
    modules: {
        toolbar: [
            [{ header: [1, 2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['link'],
            ['clean']
        ]
    }
});

// Keep the real hidden textarea in sync so form.serialize() captures Quill's content
 

// ── Autosave + manual submit ──
(function () {
    var form = document.getElementById('updateBusinessMeta');
    var debounceTimer = null;
    var isSaving = false;
    var lastSnapshot;

    if (!form) return;
    lastSnapshot = $(form).serialize();

    form.querySelectorAll('.auto-save-field').forEach(function (field) {
        if (field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') {
            field.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(triggerAutoSave, 1500);
            });
            field.addEventListener('blur', function () {
                clearTimeout(debounceTimer);
                triggerAutoSave();
            });
        }
        if (field.tagName === 'SELECT') {
            field.addEventListener('change', function () {
                setTimeout(triggerAutoSave, 600);
            });
        }
    });

    // Manual "Save SEO Details" button submit
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearTimeout(debounceTimer);
        saveForm(true);
    });

    window.triggerAutoSave = function () {
        saveForm(false);
    };

    function saveForm(isManual) {
        var current = $(form).serialize();
        if (!isManual && current === lastSnapshot) return; // nothing changed
        if (isSaving) return;

        isSaving = true;
        showToast('Saving...', 'info');

        var token = $('input[name=_token]').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('updateBusiness.meta') }}",
            data: current + '&client_id=' + clientId,
            headers: { 'X-CSRF-TOKEN': token },
            cache: false,
            success: function () {
                isSaving = false;
                lastSnapshot = current;
                showToast(isManual ? 'Profile saved successfully' : 'Saved', 'success');
            },
            error: function (jqXHR) {
                isSaving = false;
                showToast('❌ Validation error', 'danger');

                var response;
                try {
                    response = JSON.parse(jqXHR.responseText);
                } catch (e) {
                    alert('Something went wrong');
                    return;
                }

                if (response.errors) {
                    $('#updateBusinessMeta').find('.form-input').removeClass('has-error');
                    $('#updateBusinessMeta').find('.help-block').remove();

                    for (var key in response.errors) {
                        if (response.errors.hasOwnProperty(key)) {
                            var el = $('#updateBusinessMeta').find('*[name="' + key + '"]');
                            $('<span class="help-block"><strong>' + response.errors[key][0] + '</strong></span>').insertAfter(el);
                            el.closest('.form-input').addClass('has-error');
                        }
                    }
                } else {
                    alert('Something went wrong');
                }
            }
        });
    }
})();

// ── Status indicator ──
var successModalInstance = null;

function isNumberKey(e) {
    var a = e.keyCode || e.charCode;
    return !!(a >= 48) && !!(a <= 57);
}


/**
 * Usage: showToast('Favorite lead updated', 'success');
 *        showToast('Something went wrong', 'error');
 */
function showToast(message, type = 'success', duration = 3000) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const styles = {
        success: {
            bg: 'bg-emerald-50 border-emerald-200 text-emerald-800',
            icon: `<svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>`,
        },
        error: {
            bg: 'bg-red-50 border-red-200 text-red-800',
            icon: `<svg class="h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>`,
        },
    };

    const style = styles[type] ?? styles.success;

    const toast = document.createElement('div');
    toast.className = `pointer-events-auto flex items-center gap-3 rounded-xl border ${style.bg} px-4 py-3 shadow-lg transition-all duration-300 ease-out translate-x-4 opacity-0`;
    toast.innerHTML = `
        ${style.icon}
        <p class="flex-1 text-sm font-medium">${message}</p>
        <button type="button" class="shrink-0 rounded p-1 text-current/60 hover:text-current" aria-label="Dismiss">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    `;

    container.appendChild(toast);

    // animate in
    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-4', 'opacity-0');
    });

    const dismiss = () => {
        toast.classList.add('translate-x-4', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    };

    toast.querySelector('button').addEventListener('click', dismiss);
    setTimeout(dismiss, duration);
}

</script>

 

@endsection