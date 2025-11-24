<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Embassy;
use App\Models\Country;
use Illuminate\Http\Request;

class EmbassyController extends Controller
{
public function index(Request $request)
{
    $query = Embassy::with('countryData');

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->whereHas('countryData', function($c) use ($request) {
                $c->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->orWhere('mission_name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('contact_person', 'LIKE', '%' . $request->search . '%')
            ->orWhere('email', 'LIKE', '%' . $request->search . '%')
            ->orWhere('phone', 'LIKE', '%' . $request->search . '%');
        });
    }

    $embassies = $query->paginate(10)->appends(['search' => $request->search]);

    return view('admin.embassies.index', compact('embassies'));
}


    public function create()
    {
        $countries = Country::all();
        return view('admin.embassies.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
        ]);

        Embassy::create($request->all());

        return redirect()->route('admin.embassies.index')
            ->with('success', 'Embassy added successfully.');
    }

    public function edit($id)
    {
        $embassy = Embassy::findOrFail($id);
        $countries = Country::all();
        return view('admin.embassies.edit', compact('embassy','countries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'required|string|max:255',
        ]);

        $embassy = Embassy::findOrFail($id);
        $embassy->update($request->all());

        return redirect()->route('admin.embassies.index')
            ->with('success', 'Embassy updated successfully.');
    }

    public function destroy($id)
    {
        Embassy::findOrFail($id)->delete();

        return redirect()->route('admin.embassies.index')
            ->with('success', 'Embassy deleted successfully.');
    }
}
