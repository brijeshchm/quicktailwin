 
@extends('client.layouts.app')

@section('title', 'Quick Dials | A Local Search Engine for Businesses')
@section('description', 'Find Only Certified Training Institutes, Coaching Centers near you on quickdials and Get Free counseling, Free Demo Classes, and Get Placement Assistence.')
@section('keyword', 'Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you.')

@section('content')
 

 @include('client.components.homePage.hero-section')

 

 @include('client.components.homePage.category-grid')


 @include('client.components.homePage.service-cards')
 @include('client.components.homePage.repair-services')
 @include('client.components.homePage.wedding-planning')
 @include('client.components.homePage.featured-businesses')
 @include('client.components.homePage.blog-service')
 @include('client.components.homePage.stats-banner')
 @include('client.components.homePage.country-flags')




@endsection

