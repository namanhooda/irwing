<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountryProfile;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryProfileController extends Controller
{
    public function index()
    {
        $profiles = CountryProfile::with('country')->orderBy('id', 'DESC')->get();
        return view('admin.country_profile.index', compact('profiles'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.country_profile.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|unique:country_profiles,country_id',
            'capital' => 'required',
            'official_language' => 'required',
            'currency' => 'required',
            'flag_image' => 'nullable|image|mimes:jpg,png,jpeg|max:5120',
            'profile_document' => 'nullable|mimes:pdf|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('flag_image')) {
            $filename = time().'_flag.'.$request->flag_image->extension();
            $request->flag_image->move('uploads/country_flags/', $filename);
            $data['flag_image'] = 'uploads/country_flags/'.$filename;
        }

        if ($request->hasFile('profile_document')) {
            $filename = time().'_profile.'.$request->profile_document->extension();
            $request->profile_document->move('uploads/country_docs/', $filename);
            $data['profile_document'] = 'uploads/country_docs/'.$filename;
        }

        CountryProfile::create($data);

        return redirect()->route('admin.country_profiles.index')
            ->with('success', 'Country Profile Added Successfully!');
    }

    public function edit($id)
    {
        $profile = CountryProfile::findOrFail($id);
        $countries = Country::orderBy('name')->get();
        return view('admin.country_profile.edit', compact('profile','countries'));
    }

    public function update(Request $request, $id)
    {
        $profile = CountryProfile::findOrFail($id);

        $request->validate([
            'country_id' => 'required|unique:country_profiles,country_id,'.$id,
            'capital' => 'required',
            'official_language' => 'required',
            'currency' => 'required',
            'flag_image' => 'nullable|image|mimes:jpg,png,jpeg|max:5120',
            'profile_document' => 'nullable|mimes:pdf|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('flag_image')) {
            if ($profile->flag_image && file_exists($profile->flag_image)) unlink($profile->flag_image);

            $filename = time().'_flag.'.$request->flag_image->extension();
            $request->flag_image->move('uploads/country_flags/', $filename);
            $data['flag_image'] = 'uploads/country_flags/'.$filename;
        }

        if ($request->hasFile('profile_document')) {
            if ($profile->profile_document && file_exists($profile->profile_document)) unlink($profile->profile_document);

            $filename = time().'_profile.'.$request->profile_document->extension();
            $request->profile_document->move('uploads/country_docs/', $filename);
            $data['profile_document'] = 'uploads/country_docs/'.$filename;
        }

        $profile->update($data);

        return redirect()->route('admin.country_profiles.index')
            ->with('success', 'Country Profile Updated Successfully!');
    }

    public function destroy($id)
    {
        $profile = CountryProfile::findOrFail($id);

        if ($profile->flag_image && file_exists($profile->flag_image)) {
            unlink($profile->flag_image);
        }
        if ($profile->profile_document && file_exists($profile->profile_document)) {
            unlink($profile->profile_document);
        }

        $profile->delete();

        return redirect()->back()->with('success', 'Country Profile Deleted!');
    }
}
