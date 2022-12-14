@extends('layouts.main')

@section('container')
<br>
<br>

<!-- Halaman untuk dashboard pesan oleh mahasiswa untuk admin -->
<h3 class="animate__animated animate__fadeIn">Pertanyaan</h3>
<br>

<table class="table__show animate__animated animate__fadeIn" style="text-align: center;">
  <thead>
    <tr>
      <th style="background: #38b6ff" scope="col">Nomor</th>
      <th style="background: #38b6ff" scope="col">Nama</th>
      <th style="background: #38b6ff" scope="col">Pertanyaan</th>
      <th style="background: #38b6ff" scope="col">Tanggal</th>
      <th style="background: #38b6ff" scope="col">Status Tampil</th>
      <th style="background: #38b6ff" scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach($comments as $comment )
  <!-- Kondisi untuk menampilkan pesan hanya dari mahasiswa, jadi membutuhkan pesan/comment yang tidak memiliki id parent -->
  @if($comment->id_parent == NULL)
    <tr>
      <td data-label="Nomor">{{ $loop->iteration }}</td>
      <td data-label="Nama">{{ $comment->nama }}</td>
      <td data-label="Pertanyaan" class="col-sm-3">{{ $comment->comment }}</td>
      <td data-label="Tanggal">{{ $comment->created_at }}</td>
      <td data-label="Status Tampil">
          @if($comment->status == 0)
          <!-- Tanda pertanyaan masi baru -->
            <p class="text-info">Pesan Baru</p>            
          @elseif($comment->status == 2)
          <!-- Button untuk menampilkan pesan -->
            <a href="{{ route('changeStatus', $comment->id) }}"
              class="btn btn-sm btn-warning shadow"><i class="bi bi-x-square"></i> Tidak Tampil</i></a>
          @else
          <!-- Button untuk tidak menampilkan pesan -->
            <a href="{{ route('changeStatusNonaktif', $comment->id) }}"
            class="btn btn-sm btn-primary shadow"><i class="bi bi-check-square"></i> Tampil</i></a>  
          @endif
      </td>
      <td data-label="Actions">
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