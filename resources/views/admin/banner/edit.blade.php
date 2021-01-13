@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('status_err'))
                        <div class="alert alert-danger">
                            {{ session('status_err') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Update banner
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update_banner', $banner->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <input class="form-control" type="text" name="description"
                                    value="{{ $banner->description }}" data-toggle="tooltip" id="description">
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <img class="" style="width: 80px; height: auto;" src="{{ asset($banner->path) }}"
                                        alt="banner cũ" title="banner cũ">
                                </div>
                                <div class="col-9 form-group">
                                    <label for="file">(Banner) (848 x 371px)</label>
                                    <input type="file" name="banner" class="form-control-file mt-2" id="file">
                                    @error('banner')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-1" value="1">
                                <label class="form-check-label" for="status-1">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-2" value="0" checked>
                                <label class="form-check-label" for="status-2">
                                    Inactive
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2" name="btn-add" value="Cập nhật">Cập
                                nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
