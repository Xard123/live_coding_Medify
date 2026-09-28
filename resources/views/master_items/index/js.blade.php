<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    $(document).ready(function() {

        $('#table').DataTable({
            searching: false,
            order: [[1, 'desc']],
            columnDefs: [
                {
                    orderable: false,
                    targets: [0, 8]
                }
            ]
        });

        getData();
    });

    $('.btn-get-data').click(function() {
        getData();
    });

    function getData() {

        $('#loading-filter').show();

        var dataTableObj = $('#table').DataTable();

        var filter_kode = $('#filter-kode').val();
        var filter_nama = $('#filter-nama').val();
        var filter_harga_min = $('#filter-harga-min').val();
        var filter_harga_max = $('#filter-harga-max').val();

        dataTableObj.clear().draw();

        $.ajax({
            url: '{{ url("master-items/search") }}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,

            data: {
                kode: filter_kode,
                nama: filter_nama,
                hargamin: filter_harga_min,
                hargamax: filter_harga_max
            },

            success: function(results) {

                var data = results.data;

                $.each(data, function(index, item) {

                    // =========================
                    // FOTO
                    // =========================

                    var foto = '';

                    if (item.foto) {
                        foto = `
                            <img
                                src="{{ asset('storage') }}/${item.foto}"
                                alt="${escapeHtml(item.nama)}"
                                width="60"
                                height="60"
                                style="
                                    object-fit: cover;
                                    border-radius: 8px;
                                "
                            >
                        `;
                    } else {
                        foto = `
                            <span class="text-muted">
                                Tidak ada foto
                            </span>
                        `;
                    }


                    // =========================
                    // HARGA JUAL
                    // =========================

                    var harga_jual =
                        Number(item.harga_beli) +
                        (
                            Number(item.harga_beli) *
                            Number(item.laba) /
                            100
                        );

                    harga_jual = Math.round(harga_jual);


                    // =========================
                    // KATEGORI
                    // =========================

                    var kategori = '';

                    if (item.categories && item.categories.length > 0) {

                        kategori = item.categories.map(function(category) {
                            return `
                                <span class="badge bg-secondary me-1">
                                    ${escapeHtml(category.name)}
                                    (${escapeHtml(category.code)})
                                </span>
                            `;
                        }).join('');

                    } else {

                        kategori = `
                            <span class="text-muted">
                                -
                            </span>
                        `;
                    }


                    // =========================
                    // VIEW
                    // =========================

                    var html = `
                        <a
                            href="{{ url('master-items/view') }}/${item.kode}"
                            class="btn btn-primary btn-sm"
                        >
                            View
                        </a>
                    `;


                    // =========================
                    // TAMBAH ROW
                    // =========================

                    dataTableObj.row.add([
                        foto,
                        item.kode,
                        escapeHtml(item.nama),
                        escapeHtml(item.jenis),
                        formatRupiah(item.harga_beli),
                        formatRupiah(harga_jual),
                        escapeHtml(item.supplier),
                        kategori,
                        html
                    ]).draw(false);

                });

                $('#loading-filter').hide();
            },

            error: function(xhr, textStatus, errorThrown) {

                this.tryCount++;

                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }

                alert(
                    'Terjadi kesalahan server, tidak dapat mengambil data'
                );

                $('#loading-filter').hide();
            }
        });
    }


    // =========================
    // FORMAT RUPIAH
    // =========================

    function formatRupiah(value) {

        if (value === null || value === undefined || value === '') {
            return '-';
        }

        return 'Rp ' + Number(value).toLocaleString('id-ID');
    }


    // =========================
    // ESCAPE HTML
    // =========================

    function escapeHtml(value) {

        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

</script>