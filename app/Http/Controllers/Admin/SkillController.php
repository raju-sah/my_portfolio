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

class SkillController extends Controller
{
    use StatusTrait;
    public function index(): View
    {
        return view('admin.skill.index', [
            'skills' => Skill::query()
                ->select(['id', 'name', 'percentage', 'display_order', 'skill_domain', 'status'])
                ->orderBy('display_order')
                ->get()
                ->groupBy(fn($skill) => optional($skill->skill_domain)->value ?? 0)
        ]);
    }

    public function updateOrder(Request $request): RedirectResponse
    {
        $order = $request->input('order');
        foreach ($order as $index => $id) {
            Skill::where('id', $id)->update(['display_order' => $index + 1]);
        }
        return redirect()->back()->with('success', 'Order Updated Successfully!');
    }

    public function create(): View
    {
        return view('admin.skill.create');
    }

    public function store(SkillRequest $request): RedirectResponse
    {
        Skill::create($request->validated());
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
        $skill->update($request->validated());
        return redirect()->route('admin.skills.index')->with('success', 'Skill Updated Successfully!');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('error', 'Skill Deleted Successfully!');
    }

    public function changeStatus(Request $request): void
    {
        $this->changeItemStatus('Skill', $request->id, $request->status);
    }
}
