<?php

class Photo {

    private string $name;
    private string $path;
    private string $description;

    public function __construct(string $name, string $path, string $description)
    {
        $this->name = $name;
        $this->path = $path;
        $this->description = $description;
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
