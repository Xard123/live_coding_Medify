<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#table').DataTable({
        searching: false,
        order: [[0, 'desc']]
    });
    getData();
});

$('.btn-get-data').click(getData);

function getData() {
    $('#loading-filter').show();
    const table = $('#table').DataTable();
    table.clear();

    $.getJSON('{{url("master-items/search")}}', {
        kode: $('#filter-kode').val(),
        nama: $('#filter-nama').val(),
        hargamin: $('#filter-harga-min').val(),
        hargamax: $('#filter-harga-max').val()
    }, function(results) {
        $.each(results.data, function(_, item) {
            const hargaJual = Math.round(item.harga_beli + item.harga_beli * item.laba / 100);
            const kategori = (item.categories || []).map(category => category.name).join(', ');
            const html = '<a href="{{url("master-items/view")}}/' + item.kode + '" class="btn btn-primary">View</a>';

            table.row.add([
                item.kode,
                item.nama,
                kategori,
                item.jenis,
                item.harga_beli,
                hargaJual,
                item.supplier,
                html
            ]);
        });
        table.draw();
    }).fail(function() {
        alert('Terjadi kesalahan server, tidak dapat mengambil data');
    }).always(function() {
        $('#loading-filter').hide();
    });
}
</script>