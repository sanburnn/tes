<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewExpenseRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $belanja;
    public function __construct($belanja)
    {
        $this->belanja = $belanja;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'id' => $this->belanja['id'],
            'sekolah_id' => $this->belanja['sekolah_id'],
            'tahun_ajaran' => $this->belanja['tahun_ajaran'],
            'belanja' => $this->belanja['belanja'],
            'sub_belanja' => $this->belanja['sub_belanja'],
            'jumlah' => $this->belanja['jumlah'],
            'created_at' => $this->belanja['created_at']
        ];
    }
}
