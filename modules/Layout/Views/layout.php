<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title><?= $title ?></title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url()?>/vendors/admin/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url()?>/vendors/admin/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>/vendors/admin/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/vendors/admin/styles/core.css?v=1.2">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/vendors/admin/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/vendors/admin/styles/style.css?v=1.1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/src/plugins/dropzone/src/dropzone.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/vendors/admin//summernote/summernote-bs4.min.css">
	<?php /* <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/src/plugins/jquery-steps/jquery.steps.css"> */ ?>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>

  	<style>
		.active-kat{
			background-color:#11458e;
			border-radius:5px;
			color:#ffffff;
		}
		.drop-zone-custom {
            max-width: 100px;
            height: 100px;
            border: 2px dotted blue;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .preview-produk {
            object-fit: cover;
            width: 100%;
            height: 100%;
            display: none;
        }

        .form-group.required .starlabel:after {
            content:"*";
            color:red;
        }
        /* .form-group.required:not(.form-check-label)  .form-label:after {
            content:"*";
            color:red;
        } */

		.borderbottom{
			border-bottom:4px solid #000;
		}
		.blinktext{
			font-size: 25px;
			font-family: cursive;
			color: white;
			animation: blink 1s linear infinite;
  			animation-name: blinkingbadge;
		}
		@keyframes blinkingbadge{
			0%{opacity: 0;}
			50%{opacity: .5;}
			100%{opacity: 1;}
		}
		.alerts-border {
			border: 2px #ff0000 solid;
			
			animation: blink 1s linear infinite;
  			animation-name: blinking;
		}
		@keyframes blinking { 
			50% { border-color:#fff ; }  
		}
		div.stars {
			width: 270px;
			display: inline-block
		}

		input.star {
			display: none
		}

		label.star {
			float: right;
			padding: 10px;
			font-size: 36px;
			color: #4A148C;
			transition: all .2s
		}

		input.star:checked~label.star:before {
			content: '\f005';
			color: #FFC107;
			transition: all .25s
		}

		input.star-5:checked~label.star:before {
			color: #FFC107;
			text-shadow: 0 0 20px #FFF;
		}

		input.star-1:checked~label.star:before {
			color: #F62
		}

		label.star:hover {
			transform: rotate(-15deg) scale(1.3)
		}

		label.star:before {
			content: '\f006';
			font-family: FontAwesome
		}

		.stars-container {
		position: relative;
		display: inline-block;
		color: transparent;
		}

		.stars-container:before {
		position: absolute;
		top: 0;
		left: 0;
		content: '★★★★★';
		color: lightgray;
		}

		.stars-container:after {
		position: absolute;
		top: 0;
		left: 0;
		content: '★★★★★';
		color: gold;
		overflow: hidden;
		}
		.stars-0:after { width: 0%; }
		.stars-1:after { width: 20%; }
		.stars-2:after { width: 40%; }
		.stars-3:after { width: 60%; }
		.stars-4:after { width: 80%; }
		.stars-5:after { width: 100; }

    </style>
</head>
<body class=" header-dark sidebar-dark">



  <!-- HEADERTOP  -->
  <?= $this->include('Modules\Layout\Views\headertop') ?>

  <!-- RIGHTBAR  -->
  <?= $this->include('Modules\Layout\Views\rightbar') ?>

  <!-- SIDEBAR -->
  <?= $this->include('Modules\Layout\Views\sidebar') ?>

  <!-- CONTENT -->


  <?php if(session('errors')): ?>
  <script>
      $( document ).ready(function() {
          $('#<?= session('KetForm') ?>').modal({backdrop: 'static',keyboard: false,show: true});
      });
  </script>
  <?php endif; ?>
  <script>
      $( document ).ready(function() {
          $('#<?= session('KetForm') ?>').modal({backdrop: 'static',keyboard: false,show: true});
      });
  </script>
  <script>
      $( document ).ready(function() {
          $('#<?= session('KetLogo') ?>').modal({backdrop: 'static',keyboard: false,show: true});
      });
  </script>

  <?php if(session()->getFlashdata('sukses')){ ?>
    <script>
        $(document).ready(function(){
            $('.alert-status').text('Success!');
            $('.alert-pesan').text("<?= session()->getFlashdata('sukses') ?>");
            $(".alert-color-success").fadeTo(2000, 500).slideUp(500, function() {
              $(".alert-color-success").slideUp(500);
            });
        });
    </script>
  <?php }elseif(session()->getFlashdata('warning')){ ?>
    <script>
        $(document).ready(function(){
            $('.alert-status').text('Warning!');
            $('.alert-pesan').text("<?= session()->getFlashdata('warning') ?>");
            $(".alert-color-warning").fadeTo(2000, 500).slideUp(500, function() {
              $(".alert-color-warning").slideUp(500);
            });
        });
    </script>
  <?php }elseif(session()->getFlashdata('gagal')){ ?>
    <script>
        $(document).ready(function(){
            $('.alert-status').text('Gagal!');
            $('.alert-pesan').text("<?= session()->getFlashdata('gagal') ?>");
            $(".alert-color-gagal").fadeTo(2000, 500).slideUp(500, function() {
              $(".alert-color-gagal").slideUp(500);
            });
        });
    </script>
  <?php } ?>
  <?= $this->renderSection('content') ?>

	<!-- js -->
	<script src="<?php echo base_url()?>/vendors/admin/scripts/core.js"></script>
	<script src="<?php echo base_url()?>/vendors/admin/scripts/script.min.js"></script>
	<script src="<?php echo base_url()?>/vendors/admin/scripts/process.js"></script>
	<script src="<?php echo base_url()?>/vendors/admin/scripts/layout-settings.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/dropzone/src/dropzone.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<script src="<?php echo base_url()?>/vendors/admin/scripts/dashboard.js"></script>
    <script src="<?php echo base_url()?>/vendors/admin/summernote/summernote-bs4.js"></script>
	<!-- fancybox Popup Js -->
	<script src="<?php echo base_url()?>/src/plugins/fancybox/dist/jquery.fancybox.js"></script>
	<!-- buttons for Export datatable -->
    <script src="<?php echo base_url()?>/assets/setting.js?v=0.2"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/buttons.print.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/buttons.html5.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/pdfmake.min.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/datatables/js/vfs_fonts.js"></script>
	<script src="<?php echo base_url()?>/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="<?php echo base_url()?>/vendors/admin/scripts/advanced-components.js"></script>
	<?php /* <script src="<?php echo base_url()?>/src/plugins/jquery-steps/jquery.steps.js"></script>
	<script src="<?php echo base_url()?>/vendors/admin/scripts/steps-setting.js"></script> */ ?>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

  <script type="text/javascript">
      $(document).ready(function() {
		// console.clear();


        $('.table-dataku').DataTable({
        		scrollCollapse: true,
        		autoWidth: false,
        		responsive: true,
        		columnDefs: [{
        			targets: "datatable-nosort",
        			orderable: false,
        		}],
        		"lengthMenu": [[100, 150, 200, -1], [100, 150, 200, "All"]],
        		"language": {
        			"info": "_START_-_END_ of _TOTAL_ entries",
        			searchPlaceholder: "Search",
        			paginate: {
        				next: '<i class="ion-chevron-right"></i>',
        				previous: '<i class="ion-chevron-left"></i>'
        			}
        		},
        });
        $('.table-dataall').DataTable({
        		scrollCollapse: true,
        		autoWidth: false,
        		responsive: true,
        		columnDefs: [{
        			targets: "datatable-nosort",
        			orderable: false,
        		}],
        		"lengthMenu": [[-1], ["All"]],
        		"language": {
        			"info": "_START_-_END_ of _TOTAL_ entries",
        			searchPlaceholder: "Search",
        			paginate: {
        				next: '<i class="ion-chevron-right"></i>',
        				previous: '<i class="ion-chevron-left"></i>'
        			}
        		},
        });
        $('.table-dataku2').DataTable({
        		scrollCollapse: true,
        		autoWidth: false,
        		responsive: true,
        		columnDefs: [{
        			targets: "datatable-nosort",
        			orderable: false,
        		}],
        		"lengthMenu": [[100, 125, 150, -1], [100, 125, 150, "All"]],
        		"language": {
        			"info": "_START_-_END_ of _TOTAL_ entries",
        			searchPlaceholder: "Search",
        			paginate: {
        				next: '<i class="ion-chevron-right"></i>',
        				previous: '<i class="ion-chevron-left"></i>'
        			}
        		},
        });


      });

  </script>
	<script>	
	function previewImages() {

  		var $preview = $('#previewimg').empty();		
		if (this.files) $.each(this.files, readAndPreview);

		function readAndPreview(i, file) {
			
			if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
				
			return alert(file.name +" is not an image");

			} // else...
			if (document.getElementById('imgsekarang'))
			document.getElementById("imgsekarang").style.display = "none";

			var reader = new FileReader();

			$(reader).on("load", function() {
			$preview.append($("<img/>", {src:this.result, height:200}));
			});

			reader.readAsDataURL(file);
			
		}

	}
	document.querySelector('#file-input-img').addEventListener("change", previewImages);
	</script>
	<script>	
	function previewImages() {

  		var $preview = $('#previewimg2').empty();		
		if (this.files) $.each(this.files, readAndPreview);

		function readAndPreview(i, file) {
			
			if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
				
			return alert(file.name +" is not an image");

			} // else...
			if (document.getElementById('imgsekarang2'))
			document.getElementById("imgsekarang2").style.display = "none";
			
			var reader = new FileReader();

			$(reader).on("load", function() {
			$preview.append($("<img/>", {src:this.result, height:200}));
			});

			reader.readAsDataURL(file);
			
		}

	}
	document.querySelector('#file-input-img2').addEventListener("change", previewImages);
	</script>
</body>
</html>
