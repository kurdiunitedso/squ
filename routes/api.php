<?php

use App\Http\Controllers\CP\Whatsapp\TestWebhookController;
use App\Http\Controllers\CP\Whatsapp\WhatsappController;
use App\Http\Controllers\CP\Whatsapp\WhatsappWebhookSetupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::get('/whatsapp/listTemplates', [WhatsappController::class, 'listTemplates']);
Route::post('/whatsapp/sendTemplateHello', [WhatsappController::class, 'sendTemplateHello']);
Route::post('/whatsapp/send', [WhatsappController::class, 'sendMessage']);


/*
Flow when WhatsApp sends a message:
User sends message on WhatsApp
↓
WhatsApp sends webhook to your /webhook/whatsapp endpoint
↓
WhatsAppWebhookController receives it
↓
WhatsAppChatbotService processes it
↓
Message is stored in chat_messages
↓
Session is retrieved/created in chat_sessions
↓
Appropriate response is sent back to user
*/
// Route::match(['get', 'post'], '/webhook/whatsapp', [WhatsappWebhookController::class, 'handle']);

// Test route
Route::post('/test/webhook', [TestWebhookController::class, 'simulateMessage']);


Route::match(['GET', 'POST'], '/webhook/whatsapp', [WhatsappWebhookSetupController::class, 'handleWebhook']);
