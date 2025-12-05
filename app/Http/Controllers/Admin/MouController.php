<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mou;
use App\Models\Country;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MouExport;

class MouController extends Controller
{
    public function index()
    {
        $records = Mou::with('country')->orderBy('id', 'DESC')->get();
        return view('admin.mou.index', compact('records'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.mou.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'mou_title' => 'required',
            'signed_date' => 'nullable|date',
            'mou_file'   => 'nullable|mimes:pdf,doc,docx|max:20480',
        ]);

        $data = $request->all();

        if ($request->hasFile('mou_file')) {
            $file = $request->file('mou_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/mou/', $filename);
            $data['mou_file'] = 'uploads/mou/' . $filename;
        }

        Mou::create($data);

        return redirect()->route('admin.mou.index')->with('success', 'MoU Added Successfully!');
    }

    public function edit($id)
    {
        $record = Mou::findOrFail($id);
        $countries = Country::orderBy('name')->get();
        return view('admin.mou.edit', compact('record', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required',
            'mou_title' => 'required',
            'signed_date' => 'nullable|date',
            'mou_file'   => 'nullable|mimes:pdf,doc,docx|max:20480',
        ]);

        $record = Mou::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('mou_file')) {
            if ($record->mou_file && file_exists($record->mou_file)) {
                unlink($record->mou_file);
            }
            $file = $request->file('mou_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/mou/', $filename);
            $data['mou_file'] = 'uploads/mou/' . $filename;
        }

        $record->update($data);

        return redirect()->route('admin.mou.index')->with('success', 'MoU Updated Successfully!');
    }

    public function destroy($id)
    {
        $record = Mou::findOrFail($id);

        if ($record->mou_file && file_exists($record->mou_file)) {
            unlink($record->mou_file);
        }

        $record->delete();

        return redirect()->back()->with('success', 'MoU Deleted!');
    }

    public function exportExcel()
    {
        return Excel::download(new MouExport, 'mou_records.xlsx');
    }
}
