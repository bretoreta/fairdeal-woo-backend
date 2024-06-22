<?php

namespace App\Notifications\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SyncFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $actor, public string $exception_message)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line("Sync with the website that was started by {$this->actor->name} has failed. Here is the detail of the error that ocuured")
                    ->line("{$this->exception_message}")
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'actor_id' => $this->actor->id,
            'actor_name' => $this->actor->name,
            'actor_profile' => $this->actor->profile_photo_url,
            'message_type' => 'exception',
            'message' => "Sync with the website that was started by {$this->actor->name} has failed. Here is the detail of the error that occured",
            'exception_message' => "{$this->exception_message}",
            'actionable' => true,
            'actions' => [
                'primary' => [
                    'action_label' => 'Retry Sync',
                    'action_url' => route('admin.sync.dispatch'),
                ],
            ]
        ];
    }
}