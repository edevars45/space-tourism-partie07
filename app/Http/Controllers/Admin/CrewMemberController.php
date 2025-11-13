<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrewMemberRequest;
use App\Models\CrewMember;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CrewMemberController extends Controller
{
    private function keepExisting(array $data): array
    {
        $table = (new CrewMember)->getTable();
        return collect($data)->filter(fn($v,$k)=>Schema::hasColumn($table,$k))->all();
    }

    public function index()
    {
        $q = CrewMember::query();
        $table = (new CrewMember)->getTable();
        Schema::hasColumn($table,'order') ? $q->orderBy('order') : $q->orderBy('name');
        $members = $q->paginate(12);

        return view('admin.crew_members.index', compact('members'));
    }

    public function create()
    {
        $member = new CrewMember();
        return view('admin.crew_members.create', compact('member'));
    }

    public function store(CrewMemberRequest $request)
    {
        $table = (new CrewMember)->getTable();
        $data = $request->validated();

        if (Schema::hasColumn($table,'slug')) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name'] ?? '');
        }
        if (Schema::hasColumn($table,'published')) {
            $data['published'] = (bool)($data['published'] ?? false);
        }
        if ($request->hasFile('image') && Schema::hasColumn($table,'image_path')) {
            $data['image_path'] = $request->file('image')->store('crew','public');
        }

        CrewMember::create($this->keepExisting($data));
        return redirect()->route('admin.crew.index')->with('success','Membre créé.');
    }

    public function edit(CrewMember $crew)
    {
        $member = $crew;
        return view('admin.crew_members.edit', compact('member'));
    }

    public function update(CrewMemberRequest $request, CrewMember $crew)
    {
        $table = $crew->getTable();
        $data = $request->validated();

        if (Schema::hasColumn($table,'slug')) {
            $data['slug'] = $data['slug'] ?? Str::slug($data['name'] ?? $crew->name);
        }
        if (Schema::hasColumn($table,'published')) {
            $data['published'] = (bool)($data['published'] ?? false);
        }
        if ($request->hasFile('image') && Schema::hasColumn($table,'image_path')) {
            if ($crew->image_path) Storage::disk('public')->delete($crew->image_path);
            $data['image_path'] = $request->file('image')->store('crew','public');
        }

        $crew->update($this->keepExisting($data));
        return redirect()->route('admin.crew.index')->with('success','Membre mis à jour.');
    }

    public function destroy(CrewMember $crew)
    {
        if ($crew->image_path) Storage::disk('public')->delete($crew->image_path);
        $crew->delete();
        return back()->with('success','Membre supprimé.');
    }
}
