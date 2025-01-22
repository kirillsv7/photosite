<?php

namespace Source\Category\Interface\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Source\Category\Interface\DTOs\CategoryStoreRequestDTO;
use Source\Shared\Requests\Contracts\RequestWithDTO;
use Source\Shared\ValueObjects\StringValueObject;

final class CategoryStoreRequest extends FormRequest implements RequestWithDTO
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:255'],
            'image' => ['file'],
        ];
    }

    public function getDTO(): CategoryStoreRequestDTO
    {
        return new CategoryStoreRequestDTO(
            title: StringValueObject::fromString($this->validated('title')),
            description: $this->validated('description')
                ? StringValueObject::fromString($this->validated('description'))
                : null,
            image: $this->validated('image')
        );
    }
}
