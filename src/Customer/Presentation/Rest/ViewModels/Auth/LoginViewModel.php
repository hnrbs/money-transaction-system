<?php

namespace Src\Customer\Presentation\Rest\ViewModels\Auth;

use Src\User\Domain\Exceptions\InvalidParameterException;
use Src\User\Domain\ValueObjects\Email;
use Src\User\Domain\ValueObjects\PlainTextPassword;

class LoginViewModel
{
    public function __construct(
        public readonly Email $email,
        public readonly PlainTextPassword $password,
    ) {
    }

    /**
     * @param  array<string, string>  $payload
     *
     * @throws InvalidParameterException
     */
    public static function fromRequest(array $payload): self
    {
        return new self(
            new Email($payload['email']),
            new PlainTextPassword($payload['password'])
        );
    }
}
