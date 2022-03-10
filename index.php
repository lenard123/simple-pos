<?php
//Guard
require_once '_guards.php';
Guard::cashierOnly();

$products = Product::all();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Point of Sale System :: Home</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/cashier.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">

    <script src="./js/main.js"></script>
    <script src="./js/cashier.js"></script>
    
    <!-- Datatables  Library -->
    <link rel="stylesheet" type="text/css" href="./css/datatable.css">
    <script src="./js/datatable.js"></script>

    <!-- AlpineJS Library -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body>

    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main x-data='products(<?= json_encode($products) ?>)'>
            <div class="flex h-full">
                <div class="products">
                    <div class="subtitle">Products</div>
                    <hr/>

                    <?php displayFlashMessage('transaction') ?>

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
                                    <a @click="addToCart(<?= $product->id ?>)" href="#" class="text-green-300">Add Product</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="forms">
                    <div class="flex flex-col h-full">
                        <div>
                            <div class="subtitle">Customer Orders</div>
                            <hr/>
                        </div>

                        <div id="cardItemsContainer" class="flex-grow" style="overflow-y: auto;">
                            <template x-for="cart in carts">
                                <div class="cart-item">
                                    <span class="left" x-text="cart.product.name"></span>
                                    <div class="middle">
                                        <div class="cart-item-buttons">
                                            <button @click="subtractQuantity(cart)">-</button>
                                            <span x-text="cart.quantity"></span>
                                            <button @click="addQuantity(cart)">+</button>
                                        </div>
                                    </div>
                                    <span class="right" x-text="(cart.quantity * cart.product.price) + 'PHP'"></span>
                                </div>                                
                            </template>
                        </div>

                        <form action="api/cashier_controller.php" method="POST" @submit="validate">

                            <input type="hidden" name="action" value="proccess_order">

                            <template x-for="(cart,i) in carts" :key="cart.product.id">
                                <div>
                                    <input type="hidden" :name="`cart_item[${i}][id]`" :value="cart.product.id">
                                    <input type="hidden" :name="`cart_item[${i}][quantity]`" :value="cart.quantity">
                                </div>
                            </template>

                            <div>
                                <span>Total Price: </span>
                                <span class="font-bold" x-text="totalPrice + 'php'"></span>
                            </div>
                            <div class="flex align-center gap-16">
                                <span>Payment: </span>
                                <div class="form-control flex-grow">
                                    <input type="number" x-model="payment" step="0.25" name=""/>
                                </div>
                                <button type="button" @click="calculateChange" class="btn btn-outlined">Calculate Change</button>
                            </div>
                            <div>
                                <span>Change: </span>
                                <span class="font-bold" x-ref="change">--</span>
                            </div>
                            <button class="btn btn-primary mt-16 w-full">Proccess Order</button>
                        </form>

                    </div>
                </div>
            </div>
        </main>
    </div>

<script type="text/javascript">
var dataTable = new simpleDatatables.DataTable("#productsTable")
</script>


</body>
</html>