<?php

namespace Source\Category\Interface\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Source\Category\Interface\DTOs\CategoryStoreRequestDTO;
use Source\Shared\Requests\Contracts\RequestWithDTO;
use Source\Shared\ValueObjects\StringValueObject;

/**
 * @property-read  string $title
 * @property-read  string|null $description
 * @property-read  UploadedFile $image
 */
final class CategoryStoreRequest extends FormRequest implements RequestWithDTO
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'image' => ['file'],
        ];
    }

    public function getDTO(): CategoryStoreRequestDTO
    {
        return new CategoryStoreRequestDTO(
            title: StringValueObject::fromString($this->title),
            description: $this->validated('description')
                ? StringValueObject::fromString($this->description ?? '')
                : null,
            image: $this->image
        );
    }
}
