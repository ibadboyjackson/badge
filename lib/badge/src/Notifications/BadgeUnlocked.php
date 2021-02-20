<?php

namespace Badge\Notifications;

use Badge\Badge;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BadgeUnlocked extends Notification
{
    use Queueable;

    /**
     * @var Badge
     */
    private $badge;

    /**
     * Create a new notification instance.
     *
     * @param Badge $badge
     */
    public function __construct(Badge $badge)
    {
        $this->badge = $badge;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Vous avez débloqué le badge ' . $this->badge->name)
                    ->line('Bravo !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'name' => $this->badge->name
        ];
    }

    public static function toText ($data): string
    {
        return "Vous avez débloqué le badge " . $data['name'];
    }
}
