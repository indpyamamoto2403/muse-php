<?php

namespace App\Services;

use App\Repositories\EvaluationRepository;

/**
 * Class EvaluationService
 *
 * Service class responsible for managing evaluations by interacting with the EvaluationRepository.
 */
class EvaluationService
{
    /**
     * @var EvaluationRepository
     */
    private $evaluationRepository;

    /**
     * EvaluationService constructor.
     *
     * Initializes a new instance of the EvaluationService and sets up the EvaluationRepository.
     */
    public function __construct()
    {
        $this->evaluationRepository = new EvaluationRepository();
    }

    /**
     * Retrieve all evaluations.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * Returns a collection of all evaluations.
     */
    public function getAllEvaluations()
    {
        return $this->evaluationRepository->all();
    }

    /**
     * Retrieve a single evaluation by its ID.
     *
     * @param int|string $id
     * @return \App\Models\Evaluation|null
     * Returns an evaluation if found, otherwise null.
     */
    public function getEvaluation($id)
    {
        return $this->evaluationRepository->find($id);
    }

    /**
     * Create a new evaluation record.
     *
     * @param array $data
     * @return \App\Models\Evaluation
     * Returns the newly created evaluation.
     */
    public function createEvaluation(array $data)
    {
        return $this->evaluationRepository->create($data);
    }

    /**
     * Update an existing evaluation record.
     *
     * @param int|string $id
     * @param array $data
     * @return \App\Models\Evaluation|bool
     * Returns the updated evaluation if successful, otherwise false.
     */
    public function updateEvaluation($id, array $data)
    {
        $evaluation = $this->evaluationRepository->find($id);
        if (!$evaluation) {
            return false;
        }
        return $this->evaluationRepository->update($evaluation, $data);
    }

    /**
     * Delete an existing evaluation record.
     *
     * @param int|string $id
     * @return bool
     * Returns true on successful deletion, otherwise false.
     */
    public function deleteEvaluation($id)
    {
        $evaluation = $this->evaluationRepository->find($id);
        if (!$evaluation) {
            return false;
        }
        return $this->evaluationRepository->delete($evaluation);
    }
}

