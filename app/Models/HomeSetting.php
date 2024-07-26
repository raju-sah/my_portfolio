<?php

namespace App\Models;

use App\Traits\ModelQueryTrait;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeSetting extends Model
{
    use HasFactory, UploadFileTrait, ModelQueryTrait;
    protected $guarded = ['id'];


    public function getImagePathAttribute(): string
    {
        return $this->image ? asset('uploaded-images/home-setting-images/'.$this->image) : '';
    }
    public function getPdfPathAttribute(): string
{
    return $this->pdf_file ? asset('uploaded-images/pdf-files/' . $this->pdf_file) : '';
}

    public function getLogoPathAttribute(): string
    {
        return $this->logo ? asset('uploaded-images/home-setting-logo/'.$this->logo) : 'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
    }

    public function BackForthTexts()
    {
        return $this->hasMany(BackForthText::class);
    }

    public function socialSetting()
    {
        return $this->hasOne(SocialSetting::class);
    }


 

}
