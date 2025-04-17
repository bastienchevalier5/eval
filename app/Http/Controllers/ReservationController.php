<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Salle;
use App\Models\Reservation;
use App\Notifications\ReservationAnnulee;
use App\Notifications\ReservationCreee;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::user()->isAn('employe')) {
            $reservations = Reservation::with('salle')
            ->where('user_id', auth()->id())
            ->orderBy('heure_debut')
            ->get();

            return view('reservations.index', compact('reservations'));
        } else if (Auth::user()->isAn('admin')) {
            $salles = Salle::all();
            $weeks = collect();

            // On récupère les 6 dernières semaines (de cette année)
            for ($i = 5; $i >= 0; $i--) {
                $startOfWeek = Carbon::now()->startOfWeek()->subWeeks($i);
                $endOfWeek = $startOfWeek->copy()->endOfWeek();
                $reservationsCount = Reservation::whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])->count();

                $totalSlots = ($salles->count() * 10 * 5) - $reservationsCount; // Ex: 10 créneaux/jour × 5 jours ouvrés × nb de salles

                $weeks->push([
                    'label' => 'Semaine ' . $startOfWeek->isoWeek,
                    'total_reservations' => $reservationsCount,
                    'total_slots' => $totalSlots,
                    'taux' => round(($reservationsCount / $totalSlots) * 100, 2)
                ]);
            }

            return view('reservations.index', compact('weeks'));
        } else {
            return view('reservations.index')->with('error', "Vous n'êtes pas autorisé à accéder à cette page");
        }

    }

    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $salles = Salle::all();
        return view('reservations.create', compact('salles'));
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\ReservationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReservationRequest $request)
    {
        $salle = Salle::findOrFail($request->salle_id);
        $debut = Carbon::parse($request->date . ' ' . $request->heure_debut);
        $fin = Carbon::parse($request->date . ' ' . $request->heure_fin);

        if (!$salle->estDisponible($debut, $fin)) {
            return back()->withErrors(['message' => 'La salle n\'est pas disponible pour cette plage horaire.']);
        }

        $reservation = new Reservation([
            'salle_id' => $request->salle_id,
            'user_id' => auth()->id(),
            'date' => $request->date,
            'heure_debut' => $debut,
            'heure_fin' => $fin,
            'titre' => $request->titre,
            'description' => $request->description ?? null,
        ]);

        $reservation->save();

        auth()->user()->notify(new ReservationCreee($reservation));


        return redirect()->route('reservations.index')->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Summary of show
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Summary of destroy
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            return back()->withErrors(['message' => 'Vous n\'êtes pas autorisé à annuler cette réservation.']);
        }

        $user = auth()->user();
        $reservationInfo = clone $reservation;

        $reservation->delete();

        $user->notify(new ReservationAnnulee($reservationInfo));


        return redirect()->route('reservations.index')->with('success', 'Réservation annulée avec succès.');
    }
}
