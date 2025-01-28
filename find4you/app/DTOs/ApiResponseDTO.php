<?php

namespace App\DTOs;

class ApiResponseDTO
{
    public $status;

    public $message;

    public $data;

    public $errors;

    public function __construct($status = 200, $message = null, $data = null, $errors = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
    }

    public static function success($status = 200, $data = null, $message = 'Requisição realizada com sucesso')
    {
        return new self($status, $message, $data);
    }

    public static function error($status = 400, $message = 'Requisição falhou', $errors = null)
    {
        return new self($status, $message, null, $errors);
    }

    public function toArray()
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
            'errors' => $this->errors,
        ];
    }

    public function toJson()
    {
        return response()->json($this->toArray(), $this->status);
    }
}
