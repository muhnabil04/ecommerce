@extends('admin.layout.navbar')

@section('container')
    <form method="POST" action="{{ route('admin.coupon.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="kode" class="form-label">kode</label>
            <input type="text" class="form-control" id="kode" name="kode">
        </div>
        <div class="mb-3">
            <label for="diskon" class="form-label">diskon</label>
            <input type="text" class="form-control" id="diskon" name="diskon">
        </div>
        <button type="submit" class="btn btn-primary mt-3" name="submit">Submit</button>
    </form>
@endsection
