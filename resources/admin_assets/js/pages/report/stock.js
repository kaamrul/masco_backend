let columns = [
    { data: 'id' },
    { data: 'branch_id' },
    { data: 'product_id' },
    { data: 'supplier_id' },
    { data: 'purchase_price' },
    { data: 'sale_price' },
    { data: 'special_price' },
    { data: 'quantity' },
    { data: 'discount_id' },
    { data: 'stock_alert' },
    { data: 'purchase_date' },
    { data: 'warranty_date' },
    { data: 'sku_code' },
    { data: 'barcode' },
    { data: 'status' },
    { data: 'note' },
    { data: 'operator' },
];
let column_defs = [
    { targets: 10, visible: false },
    { targets: 11, visible: false },
    { targets: 12, visible: false },
    { targets: 13, visible: false },
    { targets: 14, visible: false },
    { targets: 15, visible: false },
    { "className": "text-center", "targets": [0,16] }
];

var table = $('#stockReportDataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/report/stock",
        data: function (d) {
            d.branch_id   = $("#branch_id").val()
            d.fromDate = $("#fromDate").val()
            d.toDate = $("#toDate").val()
        }
    },
    columns: columns,
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        {
            text: '<i class="fas fa-download"></i> Export',
            extend: 'collection',
            className: 'custom-html-collection pull-right',
            buttons: [
                'pdf',
                'csv',
                'excel',
            ]
        },
        { html: colVisibility('#stockReportDataTable', column_defs) },

    ],
    columnDefs: column_defs,
    language: {
        searchPlaceholder: "Search records",
        search: "",
        buttons: {
            pageLength: {
                _: "%d Rows",
            }
        }
    }
});

executeColVisibility(table);
// End Tables

$(document).ready(function () {
    $('#branch_id').select2({
        placeholder: "Select Branch",
        allowClear: false,
        multiple: true,
    });

    $('#branch_id').siblings('.select2-container').append('<span class="select-all"><i class="fa-regular fa-square-check"></i></span>');
});


window.filterUsers = function () {
    table.ajax.reload();
}

window.filterClear = function () {
    $('#branch_id').val('').trigger('change');
    $('input[name="date_range"]').val('');

    table.ajax.reload();
}
