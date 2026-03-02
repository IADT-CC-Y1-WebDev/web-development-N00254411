<?php

class Format {
    public $id;
    public $name;
    public $manufacturer;

    private $db;

    public function __construct($data = []) {
        $this->db = DB::getInstance()->getConnection();

        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->manufacturer = $data['manufacturer'] ?? null;
        }
    }

    // Find all formats
    public static function findAll() {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM formats ORDER BY name");
        $stmt->execute();

        $formats = [];
        while ($row = $stmt->fetch()) {
            $formats[] = new Format($row);
        }

        return $formats;
    }

    // Find format by ID
    public static function findById($id) {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM formats WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        if ($row) {
            return new Format($row);
        }

        return null;
    }

    // Find formats by game (requires JOIN with book_format table)
    public static function findByGame($bookid) {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT f.*
            FROM formats f
            INNER JOIN book_format gp ON f.id = gp._id
            WHERE gp.book_id = :book_id
            ORDER BY f.name
        ");
        $stmt->execute(['book_id' => $bookid]);

        $formats = [];
        while ($row = $stmt->fetch()) {
            $formats[] = new Format($row);
        }

        return $formats;
    }
    
    // Convert to array for JSON output
    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'manufacturer' => $this->manufacturer
        ];
    }
}
