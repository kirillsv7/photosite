<?php

namespace Source\Slug\Domain\Enums;

use JsonSerializable;
use Source\Shared\Enums\Contracts\EnumFromName;
use Source\Shared\Enums\Contracts\EnumToArray;
use Source\Shared\Enums\Traits\UseEnumFromNameTrait;
use Source\Shared\Enums\Traits\UseEnumToArrayTrait;
use Source\Shared\Enums\Traits\UseNonBackedEnumSerializableTrait;

enum SluggableTypeEnum implements EnumFromName, EnumToArray, JsonSerializable
{
    use UseEnumFromNameTrait;
    use UseEnumToArrayTrait;
    use UseNonBackedEnumSerializableTrait;

    case Category;
    case Photo;
}
