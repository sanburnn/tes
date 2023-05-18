@extends('layouts.app')
@section('title', isset($title) ? $title : 'Jabatan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
	<div class="row">
		<div class="col-md-12">
			<div class="card demo-icons">
				<div class="card-header">
					<div class="row">
						<div class="col">
							<h5 class="card-title">Data Jabatan</h5>
						</div>
						<div class="col text-right">
							<a href="{{ route('jabatan.create') }}" class="btn btn-outline-warning"><i class="fa fa-plus"></i> Tambah</a>
						</div>
					</div>
					<p class="card-category">Daftar jabatan yang ada di setiap sekolah dibawah naungan
						<a href="/home">Yayasan Miftahul Huda</a>
					</p>			    
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<th style="width: 10%">No</th>
								<th style="width: 20%">Jabatan</th>
								<th style="width: 20%">Aksi</th>
							</thead>
							<tbody>
								@foreach($jabatan as $value)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $value->nama ?? '-' }}</td>
										<td class="d-flex" style="gap: .5rem;">
											<a href="{{ route('jabatan.show', $value->id) }}" class="btn btn-outline-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
											<a href="{{ route('jabatan.edit', $value->id) }}" class="btn btn-outline-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>         
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
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
    var table = $(document).ready(function() {
        $('#dataTable').dataTable();
    });
</script>
@endpush