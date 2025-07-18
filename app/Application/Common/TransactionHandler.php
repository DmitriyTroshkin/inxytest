<?php
namespace App\Application\Common;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TransactionHandler
{
    private int $maxAttempts;
    private int $delayMs;

    public function __construct(int $maxAttempts = 3, int $delayMs = 100)
    {
        $this->maxAttempts = $maxAttempts;
        $this->delayMs = $delayMs; // Задержка между попытками
    }

    /**
     * Выполняет замыкание с повтором в случае исключения.
     */
    public function run(Closure $callback): void
    {
        $attempt = 0;

        do {
            try {
                DB::beginTransaction();
                $callback();
                DB::commit();
                return;
            } catch (Throwable $e) {
                DB::rollBack();
                $attempt++;

                Log::warning("Transaction attempt #$attempt failed: " . $e->getMessage(), [
                    'exception' => $e,
                ]);

                if ($attempt >= $this->maxAttempts) {
                    Log::error("All {$this->maxAttempts} transaction attempts failed.");
                    throw $e;
                }

                usleep($this->delayMs * 1000); // задержка перед повтором
            }
        } while ($attempt < $this->maxAttempts);
    }
}