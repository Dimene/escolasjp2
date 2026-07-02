namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class SmsChannel
{
    protected $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        $to = $notifiable->routeNotificationForSms($notifiable);

        if (!$to) {
            return;
        }

        $this->twilio->messages->create($to, [
            'from' => config('services.twilio.from'),
            'body' => $message,
        ]);
    }
}
