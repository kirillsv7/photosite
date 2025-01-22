<?php

namespace Source\MediaFile\Infrastructure\Services;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\DecoderInterface;
use Intervention\Image\Interfaces\DriverInterface;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ImageManagerInterface;

final class InterventionImageManager implements ImageManagerInterface
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    public function create(int $width, int $height): ImageInterface
    {
        return $this->imageManager->create($width, $height);
    }

    public function read(mixed $input, array|string|DecoderInterface $decoders = []): ImageInterface
    {
        return $this->imageManager->read($input, $decoders);
    }

    public function animate(callable $init): ImageInterface
    {
        return $this->imageManager->animate($init);
    }

    public function driver(): DriverInterface
    {
        return $this->imageManager->driver();
    }
}
