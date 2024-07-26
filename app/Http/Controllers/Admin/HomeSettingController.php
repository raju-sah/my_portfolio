<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HomeSettingUpdateRequest;
use App\Models\BackForthText;
use App\Models\HomeSetting;
use App\Models\SocialSetting;
use App\Traits\StatusTrait;
use App\Traits\UploadFileTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeSettingController extends Controller
{
    use StatusTrait, UploadFileTrait;
    public function index(): View
    {
        return view('admin.home_setting.index', [
            'home_settings' => HomeSetting::query()
                ->select(['id', 'title', 'slug', 'logo', 'description', 'image', 'status'])
                ->latest()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.home_setting.create');
    }

    public function show(HomeSetting $homeSetting): View
    {
        return view('admin.home_setting.show', compact('homeSetting'));
    }

    public function edit(HomeSetting $homeSetting, SocialSetting $socialSetting): View
    {
        return view('admin.home_setting.edit', compact('homeSetting', 'socialSetting'));
    }

    public function update(HomeSettingUpdateRequest $request, HomeSetting $homeSetting): RedirectResponse
    {
        $homeSetting->update($request->safe()->except('logo', 'image', 'pdf_file', 'name', 'email', 'phone', 'address'));
        if ($request->hasFile('logo')) {
            $homeSetting->updateImage('logo', 'home-setting-logo', $request->file('logo'),100,100);
        }
        if ($request->hasFile('image')) {
            $homeSetting->updateImage('image', 'home-setting-images', $request->file('image'),100,100);
        }

        if ($request->hasFile('pdf_file')) {
            $homeSetting->updatePDF('pdf_file', 'pdf-files', $request->file('pdf_file'));
        }

        $data = $request->validated();
        $backforth = [];
        if (isset($data['name']) && is_array($data['name'])) {
            foreach ($data['name'] as $index => $name) {
                $backforth[] = [
                    'name' => ucfirst($name),
                    'home_setting_id' => $homeSetting->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $homeSetting->BackForthTexts()->delete();
            BackForthText::insert($backforth);
        }

        return redirect()
            ->route('admin.home-settings.edit', $homeSetting->id)
            ->with('success', 'Home Setting Updated Successfully!');
    }
}
