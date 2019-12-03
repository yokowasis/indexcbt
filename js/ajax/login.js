jQuery(document).ready(function ($) {

    /**
     * Lihat Nilai di Halaman Login
     */
    $('body').on('click', 'span#lihatnilai', function (event) {
        $('span#lihatnilai').text('loading...');
        $.ajax({
            url: 'wp-content/themes/unbk/nilai.php',
            type: 'POST',
            data: {
                userid: $('#username').val(),
                mapel: $('#mapel').val(),
                standalone: 1
            },
        })
            .done(function (s) {
                $('span#lihatnilai').remove();
                $('#loginbox').addClass('konfirm');
                $('#loginbox').addClass('konfirm3');
                var loginbox = `
            <form action="./?logout=1" method="POST">
                <div id="logintitle">
                    <p>Lihat Nilai</p>
                </div>

                <div id="loginbody" style="text-align:center">
                    Nilai Anda Untuk Mata Pelajaran 
                    <br>
                    <span style="font-size:25px;">` + $('#mapel').val() + `</span> <br>
                    adalah <br>

                    <div style="text-align:center;font-size:50px; font-weight:bold;margin-top:20px;">
                        ` + s + `
                    </div>

                </div>
                <div id="loginfooter">
                    <input type="submit" value="LOGOUT">
                    <div class="clear"></div>
                </div>
            </form>

            `;
                $('#loginbox').html(loginbox);
            })
            .fail(function () {
                $('span#lihatnilai').text("Gagal");
            })
            .always(function () {
            });

    });

    /**
     * Mengambil mapel dari database
     */
    $.post(backend, { getmapel: '1' }, function (data, textStatus, xhr) {
        $('#mapel').html(data);
    });

    /**
     * Proses Login
     */
    $('#submitlogin').click(function (event) {
        $('#ajax').show();

        $.ajax({
            url: `${backend}/wp-content/themes/unbk/ajax_dologin.php`,
            type: 'POST',
            data: {
                kode: $('#username').val(),
                pass: $('#password').val(),
                mapel: $('#mapel').val()
            },
        })
            .done(function (e) {
                // success
                console.log(e);
                var obj = JSON.parse(e);

                if (obj.status == 'Success') {

                    $('#sect_login').slideUp('slow');

                    $('#sect_konfirmasi').show();

                    $('#userid').html(obj.username);
                    $('#nama_siswa2').html(obj.namalengkap);
                    $('#localstorage').html(obj.locastorage);
                    $('#objnama').html(obj.nama);
                    $('#objstatus').html(obj.status);
                    $('#objsubtest').html(obj.subtest);
                    $('#objtanggal').html(obj.tanggal);
                    $('#objwaktu').html(obj.waktu);
                    $('#objalokasi').html(obj.alokasi);

                    $('#token').val(obj.token);

                    localStorage.setItem('token', obj.token);

                    $('#mulaiwrapper').html(obj.x);

                } else {
                    $('#box_keterangan').html(obj.status);
                }
            })
            .fail(function (e) {
                // console.log("error");
                alert('Jaringan Gangguan, silakan coba lagi');
            })
            .always(function (e) {
                // console.log("complete");
                $('#ajax').hide();
            });
    });


    $('#eye').hover(function () {
        $('#password').prop('type', 'text');
    }, function () {
        $('#password').prop('type', 'password');
    });

    /**
     * Daftar Siswa Baru
     */
    $('#tombol_daftar').click(function (event) {
        if (
            ($('#inp_nama').val() == '') ||
            ($('#inp_username').val() == '') ||
            ($('#inp_password').val() == '')
        ) {
            alert('Semua Kotak Data Harus diisi');
        } else {
            console.log($('#mapel').val());
            if ($('#mapel').val()) {
                $('#ajax').show();
                $.post(backend, {
                    name_baru: $('#inp_nama').val(),
                    user_baru: $('#inp_username').val(),
                    passw_baru: $('#inp_password').val(),
                    mapel_baru: $('#mapel').val()
                }, function (data, textStatus, xhr) {
                    if (data == 'Username Sudah Ada, silakan menggunakan username yg lain') {
                        alert(data);
                    } else {
                        $('#modal_close').click();
                        $('#username').val($('#inp_username').val());
                        $('#password').val($('#inp_password').val());
                        $('#submitlogin').click();
                    }
                    $('#ajax').hide();
                });
            } else {
                alert('Kode Ujian Tidak Boleh Kosong');
            }
        }
    });
});