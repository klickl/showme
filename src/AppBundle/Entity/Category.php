<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 02/08/2016
 * Time: 19:29
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;

    /**
     * @ORM\Column(name="description", type="string", length=100)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent", cascade={"remove"})
     */
    protected $children;


    /**
     * @ORM\OneToMany(targetEntity="Show", mappedBy="category")
     */
    protected $shows;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->shows = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\AppBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\AppBundle\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\Category $child
     */
    public function removeChild(\AppBundle\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add show
     *
     * @param \AppBundle\Entity\Show $show
     *
     * @return Category
     */
    public function addShow(\AppBundle\Entity\Show $show)
    {
        $this->shows[] = $show;

        return $this;
    }

    /**
     * Remove show
     *
     * @param \AppBundle\Entity\Show $show
     */
    public function removeShow(\AppBundle\Entity\Show $show)
    {
        $this->shows->removeElement($show);
    }

    /**
     * Get shows
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShows()
    {
        return $this->shows;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function hasChildren()
    {
        return sizeof($this->children) > 0;
    }

    public function isParent()
    {
        return $this->parent == null;
    }

    public function hasShows()
    {
        return sizeof($this->shows) > 0;
    }

    public function hasChildrenShows()
    {
        $result = false;

        if($this->isParent()){
            foreach($this->children as $child)
            {
                $result = $result || $child->hasShows();
            }
        }
        return $result;
    }
}
