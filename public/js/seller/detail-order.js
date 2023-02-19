$(document).ready(function () {

    $('#changeStatus').select2({
        minimumResultsForSearch: Infinity,
    });

    $("#copy-tracking-no").click(function() {
        var copyText = document.getElementById("tracking_no");
        copyText.setSelectionRange(0, 99999); // mengatur range seleksi dari karakter 0 hingga 99999
        var button = this; // simpan referensi ke tombol yang diklik
        navigator.clipboard.writeText(copyText.value).then(function() {
            var tooltip = document.createElement("div");
            tooltip.innerHTML = "Disalin!";
            tooltip.classList.add("tooltip-copy");
            $(button).parent().append(tooltip); // gunakan referensi tombol untuk menambahkan tooltip
            setTimeout(function() {
                $(tooltip).fadeOut("fast", function() {
                    $(this).remove();
                });
            }, 1000);
        }, function() {
            console.error("Tidak dapat menyalin teks");
        });
    });



    // hitung countdown expire transaksi
    const countDownDate = new Date(transactionExpire).getTime();
    const countdown = $("#countdown");
    const x = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;
        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);
        countdown.html(`${days > 0 ? days + ' hari ' : ''}${hours} jam ${minutes} menit ${seconds} detik`);
        if (distance < 0) {
            clearInterval(x);
            countdown.html("Waktu Habis");
        }
    }, 1000);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Konfirm Order
    let confirmBtn = $('#confirmBtn');
    confirmBtn.click(function (e){
        e.preventDefault();
        $.ajax({
            url: updateConfirmUrl,
            type: 'POST',
            method: 'PUT',
            success: function (response) {
                Toastify({
                    node: $("#success-confirm-content").clone().removeClass("hidden")[0],
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "center",
                    stopOnFocus: true,
                }).showToast();
                // Refresh a specific div
                $('#detail-order').html(response);
                $('#detail-order').append(scriptElement);
            },
            error: function (xhr, status, error) {
                // menampilkan pesan error
                alert('Terjadi kesalahan saat mengkonfirmasi pesanan.');
            }
        });
    });

    /*$('#rejectBtn').click(function() {
        let reason = $('#reject-msg').val();
        let isValid = $('#reject-msg').parsley().validate();
        if (isValid === true) {
            $.ajax({
                url: updateRejectUrl,
                type: 'POST',
                method: 'PUT',
                data: { rejectMsg: reason},
                success: function () {
                    Toastify({
                        node: $("#reject-notification-content").clone().removeClass("hidden")[0],
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                    }).showToast();
                },
                error: function (xhr, status, error) {
                    // menampilkan pesan error
                    alert('Terjadi kesalahan saat menolak pesanan.');
                }
            });
        }
    });*/

    // Ubah status
    let changeStatus = $('#changeStatus');
    changeStatus.select2({
        minimumResultsForSearch: Infinity,
    });
    changeStatus.change(function (){
        let selectedStatus = $(this).val();
        $.ajax({
            type: "POST", // ubah menjadi POST
            method: "PUT", // tambahkan option method
            url: updateStatusUrl,
            data: {
                _method: "PUT", // tambahkan data _method
                selectedStatus: selectedStatus
            },
            beforeSend: function() {
                changeStatus.prop("disabled", true);
            },
            success: function(response) {
                // Success notification
                Toastify({
                    node: $("#success-notification-content").clone().removeClass("hidden")[0],
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "center",
                    stopOnFocus: true,
                }).showToast();
                // Refresh a specific div
                $('#detail-order').html(response);
                $('#detail-order').append(scriptElement);
            },
            complete: function() {
                setTimeout(function() {
                    changeStatus.prop("disabled", false);
                }, 1300);  // 1000 milliseconds = 1 second
            }
        })

    });

    // Update Resi
    let saveResiBtn = $('#save-resi-btn');
    let saveResiResponse = $('#save-resi-response');

    saveResiBtn.click(function () {
        let trackingNo = $('#tracking_no').val();
        let isValid = $('#tracking_no').parsley().validate();

        if (isValid === true) {
            $.ajax({
                type: 'PUT',
                url: updateResiUrl,
                data: { trackingNo: trackingNo },
                success: function (response) {
                    saveResiResponse.removeClass('hidden').text(response.success);
                    // Menampilkan pesan selama 3 detik
                    setTimeout(function() {
                        saveResiResponse.addClass('hidden');
                    }, 2000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    saveResiResponse.removeClass('hidden').text("Terjadi kesalahan.");
                    setTimeout(function() {
                        saveResiResponse.addClass('hidden');
                    }, 2000);
                }
            });
        }

    });

});

