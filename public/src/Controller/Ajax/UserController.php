<?php

namespace App\Controller\Ajax;


use App\Entity\User;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller\Ajax
 * @Route("/ajax/user", name="ajax_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/search/", name="search", methods={"GET"})
     */
    public function searchUser(Request $request, UserRepository $userRepository)
    {
        $slug = $request->get('query');
        $datas = $userRepository->findLikeSlug($slug);
        $outDatas = [
            "query" => "Unit",
            "suggestions" => [],
        ];
        if (!empty($datas)) {
            foreach ($datas as $data) {
                $outDatas["suggestions"][] = [
                    'value' => $data->getEmail(),
                    'data' => $data->getId()
                ];
            }
        }
        $response = new JsonResponse();
        $response->setData($outDatas);
        return $response;
    }

    /**
     * @Route("/match/", name="match_user", methods={"GET"})
     */
    public function matchUser(Request $request, UserRepository $userRepository)
    {
        $pseudo = $request->get('pseudo');
        $test = $userRepository->findOneBy(['pseudo'  => $pseudo]);

        if (!empty($test)) {
            $outDatas = [
                'mail' => $test->getEmail(),
                'id' => $test->getId()
            ];
            $response = new JsonResponse();
            $response->setData($outDatas);
            return $response;
        }
        else {
            return null;
        }
    }
}
