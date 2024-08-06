<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\SharedImage;

class ImageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Image::where('user_id', $user->id)->get();
    }

    public function store(Request $request)
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

                $imageUrl = str_replace('http://localhost', 'http://localhost:8000', $imageUrl);

                $image = Image::create([
                    'title' => $request->title,
                    'path' => $imageUrl,
                    'user_id' => Auth::id()
                ]);

                return response()->json($image, 201);
            }
        } catch (\Exception $e) {
            Log::error('Failed to save image: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save the image'], 500);
        }

        return response()->json(['error' => 'Image upload failed'], 400);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $image = Image::where('user_id', Auth::id())->findOrFail($id);
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

    public function destroy($id)
    {
        $image = Image::where('user_id', Auth::id())->findOrFail($id);

        if ($image->path) {
            $oldPath = str_replace('/storage', 'public', $image->path);
            Storage::delete($oldPath);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully'], 200);
    }

    public function shareImage(Request $request, $imageId)
    {
        $request->validate([
            'shared_with_user_id' => 'required|exists:users,id',
        ]);

        $image = Image::where('user_id', Auth::id())->findOrFail($imageId);

        SharedImage::create([
            'image_id' => $image->id,
            'shared_with_user_id' => $request->shared_with_user_id,
        ]);

        return response()->json(['message' => 'Image shared successfully'], 200);
    }

}
