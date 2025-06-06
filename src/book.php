<?php
require_once 'db.php';

class Book {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = dbConnect();
    }

    public function getAllBooks() {
        $query = "SELECT * FROM books";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookById($id) {
        $query = "SELECT * FROM books WHERE book_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addBook($title, $author, $description, $price) {
        $query = "INSERT INTO books (title, author, description, price) VALUES (:title, :author, :description, :price)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function updateBook($id, $title, $author, $description, $price) {
        $query = "UPDATE books SET title = :title, author = :author, description = :description, price = :price WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function deleteBook($id) {
        $query = "DELETE FROM books WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>