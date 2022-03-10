<?php

require_once __DIR__.'/../_init.php';

class Product 
{
    public $id;
    public $name;
    public $category_id;
    public $quantity;
    public $price;
    public $category;

    public function __construct($product)
    {
        $this->category = $this->getCategory($product);
        $this->id = $product['id'];
        $this->name = $product['name'];
        $this->category_id = $product['category_id'];
        $this->quantity = intval($product['quantity']);
        $this->price = floatval($product['price']);
    }

    public function update()
    {
        global $connection;

        $stmt = $connection->prepare('UPDATE products SET name=:name, category_id=:category_id, quantity=:quantity, price=:price WHERE id=:id');
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('category_id', $this->category_id);
        $stmt->bindParam('quantity', $this->quantity);
        $stmt->bindParam('price', $this->price);
        $stmt->bindParam('id', $this->id);
        $stmt->execute();
    }

    public function delete() {
        global $connection;

        $stmt = $connection->prepare('DELETE FROM `products` WHERE id=:id');
        $stmt->bindParam('id', $this->id);
        $stmt->execute();
    }

    private function getCategory($product)
    {
        if (isset($product['category_name'])) {
            return new Category([
                'id' => $product['category_id'],
                'name' => $product['category_name']
            ]);
        }

        return Category::find($product['category_id']);
    }

    public static function all()
    {
        global $connection;

        $stmt = $connection->prepare('SELECT products.*, categories.name as category_name FROM products INNER JOIN categories ON products.category_id = categories.id');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        $result = array_map(fn($item) => new Product($item), $result);

        return $result;
    }

    public static function find($id)
    {
        global $connection;

        $stmt = $connection->prepare('SELECT products.*, categories.name as category_name FROM products INNER JOIN categories ON products.category_id = categories.id WHERE products.id=:id');
        $stmt->bindParam('id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return new Product($result[0]);
        }

        return null;
    }

    public static function add($name, $category_id, $quantity, $price)
    {
        global $connection;

        $sql_command = 'INSERT INTO products (name, category_id, quantity, price) VALUES (:name, :category_id, :quantity, :price)';
        $stmt = $connection->prepare($sql_command);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('category_id', $category_id);
        $stmt->bindParam('quantity', $quantity);
        $stmt->bindParam('price', $price);
        $stmt->execute();
    }
}