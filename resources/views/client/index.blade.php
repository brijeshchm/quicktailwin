 
@extends('client.layouts.app')

@section('title', 'QuickDials - India’s Trusted Local Business Search Engine')

@section('description', 'QuickDials is India’s leading local business search engine to discover top-rated IT training institutes, hotels, salons, healthcare services, real estate, travel agencies, schools, colleges, and more near you. Find verified business listings, addresses, phone numbers, reviews, ratings, photos, and maps across India.')

@section('keyword', 'QuickDials, local business directory India, business listing website, IT training institutes near me, coaching centres near me, hotels near me, salons near me, healthcare services, real estate services, travel agencies, schools and colleges near me, certified institutes, education consultants, online business directory, local search engine India, top businesses near me, business reviews and ratings')

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

