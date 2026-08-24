 
@extends('client.layouts.app')
@section('title', 'QuickDials - India’s Trusted Local Business Search Engine')
@section('description', 'QuickDials is India’s leading local business search engine to find top-rated IT training institutes, wedding services, academy, real estate, and repair services.')
@section('keywords', 'QuickDials, Local business directory in India, Business listing, IT Training Institutes near me, Wedding book near me, Hotels near me, Salons near me, Healthcare services, Schools & Colleges near me, Business reviews, ratings, contact, and address')
@section('content')
@include('client.components.homePage.hero-section')
@include('client.components.homePage.category-grid')
@include('client.components.homePage.blog-service')
@include('client.components.homePage.stats-banner')
@endsection

