<?php

namespace Source\Photo\Interface\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Source\Photo\Interface\DTOs\PhotoStoreRequestDTO;
use Source\Shared\Requests\Contracts\RequestWithDTO;
use Source\Shared\ValueObjects\StringValueObject;

/**
 * @property-read  string $title
 * @property-read  UploadedFile $image
 */
final class PhotoStoreRequest extends FormRequest implements RequestWithDTO
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'image' => ['required', 'file'],
        ];
    }

    public function getDTO(): PhotoStoreRequestDTO
    {
        return new PhotoStoreRequestDTO(
            title: $this->validated('title')
                ? StringValueObject::fromString($this->title)
                : null,
            image: $this->image
        );
    }
}
