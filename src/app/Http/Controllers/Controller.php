<?php

/**
 *   Stake iGaming platform
 *   ----------------------
 *   Controller.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use OpenApi\Attributes as OA;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Platform API Documentation",
     *      description="Platform api",
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Local server"
     * )
     * 
     * @OA\server(
     *      url="https://platform-dev.baanbaan.site",
     *      description="Dev server"
     * )
     * 
     * @OA\SecurityScheme(
     *      securityScheme="Authorization",
     *      type="apiKey",
     *      in="header",
     *      name="Authorization"
     * )
     */

    use AuthorizesRequests, ValidatesRequests;

    public function successResponse($data = NULL)
    {
        $result = ['success' => TRUE];

        if (!is_null($data)) {
            $result = array_merge($result, is_string($data) ? ['message' => $data] : (array) $data);
        }

        return $result;
    }

    public function errorResponse(string $message)
    {
        return [
            'success' => FALSE, 'message' => $message
        ];
    }
}
