<?php

namespace Src\Customer\Application;

use Illuminate\Support\Facades\Hash;
use Src\Customer\Domain\DTOs\CreateCustomerDTO;
use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Customer\Presentation\Rest\ViewModels\RegisterViewModel;
use Src\User\Domain\ValueObjects\HashedPassword;
use Src\User\Domain\ValueObjects\PlainTextPassword;

class RegisterCustomer
{
    public function __construct(private readonly CustomerRepository $customerRepository)
    {
    }

    public function handle(RegisterViewModel $payload): Customer
    {
        $hashedPassword = $this->hashPassword($payload->password);

        $dto = new CreateCustomerDTO(
            $payload->fullName,
            $payload->email,
            $payload->cpf,
            $hashedPassword
        );

        return $this->customerRepository->create($dto);
    }

    private function hashPassword(PlainTextPassword $password): HashedPassword
    {
        $hashed = Hash::make((string) $password);

        return new HashedPassword($hashed);
    }
}
