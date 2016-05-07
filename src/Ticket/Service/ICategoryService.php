<?php
namespace Ticket\Service;

use Ticket\Entity\Category;
use Ticket\Exception\EntityNotFoundException;

interface ICategoryService {

    public function getAll();
    public function getCategoryById($id);
    public function createCategory(Category $category);
    public function updateCategory(Category $category);
    public function countAll();

}
