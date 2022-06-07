@extends('layouts.main')

@section('container')

<!-- Halaman yang menampilkan detail pesan dari mahasiswa -->
<div class="container-xxl animate__animated animate__fadeIn">
    <br>
    <br>
    <hr>

    <section style="background-color: #eee;">
        <div class="container my-5 py-5">            
            <div class="row d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8">
            <h6>Pertanyaan</h6>
                <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-start align-items-center">
                        <img class="rounded-circle shadow-1-strong me-3"
                            src="/img/user.png" alt="avatar" width="60"
                            height="60" />
                        <div>
                            <h6 class="fw-bold text-primary mb-1">{{$comment->nama}} - {{$comment->username}}</h6>
                            <p class="text-muted small mb-0">
                            {{$comment->created_at}}
                            </p>
                        </div>
                        </div>

                        <div class="border mt-2" style="border-radius: 20px; background-color: #f2f4f5; width: fit-content;">   
                            <div style="padding-left: 10px; padding-right: 10px;">
                                <p class="mt-3">
                                    {!! $comment->comment !!}
                                </p>
                            </div>                                     
                        </div>
                    </div>

                    <!-- Untuk menampilkan balasan yang telah kita buat -->
                    @foreach($comments as $com)
                    <!-- Untuk menyaring balasan pesan yang sesuai dengan id parent -->
                    @if($com->id_parent == $comment->id)
                    <div style="padding-left:3.5em; padding-right: 10px; bg-dark" class="mb-5">
                                <p style="color: #be5504;">Balasan <i class="bi bi-reply-all"></i></p>
                                <h6 style="color: #be5504;" class="fw-bold mb-1">{{$com->nama}}</h6>
                                <p class="text-muted small mb-0">
                                    {{$com->created_at}}
                                </p>
                                <div class="border" style="border-radius: 20px; background-color: #f2f4f5; width: fit-content;">   
                                    <div style="padding-left: 10px; padding-right: 10px;">
                                        <p>
                                            {!! $com->comment !!}
                                        </p>
                                    </div>                                     
                                </div>
                    </div>
                    @endif
                    @endforeach
                </div>               
                </div>
                
                <!-- Form untuk membalasa pesan dari mahasiswa -->
                <div class="card-footer py-3 border-0 mt-3" style="background-color: #f8f9fa;">
                    <div class="d-flex flex-start w-100 justify-content-center">
                        <form action="{{ route('answer.store', $comment) }}" method="post">
                            @csrf
                            @method('post')  
                            
                            <div class="form-group mt-2">
                                <label for="komentar">Balas Pertanyaan</label>
                                <textarea
                                    name="komentar" id="editor"
                                    class="form-control @error('komentar') is-invalid @enderror"
                                    rows="5" 
                                    required>{{ old('komentar') }}</textarea>

                                <!-- error message untuk deskripsi -->
                                @error('komentar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="float-start mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                                <a href="{{ route('pertanyaan') }}" class="btn btn-outline-primary btn-sm">Kembali</a>
                            </div>
                            
                        </form>      
                </div>
            </div>
            </div>
        </div>
    </section>

    <br>
    <br>
    <br>

</div>

@endsection

@section('script')
<script>
    CKEDITOR.replace( 'editor' );
</script>
@endsection