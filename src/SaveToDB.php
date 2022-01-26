<?php

use Components\ApiClient;
use Components\DbConnection;
use GuzzleHttp\Exception\GuzzleException;

class SaveToDB
{
    private ApiClient $ApiClient;
    private PDO $pdo;

    public function __construct()
    {
        $this->ApiClient = new ApiClient();
        $this->pdo = DbConnection::getInstance();
    }

    /**
     * @throws GuzzleException
     */
    public function save()
    {
        try {
            $products = $this->getProducts();
            foreach ($products as $product) {
                $this->addProduct($product);
            }
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function addProduct($product): bool
    {
        $sql = $this->pdo->prepare('INSERT INTO products (id, title, body, vendor, status, price) VALUES (:id, :title, :body, :vendor, :status, :price) 
ON DUPLICATE KEY UPDATE id = :id, title = :title, body = :body, vendor = :vendor, status = :status');
        $status = $sql->execute(['id' => $product->id, 'title' => $product->title, 'body' => $product->body_html, 'vendor' => $product->vendor, 'status' => $product->status, 'price' => (float)$product->variants[0]->price]);
        return $status;
    }

    /**
     * @throws GuzzleException
     */
    private function getProducts(): array
    {
        $response = $this->ApiClient->doRequest('GET', 'products.json');
        return $response->products;
    }
}