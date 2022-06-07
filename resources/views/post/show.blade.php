@extends('layouts.main')

@section('container')
<!-- Halaman untuk menampilkan single post -->

<div class="container-xxl animate__animated animate__fadeIn">
    <br>

    <ul id="menu">
        <li><a href="{{ route('/') }}">Knowledge Base ></a></li>
        <li><a href="{{ route('unit.posts', $post->id_unit) }}">{{  $post->id_unit }} ></a></li>
        <li><a href="{{ route('show', ['id_unit'=>$post->id_unit, 'slug'=>$post->slug]) }}">{{ $post->judul_post }}</a></li>
    </ul>  

    <a href="{{ route('/') }}"><p class="text-primary fw-light" style="font-size:20px;">Knowledge Base > <a href="{{ route('unit.posts', $post->id_unit) }}"><p class="text-primary fw-light" style="font-size:20px;">{{ $post->id_unit}} > <a href="{{ route('show', ['id_unit'=>$post->id_unit, 'slug'=>$post->slug] )}}"><p class="text-primary fw-light" style="font-size:20px;">{{ $post->judul_post }}</p></a></p></a></p></a>
    

    <a href="{{ URL::previous() }}"><p class="text-primary fw-light" style="font-size:20px;">{{ $post->judul_post }}</p></a>

    
    <hr>

    <header class="w3-container w3-center w3-padding-32 text-align-center"> 
    <h1 class="text-center"><b>{{ $post->judul_post }}</b></h1>
    <p class="text-center">{{ $post->created_at->diffForHumans() }}</p>
    </header>

    <div class="text-justify mb-5">
        <p class="text-justify">{!! $post->isi_post !!}</p> 
    </div>

    <!-- Pertanyaan terkait -->
    <div class="slider">
    <h6 class="bbb_viewed_title">Pertanyaan terkait :</h6>
        <div class="slider__wrapper">
            <!-- Untuk memanggil data mengenai pertanyaan terkait -->
            @foreach($relatedPosts->slice(0, 16) as $rpost)
            <!-- Untuk memilah data agar sesuai dengan tags dan seusai dengan id unit yang sama -->
            @if($rpost->id_unit == $post->id_unit && $rpost->id != $post->id)
            <div class="slider__item">
                    <a href="{{ route('show', ['id_unit'=>$rpost->id_unit, 'slug'=>$rpost->slug] )}}">
                    <div class="card__header_post text-dark bbb_viewed_name">
                        <img class="img_post" src="{{ asset('storage/'.$rpost->image) }}" alt="card__image" class="card__image" width="600">
                    </div>
                    <p>{{ Str::limit($rpost->judul_post, 30) }}</p></a>
                    <p>{{ $rpost->created_at->diffForHumans() }}</p>
            </div>
            @endif
            @endforeach
        </div>
        <a class="slider__control slider__control_left" href="#" role="button"></a>
        <a class="slider__control slider__control_right slider__control_show" href="#" role="button"></a>
    </div>

    <!-- Comment -->
    <section style="background-color: #eee;">
        <div class="container my-5 py-5">            
            <div class="row d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8">
            <h6>Pertanyaan</h6>

            <!-- Untuk memanggil data pesan pada post ini -->
            @foreach($comments as $comment)
            <!-- Untuk menyaring psean yang sesuai dengan id post  -->
            @if($comment->id_post == $post->id && $comment->id_parent == NULL && $comment->status == 1)
                <div class="card">                
                <div class="card-body d-flex flex-fill">                    
                    <div class="d-flex flex-start align-items-center">
                        <div>
                            <h6 class="fw-bold text-primary mb-1">{{$comment->nama}}</h6>
                            <p class="text-muted small mb-0">
                            {{$comment->created_at}}
                            </p>

                            <div class="border" style="border-radius: 20px; background-color: #f2f4f5; width: fit-content; margin-bottom: 10px;">   
                                <div style="padding-left: 10px; padding-right: 10px;">
                                    <p class="mt-3">
                                        {!! $comment->comment !!}
                                    </p>
                                </div>                                     
                            </div>

                            <!-- Untuk memanggil data balasan pesan dari admin -->
                            @foreach($comments as $com)
                            <!-- Untuk menyaring balasan pesan yang sesuai dengan id parent -->
                                @if($com->id_parent == $comment->id)
                                    <div style="padding-left:3.5em; bg-dark">
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

                            <hr>
                        
                            </div>
                        </div>                    
                    </div>
                </div>                
            @endif
            @endforeach

            <!-- Form input untuk pesan mahasiswa -->
                <div class="card-footer py-3 border-0 mt-3" style="background-color: #f8f9fa;">
                    <h6>Tinggalkan Pertanyaan</h6>
                    <div class="d-flex flex-start w-100 justify-content-center">
                        <form action="{{ route('pertanyaan.store', $post) }}" method="post">
                            @csrf
                            @method('post')  

                            <div class="form-group float-start mt-2 pt-2">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" id="nama" 
                                    oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Nama wajib diisi !')"
                                    placeholder="Nama Lengkap"  value="{{ old('nama') }}" required>

                                <!-- error message untuk title -->
                                @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group float-end mt-2 pt-2 m-2">
                                <label for="email">Email Student</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    pattern=".+@students.uajy.ac.id" oninput="setCustomValidity('')"
                                    oninvalid="this.setCustomValidity('Hanya dapat menggunakan email student !')"
                                    name="email" id="email" placeholder="npm@students.uajy.ac.id" value="{{ old('email') }}" required>
                            </div>

                            <div class="form-group mt-2">
                                <label for="komentar">Pertanyaan</label>
                                <textarea
                                    name="komentar" id="editor"
                                    class="form-control @error('komentar') is-invalid @enderror w-100"
                                    rows="5"
                                    placeholder="Pertanyaan"
                                    oninput="setCustomValidity('')"
                                    oninvalid="this.setCustomValidity('Pertanyaan wajib diisi !')"
                                    required>{{ old('komentar') }}</textarea>

                                <!-- error message untuk deskripsi -->
                                @error('komentar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="float-start mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">Ajukan Pertanyaan</button>
                                <a href="{{ route('show', ['id_unit'=>$post->id_unit, 'slug'=>$post->slug]) }}" class="btn btn-outline-primary btn-sm">Batal</a>
                            </div>

                            

                        </form>                       
                    
                </div>
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