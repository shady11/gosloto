<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			@yield('title')
		</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Montserrat:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->

        <!--begin::Base Styles -->  

        <!--begin::Page Vendors -->
		<link href="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors -->

		<link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/demo/demo11/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->

		<!--begin::Custom Styles -->
		<link href="/assets/admin/css/style.css" rel="stylesheet" type="text/css" />
		<!--end::Custom Styles -->

		<link rel="shortcut icon" href="/assets/demo/demo11/media/img/logo/favicon.ico" />

	</head>
	<!-- end::Head -->

    <!-- end::Body -->
	<body  class="m-content--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside--offcanvas-default"  >

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			@include('admin.partials.header')
			<!-- END: Header -->

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

				<!-- BEGIN: Left Aside -->
				@include('admin.partials.leftAside')
				<!-- END: Left Aside -->

				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					@yield('content')
				</div>
			</div>
			<!-- end:: Body -->

			<!-- begin::Footer -->
			@include('admin.partials.footer')
			<!-- end::Footer -->

		</div>
		<!-- end:: Page -->

	    <!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- end::Scroll Top -->

    	<!--begin::Base Scripts -->
		<script src="{{asset('/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('/assets/demo/demo11/base/scripts.bundle.js')}}" type="text/javascript"></script>
		<!--end::Base Scripts -->

		<script>
			$.ajaxSetup({
		        headers: {'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')}
		    });
		</script>

		@yield('footer')
	</body>
	<!-- end::Body -->
</html>