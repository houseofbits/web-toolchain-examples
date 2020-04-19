<?php
namespace Products\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_stock")
 */
class ProductStock
{
    //Product Stock Api request statuses
    const STATUS_UNDEFINED = 0;
    const STATUS_REQUEST_SENT = 1;
    const STATUS_REQUEST_SUCCESFUL = 2;
    const STATUS_REQUEST_FAILED = 3;

    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="Product", mappedBy="stock")
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @ORM\Column(type="integer")
     */
    protected $availableCount;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null|Product $product
     * @return ProductStock
     */
    public function setProduct(?Product $product): ProductStock
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return null|Product
     */
    public function getProduct():? Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getStatus():int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return ProductStock
     */
    public function setStatus(int $status): ProductStock
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getAvailableCount():int
    {
        return $this->availableCount;
    }

    /**
     * @param int $availableCount
     * @return ProductStock
     */
    public function setAvailableCount(?int $availableCount): ProductStock
    {
        $this->availableCount = $availableCount;
        return $this;
    }

    /**
     * @return array
     */
    public function getStatusKeys(): array
    {
        return [
            self::STATUS_UNDEFINED => 'Undefined status',
            self::STATUS_REQUEST_SENT => 'Stock request sent',
            self::STATUS_REQUEST_SUCCESFUL => 'Stock request successful',
            self::STATUS_REQUEST_FAILED => 'Stock request failed',
        ];
    }

    /**
     * @return string
     */
    public function getStatusKey(): string
    {
        $statuses = $this->getStatusKeys();
        return $statuses[$this->getStatus()] ?? '';
    }
}