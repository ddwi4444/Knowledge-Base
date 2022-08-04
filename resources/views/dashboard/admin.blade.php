@extends('layouts.main')

@section('container')
<!-- Merupakan halaman dashboard admin -->
<h3 class="animate__animated animate__fadeIn mt-5">Daftar User</h3>

<!-- Input untuk mencari post oleh admin -->
<form action="{{ route('unit.search.admin') }}" method="GET" class="search input-group rounded mt-4 animate__animated animate__fadeIn">
		<input type="text" class="form-control rounded" name="cari" placeholder="Cari.." value="{{ old('cari') }}">
		<span class="input-group-text border-0" id="search-addon">
      <i class="bi bi-search"></i>
    </span>
</form>

<!-- Table untuk menampilkan daftar post yang telah dibuat oleh admin -->
<table class="table__show animate__animated animate__fadeIn container responsive" style="text-align: center;">
  <thead>
    <tr>
      <th style="background: #38b6ff" scope="col">Nomor</th>
      <th style="background: #38b6ff" scope="col">ID Unit</th>
      <th style="background: #38b6ff" scope="col">Nama Unit</th>
      <th style="background: #38b6ff" scope="col">Username</th>
      <th style="background: #38b6ff" scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <!-- Perulangan Post -->
  @foreach($users as $user)
    <tr>
      <td data-label="Nomor">{{ $loop->iteration }}</td>
      <td data-label="ID Unit">{{ $user->id_unit }}</td>
      <td data-label="Nama Unit">{{ $user->nama_unit }}</td>
      <td data-label="Username">{{ $user->username }}</td>
      <td data-label="Actions">
              <form>           
              @if($user->status == 0)
              <!-- Button untuk menampilkan pesan -->
                <a href="{{ route('changeStatusUserNonaktif', $user->id) }}"
                  class="btn btn-sm btn-warning shadow"><i class="bi bi-x-square"></i> Nonaktifkan</i></a>
              @else
              <!-- Button untuk tidak menampilkan pesan -->
                <a href="{{ route('changeStatusUserAktif', $user->id) }}"
                class="btn btn-sm btn-primary shadow"><i class="bi bi-check-square"></i> Aktif</i></a>  
              @endif
                <a href="{{ route('password/admin.edit', $user->id) }}"
                    class="btn btn-sm btn-info shadow">Edit Password</a>
                @csrf
            </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<br>
<br>
<br>
@endsection