<?php

class Photo {

    private int $id;
    private string $name;
    private string $path;
    private string $description;

    public function __construct(int $id, string $name, string $path, string $description) {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
