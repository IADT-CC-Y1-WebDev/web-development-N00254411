<?php

class Book {
    public $id;
    public $title;
    public $author;
    public $year;
    public $isbn;
    public $format_ids;
    public $description;
    public $cover_filename;

    private $db;

    public function __construct($data = []) {
        $this->db = DB::getInstance()->getConnection();

        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->title = $data['title'] ?? null;
            $this->author = $data['author'] ?? null;
            $this->year = $data['year'] ?? null;
            $this->isbn = $data['isbn'] ?? null;
            $this->format_ids = $data['format_ids'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->cover_filename = $data['cover_filename'] ?? null;
        }
    }

    // Find all books
    public static function findAll() {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM books ORDER BY title");
        $stmt->execute();

        $books = [];
        while ($row = $stmt->fetch()) {
            $books[] = new Book($row);
        }

        return $books;
    }

    // Find book by ID
    public static function findById($id) {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        if ($row) {
            return new Book($row);
        }

        return null;
    }

    // // Find games by genre
    // public static function findByGenre($genreId) {
    //     $db = DB::getInstance()->getConnection();
    //     $stmt = $db->prepare("SELECT * FROM books WHERE format_ids = :format_ids ORDER BY title");
    //     $stmt->execute(['format_ids' => $format_ids]);

    //     $books = [];
    //     while ($row = $stmt->fetch()) {
    //         $books[] = new Book($row);
    //     }

    //     return $books;
    // }

    // // Find games by platform (requires JOIN with GamePlatforms table)
    public static function findByPlatform($formatId) {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT g.*
            FROM games g
            INNER JOIN BookFormat gp ON g.id = gp.book_id
            WHERE gp.format_id = :format_id
            ORDER BY g.title
        ");
        $stmt->execute(['format_id' => $formatId]);

        $books = [];
        while ($row = $stmt->fetch()) {
            $books[] = new book($row);
        }

        return $books;
    }

    // Save (insert or update)
    public function save() {
        if ($this->id) {
            // Update existing record
            $stmt = $this->db->prepare("
                UPDATE books
                SET title = :title,
                    author= :author
                    publisher_id = :publisher_id,
                    year = :year,
                    isbn = :isbn
                    format_ids = :format_ids
                    description = :description,
                    cover_filename = :cover_filename
                WHERE id = :id
            ");

            $params = [
                'title' => $this->title,
                'author' => $this-> author,
                'publisher_id' => $this->publisher_id,
                'year' => $this->year,
                'isbn'=>$this->isbn,
                'format_ids'=>$this ->format_ids,
                'description' => $this->description,
                'cover_filename' => $this->cover_filename,
                'id' => $this->id
            ];
        } 
        else {
            // Insert new record
            $stmt = $this->db->prepare("
                INSERT INTO books (title, author, publisher_id, year, isbn, format_id, description, cover_filename)
                VALUES (:title, :author, :publisher_id, :year, :isbn, :format_ids, :description, :cover_filename)
            ");

            $params = [
                'title' => $this->title,
                'author' => $this-> author,
                'publisher_id' => $this->publisher_id,
                'year' => $this->year,
                'isbn'=>$this->isbn,
                'format_ids'=>$this ->format_ids,
                'description' => $this->description,
                'cover_filename' => $this->cover_filename
            ];
        }
        // Execute statement
        $status = $stmt->execute($params);

        // Check for errors
        if (!$status) {
            $error_info = $stmt->errorInfo();
            $message = sprintf(
                "SQLSTATE error code: %d; error message: %s",
                $error_info[0],
                $error_info[2]
            );
            throw new Exception($message);  
        }

        // Ensure one row affected
        if ($stmt->rowCount() !== 1) {
            throw new Exception("Failed to save book.");
        }

        // Set ID for new records
        if ($this->id === null) {
            $this->id = $this->db->lastInsertId();
        }
    }

    // Delete
    public function delete() {
        if (!$this->id) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM books WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }

    // Convert to array for JSON output
    public function toArray() {
        return [
            'title' => $this->title,
            'author' => $this-> author,
            'publisher_id' => $this->publisher_id,
            'year' => $this->year,
            'isbn'=>$this->isbn,
            'format_ids'=>$this ->format_ids,
            'description' => $this->description,
            'cover_filename' => $this->cover_filename,
            'id' => $this->id
        ];
    }
}
