<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Throwable;

trait ImageTrait
{
    protected $allowedFileExtensions = ['jpg', 'png', 'jpeg']; // Simplify to lowercase only

    /**
     * Uploads an image to the specified disk.
     *
     * @param string $disk
     * @param UploadedFile $file
     * @return string
     */
    public function upload_image($disk, $file)
    {
        $extension = strtolower($file->getClientOriginalExtension()); // Standardize extension to lowercase
        if (!in_array($extension, $this->allowedFileExtensions)) {
            Log::warning('Attempt to upload disallowed file type.', ['extension' => $extension]);
            return "";
        }

        $path = $file->store('images/user_images', $disk);
        return "/$disk/$path";
    }

    /**
     * Deletes an image from the specified path and disk.
     *
     * @param string $disk
     * @param string $path
     * @return bool
     */
    public function delete_image($disk, $path)
    {
        if (str_contains($path, "default")) {
            return true;
        }

        try {
            $filename = basename($path); // More robust extraction of filename
            Storage::disk($disk)->delete("images/user_images/$filename");
            return true;
        } catch (Throwable $th) {
            Log::error('Failed to delete image.', ['error' => $th->getMessage()]);
            return false;
        }
    }

    /**
     * Handles uploading a new image and deleting an old one if applicable.
     *
     * @param UploadedFile $image
     * @param string $path
     * @param string|null $oldImagePath
     * @return string
     */
    public function addImage(UploadedFile $image, $path , $oldImagePath = null)
    {
        if ($oldImagePath) {
            $this->deleteImage($oldImagePath);
        }

        $name = $this->generateImageName($image);
        $destinationPath = public_path("/images/$path");
        $image->move($destinationPath, $name);
        Log::info('Image stored.', ['path' => $destinationPath, 'name' => $name]);

        return "/images/$path/$name";
    }

    /**
     * Deletes an image from the local path.
     *
     * @param string $oldImagePath
     */
    public function deleteImage($oldImagePath)
    {
        $fullPath = public_path($oldImagePath);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
            Log::info('Image deleted.', ['path' => $fullPath]);
        }
    }

    /**
     * Generates a unique name for the image based on its original name and a timestamp.
     *
     * @param UploadedFile $image
     * @return string
     */
    protected function generateImageName(UploadedFile $image)
    {
        $timestamp = time();
        $extension = strtolower($image->getClientOriginalExtension());
        $uniqueHash = md5(uniqid($image->getClientOriginalName(), true)); // Add a unique hash
        return $uniqueHash . '.' . $extension; // Return the unique hash as part of the file name
    }

    /**
     * Functionality equivalent to addImage, tailored for images uploaded from text editors.
     *
     * @param UploadedFile $image
     * @param string $path
     * @param string|null $oldImagePath
     * @return array
     */
    public function addImageFromTextEditor(UploadedFile $image, $path = 'user_images', $oldImagePath = null)
    {
        if ($oldImagePath) {
            $this->deleteImage($oldImagePath);
        }

        $name = $this->generateImageName($image);
        $destinationPath = public_path("images/$path");
        $image->move($destinationPath, $name);
        Log::info('Image uploaded from editor.', ['path' => $destinationPath, 'name' => $name]);

        return [
            'link' => "/images/$path/$name",
            'filename' => $name
        ];
    }
}
