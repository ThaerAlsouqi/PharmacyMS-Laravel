$(document).ready(function() {
    $('#outstock-product').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('products.outstock') }}",
        columns: [
            { data: 'name' },
            { data: 'category' },
            { data: 'price' },
            { data: 'quantity' },
            { data: 'discount', defaultContent: 'N/A' } // Ensure defaultContent is set for missing data
        ],
        order: [[1, 'asc']]
    });
});