<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Review Entity Class
 * 
 * Represents a user review for a template in the database.
 * This entity stores review data including title, description, date, and relationships.
 * 
 * @ORM\Entity - Marks this class as a Doctrine entity
 * @ORM\Table - Specifies the database table name (optional, defaults to class name)
 */
#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    /**
     * Primary key - Auto-generated unique identifier
     * 
     * @ORM\Id - Marks this field as the primary key
     * @ORM\GeneratedValue - Auto-increment the value
     * @ORM\Column - Maps to database column
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Review title - Short summary of the review
     * 
     * @ORM\Column - Maps to database column with length constraint
     * @Assert\NotBlank - Ensures field is not empty
     * @Assert\Length - Validates string length (min: 3, max: 255 characters)
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Review title cannot be blank')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Review title must be at least {{ limit }} characters long', maxMessage: 'Review title cannot be longer than {{ limit }} characters')]
    private ?string $title = null;

    /**
     * Review description - Detailed review content
     * 
     * @ORM\Column - Maps to database column with length constraint
     * @Assert\NotBlank - Ensures field is not empty
     * @Assert\Length - Validates string length (min: 10, max: 255 characters)
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Review description cannot be blank')]
    #[Assert\Length(min: 10, max: 255, minMessage: 'Review description must be at least {{ limit }} characters long', maxMessage: 'Review description cannot be longer than {{ limit }} characters')]
    private ?string $description = null;

    /**
     * Review date - When the review was created
     * 
     * @ORM\Column - Maps to database column with DATETIME type
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
     * Template relationship - Many reviews belong to one template
     * 
     * @ORM\ManyToOne - Many-to-one relationship
     * @ORM\JoinColumn - Specifies foreign key column (nullable: false means required)
     */
    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Template $template = null;

    /**
     * User relationship - Many reviews belong to one user
     * 
     * @ORM\ManyToOne - Many-to-one relationship
     * @ORM\JoinColumn - Specifies foreign key column (nullable: false means required)
     */
    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // ==================== GETTER METHODS ====================

    /**
     * Get the review ID
     * 
     * @return int|null - The review ID or null if not persisted
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the review title
     * 
     * @return string|null - The review title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Get the review description
     * 
     * @return string|null - The review description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the review date
     * 
     * @return \DateTimeInterface|null - The review creation date
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Get the associated template
     * 
     * @return Template|null - The template this review belongs to
     */
    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    /**
     * Get the user who wrote the review
     * 
     * @return User|null - The user who created this review
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    // ==================== SETTER METHODS ====================

    /**
     * Set the review title
     * 
     * @param string $title - The new title
     * @return static - Returns $this for method chaining
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set the review description
     * 
     * @param string $description - The new description
     * @return static - Returns $this for method chaining
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set the review date
     * 
     * @param \DateTimeInterface $date - The new date
     * @return static - Returns $this for method chaining
     */
    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Set the associated template
     * 
     * @param Template|null $template - The template to associate with
     * @return static - Returns $this for method chaining
     */
    public function setTemplate(?Template $template): static
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Set the user who wrote the review
     * 
     * @param User|null $user - The user to associate with
     * @return static - Returns $this for method chaining
     */
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }
}
