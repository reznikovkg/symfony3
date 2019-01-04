<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    public $id_label = "Идентификатор";

    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;
    public $name_label = "Название";

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product\Category")
     * @ORM\JoinColumn(name="parent_category", referencedColumnName="id", nullable=true)
     */
    private $parentCategory;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Product\Category", mappedBy="parentCategory")
     */
    private $subcategories;
    public $subcategories_label = "Подкатегории";

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * @param mixed $parentCategory
     */
    public function setParentCategory($parentCategory)
    {
        $this->parentCategory = $parentCategory;
    }

    /**
     * @return mixed
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * @param mixed $subcategories
     */
    public function setSubcategories($subcategories)
    {
        $this->subcategories = $subcategories;
    }



}
