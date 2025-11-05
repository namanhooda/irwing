<link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@latest/tabler-icons.min.css">
<script src="https://unpkg.com/@tabler/icons@latest/icons-react.min.js"></script>


<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <!-- Add logo image or SVG here if needed -->
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-3"><a href="/"
                    class="logo d-flex align-items-center me-auto">
                    <!-- <img src="{{ asset('assets/img/logo-01.jpg') }}" alt="ailifebot logo" class="img-fluid"> -->
                    <!-- <h1 class="sitename">QuickStart</h1> -->

                    <span class="app-brand-text demo text-heading fw-bold">IR WING</span></a></span>
        </a>

        <!-- <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti tabler-layout-sidebar-right-expand d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
        </a> -->
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item ">
            <a href="{{route('dashboard')}}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

    @php
    $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();
    @endphp
    @if($activeRole == 'admin')
        <li class="menu-item ">
            <a href="{{route('dashboard2')}}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-layout-dashboard"></i>
                <div data-i18n="Dashboard 2">Dashboard 2</div>
            </a>
        </li>
        @endif

        

        <!-- Apps & Pages Header -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps & Pages">Apps &amp; Pages</span>
        </li>


        {{-- Submission --}}
        @roleCanAny(['submission.personal_performa.view', 'submission.tour_reports.view','submission.qrp.view'])
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="menu-icon icon-tabler icon-tabler-file-text" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 9h1m4 0h1" />
                    <path d="M9 13h6" />
                    <path d="M9 17h6" />
                </svg>

                <div data-i18n="Submission">Submission</div>
            </a>
            <ul class="menu-sub">
                @roleCan('submission.personal_performa.view')
                <li class="menu-item">
                    <a href="{{ route('personal-performa.index') }}" class="menu-link">
                        <div>Personal Performa</div>
                    </a>
                </li>
                @endroleCan

                @roleCan('submission.tour_reports.view')
                <li class="menu-item">
                    <a href="{{route('tour-reports.index')}}" class="menu-link">
                        <div>Tour Reports and Presentations</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('submission.qrp.view')
                <li class="menu-item"><a href="{{route('qrp.index')}}" class="menu-link">
                        <div>QRP</div>
                    </a></li>
                @endroleCan
            </ul>
        </li>
        @endroleCanAny

        {{-- Generation --}}
        @roleCanAny(['generation.personal_performa.view', 'generation.visit_tracker.view',
        'generation.sanction_memos.view', 'generation.qrp.view'])
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <span class="menu-icon">
                    <!-- Example SVG icon for 'edit' -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-pencil" viewBox="0 0 16 16">
                        <path
                            d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708L4.207 14.793l-3 1a.5.5 0 0 1-.641-.641l1-3L12.146.854zM11.207 2L3 10.207V11h.793L13 2.793 11.207 2zm1.586 1.586L13 4.793 14.207 6 14.793 5.414 12.793 3.414z" />
                    </svg>
                </span>
                <div data-i18n="Generation">Generation</div>
            </a>
            <ul class="menu-sub">
                @roleCan('generation.personal_performa.view')
                <li class="menu-item"><a href="{{ route('personal-performa-generation.index') }}" class="menu-link">
                        <div>Personal Performa</div>
                    </a></li>
                @endroleCan

                @roleCan('generation.visit_tracker.view')
                <li class="menu-item"><a href="{{ route('tourTracker.index') }}" class="menu-link">
                        <div>Tour tracker</div>
                    </a></li>
                @endroleCan

                @roleCan('generation.sanction_memos.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Sanction Memos</div>
                    </a></li>
                @endroleCan


                @roleCan('generation.qrp.view')
                <li class="menu-item"><a href="{{route('qrp-generation.index')}}" class="menu-link">
                        <div>QRP</div>
                    </a></li>
                @endroleCan
            </ul>
        </li>
        @endroleCanAny

        {{-- Repository --}}
        @roleCanAny(['repository.tour_reports.view', 'repository.presentations.view', 'repository.action_points.view',
        'repository.officer_database.view', 'repository.itu_focal_points.view',
        'repository.indian_mission_contact.view', 'repository.country_mission_master_sheet.view'])
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="menu-icon icon-tabler icon-tabler-address-book"
                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 4a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-10z" />
                    <path d="M10 16v-1a3 3 0 0 1 6 0v1" />
                    <path d="M13 11a2 2 0 1 0 -2 -2a2 2 0 0 0 2 2z" />
                </svg>
                <div data-i18n="Repository">Repository</div>
            </a>
            <ul class="menu-sub">
                @roleCan('repository.tour_reports.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Tour Reports</div>
                    </a></li>
                @endroleCan

                @roleCan('repository.presentations.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Presentations</div>
                    </a></li>
                @endroleCan

                @roleCan('repository.action_points.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Action Points</div>
                    </a></li>
                @endroleCan

                @roleCan('repository.officer_database.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Officer Database</div>
                    </a></li>
                @endroleCan

                @roleCan('repository.itu_focal_points.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>ITU Focal points</div>
                    </a></li>
                @endroleCan

                @roleCan('repository.indian_mission_contact.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Indian Mission contact</div>
                    </a></li>
                @endroleCan

                @roleCan('repository.country_mission_master_sheet.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Country's Mission Master sheet</div>
                    </a></li>
                @endroleCan
            </ul>
        </li>
        @endroleCanAny

        {{-- Engagement --}}
        @roleCanAny(['engagement.bilateral_tracker.view', 'engagement.multilateral_tracker.view',
        'engagement.mou_foreign_countries.view', 'engagement.country_profile.view',
        'engagement.itu_council_tracker.view', 'engagement.itu_council_emails.view'])
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="menu-icon icon-tabler icon-tabler-world" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M3.6 9h16.8" />
                    <path d="M3.6 15h16.8" />
                    <path d="M12 3a16 16 0 0 0 0 18" />
                    <path d="M12 3a16 16 0 0 1 0 18" />
                </svg>
                <div data-i18n="Bilateral & Multilateral">Bilateral & Multilateral Engagement</div>
            </a>
            <ul class="menu-sub">
                @roleCan('engagement.bilateral_tracker.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Bilateral Engagement Tracker</div>
                    </a></li>
                @endroleCan

                @roleCan('engagement.multilateral_tracker.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Multilateral Engagement Tracker</div>
                    </a></li>
                @endroleCan

                @roleCan('engagement.mou_foreign_countries.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>MoU with foreign Countries</div>
                    </a></li>
                @endroleCan

                @roleCan('engagement.country_profile.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Country Profile</div>
                    </a></li>
                @endroleCan

                @roleCan('engagement.itu_council_tracker.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>ITU Council 2026 Nodal Point Tracker</div>
                    </a></li>
                @endroleCan

                @roleCan('engagement.itu_council_emails.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>ITU Council 2026 Email to Nodal Points</div>
                    </a></li>
                @endroleCan
            </ul>
        </li>
        @endroleCan

        {{-- Reports --}}
        @roleCanAny(['reports.yearwise_foreign_visits.view', 'reports.officer_participation.view',
        'reports.bilateral_summary.view', 'reports.multilateral_summary.view', 'reports.visit_tracker.view'])
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="menu-icon icon-tabler icon-tabler-report" width="20"
                    height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M7.86 2h8.28a2 2 0 0 1 1.74 1l4.14 7a2 2 0 0 1 0 2l-4.14 7a2 2 0 0 1 -1.74 1h-8.28a2 2 0 0 1 -1.74 -1l-4.14 -7a2 2 0 0 1 0 -2l4.14 -7a2 2 0 0 1 1.74 -1z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
                <div data-i18n="Reports">Reports</div>
            </a>
            <ul class="menu-sub">
                @roleCan('reports.yearwise_foreign_visits.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Year-Wise Foreign Visits</div>
                    </a></li>
                @endroleCan

                @roleCan('reports.officer_participation.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Officer level participation</div>
                    </a></li>
                @endroleCan

                @roleCan('reports.bilateral_summary.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Bilateral Engagement Summary</div>
                    </a></li>
                @endroleCan

                @roleCan('reports.multilateral_summary.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Multilateral Engagement Summary</div>
                    </a></li>
                @endroleCan

                @roleCan('reports.visit_tracker.view')
                <li class="menu-item"><a href="#" class="menu-link">
                        <div>Visit Tracker</div>
                    </a></li>
                @endroleCan
                @roleCan('reports.visit_tracker.view')
                <li class="menu-item"><a href="{{ route('masterSheet.index') }}" class="menu-link">
                        <div>Master Sheet Generation</div>
                    </a></li>
                @endroleCan
            </ul>
        </li>
        @endroleCan


        {{-- Roles & Permissions --}}
        @roleCanAny(['permissions.view', 'roles.view'])
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-shield-lock"></i>
                <div data-i18n="Roles & Permissions">Roles & Permissions</div>
            </a>
            <ul class="menu-sub">
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('roles.index')}}" class="menu-link">
                        <div data-i18n="Roles">Roles</div>
                    </a>
                </li>
                @endroleCan

                @roleCan('permissions.view')
                <li class="menu-item">
                    <a href="{{route('permissions.index')}}" class="menu-link">
                        <div data-i18n="Permission">Permission</div>
                    </a>
                </li>
                @endroleCan
            </ul>
        </li>
        @endroleCanAny

        {{-- Roles & Permissions --}}
        @roleCanAny(['permissions.view', 'roles.view'])
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-shield-lock"></i>
                <div data-i18n="Frontend Pages">Frontend Pages</div>
            </a>
            <ul class="menu-sub">
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('orm-data.index')}}" class="menu-link">
                        <div data-i18n="OM's">OM's</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.circulars.index')}}" class="menu-link">
                        <div data-i18n="Circulars">Circulars</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('brochures.index')}}" class="menu-link">
                        <div data-i18n="Brochures">Brochures</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('promotional_videos.index')}}" class="menu-link">
                        <div data-i18n="Promotional Videos">Promotional Videos</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('international_forms.index')}}" class="menu-link">
                        <div data-i18n="International Forms">International Forms</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('meeting-calendars.index')}}" class="menu-link">
                        <div data-i18n="Meeting Calendars">Meeting Calendars</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('sliders.index')}}" class="menu-link">
                        <div data-i18n="Sliders">Sliders</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('minister-messages.index')}}" class="menu-link">
                        <div data-i18n="Minister Messages">Minister Messages</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('press-releases.index')}}" class="menu-link">
                        <div data-i18n="Press Releases">Press Releases</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.ir_roles.index')}}" class="menu-link">
                        <div data-i18n="Roles of IR">Roles of IR</div>
                    </a>
                </li>
                @endroleCan
                <!-- @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('achievements.index')}}" class="menu-link">
                        <div data-i18n="Achievements">Achievements</div>
                    </a>
                </li>
                @endroleCan -->
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.social_media.index')}}" class="menu-link">
                        <div data-i18n="Social Media">Social Media</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('engagements.index')}}" class="menu-link">
                        <div data-i18n="Engagements">Engagements</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('ambitions.index')}}" class="menu-link">
                        <div data-i18n="Ambitions">Ambitions</div>
                    </a>
                </li>
                @endroleCan 
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.informations.index')}}" class="menu-link">
                        <div data-i18n="Information">Information</div>
                    </a>
                </li>
                @endroleCan 
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('faqs.index')}}" class="menu-link">
                        <div data-i18n="Faq's">Faq's</div>
                    </a>
                </li>
                @endroleCan 
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.privacy_policies.index')}}" class="menu-link">
                        <div data-i18n="Privacy Policies">Privacy Policies</div>
                    </a>
                </li>
                @endroleCan 
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.terms_of_use.index')}}" class="menu-link">
                        <div data-i18n="Terms of Use">Terms of Use</div>
                    </a>
                </li>
                @endroleCan 
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.accessibility_statements.index')}}" class="menu-link">
                        <div data-i18n="Accessibility Statement">Accessibility Statement</div>
                    </a>
                </li>
                @endroleCan 
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.front_pages.index')}}" class="menu-link">
                        <div data-i18n="Custom Pages">Custom Pages</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.site_settings.index')}}" class="menu-link">
                        <div data-i18n="Site Settings">Site Settings</div>
                    </a>
                </li>
                @endroleCan
            </ul>
        </li>
        @endroleCanAny
        @roleCanAny(['permissions.view', 'roles.view'])
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-shield-lock"></i>
                <div data-i18n="Backend Pages">Backend Pages</div>
            </a>
            <ul class="menu-sub">
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.om_types.index')}}" class="menu-link">
                        <div data-i18n="OM Types">OM Types</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('countries.index')}}" class="menu-link">
                        <div data-i18n="Countries">Countries</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.units.index')}}" class="menu-link">
                        <div data-i18n="Units">Units</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.unit-offices.index')}}" class="menu-link">
                        <div data-i18n="unit-offices">Unit Offices</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.divisions.index')}}" class="menu-link">
                        <div data-i18n="Divisions">Divisions</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('designations.index')}}" class="menu-link">
                        <div data-i18n="Designations">Designations</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('agencies.index')}}" class="menu-link">
                        <div data-i18n="Organizations">Organizations</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.itu-sectors.index')}}" class="menu-link">
                        <div data-i18n="Itu Sectors">Itu Sectors</div>
                    </a>
                </li>
                @endroleCan
                @roleCan('roles.view')
                <li class="menu-item">
                    <a href="{{route('admin.itu-sector-groups.index')}}" class="menu-link">
                        <div data-i18n="Itu Sectors Groups">Itu Sectors Groups</div>
                    </a>
                </li>
                @endroleCan
                
            </ul>
        </li>
        @endroleCanAny

        {{-- Users --}}
        @roleCan('users.view')
        <li class="menu-item">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-user"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>
        @endroleCan
        <li class="menu-item">
            <a href="{{ route('profile.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-user"></i>
                <div data-i18n="Profile">Profile</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('contacts.index') }}" class="menu-link">
                <i class="menu-icon ti tabler-address-book"></i>
                <div data-i18n="Contacts">Contacts</div>
            </a>
        </li>

    </ul>
</aside>
