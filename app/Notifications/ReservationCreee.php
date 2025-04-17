<?php

namespace App\Notifications;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationCreee extends Notification
{
    use Queueable;

    public function __construct(public Reservation $reservation) {}

    /**
     * @param User $notifiable
     * @return array<string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * @param User $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $salle = $this->reservation->salle;

        return (new MailMessage)
            ->subject('Confirmation de votre réservation')
            ->greeting('Bonjour ' . ($notifiable->name ?? 'Utilisateur') . ',')
            ->line('Votre réservation a bien été enregistrée.')
            ->line('Salle : ' . ($salle->nom ?? 'Salle inconnue'))
            ->line('Date : ' . \Carbon\Carbon::parse($this->reservation->date)->format('d/m/Y'))
            ->line('De ' . \Carbon\Carbon::parse($this->reservation->heure_debut)->format('H:i') . ' à ' . \Carbon\Carbon::parse($this->reservation->heure_fin)->format('H:i'))
            ->line('Titre : ' . $this->reservation->titre)
            ->line('Merci de votre confiance.');
    }
}
