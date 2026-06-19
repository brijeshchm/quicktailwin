@extends('client.layouts.app')
@section('title', 'QuickDials | A Local Search Engine for Businesses')
@section('description', 'Find Only Certified Training Institutes, Coaching Centers near you on quickdials and Get Free counseling, Free Demo Classes, and Get Placement Assistence.')
@section('keywords', 'Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you.')
@section('content')
@include('client.components.banner-section')
<style>
:root {
    --qd-primary: #0a5bd3;
    --qd-primary-dark: #084298;
    --qd-secondary: #02a8a8;
    --qd-accent: #ff5f14;
    --qd-heading: #033967;
    --qd-text: #25364a;
    --qd-muted: #667085;
    --qd-border: #e2e8f0;
    --qd-soft-bg: #f7faff;
    --qd-danger: #dc3545;
    --qd-success: #198754;
    --qd-white: #ffffff;
    --qd-shadow: 0 10px 30px rgba(15, 23, 42, 0.09);
    --qd-radius: 12px;
}

*,
*::before,
*::after {
    box-sizing: border-box;
}

/* ---------- Shared page layout ---------- */

.container {
    width: 100%;
    max-width: 1170px;
    margin-right: auto;
    margin-left: auto;
    padding-right: 15px;
    padding-left: 15px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}

.col-xs-12,
.col-sm-12,
.col-sm-9,
.col-sm-3,
.col-md-12,
.col-md-9,
.col-md-3 {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}

.third-add-section {
    margin-top: 18px;
    overflow: hidden;
    border-radius: var(--qd-radius);
    background: var(--qd-white);
    box-shadow: var(--qd-shadow);
}

.third-add-section img {
    display: block;
    width: 100%;
    height: auto;
    max-height: 330px;
    object-fit: cover;
}

