$(document).ready(function() {
$("#kt_datatable_dom_positioning").DataTable({
	"language": {
		"lengthMenu": "Show _MENU_",
	},
	"dom":
		"<'row'" +
		"<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
		"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
		">" +

		"<'table-responsive'tr>" +

		"<'row'" +
		"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
		"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
		">",
});
});

//Penjualan
"use strict";

// Class definition
var KTAppCategoryProductspen = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-penjualan-product-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Handle status filter dropdown
    var handleStatusFilter = () => {
        const filterStatus = document.querySelector('[data-kt-penjualan-product-filter="kategori"]');
        $(filterStatus).on('change', e => {
            let value = e.target.value;
            if(value === 'all'){
                value = '';
            }
            datatable.column(1).search(value).draw();
        });
    }

		var handleDateFilter = () => {
		const filterDate = document.querySelector('#kt_datepicker_1');
		$(filterDate).flatpickr({
			dateFormat: "d-m-Y",
			mode: "single",

		});

		$(filterDate).on('change', function () {
			const selectedDate = $(this).val(); // Nilai tanggal yang dipilih oleh Flatpickr

			// Memecah format "m-Y" menjadi bulan dan tahun
			const dateParts = selectedDate.split('-');
			const bulan = dateParts[0];
			const tahun = dateParts[1];

			// Lakukan pencarian atau tindakan lain dengan nilai bulan dan tahun yang sesuai.
			datatable.column(4).search(bulan + '-' + tahun).draw();
		});
	}

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#table_penjualan_laba');

            if (!table) {
                return;
            }

            initDatatable();
            handleSearchDatatable();
            handleStatusFilter();
			handleDateFilter();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppCategoryProductspen.init();
});

//PENGELUARAN
"use strict";

// Class definition
var KTAppCategoryProducts = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-pengeluaran-product-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Handle status filter dropdown
    var handleStatusFilter = () => {
        const filterStatus = document.querySelector('[data-kt-pengeluaran-product-filter="kategori"]');
        $(filterStatus).on('change', e => {
            let value = e.target.value;
            if(value === 'all'){
                value = '';
            }
            datatable.column(1).search(value).draw();
        });
    }

		var handleDateFilter = () => {
		const filterDate = document.querySelector('#kt_datepicker_1');
		$(filterDate).flatpickr({
			dateFormat: "d-m-Y",
			mode: "single",

		});

		$(filterDate).on('change', function () {
			const selectedDate = $(this).val(); // Nilai tanggal yang dipilih oleh Flatpickr

			// Memecah format "m-Y" menjadi bulan dan tahun
			const dateParts = selectedDate.split('-');
			const bulan = dateParts[0];
			const tahun = dateParts[1];

			// Lakukan pencarian atau tindakan lain dengan nilai bulan dan tahun yang sesuai.
			datatable.column(4).search(bulan + '-' + tahun).draw();
		});
	}

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#table_pengeluaran');

            if (!table) {
                return;
            }

            initDatatable();
            handleSearchDatatable();
            handleStatusFilter();
			handleDateFilter();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppCategoryProducts.init();
});


// PENJUALAN
"use strict";

// Class definition
var KTAppSaleProducts = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-penjualan-product-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Handle status filter dropdown
    var handleStatusFilter = () => {
        const filterStatus = document.querySelector('[data-kt-penjualan-product-filter="kategori"]');
        $(filterStatus).on('change', e => {
            let value = e.target.value;
            if(value === 'all'){
                value = '';
            }
            datatable.column(1).search(value).draw();
        });
    }

		var handleDateFilter = () => {
		const filterDate = document.querySelector('#kt_datepicker_1_sale');
		$(filterDate).flatpickr({
			dateFormat: "m-Y",
			mode: "single",

		});

		$(filterDate).on('change', function () {
			const selectedDate = $(this).val(); // Nilai tanggal yang dipilih oleh Flatpickr

			// Memecah format "m-Y" menjadi bulan dan tahun
			const dateParts = selectedDate.split('-');
			const bulan = dateParts[0];
			const tahun = dateParts[1];

			// Lakukan pencarian atau tindakan lain dengan nilai bulan dan tahun yang sesuai.
			datatable.column(5).search(bulan + '-' + tahun).draw();
		});
	}

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#table_penjualan');

            if (!table) {
                return;
            }

            initDatatable();
            handleSearchDatatable();
            handleStatusFilter();
			handleDateFilter();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppSaleProducts.init();
});

// LABA-RUGI
"use strict";

// Class definition
var KTAppPendapatanProducts = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                { orderable: false, targets: 5 }, // Disable ordering on column 7 (actions)
            ]
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-pendaptan-product-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Handle status filter dropdown
    var handleStatusFilter = () => {
        const filterStatus = document.querySelector('[data-kt-pendapatan-product-filter="status"]');
        $(filterStatus).on('change', e => {
            let value = e.target.value;
            if(value === 'all'){
                value = '';
            }
            datatable.column(3).search(value).draw();
        });
    }

		var handleDateFilter = () => {
		const filterDate = document.querySelector('#kt_datepicker_1_pendapatan');
		$(filterDate).flatpickr({
			dateFormat: "d-m-Y",
			mode: "single",

		});

		$(filterDate).on('change', function () {
			const selectedDate = $(this).val(); // Nilai tanggal yang dipilih oleh Flatpickr

			// Memecah format "m-Y" menjadi bulan dan tahun
			const dateParts = selectedDate.split('-');
			const bulan = dateParts[0];
			const tahun = dateParts[1];

			// Lakukan pencarian atau tindakan lain dengan nilai bulan dan tahun yang sesuai.
			datatable.column(4).search(bulan + '-' + tahun).draw();
		});
	}

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#table_pendapatan');

            if (!table) {
                return;
            }

            initDatatable();
            handleSearchDatatable();
            handleStatusFilter();
			handleDateFilter();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppPendapatanProducts.init();
});

"use strict";

// Class definition
var KTAppEcommerceProducts = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                { render: DataTable.render.number(',', '.', 2), targets: 4},
                { orderable: false, targets: 7 }, // Disable ordering on column 7 (actions)
            ]
        });

        // Re-init functions on datatable re-draws
        datatable.on('draw', function () {
            handleDeleteRows();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-ecommerce-product-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Handle status filter dropdown
    var handleStatusFilter = () => {
        const filterStatus = document.querySelector('[data-kt-ecommerce-product-filter="status"]');
        $(filterStatus).on('change', e => {
            let value = e.target.value;
            if(value === 'all'){
                value = '';
            }
            datatable.column(1).search(value).draw();
        });
    }

    // Delete cateogry
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = table.querySelectorAll('[data-kt-ecommerce-product-filter="delete_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get category name
                const productName = parent.querySelector('[data-kt-ecommerce-product-filter="product_name"]').innerText;

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + productName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        Swal.fire({
                            text: "You have deleted " + productName + "!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        }).then(function () {
                            // Remove current row
                            datatable.row($(parent)).remove().draw();
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: productName + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            })
        });
    }


    // Public methods
    return {
        init: function () {
            table = document.querySelector('#kt_ecommerce_products_table');

            if (!table) {
                return;
            }

            initDatatable();
            handleSearchDatatable();
            handleStatusFilter();
            handleDeleteRows();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceProducts.init();
});
