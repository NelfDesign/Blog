<?php

namespace App\Blog\Table;

use App\Blog\Entity\Post;
use Framework\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;

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
     * @param int $perPage
     * @param int $currentPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage):Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            'SELECT * FROM posts ORDER BY created_at DESC ',
            'SELECT COUNT(id) FROM posts',
            Post::class
        );
        return (new Pagerfanta($query))
                ->setMaxPerPage($perPage)
                ->setCurrentPage($currentPage);
    }

    /**
     * récupére un article à propos d'un id
     * @param int $id
     * @return Post|null
     */
    public function find(int $id): ?Post
    {
        $req = $this->pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $req->execute([$id]);
        $req->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $req->fetch() ?: null;
    }
}
