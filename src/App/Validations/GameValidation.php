<?php

namespace App\Validations;

use Aura\Filter\FilterFactory;

class GameValidation
{
    private $filter;

    public function __construct()
    {
        $this->filter = (new FilterFactory)->newSubjectFilter();
    }

    public function valid(array $data): bool
    {
        $this->filter->validate('sizeField')
            ->isNotBlank()
            ->is('int')
            ->is('min', 5)
            ->setMessage('Размерность поля не должна быть меньше 5 и должно быть числом');

        $this->filter->validate('duration')
            ->isNotBlank()
            ->is('int')
            ->is('min', 1)
            ->setMessage('Длительность наблюдения не должно быть меньше 1 и должно быть числом');

        return $this->filter->apply($data);
    }

    public function getMessages(): array
    {
        $failures = $this->filter->getFailures();
        return $failures->getMessages();
    }
}