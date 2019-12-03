<?php session_start() ?>
<?php require_once (dirname(__FILE__).'/../bimadb.php'); ?>
<?php header("content-type: application/x-javascript");  ?>

<?php if (false) : ?>
<script>
<?php endif; ?>

(function($){


	//jQuery('#summary-button').click();
 
    WordToWordpress();

    <?php

    $mapel = $_GET['mapel'];
    $siswa = $_GET['siswa'];
    $mapel = str_ireplace('%20', ' ', $mapel);

    ?>

	//repopulate answer from database

	<?php


        $sql = "SELECT `id` FROM `hasil` WHERE `test` = '$mapel' AND `userid` = '".strtoupper($siswa)."'";
        $result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
		    // output data of each row
		    $row = $result->fetch_assoc();
		    $hasilid = $row['id'];
		} else {
		    //echo "0 results";
		}

		if (isset($hasilid)) {
			//Pilihan Ganda

			$sql = "SELECT * FROM `jawabanpg` WHERE `siswa` = '$hasilid' ORDER BY `no`; ";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
		    		$ans = $row['opsi'];
		    		if ($ans!='') {
		    			?>
			    			jQuery('.option[data-nomor-asli=<?php echo $row['no'] ?>]').removeClass('checked');

		    				jQuery('.option[data-nomor-asli=<?php echo $row['no'] ?>][data-option-asli="<?php echo $ans ?>"]').addClass('checked');

		    				jQuery('#summary .nomor-asli-<?php echo $row['no'] ?>').removeClass('not-done');
		    				jQuery('#summary .nomor-asli-<?php echo $row['no'] ?>').addClass('done');
		    				jQuery('#summary .nomor-asli-<?php echo $row['no'] ?> span').text(jQuery('.option[data-nomor-asli=<?php echo $row['no'] ?>].checked').text());
		    			<?php
		    		}
			    	
			    }
			} else {
			    //echo "0 results";
			}

			$sql = "SELECT * FROM `jawabanessay` WHERE `siswa` = '$hasilid' ORDER BY `no`; ";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
		    		$ans = $row['opsi'];
		    		if ($ans!='') {
		    			?>
		    				<?php 
		    					//Essay
								$ans = preg_replace("/\r\n|\r|\n/",'\r\n',$ans);
								$ans = str_ireplace("'", "\\'", $ans);
								?>
		    				jQuery('textarea[data-nomor-asli=<?php echo $row['no'] ?>]').val('<?php echo $ans ?>');
		    				jQuery('#summary .nomor-asli-<?php echo $row['no'] ?>').removeClass('not-done');
		    				jQuery('#summary .nomor-asli-<?php echo $row['no'] ?>').addClass('done');
		    				jQuery('#summary .nomor-asli-<?php echo $row['no'] ?> span').text(jQuery('.option[data-nomor-asli=<?php echo $row['no'] ?>].checked').text());
		    			<?php
		    		}
			    	
			    }
			} else {
			    //echo "0 results";
			}
		}


	?>

	//PERFORMANCE

	console.log ('READY');


	jQuery(document).ready(function($) {

		$('#ajax').show();


		if (typeof(Storage) !== "undefined") {

			$('.soal').each(function(index, el) {

				var mapel = $('#mapel').val();
				var user = $('#userid').text();

				var nomor_asli = $(this).attr('data-nomor-asli');

				if ( localStorage.getItem("ls[" + mapel + "," + user + "," + nomor_asli + "]") === null ) {

					//Jawaban tidak ada, abaikan

				} else {
					//Jawaban ada, input jawaban

					var jawabanini = localStorage.getItem("ls[" + mapel + "," + user + "," + nomor_asli + "]");
					var jawabancheck;

					jawabanini = jawabanini.replace(/['"]+/g, '');
					jawabancheck = jawabanini.replace(/\s/g,"");

					console.log (jawabancheck);
					if (jawabancheck) {
						jQuery('.option[data-nomor-asli='+nomor_asli+']').removeClass('checked');


						jQuery('.option[data-nomor-asli='+nomor_asli+'][data-option-asli="'+jawabanini+'"]').addClass('checked');

						jQuery ('textarea[data-nomor-asli='+nomor_asli+']').val(jawabanini);


						jQuery('#summary .nomor-asli-'+nomor_asli+'').removeClass('not-done');
						jQuery('#summary .nomor-asli-'+nomor_asli+'').addClass('done');

						jQuery('#summary .nomor-asli-'+nomor_asli+' span').text(jQuery('.option[data-nomor-asli='+nomor_asli+'].checked').text());
					}
				}

				//console.log (nomor_asli);

			});
		    
		} else {
			alert ('Maaf... Browser anda tidak didukung oleh aplikasi dengan metode penyimpanan Performance');
		}
		$('#ajax').hide();
		console.log ("Selesai Mengambil Jawaban");

	});

	jQuery(document).ready(function($) {
		jQuery('.essay').prev().remove();
	});


})(jQuery);

