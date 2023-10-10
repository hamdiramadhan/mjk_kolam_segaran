var loading = `<div class="spinner-border" role="status">
<span class="visually-hidden">Loading...</span>
</div>`;

function delete_user(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data User?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_user/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_kelompok_barang(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Ini?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_kode_barang/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_role(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Role?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_role/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_opd(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data OPD?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            cancelButtonColor: "#EB445A",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_opd/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_bidang(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Bidang ini?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            cancelButtonColor: "#EB445A",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_bidang/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_menu(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Menu?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_menu/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_parent_menu(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Parent Menu?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_parent_menu/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_sumber_dana(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Sumber Dana?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            cancelButtonColor: "#EB445A",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_sumber_dana/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_satuan(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Satuan?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            cancelButtonColor: "#EB445A",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_satuan/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_jumlah_pegawai(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Jumlah Pegawai?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            cancelButtonColor: "#EB445A",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_jumlah_pegawai/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_master_rekening(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Rekening?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            cancelButtonColor: "#EB445A",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_rekening/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function delete_master_bmd(token, id) {
    swal({
            title: "Yakin Untuk Menghapus Data Ini?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF5722",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                var public_path = $('#public_path').val(); /* di layouts */
                var act = public_path + '/master_bmd/destroy/' + id;
                $.post(act, {
                        _token: token
                    },
                    function(data) {
                        swal({
                                title: "Data Terhapus!",
                                text: "",
                                confirmButtonColor: "#4CAF50",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                }
                            });
                    });
            }
        });
}

function pengajuan_detail_create(token, modal, id) {
    $(modal).modal('show');
    $(modal + 'Label').html('Tambah Detail Pengajuan');
    $(modal + 'Isi').html(loading);
    var public_path = $('#public_path').val(); /* di layouts */
    var act = public_path + '/pengajuan_detail_create';
    $.post(act, {
            _token: token,
            id: id
        },
        function(data) {
            $(modal + 'Isi').html(data);
        });
}

function ubah_sumberdana(token, modal, id) {
    $(modal).modal('show');
    $(modal + 'Label').html('Ubah Sumber Dana');
    $(modal + 'Isi').html(loading);
    var public_path = $('#public_path').val(); /* di layouts */
    var act = public_path + '/pengajuan_detail/edit_sumberdana';
    $.post(act, {
            _token: token,
            id: id
        },
        function(data) {
            $(modal + 'Isi').html(data);
        });
}