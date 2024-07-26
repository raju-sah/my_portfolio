<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SocialSettingUpdateRequest;
use App\Models\SocialSetting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SocialSettingController extends Controller
{
    public function index(SocialSetting $socialSettings): View
    {
        try {
            $socialSetting = $socialSettings->first();
        } catch (ModelNotFoundException $e) {
            $socialSetting = null;
        }

        return view('settings.social_setting', [
            'socialSettings' => $socialSetting,
            'id' => $socialSetting ? $socialSetting->id : null,
        ]);
    }   //end of method
    public function update(SocialSettingUpdateRequest $request, SocialSetting $socialSettings, $id = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            if ($id) {
                $socialSettings = SocialSetting::find($id);
            }

            if (!$socialSettings) {
                $socialSettings = new SocialSetting();
            }

            $socialSettings->fill($request->validated());
            $socialSettings->save();

            DB::commit();
            return redirect()->back()->with('success', 'Social Setting Updated Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }   //end of method
}

