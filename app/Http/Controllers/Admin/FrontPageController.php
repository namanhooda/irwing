<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FrontPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrontPageController extends Controller
{
    public function index()
    {
        $frontPages = FrontPage::latest()->get();
        return view('admin.front_pages.index', compact('frontPages'));
    }

    public function create()
    {
        return view('admin.front_pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'file' => 'nullable|mimes:pdf|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('front_pages', 'public');
        }

        FrontPage::create($data);

        return redirect()->route('admin.front_pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(FrontPage $front_page)
    {
        return view('admin.front_pages.edit', compact('front_page'));
    }

    public function update(Request $request, FrontPage $front_page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'file' => 'nullable|mimes:pdf|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            if ($front_page->file && Storage::disk('public')->exists($front_page->file)) {
                Storage::disk('public')->delete($front_page->file);
            }
            $data['file'] = $request->file('file')->store('front_pages', 'public');
        }

        $front_page->update($data);

        return redirect()->route('admin.front_pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(FrontPage $front_page)
    {
        if ($front_page->file && Storage::disk('public')->exists($front_page->file)) {
            Storage::disk('public')->delete($front_page->file);
        }

        $front_page->delete();
        return redirect()->route('admin.front_pages.index')->with('success', 'Page deleted successfully.');
    }
}
