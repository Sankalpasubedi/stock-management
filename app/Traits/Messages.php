<?php


namespace App\Traits;

trait Messages
{
    public function getSuccessMessage($name): array
    {
        return ['message' => ['message' => $name . ' created.']];
    }

    public function getUpdateMessage($name): array
    {
        return ['message' => ['message' => $name . ' updated.']];
    }

    public function getDestroyMessage($name): array
    {
        return ['message' => ['message' => $name . ' removed.']];
    }

    public function getMessage($msg): array
    {
        return ['message' => ['message' => $msg]];
    }

    public function getErrorMessage($msg): array
    {
        return ['errors' => ['message' => $msg]];
    }


}
