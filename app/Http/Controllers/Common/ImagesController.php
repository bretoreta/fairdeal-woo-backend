<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Images\StoreRequest;
use App\Models\Image as ImageModel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function upload(StoreRequest $request)
    {
        try {
            if($request->has('image'))
            {
                $file = $request->file('image');
                $path = "images/{$request->user()->id}/". now()->format('Y'). "/". now()->format('M');

                $fullSize = Image::make($file)->encode('webp', 60);
                $thumbnailSize = Image::make($file)->fit(200, 200)->encode('webp', 60);
                $mediumSize = Image::make($file)->fit(500, 500)->encode('webp', 60);

                Storage::disk('public')->put("{$path}/{$file->hashName()}", $fullSize);
                Storage::disk('public')->put("{$path}/thumbnail_{$file->hashName()}", $thumbnailSize);
                Storage::disk('public')->put("{$path}/small_{$file->hashName()}", $mediumSize);

                $image = ImageModel::create([
                    'user_id' => $request->user()->id,
                    'file_name' => $file->hashName(),
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'full_size_url' => $path. '/' .$file->hashName(),
                    'thumbnail_size_url' => $path. '/thumbnail_' .$file->hashName(),
                    'medium_size_url' => $path. '/small_' .$file->hashName(),
                ]);

                return response()->json($image->uuid);
            }

            return response(403)->json(['message', 'Missing Required Parameter: Image']);
        } catch (\Error $error) {
            return response($error->getMessage(), 500);
        }
    }

    public function delete(ImageModel $image)
    {
        try {
            Storage::disk('public')->delete([$image->full_size_url, $image->thumbnail_size_url, $image->medium_size_url]);

            $image->delete();

            return back()->with('message', [
                'type' => 'success',
                'message' => 'Image Has Been Deleted Successfully'
            ]);
        } catch (\Error $error) {
            return response($error->getMessage(), 500);
        }
    }
}