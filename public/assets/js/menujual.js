const quantityInputs = document.querySelectorAll('.quantity-input');
    const categoryTotals = {};

    quantityInputs.forEach(input => {
        const baseQuantity = parseInt(input.getAttribute('data-base-quantity'));
        const price = parseFloat(input.getAttribute('data-price'));
        const totalCell = input.parentNode.nextElementSibling.nextElementSibling;
        const categoryCell = input.parentNode.previousElementSibling;
        const categoryName = categoryCell.textContent.trim();
        const barangDikurangiCell = input.parentNode.nextElementSibling.nextElementSibling.nextElementSibling;

        if (!categoryTotals[categoryName]) {
            categoryTotals[categoryName] = 0;
        }

        input.addEventListener('change', () => {
            const quantity = parseInt(input.value);
            const adjustedQuantity = baseQuantity - quantity;
            barangDikurangiCell.textContent = adjustedQuantity.toString();

            if (adjustedQuantity >= 0) {
                const total = adjustedQuantity * price;
                totalCell.textContent = 'Rp' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                categoryTotals[categoryName] += total;

                updateCategoryTotalDisplay(categoryName, categoryTotals[categoryName]);
            }
        });
    });

    const saveButton = document.getElementById('refresh-button');
    saveButton.addEventListener('click', () => {
    const changedData = [];

    quantityInputs.forEach(input => {
        const quantity = parseInt(input.value);
        const baseQuantity = parseInt(input.getAttribute('data-base-quantity'));
        const adjustedQuantity = baseQuantity - quantity;

        if (adjustedQuantity !== 0) {
            const itemName = input.parentNode.previousElementSibling.previousElementSibling.textContent.trim();
            const data = {
                itemName: itemName,
                adjustedQuantity: adjustedQuantity
            };
            changedData.push(data);
        }
    });

    if (changedData.length > 0) {

        $.ajax({
            type: 'POST',
            url: '/save_changes',
            data: { changes: changedData },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
            },
            error: function(error) {
                console.error('Terjadi kesalahan:', error);
            }
        });
    }
    });

    function updateCategoryTotalDisplay(categoryName, total) {
    const categoryTotalDisplay = document.querySelector(`#${categoryName.replace(/\s+/g, '-')}-total`);
    if (categoryTotalDisplay) {
        categoryTotalDisplay.textContent = 'Rp' + total.toFixed(2);
    }
    }
    function updateTotalPrice() {
    const totalCells = document.querySelectorAll('.total');
    let totalPrice = 0;

    totalCells.forEach(cell => {
        const totalValue = parseFloat(cell.textContent.replace('Rp', '').replace(',', '').trim());
        totalPrice += totalValue;
    });

    const totalAmount = document.getElementById('total-amount');
    totalAmount.textContent = 'Rp' + totalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }


    quantityInputs.forEach(input => {
        input.addEventListener('change', () => {
            updateTotalPrice();
        });
    });

    window.addEventListener('load', updateTotalPrice);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    const refreshButton = document.getElementById('refresh-button');

    refreshButton.addEventListener('click', () => {
        location.reload();
    });

document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('table_penjualan');
    const saveButton = document.getElementById('save-button');
    const billModal = new bootstrap.Modal(document.getElementById('billModal'));

    const soldItems = [];

    saveButton.addEventListener('click', function() {

        let totalAmount = 0;

        soldItems.length = 0;

        for (let i = 1; i < table.rows.length; i++) {
            const row = table.rows[i];
            const quantityInput = row.querySelector('.quantity-input');
            const basePrice = parseFloat(quantityInput.dataset.price);
            const quantity = parseFloat(quantityInput.value);
            const baseQuantity = parseFloat(quantityInput.dataset.baseQuantity);

            const soldQuantity = baseQuantity - quantity;

            if (soldQuantity > 0) {

                const totalPrice = basePrice * soldQuantity;

                row.cells[5].textContent = 'Rp' + formatNumberWithCommas(totalPrice.toFixed(2));
                totalAmount += totalPrice;

                soldItems.push({
                    item: row.cells[1].textContent,
                    category: row.cells[2].textContent,
                    quantity: soldQuantity,
                    price: basePrice,
                });
            } else {

                row.cells[5].textContent = 'Rp0';
            }
        }

        const billContent = generateBillContent(soldItems, totalAmount);

        const billContentElement = document.getElementById('bill-content');
        billContentElement.innerHTML = billContent;
        billModal.show();
    });
});

function generateBillContent(soldItems, totalAmount) {

    let billContent = '<h2>Sold Items</h2>';

    if (soldItems.length > 0) {
        const tableStyle = 'table table-striped table-row-bordered gy-5 gs-7 border rounded';
        const cellStyle = 'border: 2px solid #2b2b40; border-radius: 5px; padding: 8px';

        billContent += `<table class="${tableStyle}">`;
        billContent += '<tr>';
        billContent += `<th style="${cellStyle}">No</th>`;
        billContent += `<th style="${cellStyle}">Item</th>`;
        billContent += `<th style="${cellStyle}">Category</th>`;
        billContent += `<th style="${cellStyle}">Quantity</th>`;
        billContent += `<th style="${cellStyle}">Total Price</th>`;
        billContent += '</tr>';

        let rowNumber = 1;
        for (const soldItem of soldItems) {
            billContent += '<tr>';
            billContent += `<td style="${cellStyle}">${rowNumber}</td>`;
            billContent += `<td style="${cellStyle}">${soldItem.item}</td>`;
            billContent += `<td style="${cellStyle}">${soldItem.category}</td>`;
            billContent += `<td style="${cellStyle}">${soldItem.quantity}</td>`;
            billContent += `<td style="${cellStyle}">Rp${formatNumberWithCommas((soldItem.price * soldItem.quantity).toFixed(2))}</td>`;
            billContent += '</tr>';
            rowNumber++;
        }

        billContent += '</table>';
    } else {
        billContent += '<p>Tidak ada barang yang terjual.</p>';
    }

    billContent += `<div style="margin-top: 20px;"></div>`;

    billContent += `<h4>Total Price: Rp${formatNumberWithCommas(totalAmount.toFixed(2))}</h4>`;

    return billContent;
}

function formatNumberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

