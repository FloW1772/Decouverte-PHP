 <?php
 namespace App\Entity;
 use App\Repository\WishRepository;
 use Doctrine\DBAL\Types\Types;
 use Doctrine\ORM\Mapping as ORM;
 #[ORM\Entity(repositoryClass: WishRepository::class)]
 class Wish
 {
 }
 #[ORM\Id]
 #[ORM\GeneratedValue]
 #[ORM\Column]
 private ?int $id = null;
 #[ORM\Column(length: 250)]
 private ?string $title = null;
 #[ORM\Column(type: Types::TEXT, nullable: true)]
 private ?string $description = null;
 #[ORM\Column(length: 50)]
 private ?string $author = null;
 #[ORM\Column]
 private ?bool $isPublished = null;
 #[ORM\Column(nullable: true)]
 private ?\DateTimeImmutable $dateCreated = null;
 #[ORM\Column]
 private ?\DateTimeImmutable $dateUpdated = null;
 // ... getters/setters ...
 #[ORM\Entity(repositoryClass: WishRepository::class)]
 class Wish
 {
 }
 // ...
 public function __construct()
 {
 $this->isPublished = false;
 $this->dateCreated = new \DateTimeImmutable();
 }
 // ..