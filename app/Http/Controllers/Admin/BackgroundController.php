<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Background;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BackgroundRequest;
use App\Http\Requests\Admin\BackgroundUpdateRequest;
use App\Traits\StatusTrait;
use App\Traits\UploadFileTrait;

class BackgroundController extends Controller
{
    use StatusTrait, UploadFileTrait;
    public function index() : View
    {
        return view('admin.background.index', [
            'backgrounds' => Background::query()->select(['id', 'name','slug','address','web_url','status'])->latest()->get()
        ]);
    }

    public function create() : View
    {
        return view('admin.background.create');
    }

    public function store(BackgroundRequest $request) : RedirectResponse
    {
        $background = Background::create($request->safe()->except('image'));
if ($request->hasFile('image')) {
    $background->storeImage('image', 'background-images', $request->file('image'));
}

        return redirect()->route('admin.backgrounds.index')->with('success', 'Background Created Successfully!');
    }

    public function show(Background $background) : View
    {
        return view('admin.background.show', compact('background'));
    }

    public function edit(Background $background) : View
    {
        return view('admin.background.edit', compact('background'));
    }

    public function update(BackgroundUpdateRequest $request, Background $background) : RedirectResponse
    {
        $background->update($request->safe()->except('image'));
if ($request->hasFile('image')) {
    $background->updateImage('image', 'background-images', $request->file('image'));
}

        return redirect()->route('admin.backgrounds.index')->with('success', 'Background Updated Successfully!');
    }

    public function destroy(Background $background) : RedirectResponse
    {
        if($background->image){
$background->deleteImage('image', 'background-images');
}

        $background->delete();

        return redirect()->route('admin.backgrounds.index')->with('error', 'Background Deleted Successfully!');
    }

    public function changeStatus(Request $request):void {
$this->changeItemStatus('Background',$request->id,$request->status);
}

}
