<?php
class Bookmark {
    private $db;
    private $table = "bookmarks";
    private $id;
    private $url;
    private $title;
    private $dateAdded;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // setters
    public function setId(int $id): void       { $this->id    = $id; }
    public function setUrl(string $u): void    { $this->url   = $u; }
    public function setTitle(string $t): void  { $this->title = $t; }

    // getters
    public function getId(): int               { return $this->id; }
    public function getUrl(): string           { return $this->url; }
    public function getTitle(): string         { return $this->title; }
    public function getDateAdded(): string     { return $this->dateAdded; }

    public function create(): bool {
        $sql = "INSERT INTO {$this->table} (url,title,date_added)
                VALUES(:url,:title,now())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":url",   $this->url);
        $stmt->bindParam(":title", $this->title);
        return $stmt->execute();
    }

    public function readAll(): PDOStatement {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY date_added DESC");
        $stmt->execute();
        return $stmt;
    }

    public function readOne(): bool {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=:id LIMIT 1");
        $stmt->bindParam(":id", $this->id);
        if(!$stmt->execute() || $stmt->rowCount()!==1) return false;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->url       = $row['url'];
        $this->title     = $row['title'];
        $this->dateAdded = $row['date_added'];
        return true;
    }

    public function update(): bool {
        $sql = "UPDATE {$this->table}
                SET url=:url, title=:title
                WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":url",   $this->url);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":id",    $this->id);
        return $stmt->execute();
    }

    public function delete(): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id=:id");
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
?>