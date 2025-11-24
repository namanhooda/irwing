<div class="row">

    <div class="col-md-6">
        <label>Country *</label>

        <select name="country" class="form-select" required>
            <option value="">-- Select Country --</option>

            @foreach($countries as $c)
                <option value="{{ $c->id }}"
                    {{ (isset($embassy) && $embassy->country == $c->id) ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label>Mission Name</label>
        <input type="text" name="mission_name" value="{{ old('mission_name', $embassy->mission_name ?? '') }}"
            class="form-control">
    </div>

    <div class="col-md-12 mt-3">
        <label>Address</label>
        <textarea name="address" class="form-control">{{ old('address', $embassy->address ?? '') }}</textarea>
    </div>

    <div class="col-md-6 mt-3">
        <label>Contact Person</label>
        <input type="text" name="contact_person" value="{{ old('contact_person', $embassy->contact_person ?? '') }}"
            class="form-control">
    </div>

    <div class="col-md-6 mt-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $embassy->email ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6 mt-3">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $embassy->phone ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6 mt-3">
        <label>Website</label>
        <input type="text" name="website" value="{{ old('website', $embassy->website ?? '') }}" class="form-control">
    </div>

</div>
