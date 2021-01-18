@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật thông tin
            </div>
            <div class="card-body">
                <form action="{{ route('update_user', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" value="{{ $user->name }}" id="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ $user->email }}" disabled="disabled"
                            id="email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <label for="email">Quyền</label>
                    @foreach ($roles as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="list_check[]" value="{{ $item->id }}"
                                id="select_{{ $item->id }}" {{ $roleUser->contains($item->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="select_{{ $item->id }}">
                                {{ $item->name }}
                            </label>
                        </div>
                    @endforeach
                    <button type="submit" name="btn-update" value="update" class="btn btn-primary mt-2">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