.form-section {
    margin-top: 20px;
    padding: 20px 24px;
    border: 1px solid var(--qd-border);
    border-radius: var(--qd-radius);
    background: linear-gradient(135deg, #ffffff 0%, #f5f9ff 100%);
    box-shadow: var(--qd-shadow);
}

.removeLeftSpace {
    margin: 0;
    padding: 0;
}

.hdTitle h1 {
    margin: 0 0 10px;
    color: var(--qd-heading);
    font-size: clamp(24px, 3vw, 38px);
    font-weight: 700;
    line-height: 1.25;
}

.hdTitle [itemprop="aggregateRating"] {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 5px;
    color: #475467;
    font-size: 13px;
    line-height: 1.6;
}

.hdTitle [itemprop="aggregateRating"] img {
    width: auto;
    max-width: 105px;
    height: 18px;
    object-fit: contain;
}

.hdTitle [itemprop="ratingValue"],
.hdTitle [itemprop="ratingCount"] {
    color: var(--qd-heading);
    font-weight: 700;
}

 

.reviews-box-main {
    margin-top: 24px;
}

.top_description {
    margin-top: 0 !important;
    margin-bottom: 20px;
    padding: 20px 22px;
    color: var(--qd-heading) !important;
    border-left: 4px solid var(--qd-primary);
    border-radius: 8px;
    background: #f2f7ff;
}

.top_description p {
    margin: 0;
    color: inherit;
    font-size: 15px;
    line-height: 1.8;
}

 
/* ---------- About accordion ---------- */

.line-content,
.client-list-first,
.about-accordian,
.abt-accordion {
    width: 100%;
}

.abt-accordion .card {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    min-width: 0;
    margin-bottom: 18px;
    overflow: hidden;
    word-wrap: break-word;
    border: 1px solid var(--qd-border);
    border-radius: var(--qd-radius);
    background: var(--qd-white);
    box-shadow: 0 6px 20px rgba(15, 23, 42, 0.08);
}

.abt-accordion .card-header {
    padding: 0;
    border: 0;
    background: linear-gradient(135deg, #f8fbff, #ffffff);
}

.abt-accordion .card-header h2 {
    margin: 0;
}

.abt-accordion .card-header h2 button,
.abt-accordion .btn-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    min-height: 58px;
    margin: 0;
    padding: 15px 20px;
    color: var(--qd-heading);
    border: 0;
    border-radius: 0;
    outline: 0;
    background: transparent;
    font: inherit;
    font-size: 18px;
    font-weight: 700;
    line-height: 1.4;
    text-align: left;
    text-decoration: none;
    cursor: pointer;
}

.abt-accordion .btn-link:hover,
.abt-accordion .btn-link:focus {
    color: var(--qd-primary);
    text-decoration: none;
}
 

.abt-accordion .collapse.show {
    position: relative;
    display: block;
}

.abt-accordion .collapse.show::before {
    position: absolute;
    top: 0;
    right: 20px;
    left: 20px;
    height: 1px;
    content: "";
    background: var(--qd-secondary);
}

.abt-accordion .card-body {
    flex: 1 1 auto;
    padding: 20px 22px;
    color: #344054 !important;
    font-size: 14px !important;
    font-weight: 400;
    line-height: 1.8;
}

.about-accordian .card-body p {
    margin: 0 0 12px;
    padding: 0;
    color: inherit;
    font-size: inherit;
    line-height: inherit;
}

.about-accordian .card-body > ul,
.about-accordian .card-body ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.about-accordian .card-body ul ul {
    margin-top: 10px;
    margin-left: 0;
    padding-left: 24px;
}

.about-accordian .card-body li {
    position: relative;
    margin: 0 0 10px;
    padding-left: 20px;
    color: #344054;
    font-size: 14px !important;
    line-height: 1.75;
    text-align: left;
}

.about-accordian .card-body li::before {
    position: absolute;
    top: 8px;
    left: 1px;
    width: 7px;
    height: 12px;
    content: "";
    transform: rotate(45deg);
    border-right: 2px solid var(--qd-accent);
    border-bottom: 2px solid var(--qd-accent);
}

 

/* ---------- Content cards ---------- */

.category-description {
    margin-top: 24px;
    padding: 26px 28px;
    overflow: hidden;
    border: 1px solid var(--qd-border);
    border-radius: var(--qd-radius);
    background: var(--qd-white);
    box-shadow: var(--qd-shadow);
}

.category-description h2,
.category-description h3,
.category-description h4,
.category-description h5 {
    color: var(--qd-heading);
    font-weight: 700;
    line-height: 1.35;
}

.category-description h2 {
    position: relative;
    margin: 0 0 20px;
    padding-bottom: 12px;
    font-size: clamp(21px, 2.2vw, 29px);
}

.category-description h2::after {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 54px;
    height: 3px;
    content: "";
    border-radius: 999px;
    background: var(--qd-primary);
}

.category-description h3 {
    margin: 24px 0 12px;
    font-size: 20px;
}

.category-description h4 {
    margin: 0 0 18px;
    font-size: 21px;
}

.category-description h5 {
    margin: 0;
    font-size: 16px;
}

.category-description .card-body {
    padding: 0;
    color: var(--qd-text) !important;
    font-size: 15px !important;
    line-height: 1.8;
}

.category-description p {
    margin: 0 0 14px;
    padding: 0;
    color: var(--qd-text);
    font-size: 15px;
    line-height: 1.8;
}

.category-description strong {
    color: #172b4d;
}

.category-description ul {
    margin: 12px 0 18px;
    padding-left: 0;
    list-style: none;
}

.category-description ul ul {
    margin: 14px 0 0;
    padding-left: 18px;
}

.category-description li {
    position: relative;
    margin-bottom: 10px;
    padding-left: 26px;
    color: var(--qd-text);
    font-size: 15px !important;
    line-height: 1.7;
}

.category-description li::before {
    position: absolute;
    top: 8px;
    left: 2px;
    width: 8px;
    height: 13px;
    content: "";
    transform: rotate(45deg);
    border-right: 2px solid var(--qd-secondary);
    border-bottom: 2px solid var(--qd-secondary);
}

/* ---------- FAQ schema blocks ---------- */

.category-description [itemtype="https://schema.org/FAQPage"] {
    display: grid;
    gap: 12px;
}

.category-description [itemprop="mainEntity"] {
    padding: 17px 18px;
    border: 1px solid var(--qd-border);
    border-radius: 10px;
    background: var(--qd-soft-bg);
}

.category-description [itemprop="mainEntity"] h5 {
    margin-bottom: 8px;
}

.category-description [itemprop="acceptedAnswer"] {
    display: block;
    color: #475467;
    font-size: 14px;
    line-height: 1.75;
}

/* ---------- Pagination ---------- */

.current .btn-info {
    color: var(--qd-success);
}

#pagin {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin: 20px 0;
    padding: 0;
    list-style: none;
}

#pagin li {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    min-height: 36px;
    margin: 0;
    padding: 0;
    border-radius: 7px;
    background: #c94a30;
}

#pagin li a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    padding: 7px 10px;
    color: var(--qd-white);
    text-decoration: none;
}

#pagin li:hover,
#pagin li.current {
    background: var(--qd-primary);
}

/* ---------- Popup overlay ---------- */

.inquiry-popup {
    
}

