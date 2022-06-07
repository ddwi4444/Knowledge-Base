@extends('layouts.main')

@section('container')
<br>
<br>

<!-- Halaman untuk dashboard pesan oleh mahasiswa untuk admin -->
<h3 class="animate__animated animate__fadeIn">Pertanyaan</h3>
<br>

<table class="table animate__animated animate__fadeIn">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Username</th>
      <th scope="col">Nama</th>
      <th scope="col">Pertanyaan</th>
      <th scope="col">Tanggal</th>
      <th scope="col">Status Tampil</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach($comments as $comment )
  <!-- Kondisi untuk menampilkan pesan hanya dari mahasiswa, jadi membutuhkan pesan/comment yang tidak memiliki id parent -->
  @if($comment->id_parent == NULL)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $comment->username }}</td>
      <td>{{ $comment->nama }}</td>
      <td>{{ $comment->comment }}</td>
      <td>{{ $comment->created_at->format('d, M Y'); }}</td>
      <td>
          @if($comment->status == 0)
          <!-- Button untuk menampilkan pesan -->
            <a href="{{ route('changeStatus', $comment->id) }}"
            class="btn btn-sm btn-warning shadow"><i class="bi bi-x-square"></i> Tidak Tampil</i></a>
          @else
          <!-- Button untuk tidak menam[ilkan pesan -->
            <a href="{{ route('changeStatusNonaktif', $comment->id) }}"
            class="btn btn-sm btn-primary shadow"><i class="bi bi-check-square"></i> Tampil</i></a>  
          @endif
      </td>
      <td>
        <form
          action="{{ route('comment.destroy', $comment->id) }}" method="Post">
          <!-- Button untuk masuk ke halaman detail pesan oleh mahasiswa -->
          <a href="{{ route('showComment', $comment->id) }}"
            class="btn btn-sm btn-light shadow">Detail
          </a>
          @csrf
          @method('DELETE')
          <!-- Button untuk mengahpus pesan dari mahasiswa -->
          <button type="submit" class="btn btn-sm btn-danger show_confirm" data-toggle="tooltip" title='Delete'>Hapus</button>
        </form>
      </td>
    </tr>
    @endif
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