<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function getAllImages()
    {
        return Image::all();
    }

    public function showShared($uuid)
    {
        $image = Image::where('shared_url', $uuid)->firstOrFail();
        return response()->json($image);
    }

    public function createImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,bmp|max:2048',
            'title' => 'required|string|max:255',
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('images', 'public');
                $imageUrl = Storage::url($path);

                // Append the port to the URL
                $imageUrl = str_replace('http://localhost', 'http://localhost:8000', $imageUrl);

                $image = Image::create([
                    'title' => $request->title,
                    'path' => $imageUrl
                ]);

                return response()->json($image, 201);
            }
        } catch (\Exception $e) {
            Log::error('Failed to save image: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save the image'], 500);
        }

        return response()->json(['error' => 'Image upload failed'], 400);
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $image = Image::findOrFail($id);
        $image->title = $request->title;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('images', 'public');
            $imageUrl = Storage::url($path);

            if ($image->path) {
                $oldPath = str_replace('/storage', 'public', $image->path);
                Storage::delete($oldPath);
            }

            $image->path = $imageUrl;
        }

        $image->save();

        return response()->json($image);
    }

    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);

        if ($image->path) {
            $oldPath = str_replace('/storage', 'public', $image->path);
            Storage::delete($oldPath);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully'], 200);
    }
}
