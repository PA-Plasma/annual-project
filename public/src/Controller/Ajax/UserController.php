<?php

namespace App\Controller\Ajax;


use App\Entity\User;
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
    public function searchUser(Request $request)
    {
        $slug = $request->get('query');
        $em = $this->getDoctrine()->getRepository(User::class);
        $datas = $em->findLikeSlug($slug);
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
}