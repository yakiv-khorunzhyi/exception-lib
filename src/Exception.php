<?php

declare(strict_types=1);

namespace Lib;

class Exception extends \Exception
{
    /** @var array */
    private $data;

    ////////////////////////////////////////////////////////////////

    public function __construct(string $message = '', array $replacements = [], array $data = [])
    {
        $formattedMessage = $this->interpolate($message, $replacements);
        $this->data       = $data;
        parent::__construct($formattedMessage, $this->code);
    }

    ////////////////////////////////////////////////////////////////

    public function getData(): array
    {
        return $this->data;
    }

    ////////////////////////////////////////////////////////////////

    public function toArray(): array
    {
        return [
            'code'    => $this->getCode(),
            'message' => $this->getMessage(),
            'file'    => $this->getFile(),
            'line'    => $this->getLine(),
            'data'    => $this->getData(),
            'trace'   => $this->getTrace(),
        ];
    }

    ////////////////////////////////////////////////////////////////

    private function interpolate(string $message, array $replacements = []): string
    {
        $replace = [];
        foreach ($replacements as $fieldName => $value) {
            $replace["{{$fieldName}}"] = $value;
        }

        return strtr($message, $replace);
    }

    ////////////////////////////////////////////////////////////////
}
