<?php

namespace App\Traits;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
trait UploadFileTrait
{
    public function storeImage(string $field, string $folder_name, $file, int $width = null, int $height = null, string $image_name = null): static
    {
        $filename = $image_name ?? $file->hashName();
        $path = public_path('uploaded-images/' . $folder_name . '/' . $filename);

        $this->resizeAndSave($file, $path, $width, $height);
        $this->update([$field => $filename]);
        return $this;
    }

    public function updateImage(string $field, string $folder_name, $file, int $width = null, int $height = null, string $image_name = null): static
    {
        if (isset($this->{$field})) {
            @unlink('uploaded-images/' . $folder_name . '/' . $this->{$field});
        }

        $filename = $image_name ?? $file->hashName();
        $path = public_path('uploaded-images/' . $folder_name . '/' . $filename);

        $this->resizeAndSave($file, $path, $width, $height);
        $this->update([$field => $filename]);
        return $this;
    }

    public function updatePDF(string $field, string $folder_name, $file): static
    {
        if (isset($this->{$field})) {
            @unlink(public_path('uploaded-images/' . $folder_name . '/' . $this->{$field}));
        }

        $filename = $file->hashName();
        $path = public_path('uploaded-images/' . $folder_name . '/' . $filename);

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $file->move($directory, $filename);
        $this->update([$field => $filename]);
        return $this;
    }

    public function deleteImage(string $field, string $folder_name): static
    {
        if (isset($this->{$field})) {
            @unlink('uploaded-images/' . $folder_name . '/' . $this->{$field});
        }
        return $this;
    }
    public function storeMultiImage($file, string $folder_name, int $width = null, int $height = null): static
    {
        $filename = $file->hashName();
        $this->image_name = $filename;
        $path = public_path('uploaded-images/' . $folder_name . '/' . $filename);

        $this->resizeAndSave($file, $path, $width, $height);

        $this->images()->create([
            'image_name' => $filename,
            'imageable_type' => get_class($this),
            'imageable_id' => $this->id,
        ]);

        return $this;
    }

    //--------------------helper function for image resize and save----------------------------------------------
    public function resizeAndSave($file, string $path, int $width = null, int $height = null): static
    {
        $imageConfig = config('imagesetting.default.image');

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());
        $image->resize($width ?? $imageConfig['width'], $height ?? $imageConfig['height'], function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save($path, $imageConfig['quality']);
        return $this;
    }
}
