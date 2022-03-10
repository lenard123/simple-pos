<?php
//Guard
require_once '_guards.php';
Guard::adminOnly();

//require_once 'api/category_controller.php';

$categories = Category::all();

$category = null;
if (get('action') === 'update') {
    $category = Category::find(get('id'));
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Point of Sale System :: Categories</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">

</head>
<body>

    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main>
            <div class="flex">
                <div class="category-form">
                    <span class="subtitle">
                        <?php if (get('action') === 'update') : ?>
                            Update Category
                        <?php else : ?>
                            New Category
                        <?php endif; ?>
                    </span>
                    <hr/>

                    <div class="card">
                        <div class="card-content">
                            <form method="POST" action="api/category_controller.php">

                                <input type="hidden" name="action" value="<?= get('action') === 'update' ? 'update' : 'add' ?>" />

                                <input type="hidden" name="id" value="<?= $category?->id ?>"/>

                                <div class="form-control">
                                    <label>Category Name</label>
                                    <input 
                                        value="<?= $category?->name ?>" 
                                        type="text" 
                                        name="name" 
                                        placeholder="Enter category name here" 
                                        required="true" 
                                    />
                                </div>

                                <div class="mt-16">
                                    <button class="btn btn-primary w-full" type="submit">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
                <div class="category-table">
                    <span class="subtitle">Category List</span>
                    <hr/>

                    <?php displayFlashMessage('add_category') ?>
                    <?php displayFlashMessage('delete_category') ?>
                    <?php displayFlashMessage('update_category') ?>

                    <table id="categoryTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($categories as $category) : ?>
                            <tr>
                                <td><?= $category->name ?></td>
                                <td>
                                    <a class="text-primary" href="?action=update&id=<?= $category->id ?>">Update</a>
                                    <a class="text-red-500 ml-16" href="api/category_controller.php?action=delete&id=<?= $category->id ?>">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </main>
    </div>
</body>
</html>