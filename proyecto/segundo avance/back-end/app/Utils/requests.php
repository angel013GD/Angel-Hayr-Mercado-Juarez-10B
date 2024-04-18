<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

function sendApiSuccess(
    $data = [],
    string $message = "Procesado exitosamente",
    int $code = 200
): JsonResponse {
    return response()->json(
        [
            "success" => true,
            "data" => $data,
            "message" => $message,
        ],
        $code
    );
}

function sendApiFailure(
    $data = null,
    string $message = "Fallo al procesar petición",
    int $code = 422
): JsonResponse {
    return response()->json(
        [
            "success" => false,
            "data" => $data,
            "message" => $message,
        ],
        $code
    );
}

function sendApiResponse(
    bool $success = true,
    $data = null,
    string $message = "Procesado exitosamente",
    int $code = 200
): JsonResponse {
    if ($success) {
        return sendApiSuccess($data, $message, $code);
    }
    return sendApiFailure($data, $message, $code);
}

// revisa si una request es multipart/form-data
function isMultipart(Request $request): bool
{
    return str_contains(
        $request->header("Content-Type"),
        "multipart/form-data"
    );
}

function getFileData(Request $request)
{
    $file = $request->file("files");
    $key = $request->get("key");
    return [
        "timestamp" => time(),
        "file" => $file,
        "extension" => $file->getClientOriginalExtension(),
        "evidencia_tipo" => $request->get("evidencia_tipo"),
        "key" => $key ? "_{$key}" : "",
    ];
}
