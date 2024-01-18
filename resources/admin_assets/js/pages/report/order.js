let type = $('#type').val();

let columns = [
    { data: 'id' },
    { data: 'invoice_id' },
    { data: 'customer_id' },
    { data: 'branch_id' },
    { data: 'sub_total_amount' },
    { data: 'total_amount' },
    { data: 'vat_amount' },
    { data: 'discount_amount' },
    { data: 'due_amount' },
    { data: 'packaging_cost' },
    { data: 'delivery_cost' },
    { data: 'other_cost' },
    { data: 'operator_id' },
];

let column_defs = [
    { targets: 6, visible: false },
    { "className": "text-center", "targets": [0, 5] }
];

var table = $('#purchaseReportDataTable').DataTable({
    order: [[0, 'desc']],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: BASE_URL + "/report/" + type + "/order",
        data: function (d) {
            d.branch_id   = $("#branch_id").val()
            d.order_status   = $("#order_status").val()
            d.payment_status   = $("#payment_status").val()
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
        { html: colVisibility('#purchaseReportDataTable', column_defs) },

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

    $('#order_status').select2({
        placeholder: "Select Order Status",
        allowClear: false,
        multiple: true,
    });
    $('#order_status').siblings('.select2-container').append('<span class="select-all"><i class="fa-regular fa-square-check"></i></span>');

    $('#payment_status').select2({
        placeholder: "Select Payment Status",
        allowClear: false,
        multiple: true,
    });
    $('#payment_status').siblings('.select2-container').append('<span class="select-all"><i class="fa-regular fa-square-check"></i></span>');
});


window.filterUsers = function () {
    table.ajax.reload();
}

window.filterClear = function () {
    $('#branch_id').val('').trigger('change');
    $('#order_status').val('').trigger('change');
    $('#payment_status').val('').trigger('change');
    $('input[name="date_range"]').val('');
    table.ajax.reload();
}
