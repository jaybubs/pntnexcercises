<?php

namespace Ijdb\Entity;
use Ninja\DbTable;

/**
 * Class Category
 * @author yourname
 */
class Category
{
    public $id;
    public $name;
    private $jokesTable;
    private $jokeCategoriesTable;

    /**
     * @param DbTable $jokesTable
     * @param DbTable $jokeCategoriesTable
     */
    public function __construct(DbTable $jokesTable, DbTable $jokeCategoriesTable)
    {
        $this->jokesTable = $jokesTable;
        $this->jokeCategoriesTable = $jokeCategoriesTable;
    }

    public function getJokes()
    {
        $jokeCategories = $this->jokeCategoriesTable->find('categoryId', $this->id);
        $jokes = [];

        foreach ($jokeCategories as $jokeCategory) {
            $joke = $this->jokesTable->findById($jokeCategory->jokeId);
            if ($joke) {
                $jokes[] = $joke;
            }
        }
        return $jokes;
    }
    
}
