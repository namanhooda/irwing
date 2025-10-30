@extends('frontend.partials.app')
@section('content')
<div class="main-content">

    <style>.event-item {
    position: relative;
    color: #fff;
    border-radius: 4px;
    padding: 2px 4px;
    font-size: 12px;
    margin-top: 3px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
}

.tooltip-box-global {
    display: none;
    position: absolute;
    background: rgba(0, 0, 0, 0.85);
    color: #fff;
    padding: 8px 10px;
    border-radius: 5px;
    font-size: 12px;
    line-height: 1.4;
    z-index: 10000;
    pointer-events: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    transition: opacity 0.1s ease-in-out;
}

        /* Government Website Design - Matching Reference */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }

        /* Fix for content behind navbar */
        .main-content {
            padding-top: 0;
            margin-top: 0;
        }

        /* Blue Banner Section - Split Layout Design */
        .blue-banner-section {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
            color: white;
            padding: 0;
            position: relative;
            overflow: hidden;
            margin-top: 0;
            padding-top: 0;
            z-index: 1;
            min-height: 300px;
            /* Reduced height */
        }

        .blue-banner-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            z-index: 1;
        }

        .banner-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            min-height: 300px;
            /* Reduced height */
            position: relative;
            z-index: 3;
            gap: 0;
            margin-bottom: 1px;
            background: white;
        }

        /* Left side - Image */
        .banner-image-side {
            height: 300px;
            background: #4a90e2;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .banner-image-side img {
            width: 70%;
            height: 90%;
            object-fit: fill;
            object-position: center;
        }

        /* Right side - Content */
        .banner-content-side {
            padding: 30px 40px;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #4a90e2;
        }

        .banner-date {
            font-size: 1.4rem;
            color: #e1f5fe;
            margin-bottom: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .banner-date i {
            color: #81d4fa;
        }

        .banner-title-new {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.3;
            color: white !important;
        }

        .banner-navigation {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 15px;
        }

        .nav-arrows {
            display: flex;
            gap: 8px;
        }

        .nav-arrow {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .nav-arrow:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.1);
        }

        .view-all-link {
            color: #e1f5fe;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        .view-all-link:hover {
            color: white;
        }

        /* Thumbnail gallery */
        .thumbnail-gallery {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .thumbnail {
            width: 50px;
            height: 38px;
            border-radius: 4px;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .thumbnail.active {
            border-color: #81d4fa;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Responsive Design for Banner */
        @media (max-width: 768px) {
            .banner-container {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .banner-image-side {
                height: 200px;
            }

            .banner-content-side {
                height: auto;
                padding: 25px 20px;
            }

            .banner-title-new {
                font-size: 1.2rem;
            }

            .thumbnail-gallery {
                justify-content: center;
            }
        }

        .banner-logo {
            width: 180px;
            height: 180px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 50px;
            flex-shrink: 0;
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .banner-logo::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .banner-logo img {
            width: 100px;
            height: 100px;
            filter: brightness(0) invert(1);
            position: relative;
            z-index: 2;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .banner-content {
            flex: 1;
            padding-right: 40px;
        }

        .banner-title {
            font-size: 3.8rem;
            font-weight: 900;
            margin-bottom: 20px;
            text-shadow:
                2px 2px 4px rgba(0, 0, 0, 0.3),
                0 0 20px rgba(255, 255, 255, 0.2);
            line-height: 1.1;
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .banner-subtitle {
            font-size: 1.9rem;
            margin-bottom: 25px;
            opacity: 0.95;
            font-weight: 500;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            line-height: 1.3;
        }

        .banner-description {
            font-size: 1.3rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .banner-features {
            display: flex;
            gap: 30px;
            margin-bottom: 25px;
        }

        .banner-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .banner-feature i {
            font-size: 1.3rem;
            color: #fbbf24;
        }

        .banner-character {
            width: 200px;
            height: auto;
            flex-shrink: 0;
        }

        /* Cool Access Bar */
        .access-bar {
            background: linear-gradient(135deg, #4a90e2 0%, #48c9b0 100%);
            color: white;
            padding: 15px 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .access-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .access-text {
            flex: 1;
        }

        .access-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .access-button:hover {
            background: white;
            color: #4a90e2;
            border-color: white;
        }

        /* Main Content Layout */
        .main-layout {
            background: white;
            padding: 0;
            margin: 0;
        }

        .main-layout .container-fluid {
            padding: 0;
            margin: 0;
            max-width: none;
        }

        .content-wrapper {
            display: grid !important;
            grid-template-columns: 300px 1fr !important;
            gap: 20px;
            min-height: 600px;
            width: 100%;
            padding: 20px;
        }

        /* Left Sidebar - Ministers */
        .ministers-sidebar {
            background: white;
            padding: 30px 20px;
            margin-top: 0px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            grid-column: 1;
        }

        .sidebar-title {
            background: #4a90e2;
            color: white;
            padding: 20px 20px;
            margin: -30px -20px 25px -20px;
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            border-radius: 8px;
        }

        .card-title {
            background: #4a90e2;
            color: white;
            padding: 15px 15px;
            margin: -15px -15px 15px -15px;
            font-size: 1.2rem;
            font-weight: 600;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .minister-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 40px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.08),
                0 4px 15px rgba(0, 0, 0, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .minister-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }

        .minister-card:hover::before {
            left: 100%;
        }

        .minister-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 8px 25px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

        .minister-photo {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 4px solid #4a90e2;
            box-shadow: 
                0 8px 20px rgba(74, 144, 226, 0.3),
                0 4px 10px rgba(0, 0, 0, 0.1),
                inset 0 2px 4px rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            background: linear-gradient(135deg, #4a90e2, #357abd);
        }

        .minister-photo::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #4a90e2, #357abd, #4a90e2);
            border-radius: 50%;
            z-index: -1;
            animation: rotate 3s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .minister-card:hover .minister-photo {
            transform: scale(1.1);
            box-shadow: 
                0 12px 30px rgba(74, 144, 226, 0.4),
                0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .minister-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .minister-card:hover .minister-photo img {
            transform: scale(1.05);
        }

        .minister-name {
            font-size: 1.35rem;
            font-weight: 800;
            color: #2c3e50;
            margin-bottom: 8px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .minister-card:hover .minister-name {
            color: #1a252f;
            transform: translateY(-2px);
        }

        .minister-title {
            font-size: 1.3rem;
            color: #6c757d;
            margin-bottom: 18px;
            line-height: 1.4;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .minister-card:hover .minister-title {
            color: #5a6c7d;
        }

        .minister-message {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            position: relative;
        }

        .minister-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #4a90e2, #357abd);
            border-radius: 1px;
        }

        .minister-message p {
            font-size: 1.15rem;
            color: #495057;
            line-height: 1.6;
            margin: 0;
            font-style: italic;
            text-align: left;
            transition: all 0.3s ease;
            position: relative;
        }

        .minister-message p::before {
            content: '"';
            font-size: 2rem;
            color: #4a90e2;
            position: absolute;
            left: -15px;
            top: -5px;
            font-family: serif;
            opacity: 0.7;
        }

        .minister-message p::after {
            content: '"';
            font-size: 2rem;
            color: #4a90e2;
            position: absolute;
            right: -10px;
            bottom: -15px;
            font-family: serif;
            opacity: 0.7;
        }

        .minister-card:hover .minister-message p {
            color: #2c3e50;
            transform: translateY(-1px);
        }

        .minister-social {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .social-icon {
            width: 35px;
            height: 35px;
            background: #4a90e2;
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: #357abd;
            transform: scale(1.1);
        }

        /* Right Content Area */
        .content-area {
            padding: 30px;
            max-height: 730px;
            display: flex;
            flex-direction: column;
            grid-column: 2;
        }

        /* Tabbed Navigation */
        .content-tabs {
            display: flex;
            background: #4a90e2;
            border-radius: 10px 10px 0 0;
            overflow: hidden;
            margin-bottom: 0;
            flex-shrink: 0; /* Prevent tabs from shrinking */
        }

        .tab-button {
            flex: 1;
            padding: 18px 20px;
            background: #4a90e2;
            color: white;
            border: none;
            font-size: 1.7rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .tab-button:last-child {
            border-right: none;
        }

        .tab-button.active,
        .tab-button:hover {
            background: #4a90e2;
        }

        /* Tab Content */
        .tab-content {
            background: white;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 10px 10px;
            padding-left: 5px;
            flex: 1; /* This makes the tab content expand to fill available space */
            display: flex;
            flex-direction: column;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: flex;
            flex-direction: column;
            flex: 1; /* Ensure tab pane expands to fill available space */
            min-height: 100%; /* Ensure minimum height */
        }

        .update-item {
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .update-item:last-child {
            border-bottom: none;
        }

        .update-item:hover {
            background: #f8f9fa;
            margin: 0 -30px;
            padding-left: 40px;
            padding-right: 30px;
            border-radius: 8px;
        }

        .update-date {
            color: #4a90e2;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .update-text {
            color: #2c3e50;
            font-size: 1.15rem;
            line-height: 1.6;
        }

        .read-more-btn {
            background: #4a90e2;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .read-more-btn:hover {
            background: #357abd;
            transform: translateY(-2px);
        }

        /* Auto-scroll container for updates */
        .updates-scroll-container {
            flex: 1; /* This makes the container expand to fill available space */
            overflow: hidden;
            position: relative;
            border-radius: 10px;
            background: white;
            padding: 20px;
        }

        .updates-scroll-content {
            animation: continuousScroll 90s linear infinite;
            position: relative;
        }

        .updates-scroll-content:hover {
            animation-play-state: paused;
        }

        @keyframes continuousScroll {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-100%);
            }
        }

        .update-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            transition: background 0.3s ease;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Calendar Styles */
        .calendar-section {
            background: white;
            padding: 50px 0;
            text-align: center;
        }

        .calendar-section .section-header {
            text-align: left;
            margin-bottom: 40px;
        }

        .calendar-section .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
            text-align: left;
            display: inline-block;
            width: 100%;
        }

        .calendar-content-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .calendar-left-column {
            /* Calendar takes full left column */
        }

        .calendar-right-column {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .social-media-header {
            background: #4a90e2;
            color: white;
            padding: 20px;
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .social-media-scroll-container {
            height: 399px;
            overflow: hidden;
            position: relative;
            background: white;
            padding: 20px;
        }

        .social-media-scroll-content {
            animation: continuousScroll 60s linear infinite;
            position: relative;
        }

        .social-media-scroll-content:hover {
            animation-play-state: paused;
        }

        .social-media-item {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 18px;
            box-shadow: 
                0 4px 15px rgba(0, 0, 0, 0.08),
                0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .social-media-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .social-media-item:hover::before {
            left: 100%;
        }

        .social-media-item:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 
                0 8px 25px rgba(0, 0, 0, 0.12),
                0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .social-simple-row {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .social-platform-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            flex-shrink: 0;
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.2),
                0 2px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .social-platform-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            pointer-events: none;
        }

        .social-media-item:hover .social-platform-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 
                0 6px 18px rgba(0, 0, 0, 0.25),
                0 3px 9px rgba(0, 0, 0, 0.15);
        }

        .social-text-content {
            flex: 1;
            padding-top: 5px;
        }

        .social-text-content .social-link {
            color: #2c3e50;
            text-decoration: none;
            line-height: 1.5;
            font-size: 1.1rem;
            display: block;
        }

        .social-text-content .social-link:hover {
            color: #4a90e2;
            text-decoration: underline;
        }

        .social-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .social-card-logo {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .social-card-info h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .social-card-info p {
            font-size: 0.8rem;
            color: #6c757d;
            margin: 0;
        }

        .social-card-content {
            margin-bottom: 15px;
        }

        .social-card-content p {
            font-size: 0.9rem;
            color: #495057;
            line-height: 1.5;
            margin: 0 0 10px 0;
        }

        .social-card-stats {
            display: flex;
            justify-content: space-around;
            margin: 15px 0;
            padding: 10px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .social-stat {
            text-align: center;
        }

        .social-stat-number {
            font-size: 1.2rem;
            font-weight: 800;
            color: #2c3e50;
            display: block;
        }

        .social-stat-label {
            font-size: 0.7rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
        }

        .social-follow-btn {
            background: #4a90e2;
            color: white !important;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            text-align: center;
        }

        .social-follow-btn:hover {
            background: #357abd;
            transform: scale(1.02);
            color: white;
        }

        .calendar-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
        }

        .calendar-header {
            background: #4a90e2;
            color: white;
            padding: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .calendar-nav {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .calendar-nav:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .calendar-selectors {
            display: flex;
            gap: 10px;
            align-items: center;
            flex: 1;
            justify-content: center;
        }

        .calendar-dropdown {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 1.3rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
            backdrop-filter: blur(10px);
        }

        .calendar-dropdown:focus {
            outline: none;
            border-color: white;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2);
        }

        .calendar-dropdown:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-1px);
        }

        .calendar-dropdown option {
            background: #4a90e2;
            color: white;
            padding: 8px;
        }

        #calendarTitle {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            width: 100%;
        }

        .calendar-day-header {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-weight: 600;
            color: #2c3e50;
            border-right: 1px solid #dee2e6;
        }

        .calendar-day-header:last-child {
            border-right: none;
        }

        .calendar-days {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            width: 100%;
        }

        .calendar-day {
            min-height: 70px;
            padding: 8px;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            position: relative;
            background: white;
            transition: background 0.3s ease;
            box-sizing: border-box;
            width: 100%;
            overflow: hidden;
        }

        .calendar-day:hover {
            background: #f8f9fa;
        }

        .calendar-day.empty {
            background: #f5f5f5;
        }

        .calendar-day-number {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .calendar-day.today {
            background: #e8f4fd;
        }

        .calendar-day.today .calendar-day-number {
            color: #4a90e2;
            font-weight: 700;
        }

        .event-item {
            background: #4a90e2;
            color: white;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 0.7rem;
            margin-bottom: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
            word-wrap: break-word;
            white-space: normal;
            line-height: 1.1;
            max-width: 100%;
            box-sizing: border-box;
        }

        .event-item:hover {
            background: #357abd;
            transform: scale(1.02);
        }

        .event-item.multi-day {
            background: linear-gradient(135deg, #4a90e2 0%, #48c9b0 100%);
        }

        /* Responsive Calendar */
        @media (max-width: 768px) {
            .calendar-container {
                margin: 0 15px;
            }

            .calendar-header {
                padding: 15px;
                flex-direction: column;
                gap: 10px;
            }

            .calendar-selectors {
                order: -1;
                flex-direction: column;
                gap: 8px;
            }

            .calendar-dropdown {
                min-width: 100px;
                font-size: 0.9rem;
                padding: 6px 10px;
            }

            .calendar-day {
                min-height: 80px;
                padding: 5px;
            }

            .calendar-day-number {
                font-size: 1rem;
            }

            .event-item {
                font-size: 0.7rem;
                padding: 2px 4px;
            }

            .calendar-content-wrapper {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .social-media-scroll-container {
                height: 400px;
            }
        }

        /* Social Media Cards */
        .social-media-section {
            background: #f8f9fa;
            padding: 50px 0;
        }

        .social-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .social-media-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
            height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .social-media-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .social-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-card-logo {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .social-card-info h5 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .social-card-info p {
            font-size: 0.9rem;
            color: #6c757d;
            margin: 0;
        }

        .social-card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .social-card-stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }

        .social-stat {
            text-align: center;
        }

        .social-stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2c3e50;
            display: block;
        }

        .social-stat-label {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
        }

        .social-follow-btn {
            background: #4a90e2;
            color: white !important;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .social-follow-btn:hover {
            background: #357abd;
            transform: scale(1.05);
            color: white;
        }

        /* Social Media Links */
        .social-link {
            color: #2c3e50;
            text-decoration: none;
            transition: color 0.3s ease;

        }

        .social-link:hover {
            color: #4a90e2;
            text-decoration: underline;
        }

        .video-link {
            color: white !important;
            text-decoration: none;
        }

        .video-link:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .services-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 991px) {
            .main.government-home {
                padding-top: 30px !important;
            }

            .banner-container {
                flex-direction: column;
                text-align: center;
                padding: 50px 0 40px 0;
            }

            .banner-logo {
                margin-right: 0;
                margin-bottom: 30px;
            }

            .banner-content {
                padding-right: 0;
            }

            .banner-features {
                justify-content: center;
                flex-wrap: wrap;
            }

            .content-wrapper {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .ministers-sidebar {
                width: 100%;
            }

            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .social-cards-grid {
                grid-template-columns: 1fr;
            }

            /* Calendar responsive design */
            .calendar-content-wrapper {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .calendar-left-column,
            .calendar-right-column {
                width: 100%;
            }

            .calendar-container {
                max-width: 100%;
            }

            .social-media-scroll-container {
                max-height: 400px;
            }
        }

        @media (max-width: 768px) {
            .banner-title {
                font-size: 2.5rem;
            }

            .banner-subtitle {
                font-size: 1.4rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .content-tabs {
                flex-direction: column;
            }

            .tab-button {
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }

            .tab-button:last-child {
                border-bottom: none;
            }

            /* Calendar mobile adjustments */
            .calendar-header {
                flex-direction: column;
                gap: 15px;
            }

            .calendar-selectors {
                order: 1;
                display: flex;
                gap: 10px;
                justify-content: center;
            }

            .calendar-nav {
                order: 2;
                align-self: center;
            }

            .calendar-dropdown {
                font-size: 0.9rem;
                padding: 8px 12px;
            }
        }

        @media (max-width: 576px) {
            .main.government-home {
                padding-top: 40px !important;
            }

            .banner-container {
                padding: 40px 0 30px 0;
            }

            .banner-title {
                font-size: 2rem;
            }

            .banner-subtitle {
                font-size: 1.2rem;
            }

            .content-area {
                padding: 20px;
            }

            .ministers-sidebar {
                padding: 20px 15px;
            }

            .service-tile {
                height: 140px;
                padding: 20px 15px;
            }

            /* Calendar mobile optimizations */
            .calendar-section {
                padding: 30px 0;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .calendar-content-wrapper {
                gap: 20px;
            }

            .calendar-grid {
                font-size: 0.85rem;
            }

            .calendar-day-number {
                font-size: 1rem;
            }

            .event-item {
                font-size: 0.75rem;
                padding: 2px 4px;
            }

            .social-media-header {
                font-size: 1.1rem;
            }

            .social-media-scroll-container {
                max-height: 350px;
            }

            .social-media-item {
                padding: 15px;
            }

            .social-platform-icon {
                width: 35px;
                height: 35px;
                font-size: 1.1rem;
            }

            .social-text-content .social-link {
                font-size: 1rem;
            }
        }

        /* --- NEW CSS for Priority Areas Section --- */
        .priority-areas-section {
            padding: 50px 0;
            background: #f8f9fa;
            /* Light background to separate sections */
        }

        .priority-areas-header {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .engagement-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .engagement-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            box-shadow: 
                0 8px 25px rgba(0, 0, 0, 0.08),
                0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .engagement-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(74, 144, 226, 0.05) 0%, rgba(53, 122, 189, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .engagement-card:hover::before {
            opacity: 1;
        }

        .engagement-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .card-image-wrapper {
            height: 180px;
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
            overflow: hidden;
            position: relative;
        }

        .card-image-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.1) 100%);
            pointer-events: none;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
            filter: brightness(0.9) contrast(1.1);
        }

        .engagement-card:hover .card-image {
            transform: scale(1.1);
            filter: brightness(1) contrast(1.2);
        }

        .card-content {
            padding: 25px;
            min-height: 130px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .card-content h3 {
            font-size: 1.3rem;
            font-weight: 800;
            color: #2c3e50;
            margin-bottom: 12px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .engagement-card:hover .card-content h3 {
            color: #1a252f;
            transform: translateY(-2px);
        }

        .card-content p {
            font-size: 1.25rem;
            color: #495057;
            line-height: 1.6;
            transition: all 0.3s ease;
            flex-grow: 1;
        }

        .engagement-card:hover .card-content p {
            color: #2c3e50;
        }

        /* Responsive adjustments for the new section */
        @media (max-width: 991px) {
            .engagement-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .engagement-grid {
                grid-template-columns: 1fr;
            }

            .priority-areas-header {
                font-size: 2rem;
                margin-bottom: 20px;
                padding-left: 15px;
            }

            .priority-areas-section {
                padding: 30px 0;
            }
        }

        /* --- NEW CSS for India's Ambitions in ITU Section --- */
        .itu-ambitions-section {
            padding: 50px 0;
            background: #ffffff;
            /* White background */
        }

        .itu-section-header {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 30px;
            padding-left: 15px;
            /* Adjust padding to match container if needed */
        }

        .itu-card {
            padding: 40px;
            border: none;
            border-radius: 20px;
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.08),
                0 5px 15px rgba(0, 0, 0, 0.05);
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .itu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(74, 144, 226, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .itu-card:hover::before {
            left: 100%;
        }

        .itu-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.12),
                0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .itu-content-wrapper {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        .itu-image-container {
            flex-shrink: 0;
            width: 280px;
            height: 200px;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 
                0 8px 20px rgba(0, 0, 0, 0.1),
                0 4px 10px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .itu-image-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(74, 144, 226, 0.1) 0%, rgba(53, 122, 189, 0.1) 100%);
            pointer-events: none;
        }

        .itu-collaboration-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
            filter: brightness(0.95) contrast(1.1);
        }

        .itu-card:hover .itu-collaboration-image {
            transform: scale(1.05);
            filter: brightness(1) contrast(1.2);
        }

        .itu-text-content {
            flex-grow: 1;
            font-size: 1.3rem;
            color: #495057;
        }

        .itu-text-content p {
            margin-bottom: 15px;
            font-size: 1.3rem;
            line-height: 1.6;
        }

        .itu-text-content ul {
            list-style: none;
            font-size: 1.3rem;
            padding: 0;
            margin-bottom: 20px;
        }

        .itu-text-content li {
            font-size: 1.3rem;
            position: relative;
            padding-left: 1.5em;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .itu-text-content li::before {
            content: '\2022';
            /* Bullet point character */
            color: #4a90e2;
            /* Blue color for bullet */
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
            font-size: 1.2em;
        }

        .itu-more-link {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
            display: block;
            text-align: right;
        }

        .itu-more-link:hover {
            text-decoration: underline;
            color: #357abd;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .itu-content-wrapper {
                flex-direction: column;
                gap: 20px;
            }

            .itu-image-container {
                width: 100%;
                height: 200px;
            }

            .itu-section-header {
                font-size: 2rem;
                padding-left: 0;
            }

            .itu-card {
                padding: 20px;
            }
        }

    </style>

    <main class="main government-home" style="padding-top: 0;">
        <!-- Blue Banner Section - Split Layout -->
        <section class="blue-banner-section">
    <div class="container-fluid p-0">
        <div class="banner-container">
            <!-- Left side - Image -->
            <div class="banner-image-side" onclick="goToSlideUrl(currentSlide)" style="cursor:pointer;">
                <img src="{{ $sliders->first() ? asset('storage/' . $sliders->first()->image) : asset('images/default.jpg') }}"
                     alt="Banner Image" id="mainBannerImage">
            </div>

            <!-- Right side - Content -->
            <div class="banner-content-side">
                <div class="banner-date">
                    <i class="bi bi-calendar3"></i>
                    <span id="bannerDate">
                        {{ $sliders->first() && $sliders->first()->date ? \Carbon\Carbon::parse($sliders->first()->date)->format('F d, Y') : '' }}

                    </span>
                </div>

                <h1 class="banner-title-new" id="bannerTitle" onclick="goToSlideUrl(currentSlide)" style="cursor:pointer;">
                    {{ $sliders->first()->title ?? '' }}
                </h1>

                <div class="banner-navigation">
                    <div class="nav-arrows">
                        <button class="nav-arrow" onclick="previousSlide()">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="nav-arrow" onclick="togglePause()">
                            <i class="bi bi-pause-fill" id="pauseIcon"></i>
                        </button>
                        <button class="nav-arrow" onclick="nextSlide()">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="thumbnail-gallery">
                    @foreach ($sliders as $index => $slider)
                    <div class="thumbnail {{ $loop->first ? 'active' : '' }}" onclick="goToSlide({{ $index }})" style="cursor:pointer;">
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Thumbnail {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@php
$slideData = $sliders->map(function($slider) {
    return [
        'image' => asset('storage/' . $slider->image),
        'title' => $slider->title,
        'date'  => $slider->date,
        'url' => $slider->url ?: url('slider-page/'.$slider->id),
    ];
});
@endphp

<script>
let currentSlide = 0;
let isPaused = false;
let slideInterval;

const slides = @json($slideData);

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
}

function updateSlide(index) {
    const slide = slides[index];
    document.getElementById('mainBannerImage').src = slide.image;
    document.getElementById('bannerDate').textContent = slide.date ? formatDate(slide.date) : '';
    document.getElementById('bannerTitle').textContent = slide.title ?? '';

    document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
        thumb.classList.toggle('active', i === index);
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    updateSlide(currentSlide);
}

function previousSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    updateSlide(currentSlide);
}

function goToSlide(index) {
    currentSlide = index;
    updateSlide(currentSlide);
}

function goToSlideUrl(index) {
    const slide = slides[index];
    if (slide.url) {
        window.location.href = slide.url;
    }
}

function togglePause() {
    const pauseIcon = document.getElementById('pauseIcon');
    if (isPaused) {
        isPaused = false;
        pauseIcon.classList.remove('bi-play-fill');
        pauseIcon.classList.add('bi-pause-fill');
        startAutoSlide();
    } else {
        isPaused = true;
        pauseIcon.classList.remove('bi-pause-fill');
        pauseIcon.classList.add('bi-play-fill');
        clearInterval(slideInterval);
    }
}

function startAutoSlide() {
    clearInterval(slideInterval); // clear any existing interval
    slideInterval = setInterval(() => {
        if (!isPaused) nextSlide();
    }, 4000);
}

// Initialize first slide
updateSlide(currentSlide);
startAutoSlide();

// Pause on hover
document.querySelector('.blue-banner-section').addEventListener('mouseenter', () => clearInterval(slideInterval));
document.querySelector('.blue-banner-section').addEventListener('mouseleave', () => {
    if (!isPaused) startAutoSlide();
});
</script>


        <!-- Cool Access Bar -->
        {{-- <section class="access-bar">
        <div class="container">
            <div class="access-content">
                <div class="access-text">
                    "Sanchar Saathi" - an Integrated Citizen Centric Web Portal
                </div>
                <a href="#" class="access-button">ACCESS NOW</a>
            </div>
        </div>
    </section> --}}
        {{-- <br></br> --}}

        <!-- Main Content Layout -->
        <section class="main-layout">
            <div class="container-fluid">
                <div class="content-wrapper">
                    <!-- Left Sidebar - Ministers -->
                    <div class="ministers-sidebar">
                        <!-- <div class="minister-card" onclick="window.location.href='/message/moc'" style="cursor: pointer;">
                        <div class="card-title">Message from Hon'ble MoC</div>
                        <div class="minister-photo">
                            <img src="{{asset('images/j.png')}}" alt="Minister">
                        </div>
                        <div class="minister-name">Hon'ble Union Minister</div>
                        <div class="minister-title">Shri Jyotiraditya M Scindia</div>
                        <div class="minister-message">
                            <p>Welcome to the Department of Telecommunications. Our commitment is to ensure seamless digital connectivity for every citizen of India. Through innovative programs, improved infrastructure, and technology-driven policies...</p>
                        </div>
                    </div>

                    <div class="minister-card" onclick="window.location.href='/message/smoc'" style="cursor: pointer;">
                        <div class="card-title">Message from Hon'ble SMoC</div>
                        <div class="minister-photo">
                            <img src="{{asset('images/p.png')}}" alt="Secretary">
                        </div>
                        <div class="minister-name">Hon'ble Minister of State</div>
                        <div class="minister-title">Dr. Pemmasani Chandra Sekhar</div>
                        <div class="minister-message">
                            <p>Innovation in telecommunications is key to bridging the digital divide. We are working tirelessly to ensure every citizen has access to quality communication services and emerging technologies.</p>
                        </div>
                    </div>
                </div>      -->


                        @foreach ($ministers as $minister)
                        <div class="minister-card" onclick="window.location.href='/message/{{ $minister->id }}'"
                            style="cursor: pointer;">
                            <div class="card-title">{{ $minister->title }}</div>
                            <div class="minister-photo">
                                <img src="{{ asset('storage/' . $minister->photo) }}"
                                    alt="{{ $minister->minister_name }}">
                            </div>
                            <div class="minister-name">{{ $minister->postion }}</div>
                            <div class="minister-title">{{ $minister->minister_name }}</div>
                            <div class="minister-message">
                                <p>{{ Str::limit($minister->message, 35, '...') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Right Content Area -->
                    <div class="content-area">
                        <!-- Single Tab Header -->
                        <div class="content-tabs">
                            <button class="tab-button active" style="width: 100%;">Latest Updates and Circulars</button>
                        </div>

                        <!-- Single Tab Content -->
                       <div class="tab-content">
    <div id="all-updates" class="tab-pane active">
        <div class="updates-scroll-container">
            <div class="updates-scroll-content" id="scrollContent">
                {{-- Repeat the circulars twice so it never goes blank --}}
                @for($i = 0; $i < 2; $i++)
                    @foreach($circulars as $circular)
                        <div class="update-item">
                            <a href="{{ $circular->url }}" target="_blank">
                                <div class="update-date">{{ $circular->title }}</div>
                            </a>
                            <div class="update-text">{{ $circular->description }}</div>
                        </div>
                    @endforeach
                @endfor
            </div>
        </div>
    </div>
</div>

<style>
.updates-scroll-container {
    flex: 1; /* Expand to fill available space */
    overflow-y: auto; /* Allow manual scroll */
    scroll-behavior: smooth; /* Smooth scroll on mouse */
    border: 1px solid #e1e1e1;
    border-radius: 8px;
    padding-right: 10px;
}

.updates-scroll-content {
    display: flex;
    flex-direction: column;
}

.update-item {
    padding: 10px 15px;
    border-bottom: 1px solid #ddd;
    transition: background-color 0.2s ease;
}

.update-item:hover {
    background-color: #f8f9fa;
}

.update-date {
    font-weight: 600;
    color: #0d6efd;
    margin-bottom: 5px;
}

.update-text {
    color: #495057;
    font-size: 14px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const scrollContainer = document.querySelector('.updates-scroll-container');

    // Optional smooth scroll on mouse wheel
    scrollContainer.addEventListener('wheel', (e) => {
        e.preventDefault();
        scrollContainer.scrollBy({
            top: e.deltaY,
            behavior: 'smooth'
        });
    });
});
</script>


                    </div>
                </div>
            </div>
        </section>

        <!-- EVENTS CALENDAR -->
        <section class="calendar-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">EVENTS CALENDAR & SOCIAL MEDIA FEED</h2>
                </div>
                <div class="calendar-content-wrapper">
                    <!-- Left Column - Calendar -->
                    <div class="calendar-left-column">
                        <div class="calendar-container">
                            <div class="calendar-header">
                                <button class="calendar-nav" id="prevMonth">&lt;</button>
                                <div class="calendar-selectors">
                                    <select class="calendar-dropdown" id="monthSelect">
                                        <option value="0">January</option>
                                        <option value="1">February</option>
                                        <option value="2">March</option>
                                        <option value="3">April</option>
                                        <option value="4">May</option>
                                        <option value="5">June</option>
                                        <option value="6">July</option>
                                        <option value="7">August</option>
                                        <option value="8">September</option>
                                        <option value="9">October</option>
                                        <option value="10">November</option>
                                        <option value="11">December</option>
                                    </select>
                                    <select class="calendar-dropdown" id="yearSelect">
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                    </select>
                                </div>
                                <button class="calendar-nav" id="nextMonth">&gt;</button>
                            </div>
                            <div class="calendar-grid">
                                <div class="calendar-day-header">Sun</div>
                                <div class="calendar-day-header">Mon</div>
                                <div class="calendar-day-header">Tue</div>
                                <div class="calendar-day-header">Wed</div>
                                <div class="calendar-day-header">Thu</div>
                                <div class="calendar-day-header">Fri</div>
                                <div class="calendar-day-header">Sat</div>
                                <div id="calendarDays" class="calendar-days"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Social Media Feed -->
                    <div class="calendar-right-column">
    <div class="social-media-header">Social Media Feed</div>

    <div class="social-media-scroll-container" style="max-height: 400px; overflow-y: auto; scroll-behavior: smooth;">
        <div class="social-media-scroll-content" id="socialScrollContent">

            {{-- Loop entries twice so it never looks empty --}}
            @for($i = 0; $i < 2; $i++)
                <!-- Instagram -->
                @if($instagram)
                <div class="social-media-item">
                    <div class="social-simple-row">
                        <div class="social-platform-icon" style="background: #E4405F;">
                            <i class="bi bi-instagram"></i>
                        </div>
                        <div class="social-text-content">
                            <a href="{{ $instagram->url }}" target="_blank" class="social-link">
                                {{ $instagram->description }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Facebook -->
                @if($facebook)
                <div class="social-media-item">
                    <div class="social-simple-row">
                        <div class="social-platform-icon" style="background: #1877F2;">
                            <i class="bi bi-facebook"></i>
                        </div>
                        <div class="social-text-content">
                            <a href="{{ $facebook->url }}" target="_blank" class="social-link">
                                {{ $facebook->description }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- YouTube -->
                @if($youtube)
                <div class="social-media-item">
                    <div class="social-simple-row">
                        <div class="social-platform-icon" style="background: #FF0000;">
                            <i class="bi bi-youtube"></i>
                        </div>
                        <div class="social-text-content">
                            <a href="{{ $youtube->url }}" target="_blank" class="social-link">
                                {{ $youtube->description }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Twitter -->
                @if($twitter)
                <div class="social-media-item">
                    <div class="social-simple-row">
                        <div class="social-platform-icon" style="background: #1DA1F2;">
                            <i class="bi bi-twitter"></i>
                        </div>
                        <div class="social-text-content">
                            <a href="{{ $twitter->url }}" target="_blank" class="social-link">
                                {{ $twitter->description }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- LinkedIn -->
                @if($linkedin)
                <div class="social-media-item">
                    <div class="social-simple-row">
                        <div class="social-platform-icon" style="background: #0A66C2;">
                            <i class="bi bi-linkedin"></i>
                        </div>
                        <div class="social-text-content">
                            <a href="{{ $linkedin->url }}" target="_blank" class="social-link">
                                {{ $linkedin->description }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            @endfor

        </div>
    </div>
</div>

                </div>
            </div>
        </section>
        <section class="priority-areas-section">
    <div class="container">
        <h1 class="priority-areas-header">Priority Areas for Engagements</h1>
        <div class="engagement-grid">
            @forelse ($engagements as $engagement)
                <div class="engagement-card">
                    <a href="{{url('enagement/'.$engagement->id)}}">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('storage/' . $engagement->image) }}" 
                             alt="{{ $engagement->title }}" class="card-image">
                    </div>
                    <div class="card-content">
                        <h3>{{ $engagement->title }}</h3>
                        <p>{!! nl2br(e($engagement->description)) !!}</p>
                    </div></a>
                </div>
            @empty
                <p>No engagements available at the moment.</p>
            @endforelse
        </div>
    </div>
</section>

        <section class="itu-ambitions-section">
            <div class="container">
                <h1 class="itu-section-header">India's Ambitions in ITU</h1>

                @if($ambition)
                <div class="itu-card">
                    <div class="itu-content-wrapper">
                        <div class="itu-image-container">
                            <img src="{{ asset('storage/' . $ambition->image) }}" alt="{{ $ambition->title }}">
                        </div>
                        <div class="itu-text-content">
                            <h2>{{ $ambition->title }}</h2>
                            <p>{!! $ambition->description !!}</p>
                        </div>
                    </div>
                </div>
                @else
                <p>No ambition data available.</p>
                @endif
            </div>
        </section>


        </section>
    </main>
<script>
    let currentDate = new Date();

    // Laravel events passed from backend
    const events = @json($events);

    // Format events for JS
    const formattedEvents = events.map(event => ({
        title: event.title,
        date: new Date(event.from_date),
        endDate: event.to_date ? new Date(event.to_date) : null,
        color: event.color || '#007bff'
    }));

    function formatDate(date) {
        const d = new Date(date);
        return d.toLocaleDateString('en-IN', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    // Create global tooltip
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip-box-global';
    document.body.appendChild(tooltip);

    function showTooltip(e, content) {
        tooltip.innerHTML = content;
        tooltip.style.display = 'block';
        tooltip.style.left = e.pageX + 15 + 'px';
        tooltip.style.top = e.pageY + 15 + 'px';
    }

    function hideTooltip() {
        tooltip.style.display = 'none';
    }

    function renderCalendar() {
        const calendarDays = document.getElementById('calendarDays');
        const monthSelect = document.getElementById('monthSelect');
        const yearSelect = document.getElementById('yearSelect');

        monthSelect.value = currentDate.getMonth();
        yearSelect.value = currentDate.getFullYear();

        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());

        const endDate = new Date(lastDay);
        endDate.setDate(endDate.getDate() + (6 - lastDay.getDay()));

        calendarDays.innerHTML = '';
        let currentDay = new Date(startDate);

        while (currentDay <= endDate) {
            const dayDiv = document.createElement('div');
            dayDiv.className = 'calendar-day';

            if (currentDay.getMonth() !== currentDate.getMonth()) {
                dayDiv.classList.add('empty');
            } else {
                const dayNumber = document.createElement('div');
                dayNumber.className = 'calendar-day-number';
                dayNumber.textContent = currentDay.getDate();
                dayDiv.appendChild(dayNumber);

                // Filter matching events
                const dayEvents = formattedEvents.filter(event => {
                    if (event.endDate) {
                        return currentDay >= event.date && currentDay <= event.endDate;
                    }
                    return currentDay.toDateString() === event.date.toDateString();
                });

                dayEvents.forEach(event => {
                    const eventDiv = document.createElement('div');
                    eventDiv.className = 'event-item';
                    eventDiv.textContent = event.title;
                    eventDiv.style.backgroundColor = event.color;

                    // Tooltip content
                    const tooltipContent = `
                        <strong>${event.title}</strong><br>
                        ${formatDate(event.date)} - ${event.endDate ? formatDate(event.endDate) : formatDate(event.date)}
                    `;

                    // Hover & mousemove handlers
                    eventDiv.addEventListener('mouseenter', e => showTooltip(e, tooltipContent));
                    eventDiv.addEventListener('mousemove', e => {
                        tooltip.style.left = e.pageX + 15 + 'px';
                        tooltip.style.top = e.pageY + 15 + 'px';
                    });
                    eventDiv.addEventListener('mouseleave', hideTooltip);

                    dayDiv.appendChild(eventDiv);
                });
            }

            calendarDays.appendChild(dayDiv);
            currentDay.setDate(currentDay.getDate() + 1);
        }
    }

    document.getElementById('prevMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    document.getElementById('monthSelect').addEventListener('change', (e) => {
        currentDate.setMonth(parseInt(e.target.value));
        renderCalendar();
    });

    document.getElementById('yearSelect').addEventListener('change', (e) => {
        currentDate.setFullYear(parseInt(e.target.value));
        renderCalendar();
    });

    renderCalendar();
</script>


</div>
@endsection
