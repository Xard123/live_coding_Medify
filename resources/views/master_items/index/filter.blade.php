<div id="filter-container">
    <h4>Filter</h4>
    <div class="row">
        <div class="col-3">
            <label>Kode</label>
            <input type="text" class="form-control" id="filter-kode">
        </div>
        <div class="col-3">
            <label>Nama</label>
            <input type="text" class="form-control" id="filter-nama">
        </div>
        <div class="col-3">
            <label>Harga Min</label>
            <input type="number" class="form-control" id="filter-harga-min">
        </div>
        <div class="col-3">
            <label>Harga Max</label>
            <input type="number" class="form-control" id="filter-harga-max">
        </div>
    </div>
    <button class="btn btn-primary mt-2 btn-get-data">Filter</button>
    <span id="loading-filter" style="display:none;">Loading...</span>
</div>