@extends('frontend.partials.app')

@section('content')

<style>
    .ir-section {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
    }

    .ir-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .ir-header h1 {
        font-weight: 700;
        color: #0d6efd;
    }

    /* Tabs styling */
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 600;
        border: 1px solid transparent;
        border-radius: 8px 8px 0 0;
        margin-right: 5px;
        transition: all 0.2s;
    }

    .nav-tabs .nav-link.active {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd #0d6efd #fff;
    }.nav.nav-tabs .nav-item .nav-link.active {
    color: white;
    text-color: white;
}

    .tab-content {
        border: 1px solid #dee2e6;
        border-top: none;
        padding: 25px;
        border-radius: 0 0 10px 10px;
        background-color: #f8f9fa;
    }

    .tab-pane h3 {
        color: #0d6efd;
        margin-bottom: 15px;
    }

    .tab-pane p {
        font-size: 1rem;
        line-height: 1.6;
        color: #343a40;
    }

    /* Card style for inner content */
    .tab-card {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }

    .tab-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
</style>

<main class="main">
    <div class="page-header text-center" style="background-image: url('front/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Role of IR Wing</h1>
        </div>
    </div>

    <div class="page-content ir-section">

        <div class="ir-header">
            <h1>{{$roleir->title}}</h1>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="irTabs" role="tablist">
            
        </ul>

        <div class="tab-content" id="irTabsContent">
            <!-- Overview -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="tab-card">
                    <p>{!! $roleir->description !!}</p>
                </div>
            </div>

            <!-- Functions -->
            <div class="tab-pane fade" id="functions" role="tabpanel">
                <div class="tab-card">
                    <h3>Functions</h3>
                    <p>The key functions include:</p>
                    <ul>
                        <li>Maintaining harmonious employer-employee relations.</li>
                        <li>Advising management on industrial relations matters.</li>
                        <li>Monitoring labor laws and compliance.</li>
                        <li>Organizing employee engagement and welfare programs.</li>
                    </ul>
                </div>
            </div>

            <!-- Responsibilities -->
            <div class="tab-pane fade" id="responsibilities" role="tabpanel">
                <div class="tab-card">
                    <h3>Responsibilities</h3>
                    <ul>
                        <li>Resolve industrial disputes amicably.</li>
                        <li>Implement government labor policies efficiently.</li>
                        <li>Ensure employee satisfaction and engagement.</li>
                        <li>Regular reporting and analysis of workforce issues.</li>
                    </ul>
                </div>
            </div>

            <!-- Achievements -->
            <div class="tab-pane fade" id="achievements" role="tabpanel">
                <div class="tab-card">
                    <h3>Achievements</h3>
                    <ul>
                        <li>Successfully reduced workplace disputes by 40% in the last 5 years.</li>
                        <li>Implemented employee welfare programs covering over 10,000 staff.</li>
                        <li>Introduced digital grievance redressal system for faster resolution.</li>
                    </ul>
                </div>
            </div>

            <!-- Contact -->
            <div class="tab-pane fade" id="contact" role="tabpanel">
                <div class="tab-card">
                    <h3>Contact</h3>
                    <p>For any queries regarding Industrial Relations, you can contact:</p>
                    <ul>
                        <li>Head of IR Wing: Mr. XYZ</li>
                        <li>Email: irwing@dot.gov.in</li>
                        <li>Phone: +91-12345-67890</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
