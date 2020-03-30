<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * One Product has Many Categories
     * @var ProductCat[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ProductCat", inversedBy="products")
     * @ORM\JoinTable(
     *  name="product_productcat",
     *  joinColumns={
     *      @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="productcat_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $productCat;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "The name must be at least {{ limit }} characters long",
     *      maxMessage = "The name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean")
     */
    private $enable = true;

    /**
     * @var string
     *
     * @ORM\Column(name="pageTitle", type="string", length=255, nullable=true)
     */
    private $pageTitle = null;

    /**
     * @var string
     *
     * @ORM\Column(name="pageDescription", type="text", nullable=true)
     */
    private $pageDescription = null;

    /**
     * @var string
     *
     * @ORM\Column(name="pageKeyword", type="string", length=255, nullable=true)
     */
    private $pageKeyword = null;

    /**
     * @var int
     *
     * @ORM\Column(name="viewCounts", type="integer")
     */
    private $viewCounts = 0;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime") 
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;


    public function __toString()
    {
        return $this->getName();
    }


    public function __construct()
    {
        $this->productCat = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ProductCat[]
     */
    public function addProductCat(ProductCat $productCat)
    {
        if (!$this->productCat->contains($productCat)) {
            $this->productCat->add($productCat);
        }
    }

    /**
     * @return ProductCat[]
     */
    public function removeProductCat(ProductCat $productCat)
    {
        $this->productCat->removeElement($productCat);
    }

    /**
     * @return \AppBundle\Entity\ProductCat
     */
    public function getProductCat()
    {
        return $this->productCat;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * Set url
     *
     * @param string $url
     *
     * @return Product
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set enable
     *
     * @param bool $enable
     * @return Product
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return bool
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Set pageTitle
     *
     * @param string $pageTitle
     * @return Product
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get pageTitle
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set pageDescription
     *
     * @param string $pageDescription
     * @return Product
     */
    public function setPageDescription($pageDescription)
    {
        $this->pageDescription = $pageDescription;

        return $this;
    }

    /**
     * Get pageDescription
     *
     * @return string
     */
    public function getPageDescription()
    {
        return $this->pageDescription;
    }

    /**
     * Set pageKeyword
     *
     * @param string $pageKeyword
     * @return Product
     */
    public function setPageKeyword($pageKeyword)
    {
        $this->pageKeyword = $pageKeyword;

        return $this;
    }

    /**
     * Get pageKeyword
     *
     * @return string
     */
    public function getPageKeyword()
    {
        return $this->pageKeyword;
    }

    /**
     * Set viewCounts
     *
     * @param \int $viewCounts
     * @return Product
     */
    public function setViewCounts($viewCounts)
    {
        $this->viewCounts = $viewCounts;

        return $this;
    }

    /**
     * Get viewCounts
     *
     * @return int
     */
    public function getViewCounts()
    {
        return $this->viewCounts;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set author
     *
     * @param User $author
     *
     * @return Product
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}