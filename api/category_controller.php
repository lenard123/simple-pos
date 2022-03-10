<?php

require_once __DIR__.'/../_init.php';


//Delete category
if (get('action') === 'delete') {
    $id = get('id');
    $category = Category::find($id);

    if ($category){
        $category->delete();
        flashMessage('delete_category', 'Category deleted successfully', FLASH_SUCCESS);
    } else {
        flashMessage('delete_category', 'Invalid category', FLASH_ERROR);
    }
    redirect('../admin_category.php');
}


//Add category
if (post('action') === 'add') {

    $name = post('name');

    try {
        Category::add($name);
        flashMessage('add_category', 'Category added successfully.', FLASH_SUCCESS);
    } catch (Exception $ex) {
        flashMessage('add_category', $ex->getMessage(), FLASH_ERROR);
    }

    redirect('../admin_category.php');
}


//Update category

if (post('action') === 'update') {
    $name = post('name');
    $id = post('id');

    try {
        $category = Category::find($id);
        $category->name = $name;
        $category->update();
        flashMessage('update_category', 'Category updated successfully.', FLASH_SUCCESS);
        redirect('../admin_category.php');
    } catch (Exception $ex) {
        flashMessage('update_category', $ex->getMessage(), FLASH_ERROR);
        redirect("../admin_category.php?action=update&id={$id}");
    }
}