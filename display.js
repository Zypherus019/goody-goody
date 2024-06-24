$(document).ready(function() {
    loadProducts(1);
    
    // Handle image upload via AJAX
    $(document).on('submit', '.upload-form', function(event) {
        event.preventDefault(); // Prevent default form submission

        var formData = new FormData(this);
        var $form = $(this);
        
        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                if (response.success) {
                    // Reload products to show updated image
                    loadProducts(1);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status, error);
                alert('An error occurred during the upload.');
            }
        });
    });
});

function loadProducts(page) {
    var category = $('#category').val();
    $.ajax({
        url: 'display.php',
        type: 'GET',
        data: {
            page: page,
            category: category
        },
        dataType: 'json',
        success: function(response) {
            displayProducts(response.products);
            updatePagination(response.total_pages, response.current_page);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + status, error);
        }
    });
}

function displayProducts(products) {
    var container = $('#product-list');
    container.empty();

    products.forEach(function(product) {
        var imageSrc = 'images/' + product.name + '.jpg';
        var html = `
            <div class="col">
                <div class="card product-card">
                    <img src="${imageSrc}" class="card-img" alt="${product.name}" onerror="this.onerror=null; this.src='images/default.jpg';">
                    <div class="card-body">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text">Price: P${product.price}</p>
                        <p class="card-text">Quantity: <span id="quantity-${product.name}">${product.quantity}</span></p>
                        <button class="btn btn-danger" onclick="updateQuantity('${product.name}', -1, '${product.category}')">-</button>
                        <button class="btn btn-success" onclick="updateQuantity('${product.name}', 1, '${product.category}')">+</button>
                        <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
                            <input type="hidden" name="product_name" value="${product.name}">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <button type="submit" name="submit">Upload</button>
                        </form>
                    </div>
                </div>
            </div>`;
        container.append(html);
    });
}

function updatePagination(totalPages, currentPage) {
    var pagination = $('#pagination');
    pagination.empty();

    if (currentPage > 1) {
        pagination.append(`<a href="#" onclick="loadProducts(${currentPage - 1})">« Previous</a>`);
    }

    for (var page = 1; page <= totalPages; page++) {
        if (page === currentPage) {
            pagination.append(`<span class="active">${page}</span>`);
        } else {
            pagination.append(`<a href="#" onclick="loadProducts(${page})">${page}</a>`);
        }
    }

    if (currentPage < totalPages) {
        pagination.append(`<a href="#" onclick="loadProducts(${currentPage + 1})">Next »</a>`);
    }
}