.searchPopup {
    position: fixed;
    z-index: 99999;
    inset: 0;
   
    overflow-y: auto;
    padding: 30px 18px;
    background: rgba(15, 23, 42, 0.72);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.searchPopup.active,
.searchPopup.show {
    display: block;
}

.searchPopup .dealclosebtn {
    position: fixed;
    z-index: 100001;
    top: 18px;
    right: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    padding: 0;
    border: 0;
    border-radius: 50%;
    background: var(--qd-white);
    box-shadow: 0 8px 25px rgba(15, 23, 42, 0.2);
    text-decoration: none;
}

.searchPopup .dealclosebtn::before,
.searchPopup .dealclosebtn::after {
    position: absolute;
    width: 19px;
    height: 2px;
    content: "";
    border-radius: 2px;
    background: #101828;
}

.searchPopup .dealclosebtn::before {
    transform: rotate(45deg);
}

.searchPopup .dealclosebtn::after {
    transform: rotate(-45deg);
}

.callback-wrapper {
    display: grid;
    grid-template-columns: minmax(280px, 0.9fr) minmax(410px, 1.1fr);
    width: min(960px, 100%);
    min-height: 590px;
    margin: 20px auto;
    overflow: hidden;
    border-radius: 18px;
    background: var(--qd-white);
    box-shadow: 0 24px 70px rgba(2, 12, 27, 0.34);
}

.left-panel {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 44px 38px;
    overflow: hidden;
    color: var(--qd-white);
    background: linear-gradient(145deg, #073b82 0%, #0a67d8 55%, #02a8a8 115%);
}

.left-panel::before,
.left-panel::after {
    position: absolute;
    content: "";
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
}

.left-panel::before {
    top: -90px;
    right: -70px;
    width: 220px;
    height: 220px;
}

.left-panel::after {
    bottom: -120px;
    left: -80px;
    width: 270px;
    height: 270px;
}

.left-panel > * {
    position: relative;
    z-index: 1;
}

.left-panel h2 {
    margin: 0 0 14px;
    color: var(--qd-white);
    font-size: clamp(27px, 3vw, 39px);
    font-weight: 750;
    line-height: 1.2;
}

.left-panel > p {
    margin: 0 0 28px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 15px;
    line-height: 1.7;
}

.benefits {
    padding: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.1);
}

.benefits h4 {
    margin: 0 0 13px;
    color: var(--qd-white);
    font-size: 17px;
}

.benefits ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.benefits li {
    margin-bottom: 10px;
    color: rgba(255, 255, 255, 0.96);
    font-size: 14px;
    line-height: 1.55;
}

.benefits li:last-child {
    margin-bottom: 0;
}

.right-panel {
    display: flex;
    flex-direction: column;
    padding: 36px 40px;
    background: var(--qd-white);
}

.right-panel > h2 {
    margin: 0 0 8px;
    color: var(--qd-heading);
    font-size: 28px;
    font-weight: 750;
    line-height: 1.25;
}

.right-panel > p {
    margin: 0 0 22px;
    color: var(--qd-muted);
    font-size: 14px;
    line-height: 1.65;
}

.orng {
    color: var(--qd-accent);
    font-weight: 700;
}

.popup-box {
    width: 100%;
}

.popupSteps {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
}

.popupSteps span {
    flex: 1 1 0;
    height: 5px;
    overflow: hidden;
    border-radius: 999px;
    background: #e8edf4;
    transition: background-color 0.25s ease, transform 0.25s ease;
}

.popupSteps span.active {
    background: linear-gradient(90deg, var(--qd-primary), var(--qd-secondary));
}

.popup-step {
   
    animation: qdFadeSlide 0.28s ease;
}

.popup-step.active {
    display: block;
}

@keyframes qdFadeSlide {
    from {
        opacity: 0;
        transform: translateY(7px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.popup-step > span {
    display: block;
    margin-bottom: 16px;
    color: var(--qd-heading);
    font-size: 19px;
    font-weight: 700;
}

.popup-form .erbr,
.popup-form .form-group {
    position: relative;
    margin-bottom: 15px;
    color: #344054;
    font-size: 14px;
    line-height: 1.5;
}

.popup-form input[type="text"],
.popup-form input[type="email"],
.popup-form input[type="tel"],
.popup-form input[type="number"],
.popup-form input[type="date"],
.popup-form select,
.popup-form textarea,
.drop-input-wrapper {
    width: 100%;
    min-height: 48px;
    border: 1px solid #d0d5dd;
    border-radius: 9px;
    outline: none;
    background: var(--qd-white);
    color: #101828;
    font-size: 14px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.popup-form input[type="text"],
.popup-form input[type="email"],
.popup-form input[type="tel"],
.popup-form input[type="number"],
.popup-form input[type="date"],
.popup-form select,
.popup-form textarea {
    padding: 11px 13px;
}

.popup-form textarea {
    min-height: 115px;
    resize: vertical;
}

.popup-form input:focus,
.popup-form select:focus,
.popup-form textarea:focus,
.drop-input-wrapper:focus-within {
    border-color: var(--qd-primary);
    box-shadow: 0 0 0 3px rgba(10, 91, 211, 0.12);
}

.popup-form select {
    appearance: none;
    -webkit-appearance: none;
    padding-right: 38px;
    background-image: linear-gradient(45deg, transparent 50%, #667085 50%),
                      linear-gradient(135deg, #667085 50%, transparent 50%);
    background-repeat: no-repeat;
    background-position: calc(100% - 18px) 20px, calc(100% - 13px) 20px;
    background-size: 5px 5px, 5px 5px;
}

.popup-form input::placeholder,
.popup-form textarea::placeholder,
.dropwn-input::placeholder {
    color: #98a2b3;
    opacity: 1;
}

/* Country code and phone row */

.div-code,
.drop-number {
    width: 100%;
}

.drop-number {
    display: grid;
    grid-template-columns: minmax(170px, 0.85fr) minmax(180px, 1.15fr);
    gap: 10px;
}

.dropdown {
    position: relative;
    min-width: 0;
}

.drop-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 0 !important;
    padding: 0 34px 0 43px;
}

.flag-icon {
    position: absolute;
    left: 12px;
    width: 23px;
    height: 16px;
    border-radius: 2px;
    object-fit: cover;
}

.dropwn-input {
    width: 100%;
    height: 46px;
    padding: 0;
    border: 0 !important;
    outline: 0 !important;
    background: transparent !important;
    box-shadow: none !important;
}

.clear-icon,
.dropdown-icon {
    position: absolute;
    right: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667085;
    cursor: pointer;
}

.clear-icon {
    right: 29px;
   
    font-size: 12px;
}

.dropdown-icon {
    font-size: 14px;
    pointer-events: none;
}

.dropdown-list {
    position: absolute;
    z-index: 50;
    top: calc(100% + 5px);
    right: 0;
    left: 0;
    
    max-height: 220px;
    overflow-y: auto;
    border: 1px solid var(--qd-border);
    border-radius: 9px;
    background: var(--qd-white);
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.15);
}

.dropdown.open .dropdown-list,
.dropdown-list.show {
    display: block;
}

.dropdown-list > * {
    padding: 10px 12px;
    border-bottom: 1px solid #eef2f6;
    cursor: pointer;
}

.dropdown-list > *:last-child {
    border-bottom: 0;
}

.dropdown-list > *:hover {
    background: #f4f8ff;
}

.quick_arrow {
    margin-bottom: 0 !important;
}

.quick_arrow input {
    height: 48px;
}

/* Checkbox option cards */

.fieldblock {
    margin-bottom: 16px;
}

.fieldblock-form {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
}

.radio-item {
    position: relative;
    display: flex;
    align-items: center;
    min-height: 46px;
    padding: 10px 12px;
    border: 1px solid #d0d5dd;
    border-radius: 9px;
    background: #fff;
    color: #344054;
    cursor: pointer;
    transition: border-color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
}

.radio-item:hover {
    transform: translateY(-1px);
    border-color: #9dbdf0;
    background: #f7faff;
}

.radio-item input {
    width: 17px;
    height: 17px;
    margin: 0 9px 0 0;
    accent-color: var(--qd-primary);
}

.radio-item:has(input:checked) {
    border-color: var(--qd-primary);
    background: #eef5ff;
    color: #073b82;
}

/* Form validation */

.erbr.has-error input,
.erbr.has-error select,
.erbr.has-error textarea,
.erbr.has-error .drop-input-wrapper,
.erbr.has-error .radio-item {
    border-color: var(--qd-danger) !important;
}

.erbr.has-error input:focus,
.erbr.has-error select:focus,
.erbr.has-error textarea:focus {
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.12);
}

.help-block {
    display: block;
    margin-top: 5px;
    color: var(--qd-danger);
    font-size: 12px;
    line-height: 1.45;
}

/* Popup buttons and terms */

.btn-center {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.btn-center button {
    min-width: 120px;
    min-height: 45px;
    padding: 10px 18px;
    border: 1px solid var(--qd-primary);
    border-radius: 9px;
    outline: 0;
    background: var(--qd-primary);
    color: var(--qd-white);
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
}

.btn-center button:hover {
    transform: translateY(-1px);
    background: var(--qd-primary-dark);
    box-shadow: 0 8px 18px rgba(10, 91, 211, 0.22);
}

.btn-center button:first-child:not(:only-child) {
    border-color: #d0d5dd;
    background: var(--qd-white);
    color: #344054;
}

.btn-center button:first-child:not(:only-child):hover {
    background: #f5f7fa;
    box-shadow: none;
}

.terms {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-top: 8px;
    color: #667085;
    font-size: 12px;
    line-height: 1.55;
}

.terms input {
    flex: 0 0 auto;
    width: 16px;
    height: 16px;
    margin-top: 2px;
    accent-color: var(--qd-primary);
}

.terms a {
    color: var(--qd-primary);
    font-weight: 600;
    text-decoration: none;
}

.terms a:hover {
    text-decoration: underline;
}

.loaderForm {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    justify-content: flex-end;
    margin-top: 8px;
    color: var(--qd-primary);
    font-size: 13px;
    font-weight: 600;
}

.loaderForm img {
    width: 20px;
    height: 20px;
}

/* ---------- Scrollbars ---------- */

.form-container {
    max-height: 420px;
    overflow-y: auto;
    padding-right: 8px;
    scrollbar-color: var(--qd-primary) #f1f1f1;
    scrollbar-width: thin;
}

.form-container::-webkit-scrollbar,
.dropdown-list::-webkit-scrollbar,
.searchPopup::-webkit-scrollbar {
    width: 6px;
}

.form-container::-webkit-scrollbar-track,
.dropdown-list::-webkit-scrollbar-track,
.searchPopup::-webkit-scrollbar-track {
    border-radius: 10px;
    background: #f1f1f1;
}

.form-container::-webkit-scrollbar-thumb,
.dropdown-list::-webkit-scrollbar-thumb,
.searchPopup::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background: linear-gradient(180deg, var(--qd-primary), #0a6adf);
}

.form-container::-webkit-scrollbar-thumb:hover,
.dropdown-list::-webkit-scrollbar-thumb:hover,
.searchPopup::-webkit-scrollbar-thumb:hover {
    background: var(--qd-primary-dark);
}

/* ---------- Responsive layout ---------- */

@media (min-width: 768px) {
    .col-sm-12 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .col-sm-9 {
        flex: 0 0 75%;
        max-width: 75%;
    }

    .col-sm-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }
}

@media (min-width: 992px) {
    .col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .col-md-9 {
        flex: 0 0 75%;
        max-width: 75%;
    }

    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }
}

@media (max-width: 991.98px) {
    .callback-wrapper {
        grid-template-columns: 1fr;
        width: min(660px, 100%);
    }

    .left-panel {
        padding: 30px;
    }

    

    .right-panel {
        padding: 30px;
    }

  

    .reviews-box-main {
        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
    }
}

@media (max-width: 767.98px) {
    .container {
        padding-right: 12px;
        padding-left: 12px;
    }

    .row {
        margin-right: -12px;
        margin-left: -12px;
    }

    .col-xs-12,
    .col-sm-12,
    .col-sm-9,
    .col-sm-3,
    .col-md-12,
    .col-md-9,
    .col-md-3 {
        padding-right: 12px;
        padding-left: 12px;
    }

    .third-add-section {
        margin-top: 12px;
        border-radius: 9px;
    }

    .third-add-section img {
        min-height: 150px;
        max-height: 220px;
    }

    .form-section {
        margin-top: 14px;
        padding: 17px;
    }

    .hdTitle h1 {
        font-size: 25px;
    }

    .top_description,
    .category-description {
        padding: 18px;
    }

    .category-description {
        margin-top: 16px;
        border-radius: 10px;
    }

    .category-description h2 {
        font-size: 22px;
    }

    .category-description h3 {
        font-size: 18px;
    }

    .category-description .card-body,
    .category-description p,
    .category-description li {
        font-size: 14px !important;
    }

    .abt-accordion .card-header h2 button,
    .abt-accordion .btn-link {
        min-height: 52px;
        padding: 13px 16px;
        font-size: 16px;
    }

    .abt-accordion .card-body {
        padding: 17px;
    }

    .searchPopup {
        padding: 10px;
    }

    .searchPopup .dealclosebtn {
        top: 12px;
        right: 12px;
        width: 38px;
        height: 38px;
    }

    .callback-wrapper {
        margin: 44px auto 15px;
        border-radius: 13px;
    }

    .left-panel {
        padding: 24px 20px;
    }

    .left-panel h2 {
        font-size: 25px;
    }

    .left-panel > p {
        margin-bottom: 0;
    }

    .right-panel {
        padding: 24px 20px;
    }

    .right-panel > h2 {
        font-size: 24px;
    }

    .drop-number,
    .fieldblock-form {
        grid-template-columns: 1fr;
    }

    .btn-center {
        justify-content: stretch;
    }

    .btn-center button {
        flex: 1 1 140px;
    }
}

@media (max-width: 479.98px) {
    .form-section,
    .category-description,
    .top_description {
        padding: 15px;
    }

    .hdTitle h1 {
        font-size: 22px;
    }

    .right-panel,
    .left-panel {
        padding: 20px 16px;
    }

    .popup-form input[type="text"],
    .popup-form input[type="email"],
    .popup-form input[type="tel"],
    .popup-form input[type="number"],
    .popup-form input[type="date"],
    .popup-form select,
    .popup-form textarea,
    .drop-input-wrapper {
        font-size: 16px;
    }

    .btn-center {
        flex-direction: column;
    }

    .btn-center button {
        width: 100%;
    }
}

@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        scroll-behavior: auto !important;
        transition-duration: 0.01ms !important;
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
    }
}


.abt-accordion .card {
border-radius: 0;
border: 1px solid rgba(179, 179, 179, 0.45);
margin-bottom: 10px;
max-width: 960px;
border-radius: 0;
box-shadow: 0 0 5px 3px #d4d4d466;
}


.card {
position: relative;
display: -ms-flexbox;
display: flex;
-ms-flex-direction: column;
flex-direction: column;
min-width: 0;
word-wrap: break-word;
background-color: #fff;
background-clip: border-box;
border: 1px solid rgba(0, 0, 0, .125);
border-radius: .25rem;
}

.abt-accordion .card .card-header {
padding: 7px;
background: none;
border: none;
}

.card-header:first-child {
border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
}

.abt-accordion .card .card-header h2 button {
display: flex;
align-items: center;
justify-content: space-between;
width: 100%;
text-decoration: none;
border-radius: 0;
font-weight: 700;
margin-left: 3%;
}

.abt-accordion .card .collapse.show {
position: relative;
visibility:visible;
}

.card-body {
-ms-flex: 1 1 auto;
flex: 1 1 auto;
padding: 1.25rem;
font-weight: 400;
font-size: 13px !important;
margin-bottom: 0;
line-height: 1.7;
padding-left: 1.5em;
color: #212529 !important;
}

.about-accordian .card-body p {
padding-left: 0;
margin-bottom: 0;
}

.card-body p {
font-weight: 400;
font-size: 13px;
margin-bottom: 10px;
line-height: 1.7;
padding-left: 1.5em;
}

.about-accordian ul {
list-style: none;
}

.about-accordian .card-body ul li:first-child {
margin-top: 0;
}

.about-accordian .card-body ul li {
position: relative;
font-weight: 400;
font-size: 13px !important;
line-height: 1.7;
margin-left: 0;
margin-bottom: 11px;
margin-top: 10px;
text-align: justify;
}

.about-accordian .card-body ul ul {
position: relative;
font-weight: 400;
font-size: 13px !important;
line-height: 1.7;
margin-left: 22px;
}

.about-accordian ul {
list-style: none;
}
 
</style>
 
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 third-add-section">

				<img loading="lazy" src="<?php echo asset('client/images/computer-courses-training.jpg'); ?>"
					alt="computer-courses-training">
				 

			</div>
		</div>
	</div>
	 
 

	<div class="container">
		<div class="form-section">
			<div class="removeLeftSpace">
				<div class="hdTitle">
					 
								<div itemscope itemtype="https://schema.org/Product" style="font-size: 12px;font-weight: 500;">
									<div class="text-primary" itemprop="name">
										<h1 title="Playwright Automation Course in Noida ">Playwright Automation Course in Noida</h1>
									</div>
									<div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
										<img loading="lazy" itemprop="image" src="{{ asset('client/images/star_4.75_new.png') }}"
											alt="5 Star Rating: Very Good" />
										<span itemprop="ratingValue">4.75</span> out of <span itemprop="bestRating"></span>based on <span itemprop="ratingCount">314</span> ratings
									</div>
								</div>
				 
					<div class="keyword-cotegory-text">				 
 
					</div>
				</div>
			</div>
			 
		</div>

	</div>
 

	<div class="container">

		<div class="col-sm-9 col-md-9 reviews-box-main mainContainer">

	 
				<div class="col-xs-12 top_description" >
				 
					<p>
						If you are planning to step into automation testing or switch from manual to automation, this Playwright Automation Training in Noida is designed to help you actually work with automation, not just learn it. Most courses teach you syntax. This one focuses on execution. You will understand how automation behaves in real projects, how scripts fail, how to debug them, and how to handle situations where things don’t work on the first attempt
			
					 
				</p>					 
				</div>
			 
			 
		<div class="services">
			<div id="recentSearchContainer">
			</div>
		</div>
 
			 
		 
				<div class="col-sm-12 col-md-12 reviews-box-1 line-content">
					<div class="client-list-first">
						<style>
							
						</style>

						<div class="about-accordian">

							<div class="abt-accordion" id="courseAcrdMain">

								<div class="card">
									<div class="card-header" id="abthdgOne">
										<h2 class="mb-0"><button type="button" class="btn-link"
												data-target="#heading_1"
												data-parent="#courseAcrdMain">
												<span>About Playwright Automation Course</span> </button> </h2>
									</div>
									<div id="heading_1" class="collapse show" aria-labelledby="abthdgOne">
										<div class="card-body">
											<ul>

											 
													<li style="font-size: 13px;">
											 This Playwright Automation Course in Noida is built around real-world testing practices.
Instead of limiting learning to theory, the course takes you through

																			</li>
											 
					<ul>
				 
					<li>
					<p style="font-size: 13px;">
				 Writing your first automation script

					</p>
					</li>

			 
				 
					<li>
					<p style="font-size: 13px;">
				 Handling real-time execution challenges

					</p>
					</li>
		 
					<li>
					<p style="font-size: 13px;">
					 Managing test flows and failures
					</p>
					</li>
				 
					<li>
					<p style="font-size: 13px;">
					 Understanding how testing actually works in production environments
					</p>
					</li>
				 
				 
				 
					</ul>
					</ul>
					<p>The goal is simple: Make you job-ready, not just course-complete.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			 
			 
		 
			 

 
		</div>

		<div class="col-sm-3 col-md-3 side-data reviews-box-1 scroll-on rightsidedata">
			 
		</div>
	</div>

 

	 
		<div class="container">
			<div class="category-description">
				<h2>Why Choose the Playwright Automation Course?</h2>
			 <div class="card-body">
			<ul>

		 
						<li style="font-size: 13px;">
							 
A practical starting point for automation testing
						</li>

						<li>
									
										Clear understanding of real-world workflows 

								
								</li>

			 
								<li>
									
										Hands-on experience with scripting and execution

									
								</li>
		 
								<li>
									
									Strong foundation in modern automation tools

								
								</li>
		 
								<li>
									
										Better chances of landing roles in automation testing
									
								</li>
		 
			<ul>
			 <h3>What You Get</h3>
								<li>
									Interactive live sessions
								</li>

			 
								<li>
								Recorded sessions for revision
								</li>
		 
								<li>
									Hands-on practice with real scenarios
								</li>
		 
								<li>
									Interview preparation support
								</li>
								<li>
									Project guidance
								</li>
			  
			 
			 
			</ul>
 
										</div>


 






			</div>


		</div>
	 
		<div class="container">
			<div class="category-description">
				<h2>What Will You Learn in Playwright Automation Classes in Noida?</h2>
			 <div class="card-body">
			<ul>
<p>In this course, you’ll focus on actual implementation, not just theory.</p>
		 <strong>You will learn:</strong>
						<li style="font-size: 13px;">
							 How to write and execute automation scripts using Playwright
						</li>

						<li>
									
							How to handle dynamic elements, waits, and test failures 

								
								</li>

			 
								<li>
									
								How real-world test cases are designed and executed

									
								</li>
		 
								<li>
									
								How to debug automation scripts logically

								
								</li>
		 
								<li>
									
								How to build structured and maintainable automation frameworks
									
								</li>
		 
			<ul>
			 <p>This Playwright Automation Course in Noida ensures that by the end, you can confidently handle real testing tasks in a job environment.</p>
			 <h3>Playwright Automation Course Overview</h3>
								<li>
									<strong>Level: </strong>Beginner to Intermediate
								</li>

			 
								<li>
								<strong>Duration: </strong>4–8 weeks (depending on batch)
								</li>
		 
								<li>
									<strong>Session Type: </strong>Practical + Instructor-led
								</li>
		 
								<li>
									<strong>Mode: </strong>Online / Offline
								</li>
								<li>
									<strong>Focus: </strong>Real-time automation testing using Playwright
								</li>
			  
			 
			 
			</ul>
 
										</div>


 






			</div>


		</div>
	 
		<div class="container">
			<div class="category-description">
				<h2>Why Most Playwright Automation Courses Don’t Work?</h2>
			 <div class="card-body">
			<ul>
<p>Most<b> Playwright Automation Courses in Noida</b> follow a checklist approach.</p>
		 
						<li style="font-size: 13px;">
							Topics covered
						</li>

						<li>
									
							Notes shared
								
								</li>

			 
								<li>
									
								Certificate provided
									
								</li>
		 
								 
		 
			<ul>
			 <p>But when it comes to real work—handling dynamic elements, fixing broken scripts, managing failures, learners struggle.</p>
			 <h3>What’s Different Here?</h3>
								<li>
								You practice in real-time
								</li>

			 
								<li>
								You understand why something works
								</li>
		 
								<li>
									You learn where to use it
								</li>
		 
								<li>
									You handle situations when scripts break
								</li>
								 
			  
			 
			 
			</ul>
 <p>Because in real projects, things always break</p>
										</div>


 






			</div>


		</div>
	 
		<div class="container">
			<div class="category-description">
				<h2>What You Will Actually Be Able to Do</h2>
			 <div class="card-body">
			<ul>
<p>After completing the <strong> Playwright Automation Classes in Noida</strong>, you will be able to.</p>
		 
						<li style="font-size: 13px;">
							Write automation scripts from scratch
						</li>

						<li>
									
						Handle complex scenarios like dynamic elements and flaky tests
								
								</li>

			 
								<li>
									
								Execute and manage real-world test cases
									
								</li>
								<li>
									
								Debug failures with clarity
									
								</li>
								<li>
									
								Design clean and structured automation code
									
								</li>
								<li>
									
								Build a complete project for interviews
									
								</li>
		 
								 
		 
			<ul>
				 <h3>Who Can Enroll? (Eligibility Criteria)</h3>
			 <p>This Playwright Training Institute in Noida is suitable for.</p>
			
								<li>
								Beginners starting a career in software testing
								</li>

			 
								<li>
								Manual testers moving into automation
								</li>
		 
								<li>
								Working professionals upgrading their skills
								</li>
		 
								<li>
								Graduates (technical or non-technical) with an interest in testing
								</li>
								<li>
								Anyone with basic computer knowledge
								</li>
								 
			  <p>You don’t need coding experience to start. Basic programming understanding is helpful but not mandatory</p>
			 
			 
			</ul>
 
										</div>


 






			</div>


		</div>
	 
		<div class="container">
			<div class="category-description">
				<h2>Why Learners Prefer This Playwright Training Institute in Noida?</h2>
			 <div class="card-body">
			<ul>
<p>There are many options, but learners stay here for one reason: clarity</p>
		 
						<li style="font-size: 13px;">
							Focus on real skills, not just certificates
						</li>

						<li>
									
					Practical learning, not scripted teaching		
								</li>

			 
								<li>
									
							Sessions based on real industry experience
									
								</li>
								<li>
									
							Flexible learning pace
									
								</li>
								 
		 
								 
		 
			<ul>
				 <h3>Course Availability</h3>
			 <p>You can enroll in:</p>
			
								<li>
								Playwright Automation Training in Noida
								</li>

			 
								<li>
								Playwright Automation Classes in Noida
								</li>
		 
								<li>
								Playwright Training Institute in Noida
								</li>
		 
								 
								 
			  <p>Also available for learners in the <strong>Delhi and Gurgaon region</strong></p>
			 
			 <p>Modes available:</p>
			 <ul>
				<li>Online</li>
				<li>Offline</li>
							</ul>

							
			 <h3>Still Thinking? Start with a Demo</h3>
			 <p>Before enrolling, you can:</p>
			 <ul>
				<li>Attend a demo session</li>
				<li>Talk to a mentor</li>
				<li>Understand how the training works</li>
							</ul>


			</ul>
 
										</div>


 






			</div>


		</div>
	   <div class="mx-auto max-w-7xl px-4">
		<div class="category-description my-6">
			<h4 class="mb-4 text-lg font-bold text-gray-800">FAQ:- Playwright Automation Course in {{ $area ?? 'Noida' }}</h4>

			<div itemscope itemtype="https://schema.org/FAQPage" class="space-y-3">

				<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="rounded-lg border border-gray-200 p-4">
					<h5 itemprop="name" class="font-semibold text-gray-800">
						<strong>Do I need coding knowledge to start?</strong>
					</h5>
					<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="mt-2">
						<div itemprop="text" class="text-sm leading-6 text-gray-600">
							No. Basic understanding helps, but everything is taught from scratch.
						</div>
					</div>
				</div>

				<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="rounded-lg border border-gray-200 p-4">
					<h5 itemprop="name" class="font-semibold text-gray-800">
						<strong>Is this course beginner-friendly?</strong>
					</h5>
					<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="mt-2">
						<div itemprop="text" class="text-sm leading-6 text-gray-600">
							Yes. It starts from the basics and gradually moves to advanced topics.
						</div>
					</div>
				</div>

				<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="rounded-lg border border-gray-200 p-4">
					<h5 itemprop="name" class="font-semibold text-gray-800">
						<strong>Will I work on real projects?</strong>
					</h5>
					<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="mt-2">
						<div itemprop="text" class="text-sm leading-6 text-gray-600">
							Yes. You will practice on real-world scenarios.
						</div>
					</div>
				</div>

				<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="rounded-lg border border-gray-200 p-4">
					<h5 itemprop="name" class="font-semibold text-gray-800">
						<strong>Is online training available?</strong>
					</h5>
					<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="mt-2">
						<div itemprop="text" class="text-sm leading-6 text-gray-600">
							Yes. Both online and offline options are available.
						</div>
					</div>
				</div>

				<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="rounded-lg border border-gray-200 p-4">
					<h5 itemprop="name" class="font-semibold text-gray-800">
						<strong>What makes this different?</strong>
					</h5>
					<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="mt-2">
						<div itemprop="text" class="text-sm leading-6 text-gray-600">
							The focus is on practical implementation, not just completing topics.
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
 
	 

	 

	<div class="inquiry-popup"></div>

	<a href="javascript:void(0);" class="dealclosebtn">&nbsp;</a>
		<style>
		.form-container {
			max-height: 420px;
			/* adjust height */
			overflow-y: auto;
			padding-right: 8px;
			/* space for scrollbar */
		}


		.form-container {
			max-height: 420px;
			overflow-y: auto;
			padding-right: 8px;
		}

		/* Scrollbar width */
		.form-container::-webkit-scrollbar {
			width: 6px;
		}

		/* Track */
		.form-container::-webkit-scrollbar-track {
			background: #f1f1f1;
			border-radius: 10px;
		}

		/* Thumb */
		.form-container::-webkit-scrollbar-thumb {
			background: linear-gradient(180deg, #0a5bd3, #0a6adf);
			border-radius: 10px;
		}

		/* Hover */
		.form-container::-webkit-scrollbar-thumb:hover {
			background: #084298;
		}
	</style>

 

	 
	 
@endsection