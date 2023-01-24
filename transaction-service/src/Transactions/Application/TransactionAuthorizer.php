<?php

namespace Src\Transactions\Application;

use Src\Infrastructure\Clients\Exceptions\InvalidURIException;
use Src\Infrastructure\Clients\Exceptions\RequestException;
use Src\Infrastructure\Clients\Exceptions\ResponseException;
use Src\Infrastructure\Clients\TransactionAuthorizer\Client;
use Src\Transactions\Domain\Entities\Transaction;

class TransactionAuthorizer
{
    public function __construct(
        private readonly Client $client,
        private readonly UpdateTransactionStatus $updateTransactionStatus
    ) {
    }

    public function handle(Transaction $transaction): bool
    {
        try {
            $this->client->authorize();
        } catch (ResponseException|InvalidURIException|RequestException) {
            $this->updateTransactionStatus->revertTransaction($transaction);

            return false;
        }

        $this->updateTransactionStatus->approveTransaction($transaction);

        return true;
    }
}
