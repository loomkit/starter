<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;

trait HasPhoto
{
    use HasPicture;

    /**
     * Update the user's photo.
     */
    public function updatePhoto(UploadedFile $photo, string $storagePath = 'photos'): static
    {
        return $this->updatePicture($photo, $storagePath, 'photo_path');
    }

    /**
     * Delete the user's photo.
     */
    public function deletePhoto(): static
    {
        return $this->deletePicture('photo_path');
    }

    /**
     * Get the URL to the user's photo.
     */
    protected function photoUrl(): Attribute
    {
        return $this->pictureUrl('photo_path');
    }

    /**
     * Get the default photo URL if no photo has been uploaded.
     */
    protected function defaultPhotoUrl(string $nameAttribute = 'name'): string
    {
        return $this->defaultPictureUrl($nameAttribute);
    }

    /**
     * Get the disk that photos should be stored on.
     */
    protected function photoDisk(string $default = 'public'): string
    {
        return $this->pictureDisk($default);
    }
}
