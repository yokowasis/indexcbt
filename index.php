<?php include (__DIR__ . "/data.php") ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google" content="notranslate">
    
    <title><?php echo $namasekolah ?> CBT TEST 2019</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css?bv=10.6.6" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">

    <script data-cfasync="false" src="js/jquery.min.js"></script>
	<script data-cfasync="false" src='js/bootstrap.min.js'></script>
	    		
	<link rel='dns-prefetch' href='//s.w.org' />
    
	<script type="text/javascript">
		$(document).ready(function () {
			$('.summary-log .content').html('<a href="#bimasoft.web.id" title="//bimasoft.web.id/">Aplikasi Simulasi Mandiri</a> :<strong> #10.6.6</strong><br>')
		});
	</script>

  </head>
  <body>
	<div id="ajax">
	    <img src='//login.tryoutdisdiksulsel.id/wp-content/themes/unbk/images/ajax-loader.gif' />
	    <p>Mengirim Data ke Server</p>
	</div>
	<div id='header'>
		<div class='container-fluid'>
			<div class='row'>	
				<div class='col-md-12'>
				<div id='logo'>
	<div id="logo-container">
		<img src='img/logo.png' />
	</div>
			<div id="text-container">
			<h1><?php echo $namasekolah ?></h1>
			<h3>CBT Application</h3>
		</div>
	</div>					<div id='welcome'>
						<div id='avatar'>
							<img src='//login.tryoutdisdiksulsel.id/wp-content/themes/unbk/images/avatar.png' />
						</div>
						<div id='selamat'>
							<div id="timenow" style="display: none;"></div>
							<div id="continue" style="display: none;"></div>
							<div id="waktutelat" style="display: none;"></div>
							<p>Selamat Datang</p>
							<p><b id='nama_siswa2'></b></p>
							<input type="hidden" id="localstorage">
							<p>(<b id='userid'></b>)</p>
													</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='container'>
		<div class='row'>
			<div style='height:30px;'></div>
		</div>
	</div>	

	<div id='notif'>
		<div class='container'>
			<div class='row'>
				<div class='col-md-12' id="box_keterangan">
					<div style="color:#000"></div>
				</div>
			</div>
		</div>
	</div>
	<div class='container'>
		<div class='row'>
			<div style='height:74px;'></div>
		</div>
		<div class='row'>
			<div class='col-md-12'>
				<div id='loginbox'>
					<div id='logintitle'>
						<p>User Login</p>
					</div>
					<div id='loginbody'>
						<div style='height :43px'></div>
						<form method='GET' id="form_login_cloud" action="//gcloud.cbt.my.id/">
							<input type="hidden" name="namalengkap" value="-">
							<input type="hidden" name="sekolah" value="<?php echo $namasekolah ?>">
							<input type="hidden" name="logo" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/img/logo.png"; ?>">
							<input type="hidden" name="backend" value="<?php echo $backendurl ?>">
							<input type="hidden" name="kumpulurl" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>/nilai.php">
							<input type="hidden" name="frontend" value="<?php echo $frontend ?>">
							<input type="hidden" name="loginurl" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
							<table>
							  <tr>
								<td>User name</td>
								<td><span class="glyphicon glyphicon-user" aria-hidden="true"></span><input type='text' name='userid' id='username' /></td>
								<td></td>
							  </tr>
							  <tr>
								<td>Password</td>
								<td><span class="glyphicon glyphicon-lock" aria-hidden="true"></span><input type='password' name='password' id='password' /></td>
								<td><span class="glyphicon glyphicon-eye-open showPassword" aria-hidden="true" id="eye"></span></td>
							  </tr>
							  <tr
							  							  >
								<td>Kode Ujian</td>
								<td>
									<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span><select name="kodemapel" id="mapel">

									</select>
								</td>
								<td></td>
							  </tr>
							  <tr>
								<td></td>
								<td></td>
								<td></td>
							  </tr>
							  <tr>
								<td></td>
								<td>
									<button type="button" id="submitlogincloud" class="btn btn-success">LOGIN</button>
									
								</td>
								<td></td>
							  </tr>
							</table>
						</form>
					</div>
					<div id='loginfooter'>
					</div>
				</div>
			</div>
		</div>
	</div>
		<div class='row margin0'>
				<div style='height:64px;'></div>
		</div>
   
   <!-- Modal -->
   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="myModalLabel">Pendaftaran Peserta Test</h4>
         </div>
         <div class="modal-body">
           <form id="daftar_baru">
             <div class="form-group">
               <label for="inp_nama">Nama Lengkap</label>
               <input type="text" class="form-control" id="inp_nama" placeholder="Nama Lengkap">
             </div>
             <div class="form-group">
               <label for="inp_username">Username</label>
               <input type="text" class="form-control" id="inp_username" placeholder="Username">
             </div>
             <div class="form-group">
               <label for="inp_password">Password</label>
               <input type="password" class="form-control" id="inp_password" placeholder="Password">
             </div>
           </form>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close">Close</button>
           <button type="button" id="tombol_daftar" class="btn btn-primary">Simpan</button>
         </div>
       </div>
     </div>
   </div>

   	<script>
		   jQuery(document).ready(function ($) {
			   $('#submitlogincloud').click(function(){
					username = encodeURI($('#username').val());
					password = encodeURI($('#password').val());
					mapel  = $('#mapel').val();
					if (!mapel) {
						$('#box_keterangan div').html("Silakan Pilih Mapel Terlebih Dahulu");
					} else
					{

						$.ajax({
							url: '<?php echo $backendurl ?>login/'+mapel+'/'+username+'/' + password,
						}).done(function(e) {
							if (e.values.length>0) {
								$("[id=username]").val(e.values[0].username);
								$("[name=namalengkap]").val(e.values[0].nama);
								$('#form_login_cloud').submit();
							} else {
								$('#box_keterangan div').html("Username / Password Tidak Ditemukan atau Sesi Belum Masuk");
							}
							console.log("success");
						}).fail(function(e) {
							$('#box_keterangan div').html("Jaringan Error");
						}).always(function(e) {
						});
					}
			   })			   
		   });
	</script>

	<script>
		jQuery(document).ready(function ($) {
			$.get('<?php echo $backendurl ?>mapels', { }, function (data, textStatus, xhr) {
				var s = "";
				data.values.forEach( function(element) {
					s += "<option value='"+element.kode+"'>"+element.kode+"</option>";
				});
				$('#mapel').html(s);
			});

			$('#eye').hover(function () {
				$('#password').prop('type', 'text');
			}, function () {
				$('#password').prop('type', 'password');
			})
		});
	</script>

<input type="hidden" id="mapel" value="">
<input type="hidden" id="kodetest" value="">

<div class="container">
	<div class="row">
		<div style="height:50px;"></div>
	</div>
</div>

<div class="summary-log">
    <div class="content">
            </div>    
</div>
<footer>
        <p>© Copyright 2019, <?php echo $namasekolah ?></a></p>
</footer>

    <div id="blocker"></div>
	
  </body>

</html>
