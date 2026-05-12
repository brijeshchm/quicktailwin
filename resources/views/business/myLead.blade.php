@extends('business.layouts.app')
@section('title')
    Quick Dials | Students
@endsection
@section('keyword')
    Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near
    You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance
    Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find
    Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education
    consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
    Find Only Certified Training Institutes, Coaching Centers near you on Estivaledge and Get Free counseling, Free Demo
    Classes, and Get Placement Assistence.
@endsection
@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>My Lead</h1>
        </div>
        <div class="container">
            <div class="header-enquiry">
                <div class="enquiry-tabs">
                    <div class="tab">
                        <span>My Lead</span>
                        <span class="count"><?php if (!empty($leads)) {
        echo count($leads);
    } ?></span>
                    </div>

                </div>

                <div class="status">
                    <span><a href="{{ url('business/myLead')}}">Total Lead</a> | </span>
                    <span><a href="{{ url('business/package')}}">Package</a></span>

                </div>
            </div>
            <style>


            </style>
            <div class="enquiries-section">


                <div class="tab-content active" id="all">
                    @if(!empty($leads))
                        @foreach($leads as $lead)

                        <div class="enquiry-item <?php        if ($lead->readLead == '0') {
                                echo "assignedLeadsClick";
                            } ?>"
                                        data-assigned_leads="{{ $lead->assignId }}" data-client_id="{{ $lead->clientId }}"
                                        style="<?php        if (!$lead->readLead) {
                                echo "background:#ddd";
                            } ?>">

                                        <div class="lead-left">

                                            <div class="avatar"><?php        echo ucfirst(substr($lead->name, 0, 1)); ?>
                                            </div>

                                            <div class="enquiry-details">
                                                <div class="head"><i class="bi bi-person"></i> {{ucfirst($lead->name)}} <span class="tag">My
                                                        Lead</span> <i
                                                        class="fa-regular bi-star favorite-icon <?php        if ($lead->favorite_lead) {
                                echo "favorited";
                            } ?>"
                                                        data-favoritleads="{{ $lead->assignId }}" title="Favorite"></i>



                                                    <div class="share-wrapper">

                                                        <input type="checkbox" id="shareToggle{{ $lead->assignId }}" class="share-toggle">

                                                        <label for="shareToggle{{ $lead->assignId }}" class="share-icon">


                                                            <i class="bi bi-share-fill"></i>
                                                        </label>

                                                        <div class="share-menu">

                                                            <a href="https://wa.me/?text={{ urlencode($lead->share_address) }}"
                                                                target="_blank">

                                                                <img src="{{ asset('img/map.png') }}" width="18"> Service

                                                            </a>

                                                            <a href="https://wa.me/?text={{ urlencode($lead->share_review) }}"
                                                                target="_blank">
                                                                ⭐ Review
                                                            </a>
                                                            <a href="https://wa.me/?text={{ urlencode($lead->share_service) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('img/service.png') }}" width="18"> Service
                                                            </a>

                                                            <a href="https://wa.me/?text={{ urlencode($lead->share_lead) }}"
                                                                target="_blank">
                                                                👤Share Lead
                                                            </a>

                                                        </div>

                                                    </div>



                                                </div>
                                                <p><i class="bi bi-book"></i> {{$lead->kw_text}}</p>
                                                <p>Online Class</p>
                                                <p>@if($lead->city_name) <i class="bi bi-pin-map-fill"></i>{{$lead->city_name}}
                                                    @if($lead->zone != $lead->city_name) {{$lead->zone}} @endif

                                                @endif
                                                </p>

                                                <div class="details-section">
                                                    <div class="title">Enquired for <strong>{{$lead->kw_text}}</strong>

                                                        Send price and other details.</div>
                                                    <div class="source">@if($lead->email) <i
                                                    class="bi bi-envelope"></i>{{$lead->email}}@endif</div>
                                                    <p>@if($lead->remarks) {{$lead->remarks}} @endif</p>
                                                </div>
                                                <div class="show-details" onclick="toggleDetails(this)">Show details</div>
                                            </div>
                                        </div>
                                        <div class="lead-right">

