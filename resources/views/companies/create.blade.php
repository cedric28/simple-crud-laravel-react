@extends('layouts.app')

@section('content')
		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Company</span> - New Record</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
							<a href="{{ route('companies.index')}}" class="breadcrumb-item"> Companies</a>
							<a href="{{ route('companies.create')}}" class="breadcrumb-item active"> Add New Record</a>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">
			
				<div class="card">
					<div class="card-header">
						@include('partials.message')
					    @include('partials.errors')
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<div class="header-elements-inline">
									<h5 class="card-title">Company Form</h5>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<form action="{{ route('companies.store')}}" method="POST" enctype="multipart/form-data">
									@csrf
	
									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Company name:</label>
                                        <div class="col-lg-9">	
                                            <input type="text" name="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror form-control" placeholder="Company Name" >
                                        </div>
									</div>
									
									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Email:</label>
                                        <div class="col-lg-9">	
                                            <input type="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror form-control" placeholder="Email" >
                                        </div>
									</div>

									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Photo:</label>
                                        <div class="col-lg-9">	
                                            <input type="file" name="photo" class="@error('photo') is-invalid @enderror form-control" placeholder="Photo" >
                                        </div>
									</div>

									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">URL:</label>
                                        <div class="col-lg-9">	
                                            <input type="text" name="website" value="{{ old('website') }}" class="@error('website') is-invalid @enderror form-control" placeholder="URL Website" >
                                        </div>
									</div>


									<div class="text-right">
										<button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /content area -->
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
        @push('scripts')
        <!-- Javascript -->
        <!-- Vendors -->
      
        <script src="{{ asset('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>
        @endpush('scripts')
@endsection