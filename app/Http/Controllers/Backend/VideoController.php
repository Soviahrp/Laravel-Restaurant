<?php

namespace App\Http\Controllers\Backend;

use App\Http\Services\VideoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;

class VideoController extends Controller
{
    public function __construct(private VideoService $videoService) {}

    public function index()
    {
        return view('backend.video.index', [
            'videos' => $this->videoService->select(10)
        ]);
    }

    public function create()
    {
        return view('backend.video.create');
    }

    public function store(VideoRequest $request)
    {
        $data = $request->validated();

        try {
            $this->videoService->create($data);
            return redirect()->route('panel.video.index')->with('success', 'video has been created');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    public function show($uuid)
    {
        $video = $this->videoService->selectFirstBy('uuid', $uuid);
        return view('backend.video.show', compact('video'));
    }

    public function edit(string $uuid)
    {
        $video = $this->videoService->selectFirstBy('uuid', $uuid);
        return view('backend.video.edit', compact('video'));
    }

    public function update(VideoRequest $request, string $uuid)
    {
        $data = $request->validated();

        try {
            $this->videoService->update($data, $uuid);
            return redirect()->route('panel.video.index')->with('success', 'Video has been updated');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    public function destroy(string $uuid)
    {
        $currentVideo = $this->videoService->selectFirstBy('uuid', $uuid);
        $currentVideo->delete();

        return response()->json([
            'message' => 'Video has been deleted']);
    }
}
