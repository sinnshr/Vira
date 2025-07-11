<?php
declare(strict_types=1);
require_once 'db.php';

class Book
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = dbConnect();
    }

    public function getAllBooks(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE book_id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function addBook(string $title, string $author, string $description, float $price): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO books (title, author, description, price) VALUES (:title, :author, :description, :price)");
        return $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':description' => $description,
            ':price' => $price
        ]);
    }

    public function updateBook(int $id, string $title, string $author, string $description, float $price): bool
    {
        $stmt = $this->pdo->prepare("UPDATE books SET title = :title, author = :author, description = :description, price = :price WHERE book_id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':description' => $description,
            ':price' => $price
        ]);
    }

    public function deleteBook(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE book_id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>