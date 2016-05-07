<?php
namespace Ticket\Service\Impl;

use Ticket\Service\ICategoryService;
use Doctrine\ORM\EntityManager;
use Ticket\Entity\Category;
use Ticket\Exception\EntityNotFoundException;

class CategoryServiceImpl implements ICategoryService {
	
	private $categoryRepository;
	private $entityManager;
	
	public function __construct(EntityManager $em) {
            $this->categoryRepository = $em->getRepository("Ticket\Entity\Category");
            $this->entityManager = $em;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Ticket\Service\ICategoryService::getAll()
	 */
	public function getAll() {
            return $this->categoryRepository->findAll();
	}

	/**
	 * {@inheritDoc}
	 * @see \Ticket\Service\ICategoryService::getCategoryById()
	 */
	public function getCategoryById($id) {
            return $this->categoryRepository->find($id);
	}

	/**
	 * {@inheritDoc}
	 * @see \Ticket\Service\ICategoryService::createCategory()
	 */
	public function createCategory(Category $category) {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            
            return $category;
	}

        /**
	 * {@inheritDoc}
	 * @see \Ticket\Service\ICategoryService::updateCategory()
	 */
	public function updateCategory(Category $category) {
            $this->entityManager->flush($category);
            return $category;
        }

        /**
	 * {@inheritDoc}
	 * @see \Ticket\Service\ICategoryService::countAll()
	 */
	public function countAll() {
            return $this->categoryRepository->count();
	}
}
