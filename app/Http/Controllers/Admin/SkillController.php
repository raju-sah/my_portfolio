<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Skill;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkillRequest;
use App\Http\Requests\Admin\SkillUpdateRequest;
use App\Traits\StatusTrait;
use App\Traits\UploadFileTrait;

class SkillController extends Controller
{
    use StatusTrait,UploadFileTrait;
    public function index(): View
    {
        return view('admin.skill.index', [
            'skills' => Skill::query()->select(['id', 'name', 'percentage', 'display_order','status'])->latest()->get()
        ]);
    }

    public function create(): View
    {
        return view('admin.skill.create');
    }

    public function store(SkillRequest $request): RedirectResponse
    {
        $skill = Skill::create($request->safe()->except('image'));
        if ($request->hasFile('image')) {
            $skill->storeImage('image', 'skill-images', $request->file('image'),100,100);
        }

        return redirect()->route('admin.skills.index')->with('success', 'Skill Created Successfully!');
    }

    public function show(Skill $skill): View
    {
        return view('admin.skill.show', compact('skill'));
    }

    public function edit(Skill $skill): View
    {
        return view('admin.skill.edit', compact('skill'));
    }

    public function update(SkillUpdateRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->safe()->except('image'));
        if ($request->hasFile('image')) {
            $skill->updateImage('image', 'skill-images', $request->file('image'),100,100);
        }

        return redirect()->route('admin.skills.index')->with('success', 'Skill Updated Successfully!');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        if ($skill->image) {
            $skill->deleteImage('image', 'skill-images');
        }

        $skill->delete();

        return redirect()->route('admin.skills.index')->with('error', 'Skill Deleted Successfully!');
    }

    public function changeStatus(Request $request): void
    {
        $this->changeItemStatus('Skill', $request->id, $request->status);
    }
}
