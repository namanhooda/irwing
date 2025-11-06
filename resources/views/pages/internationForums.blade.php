@extends('frontend.partials.app')

@section('content')

<style>
    /* --- General Page & Container Styles --- */
    .forum-container {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .forum-header {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
        padding: 25px 30px;
        font-size: 2.2rem;
        font-weight: 700;
        text-align: center;
        margin: 0;
    }

    .forum-content {
        padding: 30px;
    }

    .breadcrumb-container {
        background: #f8f9fa;
        padding: 15px 30px;
        border-bottom: 1px solid #dee2e6;
    }

    .breadcrumb {
        margin: 0;
        background: transparent;
        font-size: 0.9rem;
    }

    .breadcrumb-item a {
        color: #4a90e2;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    /* --- Content-Specific Styles --- */
    .content-section h4 {
        color: #343a40;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .content-section .mandate-intro,
    .content-section .study-period {
        color: #495057;
        font-size: 1.1rem;
        margin-bottom: 15px;
    }
    .content-section .study-period {
        font-style: italic;
    }
    .content-section .mandate-intro strong {
        font-weight: 600;
        color: #212529;
    }

    /* Sub-heading style for better hierarchy */
    .sub-heading {
        color: #4a90e2;
        font-size: 1.2rem;
        font-weight: 600;
        margin-top: 30px;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e9ecef;
    }

    /* Default list style for the mandate points */
    .mandate-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .mandate-list li {
        padding: 8px 0 8px 25px;
        border-bottom: 1px solid #f1f3f4;
        color: #495057;
        position: relative;
        line-height: 1.6;
    }
    .mandate-list li::before {
        content: '▸';
        color: #4a90e2;
        font-weight: bold;
        position: absolute;
        left: 0;
        top: 8px;
    }
    .mandate-list li:last-child {
        border-bottom: none;
    }

    /* List style for links */
    .link-list {
        list-style: disc;
        padding-left: 20px;
        margin: 0;
    }
    .link-list li {
        margin-bottom: 8px;
    }
    .external-link {
        color: #4a90e2;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .external-link:hover {
        color: #357abd;
        text-decoration: underline;
    }

    /* Table styles */
    .management-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 1rem;
    }
    .management-table th,
    .management-table td {
        padding: 12px 15px;
        border: 1px solid #dee2e6;
        color: #495057;
        text-align: left;
    }
    .management-table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    /* Overview section */
    .overview-section {
        text-align: center;
        padding: 40px 20px;
    }
    .overview-section h3 {
        color: #4a90e2;
        margin-bottom: 20px;
    }
    .overview-section p {
        color: #6c757d;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }
</style>

<div class="mb-3 mb-lg-5"></div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="forum-container">
        <div class="breadcrumb-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">International Forums</a></li>
                    @if($section)
                        <li class="breadcrumb-item">
                            @if($section == 'itu-r')
                                ITU-R
                            @elseif($section == 'itu-t')
                                ITU-T
                            @elseif($section == 'itu-d')
                                ITU-D
                            @elseif($section == 'itu-telecom')
                                ITU Telecom
                            @else
                                {{ ucfirst(str_replace('-', ' ', $section)) }}
                            @endif
                        </li>
                        @if($sub)
                            <li class="breadcrumb-item active" aria-current="page">
                                @if($sub == 'npc-wrc')
                                    NPC WRC
                                @elseif(str_starts_with($sub, 'nsg'))
                                    NSG {{ str_replace('nsg', '', $sub) }}
                                @elseif(str_starts_with($sub, 'nwg'))
                                    NWG {{ str_replace('nwg', '', $sub) }}
                                @elseif(str_starts_with($sub, 'sg'))
                                    Study Group {{ str_replace('sg', '', $sub) }}
                                @else
                                    {{ ucfirst(str_replace('-', ' ', $sub)) }}
                                @endif
                            </li>
                        @endif
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{$InternationalForm->title}}</li>
                    @endif
                </ol>
            </nav>
        </div>

        <h1 class="forum-header">
            {{$InternationalForm->title}}
        </h1>

        <div class="forum-content">
                <!-- Overview Section -->
                <div class="overview-section">
                    <!-- <h3>Welcome to International Forums</h3> -->
                    <p>{!! $InternationalForm->description !!}</p>
                </div>
        </div>

        <!-- <div class="forum-content">
                <div class="overview-section">
                    <h3>Additional links</h3>
                    <p><a href="#">link 1</a></p>
                    <p><a href="#">link 1</a></p>
                </div>
        </div> -->

    </div>
</div>

@endsection