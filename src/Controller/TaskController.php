<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/tasks', name: 'app_task.')]
#[IsGranted('IS_AUTHENTICATED_FULLY', statusCode: 401)]
class TaskController extends AbstractController
{
    private TaskRepository $taskRepository;

    public function __construct(
        TaskRepository $taskRepository
    ) {
        $this->taskRepository = $taskRepository;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function indexAction(#[CurrentUser] ?User $user, Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        if ($this->isGranted('ROLE_ADMIN')) {
            $tasks = $this->taskRepository->fetchWithPagination($page, $limit);
        } else {
            $tasks = $this->taskRepository->fetchWithPagination($page, $limit, $user);
        }

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'tasks' => $tasks,
        ]);
    }

    #[Route('/{id}', name: 'task', methods: ['GET'])]
    public function taskAction(int $id): JsonResponse
    {
        $tasks = $this->taskRepository->findById($id);

        return $this->json($tasks);
    }

    #[Route('/', name: 'new', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', statusCode: 401)]
    public function newAction(Request $request/* , #[MapRequestPayload] Task $task, ValidatorInterface $validator */): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskRepository->save($task);

            return $this->json(
                ['task_id' => $task->getId()],
                Response::HTTP_CREATED
            );
        }

        $formErrors = $form->getErrors(true);
        $errorsArray = [];
        foreach ($formErrors as $error) {
            $errorsArray[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $this->json(
            [
                'error' => $errorsArray,
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    #[Route('/{id}', name: 'put', methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', statusCode: 401)]
    public function putAction(int $id, Request $request): JsonResponse
    {
        $task = $this->taskRepository->find($id);
        if (null == $task) {
            throw $this->createNotFoundException();
        }

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(TaskType::class, $task);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskRepository->save($task);

            return $this->json(
                ['task_id' => $task->getId()],
                Response::HTTP_ACCEPTED
            );
        }

        $formErrors = $form->getErrors(true);
        $errorsArray = [];
        foreach ($formErrors as $error) {
            $errorsArray[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $this->json(
            [
                'error' => $errorsArray,
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', statusCode: 401)]
    public function deleteAction(int $id): JsonResponse
    {
        $task = $this->taskRepository->find($id);
        if (null == $task) {
            throw $this->createNotFoundException();
        }

        $this->taskRepository->remove($task);
        $this->taskRepository->flush();

        return $this->json(['message' => 'task_deleted']);
    }
}
