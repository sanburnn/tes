@extends('layouts.app')
@section('title', isset($title) ? $title : 'Tambah Sekolah - Yayasan Miftahul Huda')
@section('content')
<div class="row">
    <div class="col-md-12"> 
        <div class="card demo-icons">
            <div class="card-header">
            		<h5 class="card-title">Tambah Data Sekolah</h5>
                	<p class="card-category">daftar sekolah yang ada dibawah naungan
                  		<a href="/home">Yayasan Miftahul Huda</a>
                	</p>			    
            </div>
            <div class="card-body">
                <form class="user" method="POST" enctype="multipart/form-data" action="{{route('sekolah.store')}}">
                {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Nama Sekolah</label>
                        <input type="text" class="form-control" value="" name="nama">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Logo</label>
                        <div class="row-md-12">
                            <div class="file btn">
                            <input type="file" name="logo">
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" value="" name="alamat">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control textarea" rows="5" name="keterangan"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
                      <a href="{{route('sekolah.index')}}" class="btn btn-outline-primary">kembali</a>
                    </div>
                  </div>
                </form>
            	           
         	</div>
        </div>
    </div>
</div>

@endsection

@push('javascript')
<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endpush