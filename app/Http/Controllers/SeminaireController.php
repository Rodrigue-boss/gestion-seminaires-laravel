<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminaire;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\SeminaireValideMail;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Mail\NotificationEtudiantMail;

use Carbon\Carbon;

class SeminaireController extends Controller
{
    // Affiche le formulaire
    public function create()
    {
        return view('seminaires.create');
    }

    // Enregistre le séminaire
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'salle' => 'required|string|max:100',
            'lien_visio' => 'nullable|url',
        ]);

        Seminaire::create([
            'titre' => $request->titre,
            'date' => $request->date,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'salle' => $request->salle,
            'lien_visio' => $request->lien_visio,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Séminaire soumis avec succès.');
    }
    
    public function index(Request $request)
    {
       $filtre = $request->query('statut');
       $search = $request->query('search');

       $query = \App\Models\Seminaire::with('user')->latest();

       if ($filtre && in_array($filtre, ['en attente', 'accepté', 'rejeté'])) {
         $query->where('statut', $filtre);
       }

      if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('titre', 'like', "%$search%")
              ->orWhere('salle', 'like', "%$search%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%$search%");
              });
        });
     }

     $seminaires = $query->get();

    return view('seminaires.index', compact('seminaires', 'filtre', 'search'));
   }

   public function valider($id)
   {
      if (auth()->user()->role !== 'secretaire') {
          abort(403, 'Seul le secrétaire peut valider un séminaire.');
      }

      $seminaire = \App\Models\Seminaire::with('user')->findOrFail($id);
      $seminaire->statut = 'accepté';
      $seminaire->save();

     // Envoyer un email au présentateur
     Mail::to($seminaire->user->email)->send(new SeminaireValideMail($seminaire));

     return back()->with('success', 'Séminaire validé et notification envoyée.');
   }

   public function rejeter($id)
   {
       $seminaire = \App\Models\Seminaire::findOrFail($id);
       $seminaire->statut = 'rejeté';
       $seminaire->save();

    return back()->with('success', 'Séminaire rejeté.');
  }
  
  public function exportPDF(Request $request)
  {
    $seminaires = \App\Models\Seminaire::with('user')->latest()->get();

    $pdf = Pdf::loadView('seminaires.pdf', compact('seminaires'));
    return $pdf->download('liste_seminaires.pdf');
  }
  public function etudiantIndex()
  {
    $seminaires = \App\Models\Seminaire::with('user')
        ->where('statut', 'accepté')
        ->latest()
        ->get();

    return view('seminaires.etudiant', compact('seminaires'));
  }
  

public function editerResume($id)
{
    $seminaire = \App\Models\Seminaire::findOrFail($id);

    // Vérifier que l'utilisateur est le créateur
    if ($seminaire->user_id !== auth()->id()) {
        abort(403);
    }

    // Vérifier qu'on est à J-10 ou moins
    $aujourdhui = Carbon::today();
    $datePresentation = Carbon::parse($seminaire->date);
    $diffJours = $aujourdhui->diffInDays($datePresentation, false);

    if ($diffJours > 10) {
        return back()->with('error', 'Le résumé ne peut être envoyé que 10 jours avant la présentation.');
    }

    return view('seminaires.resume', compact('seminaire'));
}


public function mettreAJourResume(Request $request, $id)
{
    
    $seminaire = Seminaire::findOrFail($id);

    // Vérifie que l'utilisateur est bien le propriétaire
    if (auth()->id() !== $seminaire->user_id) {
        abort(403, 'Accès interdit.');
    }

    // Vérifie que la date est à J–10 ou moins
    $jmoins10 = Carbon::parse($seminaire->date)->subDays(10);
    if (Carbon::now()->lessThan($jmoins10)) {
        return back()->with('error', 'Vous ne pouvez soumettre un résumé qu’à partir de J–10.');
    }

    // Validation et mise à jour
    $request->validate([
        'resume' => 'required|string|min:10',
    ]);

    /*$seminaire->update([
    'resume' => $request->input('resume'),
    ]);*/
    /*$seminaire->forceFill([
    'resume' => $request->input('resume'),
    ]);
    \DB::listen(function ($query) {
    logger($query->sql);
    logger($query->bindings);
    });*/

    /*$seminaire->save();*/
    \DB::table('seminaires')
    ->where('id', $id)
    ->update([
        'resume' => $request->input('resume'),
        'updated_at' => now(),
    ]);

    // Recharge l'objet avec les données fraîches
    $seminaire->refresh();
    return back()->with('success', 'Résumé mis à jour avec succès.');
}



public function publier($id)
{
    if (auth()->user()->role !== 'secretaire') {
        abort(403, 'Seul le secrétaire peut publier un séminaire.');
    }
    $seminaire = \App\Models\Seminaire::findOrFail($id);
    
    $jmoins7 = \Carbon\Carbon::parse($seminaire->date)->subDays(7);
    if (now()->lessThan($jmoins7)) {
         return back()->with('error', 'La publication est autorisée seulement à partir de J–7.');
    }

    $seminaire->publie = true;
    $seminaire->save();

    // Récupérer tous les étudiants
    $etudiants = User::where('role', 'étudiant')->get();

    foreach ($etudiants as $etudiant) {
      Mail::to($etudiant->email)->send(new NotificationEtudiantMail($seminaire));
      usleep(1000000); // 0.5s
    }


    return back()->with('success', 'Séminaire publié et notification envoyée aux étudiants.');
}

public function formFichier($id)
{
    $seminaire = \App\Models\Seminaire::findOrFail($id);
    return view('seminaires.upload_fichier', compact('seminaire'));
}

public function uploadFichier(Request $request, $id)
{
    $request->validate([
        'fichier' => 'required|file|mimes:pdf,ppt,pptx|max:10240', // max 10 Mo
    ]);

    $seminaire = \App\Models\Seminaire::findOrFail($id);

    $path = $request->file('fichier')->store('presentations', 'public');
    $seminaire->fichier = $path;
    $seminaire->save();

    return redirect()->route('seminaires.index')->with('success', 'Fichier de présentation ajouté avec succès.');
}


public function indexPresentateur()
{
    $user = auth()->user();

    $seminaires = \App\Models\Seminaire::where('user_id', $user->id)->get();

    foreach ($seminaires as $seminaire) {
        $seminaire->accessible_resume = false;

        if ($seminaire->date) {
            $jmoins10 = Carbon::parse($seminaire->date)->subDays(10);
            if (Carbon::now()->greaterThanOrEqualTo($jmoins10)) {
                $seminaire->accessible_resume = true;
            }
        }
    }

    return view('roles.presentateur', compact('seminaires'));
}


}

