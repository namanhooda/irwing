@extends('layoutsBackend.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            {{-- Update Profile --}}
            <div class="card mb-6">
                <form method="POST" action="{{ route('user-profile-information.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-6">
                            <img src="{{asset('storage/'.Auth::user()->profile)}}" alt="user-avatar"
                                class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="profile_photo" class="btn btn-primary me-3 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="icon-base ti tabler-upload d-block d-sm-none"></i>
                                    <input type="file" name="photo" id="profile_photo" class="account-file-input" hidden
                                        accept="image/*" />
                                </label>
                                <button type="button" class="btn btn-label-secondary account-image-reset mb-4"
                                    onclick="document.getElementById('profile_photo').value = null;">
                                    <i class="icon-base ti tabler-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>
                                <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-4">
                        <div class="row gy-4 gx-6 mb-6">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{ old('name', Auth::user()->name) }}" required />
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Staff No</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{ old('name', $profile->staff_no) }}" required  readonly/>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    value="{{ old('email', Auth::user()->email) }}" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">In (+91)</span>
                                    <input type="text" id="phone" name="phone" class="form-control"
                                    value="{{ old('name', Auth::user()->phone) }}" placeholder="Enter Mobile" />
                                </div>
                            </div>

                            <!-- <div class="col-md-6">
                                <label class="form-label" for="country">Status</label>
                                <select id="country" class="select2 form-select" name="status">
                                    <option value="">Select</option>
                                    <option value="0" {{ Auth::user()->status == 0 ? 'selected' : '' }}>In Active</option>
                                    <option value="1" {{ Auth::user()->status == 1 ? 'selected' : '' }}>Active</option>
                                </select>
                            </div> -->
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-3">Save changes</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="card mb-6">
                <h5 class="card-header">Other Info</h5>
                <div class="card-body pt-1">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="row gy-4 gx-6 mb-6">
                    <input type="hidden" name="id" value="{{ $checkprofile->id }}">

                            <!-- Cadre -->
                            <div class="col-md-6">
                                <label for="cadre" class="form-label">Cadre</label>
                                <input type="text" class="form-control" id="cadre" name="cadre"
                                    value="{{ old('cadre', $checkprofile->cadre ?? '') }}" readonly>
                            </div>

                            <!-- Designation -->
                            <!-- Designation -->
                            <div class="col-md-6">
                                <label for="designation" class="form-label">Designation</label>
                                <select class="form-select" id="designation" name="designation">
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $designation)
                                    <option value="{{ $designation->name }}"
                                        {{ old('designation', $checkprofile->designation ?? '') == $designation->name ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Year of Allotment -->
                            <div class="col-md-6">
                                <label for="year_of_allotment" class="form-label">Year of Allotment</label>
                                <input type="text" class="form-control" id="year_of_allotment" name="year_of_allotment"
                                    value="{{ old('year_of_allotment', $checkprofile->year_of_allotment ?? '') }}">
                            </div>

                            <!-- Date of Entry in Service (Dropdown - Last 50 years) -->
                            <div class="col-md-6">
                                <label for="date_of_entry_in_service" class="form-label">Date of Entry in Service
                                    (Year)</label>
                                <select class="form-select" id="date_of_entry_in_service"
                                    name="date_of_entry_in_service">
                                    <option value="">Select Year</option>
                                    @php
                                    $currentYear = date('Y');
                                    $startYear = $currentYear - 50;
                                    @endphp
                                    @for ($year = $currentYear; $year >= $startYear; $year--)
                                    <option value="{{ $year }}"
                                        {{ old('date_of_entry_in_service', $checkprofile->date_of_entry_in_service) == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Staff No -->
                            <div class="col-md-6">
                                <label for="staff_no" class="form-label">Staff No</label>
                                <input type="text" class="form-control" id="staff_no" name="staff_no"
                                    value="{{ old('staff_no', $checkprofile->staff_no ?? '') }}" readonly>
                            </div>

                            <!-- Title -->
                            <!-- Title -->
                            <div class="col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <select class="form-select" id="title" name="title">
                                    <option value="">Select Title</option>
                                    @php
                                    $titles = ['Mr.', 'Mrs.', 'Ms.', 'Dr.', 'Prof.'];
                                    @endphp
                                    @foreach ($titles as $title)
                                    <option value="{{ $title }}"
                                        {{ old('title', $checkprofile->title ?? '') == $title ? 'selected' : '' }}>
                                        {{ $title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Officer Name -->
                            <div class="col-md-6">
                                <label for="officer_name" class="form-label">Officer Name</label>
                                <input type="text" class="form-control" id="officer_name" name="officer_name"
                                    value="{{ old('officer_name', $checkprofile->officer_name ?? '') }}" readonly>
                            </div>

                            <!-- Gender -->
                            <!-- Gender -->
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    @php
                                    $genders = ['Male', 'Female', 'Other'];
                                    @endphp
                                    @foreach ($genders as $gender)
                                    <option value="{{ $gender }}"
                                        {{ old('gender', $checkprofile->gender ?? '') == $gender ? 'selected' : '' }}>
                                        {{ $gender }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Present Posting -->
                            <div class="col-md-6">
                                <label for="present_posting" class="form-label">Present Posting</label>
                                <input type="text" class="form-control" id="present_posting" name="present_posting"
                                    value="{{ old('present_posting', $checkprofile->present_posting ?? '') }}">
                            </div>

                            <!-- Office Address -->
                            <div class="col-md-6">
                                <label for="office_address" class="form-label">Office Address</label>
                                <input type="text" class="form-control" id="office_address" name="office_address"
                                    value="{{ old('office_address', $checkprofile->office_address ?? '') }}">
                            </div>

                            <!-- Date of Joining Office -->
                            <div class="col-md-6">
                                <label for="date_of_joining_office" class="form-label">Date of Joining Office</label>
                                <input type="date" class="form-control" id="date_of_joining_office"
                                    name="date_of_joining_office"
                                    value="{{ old('date_of_joining_office', $checkprofile->date_of_joining_office ?? '') }}">
                            </div>

                            <!-- Office Phone -->
                            <div class="col-md-6">
                                <label for="office_phone" class="form-label">Office Phone</label>
                                <input type="text" class="form-control" id="office_phone" name="office_phone"
                                    value="{{ old('office_phone', $checkprofile->office_phone ?? '') }}">
                            </div>

                            <!-- Office Fax -->
                            <div class="col-md-6">
                                <label for="office_fax" class="form-label">Office Fax</label>
                                <input type="text" class="form-control" id="office_fax" name="office_fax"
                                    value="{{ old('office_fax', $checkprofile->office_fax ?? '') }}">
                            </div>

                            <!-- Office Email -->
                            <div class="col-md-6">
                                <label for="office_email" class="form-label">Office Email</label>
                                <input type="email" class="form-control" id="office_email" name="office_email"
                                    value="{{ old('office_email', $checkprofile->office_email ?? '') }}">
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input readonly type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                    value="{{ old('date_of_birth', isset($checkprofile->date_of_birth) ? \Carbon\Carbon::parse($checkprofile->date_of_birth)->format('Y-m-d') : '') }}">
                            </div>


                            <!-- Native District -->
                            <div class="col-md-6">
                                <label for="native_district" class="form-label">Native District</label>
                                <input type="text" class="form-control" id="native_district" name="native_district"
                                    value="{{ old('native_district', $checkprofile->native_district ?? '') }}">
                            </div>

                            <!-- State -->
                            <div class="col-md-6">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state"
                                    value="{{ old('state', $checkprofile->state ?? '') }}">
                            </div>

                            <!-- Educational Qualifications -->
                            <div class="col-md-6">
                                <label for="educational_qualifications" class="form-label">Educational
                                    Qualifications</label>
                                <input type="text" class="form-control" id="educational_qualifications"
                                    name="educational_qualifications"
                                    value="{{ old('educational_qualifications', $checkprofile->educational_qualifications ?? '') }}">
                            </div>

                            <!-- Languages Known -->
                            <div class="col-md-6">
                                <label for="languages_known" class="form-label">Languages Known</label>
                                <input type="text" class="form-control" id="languages_known" name="languages_known"
                                    value="{{ old('languages_known', $checkprofile->languages_known ?? '') }}">
                            </div>

                            <!-- Date of Entry in Present Grade -->
                            <div class="col-md-6">
                                <label for="date_of_entry_in_present_grade" class="form-label">Date of Entry in Present
                                    Grade</label>
                                <input type="date" class="form-control" id="date_of_entry_in_present_grade"
                                    name="date_of_entry_in_present_grade"
                                    value="{{ old('date_of_entry_in_present_grade', $checkprofile->date_of_entry_in_present_grade ?? '') }}">
                            </div>

                            <!-- Grade -->
                            <div class="col-md-6">
                                <label for="grade" class="form-label">Grade</label>
                                <input type="text" class="form-control" id="grade" name="grade"
                                    value="{{ old('grade', $checkprofile->grade ?? '') }}">
                            </div>

                            <!-- Rank -->
                            <div class="col-md-6">
                                <label for="rank" class="form-label">Rank</label>
                                <input type="text" class="form-control" id="rank" name="rank"
                                    value="{{ old('rank', $checkprofile->rank ?? '') }}">
                            </div>

                            <!-- Level in Pay Matrix -->
                            <div class="col-md-6">
                                <label for="level_in_pay_matrix" class="form-label">Level in Pay Matrix</label>
                                <input type="text" class="form-control" id="level_in_pay_matrix"
                                    name="level_in_pay_matrix"
                                    value="{{ old('level_in_pay_matrix', $checkprofile->level_in_pay_matrix ?? '') }}">
                            </div>

                            <!-- Mobile No -->
                            <div class="col-md-6">
                                <label for="mobile_no" class="form-label">Mobile No</label>
                                <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                                    value="{{ old('mobile_no', $checkprofile->mobile_no ?? '') }}">
                            </div>

                            <!-- Email ID -->
                            <div class="col-md-6">
                                <label for="email_id" class="form-label">Email ID</label>
                                <input type="email" class="form-control" id="email_id" name="email_id"
                                    value="{{ old('email_id', $checkprofile->email_id ?? '') }}">
                            </div>

                            <!-- Language -->
                            <div class="col-md-6">
                                <label for="language" class="form-label">Language</label>
                                <input type="text" class="form-control" id="language" name="language"
                                    value="{{ old('language', $checkprofile->language ?? '') }}">
                            </div>

                            <!-- Serving Status -->
                            <div class="col-md-6">
                                <label for="serving_status" class="form-label">Serving Status</label>
                                <input type="text" class="form-control" id="serving_status" name="serving_status"
                                    value="{{ old('serving_status', $checkprofile->serving_status ?? '') }}">
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-3">Save changes</button>
                            <button type="reset" class="btn btn-label-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="card mb-6">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body pt-1">
                    <form method="POST" action="{{ route('user-password.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input class="form-control" type="password" id="current_password"
                                    name="current_password" required />
                            </div>
                        </div>
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input class="form-control" type="password" id="password" name="password" required />
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input class="form-control" type="password" id="password_confirmation"
                                    name="password_confirmation" required />
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-3">Save changes</button>
                            <button type="reset" class="btn btn-label-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
