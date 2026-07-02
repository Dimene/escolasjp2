namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class SmsNotification extends Notification
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['sms'];
    }

    public function toSms($notifiable)
    {
        return $this->message;
    }

    public function routeNotificationForSms($notifiable)
    {
        return $notifiable->phone_number;
    }
}
