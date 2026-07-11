<?php 
namespace App\Services;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    public static function sendToToken($token, $title, $body, $data = [])
{
    try {
        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase/firebase_credentials.json'));
        $messaging = $factory->createMessaging();

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        return $messaging->send($message);
    } catch (NotFound $e) {
        // Token not found or unregistered - you may optionally log this
        \Log::warning("FCM Token not found or invalid: $token. Skipping.");
        return false; // skip
    } catch (MessagingException | FirebaseException $e) {
        // General Firebase Messaging error - optionally log or handle
        \Log::error("FCM Error for token $token: " . $e->getMessage());
        return false; // skip
    } catch (\Throwable $e) {
        // Catch all other unexpected exceptions
        \Log::error("Unexpected FCM error for token $token: " . $e->getMessage());
        return false; // fail silently or handle as needed
    }
}
}
