<?php

namespace App\Http\Services;

use Illuminate\Support\Str;
use App\Models\Gallery\Video;

class VideoService
{
    public function select($paginate = null)
    {
        return $paginate ? Video::latest()->paginate($paginate) : Video::latest()->get();
    }

    public function selectFirstBy($column, $value)
    {
        return Video::where($column, $value)->firstOrFail();
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['title']);

        return Video::create($data);
    }

    public function update(array $data, string $uuid)
    {
        $data['slug'] = Str::slug($data['title']);
        
        return Video::where('uuid', $uuid)->update($data);
    }
}
