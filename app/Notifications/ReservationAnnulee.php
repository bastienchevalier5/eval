<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;

class ReservationAnnulee extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Reservation $reservation) {}

    /**
     * @param \Illuminate\Foundation\Auth\User|\Illuminate\Notifications\AnonymousNotifiable $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }


    /**
     * @param \Illuminate\Foundation\Auth\User|\Illuminate\Notifications\AnonymousNotifiable $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre réservation a été annulée')
            ->greeting('Bonjour ' . ($notifiable->name ?? 'Utilisateur') . ',')
            ->line('Votre réservation a été annulée.')
            ->line('Titre : ' . $this->reservation->titre)
            ->line('Date : ' . $this->reservation->date->format('d/m/Y'))
            ->line('Merci de votre compréhension.');
    }
}
