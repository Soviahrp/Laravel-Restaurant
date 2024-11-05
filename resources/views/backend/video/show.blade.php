@extends('backend.template.main')

@section('title', 'Video: ' . $video->title)

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('panel.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('panel.video.index') }}">Video</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $video->title }}</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Video: {{ $video->title }}</h1>
                <p class="mb-0">Detail video untuk: {{ $video->title }}</p>
            </div>
            <div>
                <a href="{{ route('panel.video.index') }}" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <td width="25%">
                        <div class="video-responsive" style="padding-bottom: 56.25%; position: relative; height: 7%;">
                            <iframe src="{{ $video->url }}"
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                    frameborder="0"
                                    allow="autoplay; encrypted-media; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Url</th>
                    <td>{{ $video->url }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ $video->title }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $video->slug }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $video->description }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ date('Y-m-d H:i:s', strtotime($video->created_at)) }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ date('Y-m-d H:i:s', strtotime($video->updated_at)) }}</td>
                </tr>
            </table>
            <div class="float-end mt-2">
                <a href="{{ route('panel.video.edit', $video->uuid) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
            </div>
        </div>
    </div>
@endsection
