<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasPicture
{
    /**
     * Update the user's picture.
     */
    public function updatePicture(UploadedFile $picture, string $storagePath = 'pictures', string $attribute = 'picture_path'): static
    {
        tap($this->{$attribute}, function ($previous) use ($picture, $storagePath) {
            $this->forceFill([
                $attribute => $picture->storePublicly(
                    $storagePath, ['disk' => $this->pictureDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->pictureDisk())->delete($previous);
            }
        });

        return $this;
    }

    /**
     * Delete the user's picture.
     */
    public function deletePicture(string $attribute = 'picture_path'): static
    {
        if (is_null($this->{$attribute})) {
            return $this;
        }

        Storage::disk($this->pictureDisk())->delete($this->{$attribute});

        $this->forceFill([
            $attribute => null,
        ])->save();

        return $this;
    }

    /**
     * Get the URL to the user's picture.
     */
    protected function pictureUrl(string $attribute = 'picture_path'): Attribute
    {
        return Attribute::get(function () use ($attribute): string {
            return $this->{$attribute}
                    ? Storage::disk($this->pictureDisk())->url($this->{$attribute})
                    : $this->defaultPictureUrl();
        });
    }

    /**
     * Get the default picture URL if no picture has been uploaded.
     */
    protected function defaultPictureUrl(string $nameAttribute = 'name'): string
    {
        $name = trim(collect(explode(' ', $this->{$nameAttribute}))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that pictures should be stored on.
     */
    protected function pictureDisk(string $default = 'public'): string
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.photo_disk', $default);
    }
}
