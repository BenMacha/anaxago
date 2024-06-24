<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Index(name: 'FK__TASK__USER_ID', columns: ['user_id'])]
#[ORM\HasLifecycleCallbacks]
class Task
{
    use TimestampedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Column]
    protected ?int $id = null;

    #[Assert\NotBlank]
    #[Column(length: 255, nullable: false)]
    protected ?string $title = null;

    #[Assert\NotBlank]
    #[Column(type: Types::TEXT, nullable: false)]
    protected ?string $description = null;

    #[Assert\NotBlank]
    #[Column(type: Types::STRING, enumType: Status::class, nullable: false)]
    protected ?Status $status;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
    protected ?User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