//CountDown
<?php

	$kodemapel = $mapel;

	$sql = "SELECT alokasi FROM options WHERE `kode`='$kodemapel'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        $seconds  = $alokasi = $row['alokasi']  * 60;
	    }
	} else {
	    //echo "0 results";
	}



	$sql = "SELECT `stamp` FROM hasil WHERE `test`='$kodemapel' AND `userid`='".strtoupper($siswa)."'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        $time = $row['stamp'];
	        if ($time == '') {
	        } else {

	        	if ($time == 'NaN:NaN:NaN') {
	        		$time = "00:00:00";
	        	}

	        	if ($time == 'Completed') {
	        		$time = "00:00:00";
	        	}

		        $time = explode(":", $time);
		        $seconds = $time[0]*3600 + $time[1]*60 + $time[2];
	        }
	    }
	} else {
	}
?>
<?php if ($seconds <= 0) : ?>
	//window.location = "./?logout=1";
<?php endif; ?>
if (localStorage.getItem('ls[<?php echo "$kodemapel" ?>,<?php echo "$siswa" ?>,sisawaktu]')) {

	var hms = localStorage.getItem('ls[<?php echo "$kodemapel" ?>,<?php echo "$siswa" ?>,sisawaktu]');
	var a = hms.split(':');
	var upgradeTime = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 

} else {
	var upgradeTime = <?php echo $seconds ?>;
}
var seconds = upgradeTime;
var countdownTimer = setInterval('timer()', 1000);



