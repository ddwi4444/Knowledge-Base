@extends('layouts.main')

@section('container')
<br>
<br>
<!-- Halaman untuk menampilkan edit post -->
<div class="container mt-5 mb-5 animate__animated animate__fadeIn">
        <div class="row">
            <div class="col-md-12">

                <div class="card border-0 shadow rounded">
                    <div class="card-body">

                        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="judul_post">Judul</label>
                                <input type="text" class="form-control @error('judul_post') is-invalid @enderror"
                                    name="judul_post" id="judul_post" value="{{ old('judul_post', $post->judul_post) }}" required>

                                <!-- error message untuk title -->
                                @error('judul_post')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <div class="image">
                                <label for="image">Thumbnail</label>
                                <img style ="height: 200px;  width: 200px;" class="img_unit" src="{{ asset('storage/'.$post->image) }}" alt="Card image cap">
                                    <input type="file" class="form-control" 
                                    value="{{ $post->image_path }}" name="image" id="image" accept="image/jpg, image/png, image/jpeg">
                                </div>
                            </div>

                            <div class="form-group mt-2">
                                <label for="isi_post">Isi</label>
                                <textarea
                                    name="isi_post" id="editor"
                                    class="form-control @error('isi_post') is-invalid @enderror"
                                    rows="10"
                                    required>{{ old('isi_post', $post->isi_post) }}</textarea>

                                <!-- error message untuk deskripsi -->
                                @error('isi_post')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-2">
                                <label for="tags">Tags</label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                    name="tags" id="tags" value="{{ old('tags', $post->tags) }}" required>

                                <!-- error message untuk anggota -->
                                @error('tags')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary mt-2">Unggah</button>
                            <a href="{{ route('posts.index') }}" class="btn btn-md btn-secondary mt-2">Batal</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>
@endsection

@section('script')
<script>
    CKEDITOR.replace( 'editor' );
  </script>
@endsection