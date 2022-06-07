@extends('layouts.main')

@section('container')
<br>
<br>
<!-- Merupakan halaman dashboard admin -->
<h3 class="animate__animated animate__fadeIn">My Post</h3>
<br>

<!-- Button untuk menambah post oleh admin -->
<div class="col-md-2 animate__animated animate__fadeIn">
  <p><a class="btn text-capitalize" href="{{ route('posts.create') }}">Tambah Post </a></p>
</div>

<!-- Input untuk mencari post oleh admin -->
<form action="/dashboard/cari" method="GET" class="input-group rounded mt-4 w-25 animate__animated animate__fadeIn">
		<input type="text" class="form-control rounded" name="cari" placeholder="Cari.." value="{{ old('cari') }}">
		<span class="input-group-text border-0" id="search-addon">
      <i class="bi bi-search"></i>
    </span>
</form>

<!-- Table untuk menampilkan daftar post yang telah dibuat oleh admin -->
<table class="table animate__animated animate__fadeIn container">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Judul</th>
      <th scope="col">Tanggal</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <!-- Perulangan Post -->
  @foreach($posts as $post)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td class="col-sm-5">{{ $post->judul_post }}</td>
      <td>{{ $post->created_at }}</td>
      <td>
              <form
                action="{{ route('posts.destroy', $post->id) }}" method="POST">
                <!-- Button untuk melihat detail post -->
                <a href="{{ route('show', ['id_unit'=>$post->id_unit, 'slug'=>$post->slug]) }}"
                  class="btn btn-sm btn-light shadow">Detail</a>
                  <!-- Button untuk edit post -->
                <a href="{{ route('posts.edit', $post->id) }}"
                    class="btn btn-sm btn-info shadow">Edit</a>
                @csrf
                @method('DELETE')
                <!-- Button untuk menghapus post -->
                <button type="submit" class="btn btn-sm btn-danger shadow show_confirm" data-toggle="tooltip" title='Delete'>Delete</button>
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

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<!-- Warning untuk menyetujui pesan dihapus atau tidak -->
<script type="text/javascript">
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Apakah anda yakin ingin menghapus postingan ini?`,
              text: "Jika anda setuju, maka postingan ini akan dihapus permanent",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
</script>
@endsection