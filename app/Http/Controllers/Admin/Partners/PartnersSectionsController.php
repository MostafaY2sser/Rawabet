<?php

namespace App\Http\Controllers\Admin\Partners;

use App\Http\Controllers\Controller;
use App\Models\PartnersSection;
use Illuminate\Http\Request;

class PartnersSectionsController extends Controller
{
    public function index()
    {
        $sections = PartnersSection::all();
        return view('admin.partners.sections', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        PartnersSection::create(
            [
                'name' => $request->name,
            ]
        );

        return redirect()->back()->with('success', 'created');
    }

    public function update(Request $request, PartnersSection $section)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $request->name,
        ];

        $section->update($data);

        return redirect()->back()->with('success', 'updated');
    }
}
