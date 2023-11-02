<?php

namespace App\Notifications;

use App\Models\Pengeluaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengeluaranNotif extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $user;
    private $pengeluaran;

    public function __construct(Pengeluaran $pengeluaran, $user)
    {
        $this->pengeluaran = $pengeluaran;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
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
            'name' => auth()->user()->name,
            'requirement' => $this->pengeluaran->requirement,
            'price' => 'Rp ' . number_format($this->pengeluaran->price, 0, ',', '.'),
            'quantity' => $this->pengeluaran->quantity,
            'created_at' => $this->pengeluaran->created_at,
            'unit_price' => $this->pengeluaran->unit_price,
            'invoice' => $this->pengeluaran->invoice,
            'message' => auth()->user()->name . ' Baru saja membeli ' . $this->pengeluaran->requirement . ' seharga ' . 'Rp ' . number_format($this->pengeluaran->price, 2, ',', '.') . ' Sebanyak ' . $this->pengeluaran->quantity
        ];
    }
}