<div class="lead-card">

            <div class="lead-top">
                <div class="lead-header">
                    <div class="amount">


                    <div class="followup" title="Followup">                            

                    <a href="javascript:void(0);" 
                    onclick="enquiryController.getLeadfollowUps(<?= $lead->lead_id ?>)" 
                    title="FollowUp">
                    <i class="bi bi-eye" aria-hidden="true"></i>


                    </a>

                    </div>
                    </div>
                <div class="badge"> <i class="bi bi-currency-rupee"></i>  
                <?php
                if(!empty($lead->scrapLead)) { 
                $coins =    "<span style='color:green'>" . $lead->coins . "</span>"; 
                }else if($lead->coins){ 
                $coins =  "<span style='color:red;'> -" . $lead->coins . " </span>"; 
                }  
                echo $coins;
                ?>

                </div>
                </div>
            </div>

  
            


            <div class="contact-item">
            <div class="icon phone">
            <i class="bi bi-telephone-fill"></i>
            </div>
            <span><a href="tel:91{{$lead->mobile}}"> {{$lead->mobile}}</a></span>
            </div>

            <div class="contact-item">
            <div class="icon whatsapp">
            <i class="bi bi-whatsapp"></i>
            </div>
            <span><a href="https://wa.me/91{{$lead->mobile}}" target="_blank" aria-label="Whatsup">{{$lead->mobile}}</a></span>
            </div>

            <div class="time">
            <i class="bi bi-clock"></i>
            <?php echo get_time(strtotime($lead->created)); ?> ago
            </div>

            </div>


                                             
                                            
                                            <div class="scrapLead">

                                                <?php        if (empty($lead->scrapPay)) { ?>
                                                <button type="button" class="scrapbutton" data-bs-toggle="modal"
                                                    data-bs-target="#basicModal_<?php            echo $lead->lead_id; ?>">
                                                    Scrap Lead
                                                </button>
                                                <?php        } ?>
                                                <div class="modal fade" id="basicModal_<?php        echo $lead->lead_id; ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Report an issues</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form>
                                                                    <p>Please tell us the probelem</>
                                                                    <div class="row mb-3">
                                                                        <div class="col-sm-10">
                                                                            <div class="checkbox-container">
                                                                                <label class="checkbox-label">
                                                                                    <input type="radio" class="form-check-input"
                                                                                        id="gridRadios1" name="scrapLead"
                                                                                        data-clientId="<?php        if ($lead->clientId) {
                                echo $lead->clientId;
                            } ?>"
                                                                                        data-leadId="<?php        if ($lead->assignId) {
                                echo $lead->assignId;
                            } ?>"
                                                                                        value="1" <?php        if (isset($lead->scrapValue) && $lead->scrapValue == '1') {
                                echo "checked";
                            } ?>>
                                                                                    <span class="checkbox-text"> Student in just exploring &
                                                                                        not planing to hire any tutor</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox-container">
                                                                                <label class="checkbox-label">
                                                                                    <input type="radio" class="form-check-input"
                                                                                        id="gridRadios2" name="scrapLead"
                                                                                        data-clientId="<?php        if ($lead->clientId) {
                                echo $lead->clientId;
                            } ?>"
                                                                                        data-leadId="<?php        if ($lead->assignId) {
                                echo $lead->assignId;
                            } ?>"
                                                                                        value="2" <?php        if (isset($lead->scrapValue) && $lead->scrapValue == '2') {
                                echo "checked";
                            } ?>>
                                                                                    <span class="checkbox-text">Enquiry is posted by a
                                                                                        tutor, an Institute or a tutor agency</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox-container">
                                                                                <label class="checkbox-label">
                                                                                    <input type="radio" class="form-check-input"
                                                                                        id="gridRadios3" name="scrapLead"
                                                                                        data-clientId="<?php        if ($lead->clientId) {
                                echo $lead->clientId;
                            } ?>"
                                                                                        data-leadId="<?php        if ($lead->assignId) {
                                echo $lead->assignId;
                            } ?>"
                                                                                        value="3" <?php        if (isset($lead->scrapValue) && $lead->scrapValue == '3') {
                                echo "checked";
                            } ?>>
                                                                                    <span class="checkbox-text">Student has selected wrong
                                                                                        category</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox-container">
                                                                                <label class="checkbox-label">
                                                                                    <input type="radio" class="form-check-input"
                                                                                        id="gridRadios4" name="scrapLead"
                                                                                        data-clientId="<?php        if ($lead->clientId) {
                                echo $lead->clientId;
                            } ?>"
                                                                                        data-leadId="<?php        if ($lead->assignId) {
                                echo $lead->assignId;
                            } ?>"
                                                                                        value="4" <?php        if (isset($lead->scrapValue) && $lead->scrapValue == '4') {
                                echo "checked";
                            } ?>>
                                                                                    <span class="checkbox-text">Student has select wrong
                                                                                        locality</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox-container">
                                                                                <label class="checkbox-label">
                                                                                    <input type="radio" class="form-check-input"
                                                                                        id="gridRadios5" name="scrapLead"
                                                                                        data-clientId="<?php        if ($lead->clientId) {
                                echo $lead->clientId;
                            } ?>"
                                                                                        data-leadId="<?php        if ($lead->assignId) {
                                echo $lead->assignId;
                            } ?>"
                                                                                        value="5" <?php        if (isset($lead->scrapValue) && $lead->scrapValue == '5') {
                                echo "checked";
                            } ?>>
                                                                                    <span class="checkbox-text">Student is asking for only
                                                                                        Female/Male tutor</span>
                                                                                </label>
                                                                            </div>

                                                                            <div class="checkbox-container">
                                                                                <label class="checkbox-label">
                                                                                    <input type="radio" class="form-check-input"
                                                                                        id="gridRadios6" name="scrapLead"
                                                                                        data-clientId="<?php        if ($lead->clientId) {
                                echo $lead->clientId;
                            } ?>"
                                                                                        data-leadId="<?php        if ($lead->assignId) {
                                echo $lead->assignId;
                            } ?>"
                                                                                        value="6" <?php        if (isset($lead->scrapValue) && $lead->scrapValue == '6') {
                                echo "checked";
                            } ?>>
                                                                                    <span class="checkbox-text">Student phone number is
                                                                                        either invailid or not reachable or no response
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox-container">
                                                                                <label class="checkbox-label">
                                                                                    <input type="radio" class="form-check-input"
                                                                                        id="gridRadios7" name="scrapLead"
                                                                                        data-clientId="<?php        if ($lead->clientId) {
                                echo $lead->clientId;
                            } ?>"
                                                                                        data-leadId="<?php        if ($lead->assignId) {
                                echo $lead->assignId;
                            } ?>"
                                                                                        value="7" <?php        if (isset($lead->scrapValue) && $lead->scrapValue == '7') {
                                echo "checked";
                            } ?>>
                                                                                    <span class="checkbox-text">Student has already hire
                                                                                        tutor for this requirement </span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox-container">
                                                                                <label class="checkbox-label">
                                                                                    <input type="radio" class="form-check-input"
                                                                                        id="gridRadios8" name="scrapLead"
                                                                                        data-clientId="<?php        if ($lead->clientId) {
                                echo $lead->clientId;
                            } ?>"
                                                                                        data-leadId="<?php        if ($lead->assignId) {
                                echo $lead->assignId;
                            } ?>"
                                                                                        value="8" <?php        if (isset($lead->scrapValue) && $lead->scrapValue == '8') {
                                echo "checked";
                            } ?>>
                                                                                    <span class="checkbox-text">Student is showing
                                                                                        suspicious behaviour, with an intention to do a
                                                                                        payment scam or any other misuse. </span>
                                                                                </label>
                                                                            </div>

                                                                        </div>
                                                                    </div>


                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div><!-- End Basic Modal-->





                                            </div>
                                                                               

                                            
                                        </div>


                                    </div>
                        @endforeach
                    @endif

                </div>


            </div>
        </div>
        <style>
            .checkbox-container {
                margin-bottom: 15px;
            }

            .checkbox-label {
                display: flex;
                align-items: center;
                padding: 10px;
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .checkbox-label:hover {
                background-color: #e0e0e0;
            }
        </style>
        <script>
            // Tab switching functionality
            document.querySelectorAll('.tab-link').forEach(tab => {
                tab.addEventListener('click', () => {
                    document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                    tab.classList.add('active');
                    const tabContent = document.getElementById(tab.getAttribute('data-tab'));
                    tabContent.classList.add('active');
                });
            });

            // Favorite icon toggle functionality
            document.querySelectorAll('.favorite-icon').forEach(icon => {
                icon.addEventListener('click', () => {
                    icon.classList.toggle('fa-solid');
                    icon.classList.toggle('fa-regular');
                    icon.classList.toggle('favorited');
                });
            });


            function toggleDetails(element) {
                const detailsSection = element.previousElementSibling;
                detailsSection.classList.toggle('visible');
                element.textContent = detailsSection.classList.contains('visible') ? 'Hide details' : 'Show details';
            }

            function hideCard(element) {
                const card = element.closest('.enquiry-item');
                card.classList.add('hidden');
            }




        </script>


        <style>
            .x_content {
                padding: 0 5px 6px;
                float: left;
                clear: both;
                margin-top: 5px;
            }

            .form-label-left .row {
                margin-left: 5px;
            }

            .form-label-left .col-form-label {
                font-weight: 700;
            }

            .form-label-left .col-md-4 {}
        </style>
    </main><!-- End #main -->



    <script>
        //$('.leaddf,.leaddt').datepicker({dateFormat:"yy-mm-dd"});
    </script>
@endsection