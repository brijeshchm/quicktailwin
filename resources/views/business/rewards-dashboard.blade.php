@extends('business.layouts.app')
@section('title')
    Rewards QuickDials
@endsection
@section('keyword')
    Rewards
@endsection
@section('description')
    Find Only Certified Training Institutes, Coaching Centers near you on QuickDials and Get Free counseling, Free Demo
    Classes, and Get Placement Assistence.
@endsection
@section('content')

    <link rel="stylesheet" href="{{ asset('drag_drop/jquery.ezdz.min.css')}}">
    <main id="main" class="main">
    
 
<style>
    .bd-hero {
        background-color: #0f172a; /* slate-900 */
        color: #f8fafc;
        padding: 3rem 0;
        border-bottom: 1px solid #1e293b;
    }
    .bd-icon-amber { color: #f59e0b; }
    .bd-stat-icon {
        background-color: #f8fafc;
        border-radius: .75rem;
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bd-card-offset { margin-top: -2rem; }
    .bd-row-hover:hover { background-color: #f8fafc; }
    .bd-quote {
        background-color: #f1f5f9;
        border-radius: .5rem;
        padding: .75rem 1rem;
        font-style: italic;
        font-size: .9rem;
        color: #475569;
    }
    .bd-ping {
        display: inline-block;
        width: .75rem;
        height: .75rem;
        background-color: #3b82f6;
        border-radius: 50%;
        position: relative;
    }
    .bd-ping::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background-color: #60a5fa;
        opacity: .75;
        animation: bd-ping-anim 1.5s cubic-bezier(0,0,0.2,1) infinite;
    }
    @keyframes bd-ping-anim {
        75%, 100% { transform: scale(2); opacity: 0; }
    }
    .badge-soft-slate  { background-color: #f1f5f9; color: #475569; }
    .badge-soft-blue   { background-color: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-soft-green  { background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .badge-soft-amber  { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
</style>
 
 
<div style="background-color:#f8fafc; min-height:100vh;">

    {{-- Hero --}}
    <div class="bd-hero">
        <div class="container" style="max-width: 1140px;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-bar-chart-line bd-icon-amber fs-4"></i>
                <h1 class="fw-bold fs-2 mb-0" style="font-family: 'Georgia', serif;">Business Dashboard</h1>
            </div>
            <p class="text-secondary mb-0">Manage your services, enquiries, and performance.</p>
        </div>
    </div>

    <div class="container py-4 bd-card-offset" style="max-width: 1140px;">

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="alert alert-success" id="flash-message">{{ session('success') }}</div>
        @endif

        {{-- Stats Row --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-lg">                 
                <div class="card shadow-sm border-0 bg-white h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-secondary small mb-1">Total Revenue</p>
                                <h3 class="fw-bold mb-0" style="color:#0f172a;">{{ number_format($totalRevenue, 0) }}</h3>
                               
                            </div>
                            <div class="bd-stat-icon">
                                <i class="bi bi-graph-up-arrow" style="color: #10b981; font-size: 1.25rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-sm-6 col-lg">
               

                <div class="card shadow-sm border-0 bg-white h-100">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-secondary small mb-1">Refund Coins</p>
                                <h3 class="fw-bold mb-0" style="color:#0f172a;">{{ $rewardBalance }}</h3>
                                <p class="text-muted small mb-0 mt-1">Refunded from redemptions</p>
                            </div>
                            <div class="bd-stat-icon">
                                <i class="bi bi-coin" style="color: #f59e0b; font-size: 1.25rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg">
                

                <div class="card shadow-sm border-0 bg-white h-100">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="text-secondary small mb-1">Avg Rating</p>
                <h3 class="fw-bold mb-0" style="color:#0f172a;">{{ number_format($averageRating, 1) }}</h3>
                @isset($completedEnquiries)
                    <p class="text-muted small mb-0 mt-1">{{ $completedEnquiries }}</p>
                @endisset
            </div>
            <div class="bd-stat-icon">
                <i class="bi bi-star-fill" style="color: #f59e0b; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>
</div>
            </div>
            <div class="col-12 col-sm-6 col-lg">
               
                <div class="card shadow-sm border-0 bg-white h-100">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="text-secondary small mb-1">Pending</p>
                <h3 class="fw-bold mb-0" style="color:#0f172a;">{{ $pendingEnquiries }}</h3>
             
            </div>
            <div class="bd-stat-icon">
                <i class="bi bi-clock" style="color: #3b82f6; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>
</div>

            </div>
            <div class="col-12 col-sm-6 col-lg">
               
         <div class="card shadow-sm border-0 bg-white h-100">
    <div class="card-body p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="text-secondary small mb-1">Completed</p>
                <h3 class="fw-bold mb-0" style="color:#0f172a;">{{ $completedEnquiries }}</h3>
             
            </div>
            <div class="bd-stat-icon">
                <i class="bi bi-check-circle" style="color: #64748b; font-size: 1.25rem;"></i>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>

        <div class="row g-4">
            {{-- Main column --}}
            <div class="col-lg-8">

                {{-- Action Required --}}
                @if ($pendingList->count() > 0)
                <div class="card shadow-sm mb-4" style="border-top: 4px solid #3b82f6; border-color:#bfdbfe;">
                    <div class="card-header" style="background-color:#eff6ff;">
                        <h5 class="mb-0 d-flex align-items-center gap-2">
                            <span class="bd-ping"></span>
                            Action Required ({{ $pendingList->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach ($pendingList as $enquiry)
                            <div class="list-group-item p-3 p-md-4 d-flex flex-column flex-sm-row justify-content-between gap-3 bd-row-hover">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="fw-semibold">{{ $enquiry->customer->name ?? 'Customer' }}</span>
                                        <span class="text-muted small">requested</span>
                                    </div>
                                    <div class="fw-medium text-primary mb-2">{{ $enquiry->service_name }}</div>
                                    <p class="bd-quote mb-0">"{{ $enquiry->description }}"</p>
                                </div>
                                <div class="d-flex flex-sm-column align-items-center align-items-sm-end justify-content-between gap-2 flex-shrink-0">
                                    <div class="fw-bold fs-5">₹{{ $enquiry->cost }}</div>
                                    <form action="{{ route('business.enquiries.accept', $enquiry->id) }}" method="POST" class="js-action-form">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Accept Job</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- In Progress --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">In Progress ({{ $activeList->count() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($activeList->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($activeList as $enquiry)
                            <div class="list-group-item p-3 p-md-4 d-flex flex-column flex-sm-row justify-content-between gap-3 bd-row-hover">
                                <div>
                                    <div class="fw-semibold mb-1">{{ $enquiry->service_name }}</div>
                                    <div class="text-muted small mb-2">Customer: {{ $enquiry->customer->name ?? 'Customer' }}</div>
                                </div>
                                <div class="d-flex flex-sm-column align-items-center align-items-sm-end justify-content-between flex-shrink-0">
                                    <form action="{{ route('business.enquiries.complete', $enquiry->id) }}" method="POST" class="js-action-form">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="bi bi-check-circle me-1"></i> Mark Complete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="p-4 text-center text-muted">No active jobs.</div>
                        @endif
                    </div>
                </div>

                {{-- Reward Bookings --}}
                <div class="card shadow-sm" style="border-top: 4px solid #f59e0b;">
                    <div class="card-header" style="background-color:#fffbeb;">
                        <h5 class="mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-gift text-warning"></i>
                            Reward Bookings ({{ $rewardPendingList->count() }})
                        </h5>
                        <p class="text-muted small mb-0">
                            Free services customers booked with coins. Mark complete when done; you receive your reward coins once the customer confirms.
                        </p>
                    </div>
                    <div class="card-body p-0">
                        @if ($rewardPendingList->count() > 0 || $rewardAwaitingList->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($rewardPendingList as $r)
                            <div class="list-group-item p-3 p-md-4 d-flex flex-column flex-sm-row justify-content-between gap-3 bd-row-hover">
                                <div>
                                    <div class="fw-semibold mb-1">{{ $r->item_name }}</div>
                                    <div class="text-muted small">
                                        Customer: {{ $r->customer->name ?? 'Customer' }}{{ $r->city ? ' • ' . $r->city : '' }}
                                    </div>
                                    <div class="small mt-1 d-flex align-items-center gap-1" style="color:#b45309;">
                                        <i class="bi bi-coin"></i> {{ $r->credit_coins }} reward coins on confirmation
                                    </div>
                                </div>
                                <div class="d-flex flex-sm-column align-items-center align-items-sm-end justify-content-between flex-shrink-0">
                                    <form action="{{ route('business.redemptions.complete', $r->id) }}" method="POST" class="js-action-form">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="bi bi-check-circle me-1"></i> Mark Complete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach

                            @foreach ($rewardAwaitingList as $r)
                            <div class="list-group-item p-3 p-md-4 d-flex flex-column flex-sm-row justify-content-between gap-3" style="background-color:#f8fafc;">
                                <div>
                                    <div class="fw-semibold mb-1">{{ $r->item_name }}</div>
                                    <div class="text-muted small">Customer: {{ $r->customer->name ?? 'Customer' }}</div>
                                </div>
                                <div class="d-flex align-items-center flex-shrink-0">
                                    <span class="badge badge-soft-blue fw-normal">
                                        <i class="bi bi-clock me-1"></i> Awaiting customer confirmation
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="p-4 text-center text-muted">No reward bookings.</div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex align-items-center gap-2">
                        <i class="bi bi-chat-dots text-muted"></i>
                        <h6 class="mb-0">Recent Activity</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @if($recentEnquiries)
                            @foreach ($recentEnquiries as $enquiry)
                            <div class="list-group-item p-3 small">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <span class="fw-medium text-truncate" style="max-width: 70%;">{{ $enquiry->kw_text }}</span>
                                
                                    @php
                                    $status = $enquiry->assign_status;
                                    @endphp
                                    @switch($status)
                                    @case('pending')
                                    <span class="badge badge-soft-slate fw-normal">Pending</span>
                                    @break
                                    @case('accepted')
                                    <span class="badge badge-soft-blue fw-normal">Active</span>
                                    @break
                                    @case('completed')
                                    <span class="badge badge-soft-green fw-normal">Done</span>
                                    @break
                                    @case('reviewed')
                                    <span class="badge badge-soft-amber fw-normal">Rated</span>
                                    @break
                                    @default
                                    <span class="badge bg-secondary">{{ $status }}</span>
                                    @endswitch
                                </div>
                                <div class="d-flex justify-content-between text-muted">
                                    <span>{{ $enquiry->customer->name ?? 'Customer' }}</span>
                                    <span>₹{{ $enquiry->assign_cost }}</span>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Submit accept/complete forms via fetch so the UI feels instant (no full page reload),
// mirroring the optimistic-toast behavior from the original React mutations.
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-action-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = form.querySelector('button');
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Please wait...';

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: new FormData(form),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.reload(); // simplest reliable refresh of all lists/stats
                } else {
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                    alert(data.message || 'Action failed');
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                alert('Action failed. Please try again.');
            });
        });
    });

    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => flash.remove(), 4000);
    }
});
</script>


















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