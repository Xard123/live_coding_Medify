<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#table-kategori').DataTable({
        searching: false,
        order: [[0, 'asc']]
    });
    getData();
});

$('.btn-get-data').click(getData);

function getData() {
    $('#loading-filter').show();
    const table = $('#table-kategori').DataTable();
    table.clear();

    $.getJSON('{{url("kategori-items/search")}}', {
        name: $('#filter-name').val(),
        code: $('#filter-code').val()
    }, function (results) {
        $.each(results.data, function (_, item) {
            table.row.add([
                item.name,
                item.code,
                item.master_items_count,
                '<a href="{{url("kategori-items/view")}}/' + item.id + '" class="btn btn-primary">View</a>'
            ]);
        });
        table.draw();
    }).fail(function () {
        alert('Terjadi kesalahan server, tidak dapat mengambil data');
    }).always(function () {
        $('#loading-filter').hide();
    });
}
</script>
