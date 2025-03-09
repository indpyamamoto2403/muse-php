<?php

namespace App\Repositories;

use App\Models\AnswerHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class AnswerHistoryRepository
{
    /**
     * @var AnswerHistory
     */
    protected $model;

    /**
     * AnswerHistoryRepository constructor.
     *
     * @param AnswerHistory $answerHistory
     */
    public function __construct(AnswerHistory $answerHistory)
    {
        $this->model = $answerHistory;
    }

    /**
     * Get all answer histories.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }


    public function getMine(): Collection | AnswerHistory | null
    {
        return $this->model->where('user_id', Auth::id())->get();
    }

    /**
     * Find an answer history by ID.
     *
     * @param int $id
     * @return AnswerHistory|null
     */
    public function find(int $id): ?AnswerHistory
    {
        return $this->model->find($id);
    }

    /**
     * Create a new answer history.
     *
     * @param array $data
     * @return AnswerHistory
     */
    public function create(int $questionId, int $answer_id): AnswerHistory
    {
        return $this->model->create([
            'question_id' => $questionId,
            'answer' => $answer_id, // Update this line to use $answer_id
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Update an existing answer history.
     *
     * @param int $id
     * @param array $data
     * @return AnswerHistory|null
     */
     public function update(int $id, array $data): ?AnswerHistory
    {
      $answerHistory = $this->find($id);
      if ($answerHistory) {
        $answerHistory->update($data);
        return $answerHistory;
      }
      return null;
    }

     /**
     * Delete an existing record.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $result = $this->model::destroy($id);
        return (bool)$result;
    }

    /**
     * Get answer histories by user ID.
     *
     * @param  int  $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * Get answer histories by question ID.
     *
     * @param  int  $questionId
     * @return Collection
     */
    public function getByQuestionId(int $questionId): Collection
    {
        return $this->model->where('question_id', $questionId)->get();
    }

}