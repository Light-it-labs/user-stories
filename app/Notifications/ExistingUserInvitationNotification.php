<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ExistingUserInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $notification_url;
    protected $params;

    /**
     * Create a new notification instance.
     *
     * @param $notification_url
     */
    public function __construct($notification_url, $params)
    {
        $this->notification_url = $notification_url;
        $this->params = $params;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::get('Invitation to Project'))
            ->greeting("Hello {$this->params['email']}")
            ->line(Lang::get("You are receiving this email because {$this->params['invitation_owner']} invite 
            you to contribute in {$this->params['project_name']} project ")) 
            ->action(Lang::get('Accept Invitation'), $this->notification_url)
            ->line(Lang::get('Thank you!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
