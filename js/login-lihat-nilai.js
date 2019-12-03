jQuery(document).ready(function ($) {

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
        }).done(function (s) {
            $('span#lihatnilai').remove();
            $('#loginbox').addClass('konfirm');
            $('#loginbox').addClass('konfirm3');
            var loginbox = '' +
                '<form action="./?logout=1" method="POST">' +
                '    <div id="logintitle">' +
                '        <p>Lihat Nilai</p>' +
                '    </div>' +
                '' +
                '    <div id="loginbody" style="text-align:center">' +
                '        Nilai Anda Untuk Mata Pelajaran ' +
                '        <br>' +
                '        <span style="font-size:25px;">' + $('#mapel').val() + '</span> <br>' +
                '        adalah <br>' +
                '' +
                '        <div style="text-align:center;font-size:50px; font-weight:bold;margin-top:20px;">' +
                '            ' + s + '' +
                '        </div>' +
                '' +
                '    </div>' +
                '    <div id="loginfooter">' +
                '        <input type="submit" value="LOGOUT">' +
                '        <div class="clear"></div>' +
                '    </div>' +
                '</form>';
            $('#loginbox').html(loginbox);
        }).fail(function () {
            $('span#lihatnilai').text("Gagal");
        }).always(function () {
        });

    });

    $.post('./', { getmapel: '1' }, function (data, textStatus, xhr) {
        $('#mapel').html(data);
    });

    $('#submitlogin').click(function (event) {
        $('#ajax').show();
        $.post('./', $('#form_login').serialize(), function (data, textStatus, xhr) {
            if (data == 'OK') {
                $.post('./', { getkonfirm: '1' }, function (data, textStatus, xhr) {
                    $('#box_keterangan').html('Login Berhasil...');

                    var obj = JSON.parse(data);

                    window.location = './archives/konfirmasi---' + obj["mapel"];


                });

            } else {
                $('#box_keterangan').html(data);
            }

            $('#notif').css('background', '#eff6f4');
            setTimeout(function () {
                $('#notif').css('background', '#F4E0DE');
                $('#ajax').hide();
            }, 100);
        });
    });
    $('#eye').hover(function () {
        $('#password').prop('type', 'text');
    }, function () {
        $('#password').prop('type', 'password');
    })
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
                $.post('./', {
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
                alert('Kode Ujian Tidak Boleh Kosong')
            }
        }
    });
});
