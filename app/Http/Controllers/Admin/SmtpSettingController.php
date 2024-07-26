<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SmtpSettingUpdateRequest;
use App\Models\SmtpSetting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SmtpSettingController extends Controller
{
    public function index(SmtpSetting $smtpSettings): View
    {
        try {
            $smtpSetting = $smtpSettings->first();
        } catch (ModelNotFoundException $e) {
            $smtpSetting = null;
        }

        return view('settings.smtp_setting', [
            'smtpSettings' => $smtpSetting,
            'id' => $smtpSetting ? $smtpSetting->id : null,
        ]);
    }   //end of method
    public function update(SmtpSettingUpdateRequest $request, SmtpSetting $smtpSettings, $id = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            if ($id) {
                $smtpSettings = SMTPSetting::find($id);
            }

            if (!$smtpSettings) {
                $smtpSettings = new SMTPSetting();
            }

            $smtpSettings->fill($request->validated());
            $smtpSettings->save();

            DB::commit();
            return redirect()->back()->with('success', 'SMTP Setting Updated Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }   //end of method
}
