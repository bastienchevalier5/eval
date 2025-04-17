<?php

namespace Tests\Unit\Notifications;

use Tests\TestCase;
use App\Models\User;
use App\Models\Salle;
use App\Models\Reservation;
use App\Notifications\ReservationCreee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationCreeeTest extends TestCase
{
    public function test_notification_is_sent_by_mail()
{
    Notification::fake();

    $user = new User(['nom' => 'Jean Dupont', 'email' => 'jean@example.com']);
    $salle = new \App\Models\Salle(['nom' => 'Salle A']);

    $reservation = new \App\Models\Reservation([
        'salle_id' => 1,
        'date' => '2025-04-18',
        'heure_debut' => '09:00',
        'heure_fin' => '10:00',
        'titre' => 'Réunion projet',
    ]);

    // Associer manuellement la salle (sinon elle est nulle)
    $reservation->setRelation('salle', $salle);

    $notification = new \App\Notifications\ReservationCreee($reservation);
    $mail = $notification->toMail($user);
    $rendered = $mail->render();

    $this->assertInstanceOf(\Illuminate\Notifications\Messages\MailMessage::class, $mail);
    $this->assertStringContainsString('Confirmation de votre réservation', $mail->subject);
    $this->assertStringContainsString('Bonjour Jean Dupont', $rendered);
    $this->assertStringContainsString('Salle : Salle A', $rendered);
    $this->assertStringContainsString('Date : 18/04/2025', $rendered);
    $this->assertStringContainsString('De 09:00 à 10:00', $rendered);
    $this->assertStringContainsString('Titre : Réunion projet', $rendered);
}

}
