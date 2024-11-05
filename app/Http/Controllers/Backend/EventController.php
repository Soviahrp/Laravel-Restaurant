<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Services\FileService;
use App\Http\Requests\EventRequest;
use App\Http\Services\EventService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function __construct(
        private FileService $fileService,
        private EventService $eventService,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
       return view('backend.event.index', [
           'events' => $this->eventService->select(10),
       ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('backend.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        $data = $request->validated();

        try {
            $data['image'] = $this->fileService->upload($data['image'], 'images');

            $this->eventService->create($data);

            return redirect()->route('panel.event.index')->with('success', 'Event has been created');
        } catch (\Exception $err) {
            $this->fileService->delete($data['file']);

            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        return view('backend.event.show',[
            'event' => $this->eventService->selectFirstBy('uuid', $uuid)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        return view('backend.event.edit', [
            'event' => $this->eventService->selectFirstBy('uuid', $uuid)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, string $uuid)
    {
        $data = $request->validated();

        // Ambil Event berdasarkan UUID
        $getEvent = $this->eventService->selectFirstBy('uuid', $uuid);

        try {
            // Jika ada file gambar yang di-upload
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($getEvent->image) {
                    $this->fileService->delete($getEvent->image);
                }

                // Upload gambar baru
                $data['image'] = $this->fileService->upload($request->file('image'), 'images');
            } else {
                // Jika tidak ada upload, gunakan gambar yang lama
                $data['image'] = $getEvent->image;
            }

            // Update Event dengan data baru
            $this->eventService->update($data, $uuid);

            // Redirect ke daftar Event dengan pesan sukses
            return redirect()->route('panel.event.index')->with('success', 'Event has been updated');
        } catch (\Exception $err) {
            // Jika terjadi kesalahan, hapus gambar yang di-upload (jika ada)
            if (isset($data['image'])) {
                $this->fileService->delete($data['image']);
            }

            // Kembali ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $getEvent = $this->eventService->selectFirstBy('uuid', $uuid);
        $this->fileService->delete($getEvent->image);

        $getEvent->delete();

        return response()->json([
            'message' => 'Event has been deleted'
        ]);
    }
}
