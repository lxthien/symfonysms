<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ProductCat
 *
 * @ORM\Table(name="productcats")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductCatRepository")
 * @Vich\Uploadable
 */
class ProductCat
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
     * One Category has Many Categories.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductCat", mappedBy="parentcat")
     */
    protected $children;

    /**
     * Many Categories have One Category.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProductCat", inversedBy="children")
     * @ORM\JoinColumn(name="parentcat_id", referencedColumnName="id", nullable=true)
     */
    private $parentcat;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = null;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean")
     */
    private $enable = true;

    /**
     * @var string
     *
     * @ORM\Column(name="images", type="string", length=255, nullable=true)
     */
    private $images;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="images")
     * @var File
     */
    private $imageFile;

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

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var Product[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Product", mappedBy="productCats")
     */
    protected $products;


    public function __construct()
    {
        $this->parentcat = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     * @return ProductCat
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
     * Set parentcat
     *
     * @param ProductCat $parent
     * @return ProductCat
     */
    public function setParentcat(\AppBundle\Entity\ProductCat $parent = null) {
        $this->parentcat = $parent;

        return $this;
    }

    /**
     * Get parentcat
     *
     * @return ProductCat
     */
    public function getParentcat() {
        return $this->parentcat != null ? $this->parentcat : 'root';
    }

    /**
     * Get children
     *
     * @return ProductCat
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return ProductCat
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
     * Set description
     *
     * @param string $description
     * @return ProductCat
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

    /**
     * Set enable
     *
     * @param \boolean $enable
     * @return ProductCat
     */
    public function setEnable($enable)
    {
        $this->enable = (bool) $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return \boolean
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Set imageFile file
     *
     * @param File $imageFile
     * @return ProductCat
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return string
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set images
     *
     * @param string $images
     * @return ProductCat
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set pageTitle
     *
     * @param string $pageTitle
     * @return ProductCat
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
     * @return ProductCat
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
     * @return ProductCat
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ProductCat
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
     * @return ProductCat
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

    /**
     * Set Author
     * @param User $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * Get Author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}