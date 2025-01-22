<?php

namespace Source\Slug\Infrastructure\Services;

use Illuminate\Support\Facades\DB;
use Source\Slug\Domain\ValueObjects\SlugString;

class SlugGenerator
{
    public function generateUniqueSlug(SlugString $slugString): SlugString
    {
        $slugs = DB::table('slugs')
            ->where('slug', 'LIKE', $slugString->toPrimitive().'%')
            ->pluck('slug');

        $newSlug = $slugString->toPrimitive();

        $counter = 1;

        while ($slugs->contains($newSlug)) {
            $newSlug = $slugString->toPrimitive().'-'.$counter;

            $counter++;
        }

        return SlugString::fromString($newSlug);
    }
}
