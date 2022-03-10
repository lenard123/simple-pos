<?php
//Guard
require_once '_guards.php';
Guard::adminOnly();

$product = Guard::hasModel(Product::class);
$categories = Category::all();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Point of Sale System :: Update Product</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">
</head>
<body>

    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main>
            <div class="wrapper">
                <div class="w-40p">
                    <div class="subtitle">Update Product</div>
                    <hr/>

                    <div class="card">
                        <div class="card-content">
                            <form method="POST" action="api/product_controller.php?action=update&id=<?= $product->id ?>">

                                <?php displayFlashMessage('update_product') ?>

                                <div class="form-control">
                                    <label>Name</label>
                                    <input 
                                        value="<?= $product->name ?>" 
                                        type="text" 
                                        name="name" 
                                        required="" 
                                    />
                                </div>

                                <div class="form-control mt-16">
                                    <label>Category</label>
                                    <select name="category_id" required="">
                                        <option value=""> -- Select Category --</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option 
                                                value="<?= $category->id ?>"
                                                <?= $category->id === $product->category_id ? 'selected' : '' ?>
                                                ><?= $category->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-control mt-16">
                                    <label>Price</label>
                                    <input 
                                        value="<?= $product->price ?>" 
                                        required="" 
                                        type="number" 
                                        step=".25" 
                                        name="price" 
                                    />
                                </div>

                                <div class="mt-16">
                                    <button class="btn btn-primary w-full" type="submit">Update Product</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>
</html>