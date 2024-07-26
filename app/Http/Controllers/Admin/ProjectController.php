<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Http\Requests\Admin\ProjectUpdateRequest;
use App\Traits\DatatableTrait;
use App\Traits\StatusTrait;
use App\Traits\UploadFileTrait;

class ProjectController extends Controller
{
    use StatusTrait, DatatableTrait,UploadFileTrait;
    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Project::query()->select(['id', 'name', 'year', 'display_order', 'tech_used', 'status'])
            ->latest();

        $config = [
            'additionalColumns' => [
                'tech_used' => function ($row) {
                    $techs = json_decode($row->tech_used, true);
                    if (is_array($techs)) {
                        return implode(', ', array_map(function($tech) {
                            return '<span class="badge bg-primary">' . e($tech) . '</span>';
                        }, $techs));
                    }
                    return '<span class="badge bg-primary">' . e($row->tech_used) . '</span>';
                },
            ],
            'disabledButtons' => [],
            'model' => 'Project',
            'rawColumns' => ['tech_used'],
            'sortable' => false,
            'routeClass' => null,
        ];

        return $this->getDataTable($request, $query, $config)->make(true);
    }
    return view('admin.project.index', [
        'columns' => ['name', 'year', 'tech_used', 'display_order', 'status'],
    ]);
}

    public function create(): View
    {
        return view('admin.project.create');
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image', 'tech_used');
        $data['tech_used'] = json_encode($request->tech_used);
        $project = Project::create($data);

        if ($request->hasFile('image')) {
            $project->storeImage('image', 'project-images', $request->file('image'));
        }
        return redirect()->route('admin.projects.index')->with('success', 'Project Created Successfully!');
    }
    public function show(Project $project): View
    {
        return view('admin.project.show', compact('project'));
    }
    public function edit(Project $project): View
    {
        return view('admin.project.edit', compact('project'));
    }
    public function update(ProjectUpdateRequest $request, Project $project): RedirectResponse
    {
        $data = $request->safe()->except('image', 'tech_used');
        $data['tech_used'] = json_encode($request->tech_used);
        $project->update($data);
        if ($request->hasFile('image')) {
            $project->updateImage('image', 'project-images', $request->file('image'));
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project Updated Successfully!');
    }
    public function destroy(Project $project): RedirectResponse
    {
        if ($project->image) {
            $project->deleteImage('image', 'project-images');
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('error', 'Project Deleted Successfully!');
    }
    public function changeStatus(Request $request): void
    {
        $this->changeItemStatus('Project', $request->id, $request->status);
    }
}
