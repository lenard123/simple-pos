<?php
//Guard
require_once '_guards.php';
Guard::adminOnly();

$products = Product::all();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Point of Sale System :: Home</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">
    
    <!-- Datatables  Library -->
    <link rel="stylesheet" type="text/css" href="./css/datatable.css">
    <script src="./js/datatable.js"></script>
    <script src="./js/main.js"></script>

</head>
<body>

    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main>
            <div class="wrapper w-60p">
                <span class="subtitle">Product List</span>
                <hr/>

                <?php displayFlashMessage('delete_product') ?>
                <?php displayFlashMessage('add_stock') ?>

                <table id="productsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Stocks</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?= $product->name ?></td>
                                <td><?= $product->category->name ?></td>
                                <td><?= $product->quantity ?></td>
                                <td><?= $product->price ?></td>
                                <td>
                                    <a href="#" onclick="addStock(<?= $product->id ?>)" class="text-green-300">Add Stock</a>
                                    <a href="admin_update_item.php?id=<?= $product->id ?>" class="text-primary ml-16">Update</a>
                                    <a href="api/product_controller.php?action=delete&id=<?= $product->id ?>" class="text-red-500 ml-16">Delete</a>
                                </td>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </main>
    </div>

<script type="text/javascript">
var dataTable = new simpleDatatables.DataTable("#productsTable")
</script>


</body>
</html>