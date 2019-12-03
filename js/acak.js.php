//ACAK JS PHP
<?php 


	//Cek Apakah Sudah ada History Atau Belum
	$sql = "SELECT * FROM `hasil` WHERE `userid`='".$siswa."' AND test='".$mapel."' ";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$ordersoal = $row['ordersoal'];			
	    	if (!$ordersoal) {
			// if (true) {

	        	$saveurutansoal = 1;

	        	?>
	        	//Kalao Tidak Ada History Kerjakan ACak dan Groouping

	        	//Acak
	        	<?php if ($shuffle>0) : ?>
	        		jQuery('textarea.essay').each(function(){
						jQuery(this).closest('div.soal').addClass('soalessay');	        		
	        		})
	        		jQuery('div.soal').shuffle();

					jQuery('.soalessay').each(function(){
						jQuery(this).appendTo(jQuery('#soal-body'));
					})

				<?php endif;
				
				//KD

				$sql = "SELECT `no`,`kd` FROM `kd` WHERE `kode` = '".$_GET['kodetest']."' ORDER BY `no`; ";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						if ($row['kd']) {
							?>									
								jQuery('#nomor-asli-<?php echo $row['no'] ?>').attr('data-jeniskd',"<?php echo $row['kd'] ?>");
							<?php
						}
					}
				}

				//KDSOAL

				$sql = "SELECT `kd`,`alokasi` FROM `kdsoal` WHERE `kode` = '".$_GET['kodetest']."' ORDER BY `kd`; ";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						if ($row['kd']) {
							?>	
								jQuery('[data-jeniskd="<?php echo $row['kd'] ?>"]').addClass('kdtbr');
								jQuery('[data-jeniskd="<?php echo $row['kd'] ?>"]').shuffle();
								jQuery('[data-jeniskd="<?php echo $row['kd'] ?>"]').slice(0,<?php echo $row['alokasi'] ?>).removeClass('kdtbr');
								jQuery('.kdtbr').remove();
							<?php
						}
					}
				}
			
	        	//Lock N

					$sql = "SELECT `no`,`locking` FROM `locking` WHERE `kode` = '".$_GET['kodetest']."' ORDER BY `no`; ";
	        		$result = $conn->query($sql);
	        		
	        		if ($result->num_rows > 0) {
	        		    // output data of each row
	        		    while($row = $result->fetch_assoc()) {
	    		    		if ($row['locking']>0) {
	    		    			?>									
									var div1 = jQuery('#nomor-asli-<?php echo $row['no'] ?>');
									console.log (div1);
									var div2 = jQuery('.soal').eq(<?php echo $row['locking']-1?>);
									console.log (div2);
									var tdiv1 = div1.clone();
									var tdiv2 = div2.clone();
									div1.replaceWith(tdiv2);
									div2.replaceWith(tdiv1);
	    		    			<?php
	    		    		}
	        		    }
					}
					
				//Grouping

	        		$sql = "SELECT `no`,`grouping` FROM `grouping` WHERE `kode` = '".$_GET['kodetest']."' ORDER BY `no`; ";
	        		$result = $conn->query($sql);
	        		
	        		if ($result->num_rows > 0) {
	        		    // output data of each row
	        		    while($row = $result->fetch_assoc()) {
	    		    		if ($row['grouping']>0) {
	    		    			?>
	    		    				jQuery('#nomor-asli-<?php echo $row['grouping'] ?>').insertAfter(jQuery('#nomor-asli-<?php echo $row['no'] ?>'));
			    					console.log('<?php echo $row['no'] ?>><?php echo $row['grouping'] ?>')

	    		    			<?php
	    		    		}
	        		    }
	        		}

	        } else {
				?> 
				//Kalao Ada History Ambil History
				<?php
		       	$saveurutansoal = 0;

		       	$ordersoal = explode(";", $ordersoal);

		       	$sql = "SELECT shuffle2,shuffle,jumlahsoal, dikerjakan FROM `options` WHERE `kode`='".$mapel."'";
		       	$stmt = $conn->prepare($sql);
		       	$stmt->execute();
		       	$stmt->bind_result($shuffle2,$shuffle, $mapel_jumlahsoal, $mapel_dikerjakan);
		       	while ($stmt->fetch()) {
		       	}
		       	$stmt->close();

		       	?>
		       	<?php
		       	for ( $i=$mapel_dikerjakan ; $i>=0 ; $i-- ){
		       		if (isset($ordersoal[$i])) {
						if (is_numeric($ordersoal[$i])){
							?>
							jQuery('#nomor-asli-<?php echo $ordersoal[$i] ?>').prependTo('#soal-body');
							<?php		       			
						}
		       		}
		       	}

	        }
	    }
	} else {
		?>
			alert ('Siswa tidak ditemukan, silakan login ulang');
		<?php
		$saveurutansoal = 0;
	    //echo "0 results";
	}

?>

//END ACAK JS