<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use App\Models\OmType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::latest()->get();
        return view('admin.vacancies.index', compact('vacancies'));
    }

    public function create()
    {
        $omTypes = OmType::where('status', 1)->get();
        return view('admin.vacancies.create', compact('omTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
            'date' => 'nullable|date',
            'type' => 'nullable|string|max:100',
            'status' => 'required|boolean',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('vacancies', 'public');
        }

        Vacancy::create([
            'title' => $request->title,
            'file' => $filePath,
            'date' => $request->date,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy added successfully.');
    }

    public function edit(Vacancy $vacancy)
    {
        $omTypes = OmType::where('status', 1)->get();
        return view('admin.vacancies.edit', compact('vacancy','omTypes'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
            'date' => 'nullable|date',
            'type' => 'nullable|string|max:100',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('file')) {
            if ($vacancy->file) {
                Storage::disk('public')->delete($vacancy->file);
            }
            $vacancy->file = $request->file('file')->store('vacancies', 'public');
        }

        $vacancy->update($request->only(['title', 'date', 'type', 'status']));

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy updated successfully.');
    }

    public function destroy(Vacancy $vacancy)
    {
        if ($vacancy->file) {
            Storage::disk('public')->delete($vacancy->file);
        }

        $vacancy->delete();
        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy deleted successfully.');
    }
}
