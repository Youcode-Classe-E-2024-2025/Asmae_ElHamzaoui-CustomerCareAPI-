<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="CustomerCareAPI",
 *     version="1.0.0",
 *     description="API for managing customer support and tickets interactions",
 *     @OA\Contact(
 *         email="support@customercare.com",
 *         name="API Support"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Server(
 *     url="/api",
 *     description="Customer Care API Server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for user authentication"
 * )
 * @OA\Tag(
 *     name="Tickets",
 *     description="API Endpoints for ticket management"
 * )
 * @OA\Tag(
 *     name="Interactions",
 *     description="API Endpoints for ticket interactions"
 * )
 * @OA\Components(
 *     @OA\Schema(
 *         schema="Ticket",
 *         type="object",
 *         required={"title", "description", "status"},
 *         @OA\Property(property="id", type="integer", description="Ticket ID"),
 *         @OA\Property(property="title", type="string", description="Ticket title"),
 *         @OA\Property(property="description", type="string", description="Ticket description"),
 *         @OA\Property(property="status", type="string", description="Ticket status"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation date")
 *     ),
 *     @OA\Schema(
 *         schema="Interaction",
 *         type="object",
 *         required={"message"},
 *         @OA\Property(property="id", type="integer", description="Interaction ID"),
 *         @OA\Property(property="message", type="string", description="Interaction message"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation date")
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
