<?php

namespace App\Http\Controllers;

use App\Services\RechercheService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class RechercheController extends Controller
{
    protected $rechercheService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RechercheService $rechercheService)
    {
        $this->rechercheService = $rechercheService;
    }

    /**
     * @return View 
     * @throws BindingResolutionException 
     */
    public function recherche()
    {
        $listeTraitements = $this->rechercheService->getTraitementsList();
        $listeUrgences = $this->rechercheService->getRecordsList('urgence');
        $listeRisquesH = $this->rechercheService->getRecordsList('risque_h');
        $listeRisquesT = $this->rechercheService->getRecordsList('risque_t');
        $listeDebits = $this->rechercheService->getRecordsList('debit_renal');

        return view('recherche', [
            'listeTraitements' => $listeTraitements,
            'listeUrgences' => $listeUrgences,
            'listeRisquesH' => $listeRisquesH,
            'listeRisquesT' => $listeRisquesT,
            'listeDebits' => $listeDebits,
        ]);
    }

    public function reponse()
    {
        $filter = $this->rechercheService->createFilter($_POST);
        if (!empty($this->rechercheService->getScenario($filter))) {
            $scenario = $this->rechercheService->getScenario($filter)[0];
            $responseInfos = $this->rechercheService->prepareInfos($_POST, $scenario);
            $criteres = $this->rechercheService->prepareCriteres($_POST);
            return view('reponse', ['infos' => $responseInfos, 'criteres' => $criteres]);
        }
        return view('erreur-reponse');
    }
}
