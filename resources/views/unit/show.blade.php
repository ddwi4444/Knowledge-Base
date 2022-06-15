@extends('layouts.main')

@section('jumbotron')
<!-- Halaman untuk menampilkan daftar post berdasarkan unit tertentu berdasarkan id -->
    <div class="bg-video animate__animated animate__bounceInDown">
        <video playsinline autoplay muted loop poster="cake.jpg">
            <source src="/img/bg_videoblue.mp4" type="video/webm">
            Your browser does not support the video tag.
        </video>
        </div>

        <div class="justify-content-center animate__animated animate__bounceInDown">
            <div class="justify-content-center">
            <br>
            <br>
            <form action="{{ route('unit.search', $user->id_unit) }}" method="GET" class="mt-5 w-100 d-flex justify-content-center">                  
                <div class="input-group rounded justify-content-center">
                    <div class="form-outline w-50" style="margin-right: 5px;">
                    <input id="search-focus" type="search" id="form1" name="search" class="form-control w-100" />
                    <label class="form-label" value="{{ old('search') }}" for="form1">Search</label>
                    </div>
                    <button class="bg-transparent">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
                <p class="mt-3 d-flex justify-content-center">Apa yang dapat kami bantu?</p>       
        </div>
    </div>

@section('container')    
    <div class="container" style="margin-bottom: 50px;">
        <div class="row justify-content-center ms-1">
            <!-- Memanggil data post -->
            @foreach($posts as $post)
            <!-- Menyaring untuk menampilkan post berdasarkan id yang sama dengan parameter id unitnya -->
            @if($post->id_unit == $user->id_unit)
            <div class="col-md-3">
                <div data-aos="fade-up" class="card_unit mt-5">
                    <a class="text-dark text-underline-hover" href="{{ route('show', ['id_unit'=>$post->id_unit, 'slug'=>$post->slug] )}}">
                        <img class="img_unit" src="{{ asset('storage/'.$post->image) }}" alt=" ">
                        <div class="card_text d-flex justify-content-center">
                            <p>{{ ($post->judul_post) }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">{{ $post->created_at->format('d, M Y'); }}</li>
                        </ul>
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
@endsection

