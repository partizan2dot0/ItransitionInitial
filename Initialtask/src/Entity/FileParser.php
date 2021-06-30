<?php

namespace App\Entity;

use App\Repository\FileParserRepository;
use Doctrine\ORM\Mapping as ORM;
use League\Csv\Reader;

/**
 * @ORM\Entity(repositoryClass=FileParserRepository::class)
 */
class FileParser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filePath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }
}



