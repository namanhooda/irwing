@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Add New User</h5>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Back to Users</a>
                </div>
                <div class="card-body">
                    <form id="addNewUserForm" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="mb-3" style="position: relative;">
                            <label class="form-label" for="profile-autocomplete">Assign Profile</label>
                            <input type="text" id="profile-autocomplete" name="profile_name"
                                class="form-control @error('profile_id') is-invalid @enderror"
                                placeholder="Type staff no or name..." autocomplete="off" required>
                            <input type="hidden" name="profile_id" id="profile-id">

                            <div id="autocomplete-list" class="autocomplete-items"
                                style="position: absolute; z-index: 1000; background: #fff; border: 1px solid #ccc; width: 100%; max-height: 200px; overflow-y: auto;">
                            </div>

                            @error('profile_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <input type="hidden" class="form-control @error('staff_no') is-invalid @enderror"
                            id="add-user-fullstaff_no" name="staff_no" placeholder="staff_no"
                            value="{{ old('staff_no') }}" required />

                        <div class="mb-3 form-control-validation">
                            <label class="form-label" for="add-user-fullname">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="add-user-fullname" name="name" placeholder="John Doe" value="{{ old('name') }}"
                                required />
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-control-validation">
                            <label class="form-label" for="add-user-email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="add-user-email" name="email" placeholder="john.doe@example.com"
                                value="{{ old('email') }}" required />
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-control-validation">
                            <label class="form-label" for="add-user-contact">Contact</label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                id="add-user-contact" name="mobile" placeholder="9999999999" value="{{ old('mobile') }}"
                                required />
                            @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="user-role">User Roles</label>
                            <select id="user-role" name="roles[]"
                                class="form-select @error('roles') is-invalid @enderror" multiple required>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ (collect(old('roles'))->contains($role->id)) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl (Windows) / Command (Mac) to select multiple
                                roles</small>
                            @error('roles')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Get DOM elements
    const profiles = @json($profiles); // Laravel passes profiles array
    const input = document.getElementById('profile-autocomplete');
    const hiddenInput = document.getElementById('profile-id');
    const listContainer = document.getElementById('autocomplete-list');
    const nameField = document.getElementById('add-user-fullname');
    const emailField = document.getElementById('add-user-email');
    const mobileField = document.getElementById('add-user-contact');
    const staffNoField = document.getElementById('add-user-fullstaff_no');
    let currentFocus = -1;

    // 2. Close the autocomplete list
    function closeList() {
        listContainer.innerHTML = '';
        currentFocus = -1;
    }

    // 3. Highlight matched text
    function highlightMatch(text, query) {
        const regex = new RegExp(`(${query})`, 'ig');
        return text.replace(regex, "<strong>$1</strong>");
    }

    // 4. Input event for search
    input.addEventListener('input', function () {
        const val = input.value.trim().toLowerCase();
        closeList();
        hiddenInput.value = ''; // reset selection

        if (!val) return;

        const matches = profiles.filter(p => {
            const staff_no = p.staff_no ? p.staff_no.toLowerCase() : '';
            const officer_name = p.officer_name ? p.officer_name.toLowerCase() : '';
            return staff_no.includes(val) || officer_name.includes(val);
        });

        matches.forEach(p => {
            const item = document.createElement('div');
            const staff_no = p.staff_no || '';
            const officer_name = p.officer_name || '';
            item.innerHTML = highlightMatch(`${staff_no} - ${officer_name}`, val);
            item.style.padding = "5px 10px";
            item.style.cursor = "pointer";

            // On selecting an item
            item.addEventListener('click', function () {
                input.value = `${staff_no} - ${officer_name}`;
                hiddenInput.value = p.id;

                // ✅ Prefill related fields
                staffNoField.value = p.staff_no || '';
                nameField.value = p.officer_name || '';
                emailField.value = p.email_id || '';
                mobileField.value = p.mobile_no || '';

                closeList();
            });

            listContainer.appendChild(item);
        });
    });

    // 5. Keyboard navigation
    input.addEventListener('keydown', function (e) {
        const items = listContainer.getElementsByTagName('div');
        if (!items) return;

        if (e.key === "ArrowDown") {
            currentFocus++;
            addActive(items);
            e.preventDefault();
        } else if (e.key === "ArrowUp") {
            currentFocus--;
            addActive(items);
            e.preventDefault();
        } else if (e.key === "Enter") {
            e.preventDefault();
            if (currentFocus > -1 && items[currentFocus]) items[currentFocus].click();
        }
    });

    function addActive(items) {
        if (!items) return;
        removeActive(items);
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = items.length - 1;
        items[currentFocus].classList.add("autocomplete-active");
        items[currentFocus].style.backgroundColor = "#e9e9e9";
    }

    function removeActive(items) {
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove("autocomplete-active");
            items[i].style.backgroundColor = "#fff";
        }
    }

    // 6. Close list if clicked outside
    document.addEventListener('click', function (e) {
        if (e.target !== input) closeList();
    });
});
</script>



@endsection
