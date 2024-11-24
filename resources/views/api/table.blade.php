@extends('layouts.layout')

    @section('content')
    <h1>Products List</h1>
    <table id="productsTable" class="datatable align-middle table table-light table-striped w-100 border">
        <thead>
            <tr class="border">
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        // Fetch data using Axios
        axios.get('/api/products')
            .then(function (response) {
                const products = response.data;
                const tableBody = document.querySelector('#productsTable tbody');

                products.forEach(function(product) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${product.name}</td>
                        <td>${product.price}</td>
                        <td>${product.description}</td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(function (error) {
                console.error('Error fetching products:', error);
            });
    </script>
@endsection
