@extends('layoutsBackend.app')

@section('content')
<style>
    /* Fix missing search box in Vuexy + Select2 */
    .select2-container .select2-search--dropdown {
        display: block !important;
    }

    .select2-container .select2-search--dropdown .select2-search__field {
        display: block !important;
        width: 100% !important;
        padding: 0.375rem 0.75rem !important;
        font-size: 1rem !important;
        border: 1px solid #d8d6de !important;
        border-radius: 0.375rem !important;
    }

    .card-header {
        font-weight: bold;
        font-size: 1.2rem;
    }

    .officer-block {
        border: 1px solid #ced4da;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: #f9f9f9;
    }

    .remove-officer {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    .form-label {
        font-weight: 500;
    }

    hr {
        margin: 2rem 0;
    }

    .officer-block .row > div {
        margin-bottom: 1rem;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Create QRP Details</h5>

            @roleCan('submission.qrp.create')
            <div class="card-body">
                <form action="{{ route('qrp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Agency & ITU Section -->
                    <div class="mb-3">
                        <label class="form-label">Meeting Organizing Agency</label>
                        <select name="agency" id="agency" class="form-control" required>
                            <option value="">Select Agency</option>
                            @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                            @endforeach
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div id="itu-sector-container" class="mb-3" style="display:none;">
                        <label class="form-label">ITU Sector</label>
                        <select name="itu_sector" id="itu_sector" class="form-control">
                            <option value="">Select ITU Sector</option>
                            @foreach($sectors as $sector)
                            <option value="{{ $sector->id }}" data-agency="{{ $sector->agency_id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="sector-group-container" class="mb-3" style="display:none;">
                        <label class="form-label">Sector Group</label>
                        <select name="sector_group" id="sector_group" class="form-control">
                            <option value="">Select Sector Group</option>
                            @foreach($sectorGroups as $group)
                            <option value="{{ $group->id }}" data-sector="{{ $group->sector_id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="agency-other-container" class="mb-3" style="display:none;">
                        <input type="text" name="agency_other" class="form-control" placeholder="Specify if Other">
                    </div>

                    <!-- Meeting Info -->
                    <div class="mb-3">
                        <label class="form-label">Meeting Name</label>
                        <input type="text" name="meeting_name" class="form-control" placeholder="e.g. SG/WP/TSAG/TDAG/Council">
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label class="form-label">Duration From</label>
                            <input type="date" name="meeting_from" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Duration To</label>
                            <input type="date" name="meeting_to" class="form-control">
                        </div>
                    </div>

                    <h6>Meeting Locations</h6>
                    <div id="countries-container">
                        <div class="country-block row mb-3 position-relative">
                            <div class="col-md-3">
                                <label class="form-label">Country</label>
                                <select name="countries[0][country]" class="form-control">
                                    <option value="">-- Select Country --</option>
                                    @foreach($country as $cont)
                                    <option value="{{ $cont->id }}">{{ $cont->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">City</label>
                                <input type="text" name="countries[0][city]" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Duration From</label>
                                <input type="date" name="countries[0][meeting_from]" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Duration To</label>
                                <input type="date" name="countries[0][meeting_to]" class="form-control">
                            </div>

                            <div class="col-12 text-end mt-2">
                                <button type="button" class="btn btn-danger btn-sm remove-country">Remove</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-country" class="btn btn-primary mb-3">+ Add Country</button>

                    <div class="mb-3">
                        <label class="form-label">Invitation Letter (PDF/JPG/Word)</label>
                        <input type="file" name="invitation_letter" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Similar Meeting Occurred Before?</label>
                        <select name="similar_meeting" id="similar_meeting" class="form-control">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>

                    <div id="prev_report" class="mb-3" style="display:none;">
                        <label class="form-label">Attach Previous Tour Report</label>
                        <input type="file" name="previous_report" class="form-control">
                    </div>

                    <hr>
                    <h6>Officers Details</h6>
                    <div id="officers-container">

                        <!-- Officer Template -->
                        <div class="officer-block position-relative">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Search Profile by Staff No</label>
                                    <input type="text" class="form-control staff_no_search" placeholder="Type Staff No...">
                                    <div class="profile_list list-group mt-1" style="position: absolute; z-index: 9999; background: white;"></div>
                                    <input type="hidden" name="officers[0][profile_id]" class="profile_id">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Staff No.</label>
                                    <input type="text" name="officers[0][staff_no]" class="form-control staff_no">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Officer Name</label>
                                    <input type="text" name="officers[0][officer_name]" class="form-control officer_name" readonly>
                                </div>

                                <!-- Unit / Division / Designation -->
                                <div class="col-md-3">
                                    <label class="form-label">Unit</label>
                                    <select name="officers[0][unit]" class="form-control unit-select">
                                        <option value="">-- Select Unit --</option>
                                        @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Unit Office</label>
                                    <select name="officers[0][unit_office]" class="form-control unit-office-select">
                                        <option value="">-- Select Unit Office --</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Division</label>
                                    <select name="officers[0][division]" class="form-control division-select">
                                        <option value="">-- Select Division --</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Designation</label>
                                    <select name="officers[0][designation]" class="form-control designation-select">
                                        <option value="">-- Select Designation --</option>
                                        @foreach($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Contact / Mode / Duration -->
                                <div class="col-md-3">
                                    <label class="form-label">Mode</label>
                                    <select name="officers[0][mode]" class="form-control">
                                        <option value="Online">Online</option>
                                        <option value="Offline">Offline</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="officers[0][email]" class="form-control">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Contact No.</label>
                                    <input type="text" name="officers[0][contact]" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Duration From</label>
                                    <input type="date" name="officers[0][meeting_from]" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Duration To</label>
                                    <input type="date" name="officers[0][meeting_to]" class="form-control">
                                </div>

                                <div class="col-12">
    <h6>Officer Locations</h6>
    <div class="officer-countries-container">
        <div class="officer-country-block row mb-2 position-relative">
            <div class="col-md-3">
                <label>Country</label>
                <select name="officers[0][countries][0][country]" class="form-control">
                    <option value="">-- Select Country --</option>
                    @foreach($country as $cont)
                        <option value="{{ $cont->id }}">{{ $cont->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>City</label>
                <input type="text" name="officers[0][countries][0][city]" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Duration From</label>
                <input type="date" name="officers[0][countries][0][from]" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Duration To</label>
                <input type="date" name="officers[0][countries][0][to]" class="form-control">
            </div>

            <div class="col-12 text-end mt-2">
                <button type="button" class="btn btn-danger btn-sm remove-officer-country">Remove</button>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary btn-sm add-officer-country">+ Add Country</button>
</div>


                                <div class="col-md-6">
                                    <label class="form-label">Justification / Role / Contribution</label>
                                    <textarea name="officers[0][justification]" class="form-control"></textarea>
                                    <input type="file" name="officers[0][justification_file]" class="form-control mt-2">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Expected Outcome</label>
                                    <textarea name="officers[0][expected_outcome]" class="form-control"></textarea>
                                    <input type="file" name="officers[0][expected_file]" class="form-control mt-2">
                                </div>
                            </div>

                            <button type="button" class="btn btn-danger btn-sm remove-officer">Remove Officer</button>
                        </div>

                    </div>

                    <button type="button" id="add-officer" class="btn btn-primary mt-3">+ Add Officer</button>
                    <br><br>

                    <button type="button" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-success">Save QRP Entry</button>
                </form>
            </div>
            @endroleCan
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const agencySelect = document.getElementById('agency');
    const sectorSelect = document.getElementById('itu_sector');
    const groupSelect = document.getElementById('sector_group');

    const sectorContainer = document.getElementById('itu-sector-container');
    const groupContainer = document.getElementById('sector-group-container');
    const otherInputContainer = document.getElementById('agency-other-container');

    const allSectors = [...sectorSelect.querySelectorAll('option[data-agency]')];
    const allGroups = [...groupSelect.querySelectorAll('option[data-sector]')];

    // Agency change
    agencySelect.addEventListener('change', function () {
        const selectedAgency = this.value;

        // Hide everything
        sectorContainer.style.display = 'none';
        groupContainer.style.display = 'none';
        otherInputContainer.style.display = 'none';
        sectorSelect.innerHTML = '<option value="">Select ITU Sector</option>';
        groupSelect.innerHTML = '<option value="">Select Sector Group</option>';

        // If 'other', show input
        if (selectedAgency === 'other') {
            otherInputContainer.style.display = 'block';
            return;
        }

        // Filter sectors for this agency
        const filteredSectors = allSectors.filter(opt => opt.dataset.agency === selectedAgency);

        if (filteredSectors.length > 0) {
            filteredSectors.forEach(opt => {
                sectorSelect.appendChild(opt.cloneNode(true));
            });
            sectorContainer.style.display = 'block';
        }
    });

    // Sector change
    sectorSelect.addEventListener('change', function () {
        const selectedSector = this.value;

        groupSelect.innerHTML = '<option value="">Select Sector Group</option>';
        groupContainer.style.display = 'none';

        if (!selectedSector) return;

        // Filter groups for this sector
        const filteredGroups = allGroups.filter(opt => opt.dataset.sector === selectedSector);

        if (filteredGroups.length > 0) {
            filteredGroups.forEach(opt => {
                groupSelect.appendChild(opt.cloneNode(true));
            });
            groupContainer.style.display = 'block';
        }
    });

</script>


<script>
   let countryIndex = 1;

$('#add-country').on('click', function() {
    const lastBlock = $('#countries-container .country-block').last();
    const newBlock = lastBlock.clone();

    // Clear all inputs/selects
    newBlock.find('select, input').val('');

    // Update name attributes with new index
    newBlock.find('[name]').each(function() {
        const name = $(this).attr('name');
        if (name) {
            const updated = name.replace(/\[\d+\]/, `[${countryIndex}]`);
            $(this).attr('name', updated);
        }
    });

    $('#countries-container').append(newBlock);
    countryIndex++;
});

// Remove country block
$(document).on('click', '.remove-country', function() {
    if ($('#countries-container .country-block').length > 1) {
        $(this).closest('.country-block').remove();
    } else {
        alert('At least one country is required.');
    }
});


// Remove country block
$(document).on('click', '.remove-country', function() {
    if ($('#countries-container .country-block').length > 1) {
        $(this).closest('.country-block').remove();
    } else {
        alert('At least one country is required.');
    }
});

</script>
<script>
$(document).ready(function() {
    // Officer location index tracking
    function getNextCountryIndex(officerBlock) {
        return officerBlock.find('.officer-country-block').length;
    }

    // Add new country for officer
   $(document).on('click', '.add-officer-country', function() {
    const officerBlock = $(this).closest('.officer-block');
    const container = officerBlock.find('.officer-countries-container');
    const lastBlock = container.find('.officer-country-block').last();
    const newBlock = lastBlock.clone();

    // Get current officer index from the first input name
    const firstName = lastBlock.find('[name]').first().attr('name');
    const officerMatch = firstName.match(/officers\[(\d+)\]/);
    const officerIndex = officerMatch ? officerMatch[1] : 0;

    // Get next country index
    const newCountryIndex = container.find('.officer-country-block').length;

    // Clear values
    newBlock.find('select, input').val('');

    // Update name attributes correctly
    newBlock.find('[name]').each(function() {
        const name = $(this).attr('name');
        if(name){
            // Replace the full pattern for countries
            const updated = name.replace(/officers\[\d+\]\[countries\]\[\d+\]/, 
                `officers[${officerIndex}][countries][${newCountryIndex}]`);
            $(this).attr('name', updated);
        }
    });

    container.append(newBlock);
});


    // Remove officer country
    $(document).on('click', '.remove-officer-country', function() {
        const container = $(this).closest('.officer-countries-container');
        if(container.find('.officer-country-block').length > 1) {
            $(this).closest('.officer-country-block').remove();
        } else {
            alert('At least one country is required for this officer.');
        }
    });
});
</script>
<script>
    let officerIndex = 1;

    function attachSearchHandler(block) {
        block.find('.staff_no_search').on('keyup', function () {
            const query = $(this).val();
            const profileList = $(this).siblings('.profile_list');

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('profiles.search') }}",
                    type: "GET",
                    data: {
                        query
                    },
                    success: function (data) {
                        let html = '';
                        data.forEach(profile => {
                            html += `<a href="#" class="list-group-item list-group-item-action profile-item"
                                data-id="${profile.id}"
                                data-name="${profile.officer_name}"
                                data-staff_no="${profile.staff_no}">
                                ${profile.staff_no} - ${profile.officer_name}
                            </a>`;
                        });
                        profileList.html(html).show();
                    }
                });
            } else {
                profileList.hide();
            }
        });

        // Click profile
        block.on('click', '.profile-item', function (e) {
            e.preventDefault();
            const item = $(this);
            const container = item.closest('.officer-block');

            container.find('.profile_id').val(item.data('id'));
            container.find('.officer_name').val(item.data('name'));
            container.find('.staff_no').val(item.data('staff_no'));
            container.find('.staff_no_search').val('');
            container.find('.profile_list').hide();
        });
    }

    function attachDynamicHandlers(block) {
        // Unit → Unit Offices
        block.find('.unit-select').on('change', function () {
            const unitId = $(this).val();
            const officeSelect = block.find('.unit-office-select');
            const divisionSelect = block.find('.division-select');
            const designationSelect = block.find('.designation-select');

            officeSelect.html('<option value="">Loading...</option>');
            divisionSelect.html('<option value="">-- Select Division --</option>');
            designationSelect.html('<option value="">-- Select Designation --</option>');

            if (unitId) {
                $.get("{{ route('api.unit.offices') }}", {
                    unit_id: unitId
                }, function (data) {
                    officeSelect.html('<option value="">-- Select Unit Office --</option>');
                    data.forEach(item => {
                        officeSelect.append(`<option value="${item.id}">${item.name}</option>`);
                    });
                });
            } else {
                officeSelect.html('<option value="">-- Select Unit Office --</option>');
            }
        });

        // Unit Office → Divisions
        block.find('.unit-office-select').on('change', function () {
            const officeId = $(this).val();
            const divisionSelect = block.find('.division-select');
            const designationSelect = block.find('.designation-select');

            divisionSelect.html('<option value="">Loading...</option>');
            designationSelect.html('<option value="">-- Select Designation --</option>');

            if (officeId) {
                $.get("{{ route('api.unitoffice.divisions') }}", {
                    unit_office_id: officeId
                }, function (data) {
                    divisionSelect.html('<option value="">-- Select Division --</option>');
                    data.forEach(item => {
                        divisionSelect.append(
                            `<option value="${item.id}">${item.name}</option>`);
                    });
                });
            } else {
                divisionSelect.html('<option value="">-- Select Division --</option>');
            }
        });

        // Division → Designations
        block.find('.division-select').on('change', function () {
            const divisionId = $(this).val();
            const designationSelect = block.find('.designation-select');

            designationSelect.html('<option value="">Loading...</option>');

            if (divisionId) {
                $.get("{{ route('api.division.designations') }}", {
                    division_id: divisionId
                }, function (data) {
                    designationSelect.html('<option value="">-- Select Designation --</option>');
                    data.forEach(item => {
                        designationSelect.append(
                            `<option value="${item.id}">${item.name}</option>`);
                    });
                });
            } else {
                designationSelect.html('<option value="">-- Select Designation --</option>');
            }
        });
    }

    $(document).ready(function () {
        const container = $('#officers-container');

        // Attach handlers to first block
        const firstBlock = container.find('.officer-block');
        attachSearchHandler(firstBlock);
        attachDynamicHandlers(firstBlock); // ✅ Attach dynamic dropdown handler

        // Add new officer block
        $('#add-officer').on('click', function () {
    const container = $('#officers-container');
    const lastBlock = container.find('.officer-block').last();
    const newBlock = lastBlock.clone();

    // Get new officer index
    const newOfficerIndex = officerIndex;

    // --- 1. Reset all input/select/textarea values ---
    newBlock.find('input, select, textarea').each(function () {
        const type = $(this).attr('type');
        if (type !== 'hidden') $(this).val('');
    });

    // --- 2. Reset officer-countries-container to just one empty block ---
    const countriesContainer = newBlock.find('.officer-countries-container');
    const firstCountryBlock = countriesContainer.find('.officer-country-block').first().clone();
    // Clear values in first block
    firstCountryBlock.find('select, input').val('');
    // Reset its name to index 0 for countries
    firstCountryBlock.find('[name]').each(function () {
        const name = $(this).attr('name');
        if (name) {
            const updated = name.replace(/officers\[\d+\]\[countries\]\[\d+\]/, 
                `officers[${newOfficerIndex}][countries][0]`);
            $(this).attr('name', updated);
        }
    });
    countriesContainer.html(firstCountryBlock);

    // --- 3. Update ALL name attributes for officer-level fields ---
    newBlock.find('[name]').each(function () {
        const name = $(this).attr('name');
        if (name) {
            // Replace first index [x] after officers
            const updated = name.replace(/officers\[\d+\]/, `officers[${newOfficerIndex}]`);
            $(this).attr('name', updated);
        }
    });

    // Clear profile list
    newBlock.find('.profile_list').html('').hide();

    container.append(newBlock);

    // Attach handlers to new block
    attachSearchHandler(newBlock);
    attachDynamicHandlers(newBlock);

    officerIndex++;
});

        // Remove officer block
        $(document).on('click', '.remove-officer', function () {
            if ($('.officer-block').length > 1) {
                $(this).closest('.officer-block').remove();
            } else {
                alert('At least one officer is required.');
            }
        });
    });

</script>


{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');

</script>
@endsection
