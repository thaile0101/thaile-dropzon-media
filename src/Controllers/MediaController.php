<?php

namespace ThaiLe\Media\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use ThaiLe\Media\Models\Upload;

class MediaController extends Controller
{
    private $photoPath;

    public function __construct()
    {
        $this->photoPath = config()->get('media.folder');
    }

    /**
     * Display all of the images.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('media::media');
    }

    public function index()
    {
        $photos = Upload::orderBy('id', 'DESC')->get(['id', 'resized_name', 'original_name']);
        return response()->json([
            'code' => 200,
            'data' => $photos
        ], 200);
    }

    /**
     * Show the form for creating uploading new images.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('media::upload');
    }

    /**
     * Saving images uploaded through XHR Request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photos = $request->file('file');

        if (!is_array($photos)) {
            $photos = [$photos];
        }

        if (!is_dir($this->photoPath)) {
            mkdir($this->photoPath, 0777);
        }

        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $photo->getClientOriginalExtension();
            $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();

            Image::make($photo)
                ->resize(250, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->photoPath . '/' . $resize_name);

            $photo->move($this->photoPath, $save_name);

            $upload = new Upload();
            $upload->filename = $save_name;
            $upload->resized_name = $resize_name;
            $upload->original_name = basename($photo->getClientOriginalName());
            $upload->save();
        }
        return response()->json([
            'code' => 200,
            'data' => $upload,
            'message' => 'Image saved Successfully'
        ], 200);
    }

    /**
     *
     * Remove the images from the storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $image = Upload::find($request->id);

        if (empty($image)) {
            return response()->json(['code' => 400, 'message' => 'Sorry file does not exist'], 400);
        }

        $file_path = $this->photoPath . '/' . $image->filename;
        $resized_file = $this->photoPath . '/' . $image->resized_name;

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        if (file_exists($resized_file)) {
            unlink($resized_file);
        }

        if (!empty($image)) {
            $image->delete();
        }

        return response()->json(['code' => 200, 'message' => 'File successfully delete'], 200);
    }
}