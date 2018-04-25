<?php

namespace App\Blog\Table;

class PostTable
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {

        $this->pdo = $pdo;
    }

    /**
     * Pagine les articles
     * @return array
     */
    public function findPaginated():array
    {
        return $this->pdo->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 15')
            ->fetchAll();
    }

    /**
     * récupére un article à propos d'un id
     * @param int $id
     * @return \stdClass
     */
    public function find(int $id): \stdClass
    {
        $req = $this->pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $req->execute([$id]);
        return $req->fetch();
    }
}
