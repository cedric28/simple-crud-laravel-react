@extends('layouts.app')

@section('content')
		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Products</span></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
							<a href="" class="breadcrumb-item"> Employees</a>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">
				<!-- Search field -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h6 class="card-title">Employees</h6>
						
					</div>

					<div class="card-body">
						@include('partials.errors') 
						<ul class="nav nav-tabs">
							<li class="nav-item"><a href="#storehub-products" class="nav-link active" data-toggle="tab">Active Employees</a></li>
							{{-- <li class="nav-item"><a href="#inactive-products" class="nav-link" data-toggle="tab">Inactive Products</a></li> --}}
						</ul>

						<div class="tab-content">
							<div class="tab-pane fade show active" id="storehub-products">
								<div class="card">
									<div class="card-header bg-transparent header-elements-inline">
                                        <div style="width: 100%">
                                            <a type="button" href="{{ route('employees.create')}}" class="btn btn-outline-success btn-sm float-left"><i class="icon-add mr-2"></i> Add Employee</a>
											{{-- <a href="" class="btn btn-light btn-sm float-right"><i class="icon-printer mr-2"></i> Print</a> --}}
										</div>
									</div>
									<div class="card-body">
										<div class="text-center mb-3 py-2">
											<div id="employee"></div>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="inactive-products">
								<div class="card">
									<div class="card-header bg-transparent header-elements-inline">
                                        <div style="width: 100%">
											<a href="" class="btn btn-light btn-sm float-right"><i class="icon-printer mr-2"></i> Print</a>
										</div>
									</div>
									<div class="card-body">
										<div class="text-center mb-3 py-2">
											<div id="inactive-product"></div>
										</div>
									</div>
								</div>
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
        <!-- Vendors -->
	
			<script src="{{ asset('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
			<script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
			<script src="{{ asset('vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
			<script src="{{ asset('vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>
        @endpush('scripts')
@endsection