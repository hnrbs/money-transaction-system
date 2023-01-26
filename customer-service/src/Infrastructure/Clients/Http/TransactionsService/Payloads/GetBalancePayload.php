<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Payloads;

use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Infrastructure\Clients\Http\Constraints\RequestPayload;

class GetBalancePayload implements TransactionServicePayload
{
    public function __construct(public readonly CustomerId $customerId)
    {
    }

    public function jsonSerialize(): array
    {
        /** @var string $provider */
        $provider = config('services.current_service_name');

        return [
            'provider_id' => (string) $this->customerId,
            'provider' => $provider
        ];
    }
}
