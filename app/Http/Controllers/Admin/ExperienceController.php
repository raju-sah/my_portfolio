<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Experience;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExperienceRequest;
use App\Http\Requests\Admin\ExperienceUpdateRequest;
use App\Traits\StatusTrait;
use App\Traits\UploadFileTrait;

class ExperienceController extends Controller
{
    use StatusTrait, UploadFileTrait;
    public function index() : View
    {
        return view('admin.experience.index', [
            'experiences' => Experience::query()->select(['id','name','role','date_to','curently_here','display_order','date_from','status'])->latest()->get()
        ]);
    }

    public function create() : View
    {
        return view('admin.experience.create');
    }

    public function store(ExperienceRequest $request) : RedirectResponse
    {
        $data = $request->safe()->except('image');
    
        // Explicitly cast 'curently_here' to boolean
        $data['curently_here'] = $request->has('curently_here');
    
        $experience = Experience::create($data);
if ($request->hasFile('image')) {
    $experience->storeImage('image', 'experience-images', $request->file('image'));
}

        return redirect()->route('admin.experiences.index')->with('success', 'Experience Created Successfully!');
    }

    public function show(Experience $experience) : View
    {
        return view('admin.experience.show', compact('experience'));
    }

    public function edit(Experience $experience) : View
    {
        return view('admin.experience.edit', compact('experience'));
    }

    public function update(ExperienceUpdateRequest $request, Experience $experience) : RedirectResponse
    {
        $data = $request->safe()->except('image');
    
        // Explicitly cast 'curently_here' to boolean
        $data['curently_here'] = $request->has('curently_here');
    
        $experience->update($data);
if ($request->hasFile('image')) {
    $experience->updateImage('image', 'experience-images', $request->file('image'));
}

        return redirect()->route('admin.experiences.index')->with('success', 'Experience Updated Successfully!');
    }

    public function destroy(Experience $experience) : RedirectResponse
    {
        if($experience->image){
$experience->deleteImage('image', 'experience-images');
}

        $experience->delete();

        return redirect()->route('admin.experiences.index')->with('error', 'Experience Deleted Successfully!');
    }

    public function changeStatus(Request $request):void {
$this->changeItemStatus('Experience',$request->id,$request->status);
}

}