function WordToWordpress(){
	tabletodiv(jQuery('#soal-body>div>table'));
	removeOuterTag(jQuery('#soal-body>div'));
	for (i=1;i<=2;i++){
		removeOuterTag(jQuery('#soal-body>div'));
	}

	//Convert Html ke Class Object
	jumlahsoal = jQuery('div.ex-tr').length / 6;
	console.log(jumlahsoal);
	jQuery('#jumlah_soal').text(jumlahsoal);
	var soal = [];
	for (i=1;i<=jumlahsoal;i++) {
		console.log(i);
		soal[i] = {};
		soal[i].n = i;
		soal[i].q = jQuery('div.ex-tr').eq((i-1)*6+0).children('.ex-td').eq(1).html();
		
		if (jQuery('div.ex-tr').eq((i-1)*6+1).children('.ex-td').eq(2).html().indexOf('__')>=0) {
			soal[i].a = '<textarea maxlength="5100" data-nomor-asli='+i+' class="essay" style="width:100%;background:#fff" rows=5></textarea>';
		} else {
			soal[i].a = jQuery('div.ex-tr').eq((i-1)*6+1).children('.ex-td').eq(2).html();
		}

		if (jQuery('div.ex-tr').eq((i-1)*6+2).children('.ex-td').eq(2).html()=='&nbsp;') {
			soal[i].b = '<p class="to-be-removed">@</p>';
		} else {
			soal[i].b = jQuery('div.ex-tr').eq((i-1)*6+2).children('.ex-td').eq(2).html();
		}

		if (jQuery('div.ex-tr').eq((i-1)*6+3).children('.ex-td').eq(2).html()=='&nbsp;') {
			soal[i].c = '<p class="to-be-removed">@</p>';
		} else {
			soal[i].c = jQuery('div.ex-tr').eq((i-1)*6+3).children('.ex-td').eq(2).html();	
		}
		
		if (jQuery('div.ex-tr').eq((i-1)*6+4).children('.ex-td').eq(2).html()=='&nbsp;') {
			soal[i].d = '<p class="to-be-removed">@</p>';
		} else {
			soal[i].d = jQuery('div.ex-tr').eq((i-1)*6+4).children('.ex-td').eq(2).html();	
		}

		if (jQuery('div.ex-tr').eq((i-1)*6+5).children('.ex-td').eq(2).html()=='&nbsp;') {
			soal[i].e = '<p class="to-be-removed">@</p>';
		} else {
			soal[i].e = jQuery('div.ex-tr').eq((i-1)*6+5).children('.ex-td').eq(2).html();	
		}
		
	}

	//Clear HTML
	var body = jQuery('#soal-body');
	body.html('');

	//Masukkan Soal ke HTML
	html = '';
	for (i=1;i<=jumlahsoal;i++) {
		no = soal[i].n;
		html += '<div data-nomor-asli="'+no+'" id="nomor-asli-'+no+'" class="soal nomor-asli-'+no+'">';
		html += '<div class="nomor">'+no+'</div>';
		html += soal[i].q;
		html += '<div class="options-group">';

		for (j=1;j<=5;j++){
			html += '<div class="options">';
			html += '<span data-nomor-asli="'+no+'" data-option-asli="'+String.fromCharCode(64+j)+'" class="option">X</span>';
			html += soal[i][String.fromCharCode(96+j)];
			html += '</div>';
		}


		html += '</div>';
		html += '</div>';

	}
	body.html(html);

	//Jumlahsoal dan Yang harus Dikerjakan
	<?php 
		$sql = "SELECT shuffle2,shuffle,jumlahsoal, dikerjakan FROM `options` WHERE `kode`='".$mapel."'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($shuffle2,$shuffle, $mapel_jumlahsoal, $mapel_dikerjakan);
		while ($stmt->fetch()) {
		}
		$stmt->close();
	?>

	//Acak and Grouping
	<?php include('acak.js.php'); ?>

	//Re-Index

	jQuery('.to-be-removed').parent().remove();

	var i=0;
	jQuery('div.soal').each(function(index, el) {
		//Soal
		no = i+1;
		jQuery(this).addClass('nomor-'+(no));
		jQuery(this).find('div.nomor').text(no);

		//Pilihan
		var j = 0;
		<?php if ($shuffle2) : ?>
		jQuery(this).children('div.options-group').find('.options').shuffle();
		<?php endif; ?>
		jQuery(this).children('div.options-group').find('.options').each(function(index, el) {
			span = jQuery(this).children('span');
			//span.text(String.fromCharCode(65+j));
			span.html('<span class="inneroption">'+String.fromCharCode(65+j)+'</span>');
			span.attr('data-nomor',no);
			span.attr('data-option',String.fromCharCode(65+j));
			span.addClass('option-'+String.fromCharCode(65+j))
			j++;
		});
		jQuery(this).children('div.options-group').find('textarea').each(function(index, el) {
			span = jQuery(this);
			span.attr('data-nomor',no);
			j++;
		});

		i++;

	});

	//summary
	var i=0;
	jQuery('div.soal').each(function(index, el) {
		i++;
		var no_asli = jQuery(this).attr('data-nomor-asli');
		jQuery('#summary').append('<div id="jawaban-'+i+'" style="display:none"></div>');
		jQuery('#summary').append('<div class="not-done no nomor-asli-'+no_asli+' no-'+i+' "><p>'+i+'</p><span></span></div>');
	});
	jQuery('#summary .no-1').addClass('active')

		jQuery('.no:gt(<?php echo $mapel_dikerjakan-1 ?>)').remove();
		jQuery('.soal:gt(<?php echo $mapel_dikerjakan-1 ?>)').remove();
		jQuery('#jumlah_soal').text('<?php echo $mapel_dikerjakan ?>');


	//Simpan Urutan Acak
	<?php if ($saveurutansoal==1) : ?>
		console.log ("Menyimpan Urutan Soal");
	var s = '';
	var i = 0;
	jQuery('div.soal').each(function(index, el) {
		i++;
		id = jQuery(this).prop('id');
		id = id.replace("nomor-asli-","");
		s = s + i + "=" + id + "&";
	});
	$.get(themedir2 + '/api-18575621/saveurutan.php?'+s,{
		mapel : '<?php echo ($mapel) ?>',
		siswa : '<?php echo ($siswa) ?>'
	},function(s){
		//console.log (s);
	});
	<?php endif; ?>

	//Aktifkan
	jQuery('#soal-body').show();
	jQuery('div.soal').eq(0).addClass('active');
}

<?php if (false) : ?>
</script>
<?php endif; ?>
