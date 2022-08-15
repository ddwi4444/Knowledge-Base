@extends('layouts.main')

@section('container')
<!-- Halaman untuk menampilkan pembuatan post -->
<div class="container mt-4 animate__animated animate__fadeIn">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="">
                    <br>
                        <!-- form baru -->
                        <form method="POST" action="{{ route('storeUser') }}">
                            @method('post')
                            @csrf

                            <p><span class="text-danger">*</span> Wajib  diisi</p>

                            <!-- Input untuk password sekarang -->
                            <div class="form-group row">
                                <label for="nama_unit" class="col-md-4 col-form-label text-md-right">Nama Unit atau Fakultas <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                <input type="text" class="form-control @error('nama_unit') is-invalid @enderror"
                                    name="nama_unit" id="nama_unit" value="{{ old('nama_unit') }}" required>

                                <!-- error message untuk title -->
                                @error('nama_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                <input type="username" class="form-control @error('username') is-invalid @enderror"
                                    pattern=".+@uajy.ac.id" oninput="setCustomValidity('')"
                                    oninvalid="this.setCustomValidity('Username yang anda masukkan tidak sesuai !')"
                                    placeholder="name@uajy.ac.id"
                                    name="username" id="username" value="{{ old('username') }}" required>

                                    @error('username')
                                        <div class="text-danger mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @error('password')
                                        <div class="text-danger mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="id_unit" class="col-md-4 col-form-label text-md-right">Pilih Parent Unit atau Fakultas <span class="text-danger">*</label>

                                <div class="col-md-6">
                                    <select name="id_unit" required>
                                        <option value="" disabled selected >Pilih Parent Unit atau Fakultas <span class="text-danger">*</option>
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
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-md btn-primary mt-2">Unggah</button>
                                <a href="{{ route('dashboard/admin') }}" class="btn btn-md btn-secondary mt-2">Batal</a>
                                </div>
                            </div>
                        </form>
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

@endsection