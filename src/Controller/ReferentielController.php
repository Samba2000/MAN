<?php

namespace App\Controller;

use App\Repository\GroupeCompetenceRepository;
use App\Repository\ReferentielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReferentielController extends AbstractController
{
    private $referentielRepository;
    /**
     * @var GroupeCompetenceRepository
     */
    private $groupeCompetenceRepository;

    public function __construct(
        ReferentielRepository $referentielRepository,
        GroupeCompetenceRepository $groupeCompetenceRepository)
    {
        $this->groupeCompetenceRepository = $groupeCompetenceRepository;
        $this->referentielRepository = $referentielRepository;
    }
    /**
     * @Route(
     *     name="get_grpcompetence_id_competence",
     *     path="/api/admin/grpecompetences/{id}/competences",
     *     methods={"GET"}
     * )
     */
    public function get_grpcompetence_id_competence($id) {
        $grp=$this->groupeCompetenceRepository->find($id);
        $tab=["Groupe de Competences"=>[$grp,"Competences"=>$grp->getCompetence()]];
        return $this->json($tab, 200);
    }
    /**
     * @Route(
     *     name="get_ref_grp",
     *     path="/api/admin/referentiels/{id}/gprecompetences/{id1}",
     *     methods={"GET"}
     * )
     */
    public function get_ref_grp($id,$id1) {
        $ref=$this->referentielRepository->find($id);
        $grp=$ref->getGrpCompetences()[$id1];
        $tab=["Refentiel ".$id, "Groupe de Competences"=>$grp];
        return $this->json($tab, 200);
    }
}
