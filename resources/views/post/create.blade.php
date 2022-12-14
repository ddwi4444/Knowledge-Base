@extends('layouts.main')

@section('container')
<!-- Halaman untuk menampilkan pembuatan post -->
<div class="container animate__animated animate__fadeIn">
        <div class="row">
            <div class="col-md-12">

                <div class="border-0 shadow rounded">
                    <div class="card-body">

                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('post')                    

                            <p><span class="text-danger">*</span> Wajib  diisi</p>
                            <div class="form-group">
                                <label for="judul_post">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul_post') is-invalid @enderror"
                                    name="judul_post" id="judul_post" value="{{ old('judul_post') }}" required>

                                <!-- error message untuk title -->
                                @error('judul_post')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <div class="image">
                                <label for="image">Thumbnail <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control  @error('thumbnail') is-invalid @enderror" name="image" id="image" accept="image/jpg, image/png, image/jpeg" required>
                                </div>

                                <!-- error message untuk thumbnail -->
                                @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-2">
                                <label for="isi_post">Isi <span class="text-danger">*</span></label>
                                <textarea
                                    name="isi_post" id="editor"
                                    class="form-control @error('isi_post') is-invalid @enderror"
                                    rows="10"
                                    required>{{ old('isi_post') }}</textarea>

                                <!-- error message untuk deskripsi -->
                                @error('isi_post')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-2">
                                <tr>
                                    <th class="tagss" scope="col"><label for="tags">Tags <span class="text-danger">*</span></label></th>
                                    <th scope="col"> 
                                        <button class="btn btn-sm" type="button" data-area="{{ $mostTags }}">
                                        {{ $mostTags }}
                                        </button>
                                    </th>
                                </tr>
                                
                                <input type="text" class="typeahead form-control @error('tags') is-invalid @enderror mt-2"
                                    name="tags" id="tags" value="{{ old('tags') }}" required>

                                <!-- error message untuk anggota -->
                                @error('tags')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            @if(auth()->user()->type == 1)    
                            <div class="form-group mt-2">
                                    <select name="id_unit" required>
                                        <option value="" disabled selected >Pilih Unit atau Fakultas <span class="text-danger">*</span></option>
                                        <option value="fti">Fakultas Teknologi Industri</option>
                                        <option value="fbe">Fakultas Ekonomi dan Bisnis</option>
                                        <option value="ft">Fakultas Teknik</option>
                                        <option value="fh">Fakultas Hukum</option>
                                        <option value="fisip">Fakultas Ilmu Sosial dan Ilmu Politik</option>
                                        <option value="ftb">Fakultas Teknobiologi</option>
                                        <option value="pp">Program Pascasarjana</option>
                                        <option value="kaa">Kantor Akademik dan Admisi</option>
                                        <option value="kkp">Kantor Kerjasama dan Promosi</option>
                                        <option value="khsp">Kantor Humas, Sekretariat, dan Protokol</option>
                                        <option value="ksi">Kantor Sistem Informasi</option>
                                        <option value="ksdm">Kantor Sumber Daya Manusia</option>
                                        <option value="kkacm">Kantor Kemahasiswaan, Alumni, dan Campus Ministry</option>
                                        <option value="kpbb">Kantor Pelatihan Bahasa dan Budaya</option>
                                        <option value="kpsp">Kantor Pengelolaan Sarana dan Prasarana</option>
                                        <option value="kk">Kantor Keuangan</option>
                                        <option value="dpm">Direktorak Penjaminan Mutu</option>
                                        <option value="lppm">Lembaga Penelitian dan Pengabdian pada Masyarakat</option>
                                        <option value="perpus">Perpustakaan</option>
                                    </select>
                            </div>                 
                            @endif  

                            <button type="submit" class="btn btn-md btn-primary mt-2">Unggah</button>
                            <a href="{{ route('posts.index') }}" class="btn btn-md btn-secondary mt-2">Batal</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<!-- CKEditor -->
<script>
    CKEDITOR.replace( 'editor' );
</script>

<!-- Autocomplete -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
 $(document).ready(function() {
    $("#tags").autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: "{{url('autocomplete')}}",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.tags;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
}); 
</script>   

<script>
const buttons = document.querySelectorAll("button");
const areaField = document.getElementById("tags");

buttons.forEach(button => {
  button.addEventListener("click", () => {
    areaField.value = button.dataset.area;
    squareField.value = button.dataset.square;
  });
});
</script>
@endsection