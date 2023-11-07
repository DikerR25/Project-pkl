const quantityInputs = document.querySelectorAll('.quantity-input');
    const categoryTotals = {}; // Menyimpan total kategori
    
    quantityInputs.forEach(input => {
        const baseQuantity = parseInt(input.getAttribute('data-base-quantity')); //Jumlah barang
        const price = parseFloat(input.getAttribute('data-price')); //Harga
        const totalCell = input.parentNode.nextElementSibling.nextElementSibling;
        const categoryCell = input.parentNode.previousElementSibling;
        const categoryName = categoryCell.textContent.trim(); // Nama kategori
        const barangDikurangiCell = input.parentNode.nextElementSibling.nextElementSibling.nextElementSibling; // Ambil kolom "barangDikurangi"
        
        // Inisialisasi total kategori
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
                
                // Mengupdate total kategori
                categoryTotals[categoryName] += total;
                
                // Mengupdate tampilan total kategori
                updateCategoryTotalDisplay(categoryName, categoryTotals[categoryName]);
            }
        });
    });

    const saveButton = document.getElementById('save-button');
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
        // Mengirim data ke server menggunakan AJAX
        $.ajax({
            type: 'POST',
            url: '/save_changes', // Ganti dengan URL endpoint penyimpanan di server
            data: { changes: changedData },
            success: function(response) {
                console.log('Data berhasil disimpan:', response);
                // Di sini Anda bisa melakukan tindakan lain setelah berhasil menyimpan data
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

    // Panggil fungsi updateTotalPrice() setelah menghitung total pada setiap input quantity
    quantityInputs.forEach(input => {
        input.addEventListener('change', () => {
            // ... (kode lain di dalam event listener)

            // Setelah menghitung total untuk item individual, panggil fungsi untuk memperbarui total keseluruhan
            updateTotalPrice();
        });
    });

    // Panggil fungsi updateTotalPrice() saat halaman dimuat untuk pertama kali
    window.addEventListener('load', updateTotalPrice);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    const refreshButton = document.getElementById('refresh-button');
    
    refreshButton.addEventListener('click', () => {
        location.reload(); // Ini akan me-refresh halaman
    });

 // Bill-ie Eilish

document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('table_penjualan');
    const saveButton = document.getElementById('save-button');
    const billModal = new bootstrap.Modal(document.getElementById('billModal'));

    // Create an empty array to store sold items
    const soldItems = [];

    // Attach an event listener to the Save button
    saveButton.addEventListener('click', function() {
        // Initialize total amount
        let totalAmount = 0;

        // Reset the sold items array
        soldItems.length = 0;

        // Loop through all rows in the table
        for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
            const row = table.rows[i];
            const quantityInput = row.querySelector('.quantity-input');
            const basePrice = parseFloat(quantityInput.dataset.price);
            const quantity = parseFloat(quantityInput.value);
            const baseQuantity = parseFloat(quantityInput.dataset.baseQuantity);

            // Calculate the quantity sold
            const soldQuantity = baseQuantity - quantity;

            if (soldQuantity > 0) {
                // Calculate the total price for this item
                const totalPrice = basePrice * soldQuantity;

                // Update the total cell and add it to the overall total
                row.cells[5].textContent = 'Rp' + formatNumberWithCommas(totalPrice.toFixed(2));
                totalAmount += totalPrice;

                // Add the sold item to the array
                soldItems.push({
                    item: row.cells[1].textContent,
                    category: row.cells[2].textContent,
                    quantity: soldQuantity,
                    price: basePrice,
                });
            } else {
                // Clear the total cell and set the "Total Harga" cell to 0 if the item has no quantity sold
                row.cells[5].textContent = 'Rp0';
            }
        }

        // Generate the bill content
        const billContent = generateBillContent(soldItems, totalAmount);

        // Update the modal's content and open it
        const billContentElement = document.getElementById('bill-content');
        billContentElement.innerHTML = billContent;
        billModal.show();
    });
});

// Function to generate the bill content
function generateUniqueTransactionCode() {
    // Generate a random 5-digit number
    const min = 10000; // Minimum 5-digit number (inclusive)
    const max = 99999; // Maximum 5-digit number (inclusive)
    const randomCode = Math.floor(Math.random() * (max - min + 1)) + min;

    return randomCode.toString();
}

function generateBillContent(soldItems, totalAmount) {
    // Generate a unique 5-digit transaction code
    const transactionNumber = generateUniqueTransactionCode();

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

    // Add margin-top to create space between the table and the "Total Harga" text
    billContent += `<div style="margin-top: 20px;"></div>`;
    
    billContent += `<h4>Total Price: Rp${formatNumberWithCommas(totalAmount.toFixed(2))}</h4>`;

    
    return billContent;
}

function formatNumberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

