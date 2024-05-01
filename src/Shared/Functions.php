<?php 

namespace App\Shared;

use App\Entity\TLog;
use App\Entity\TLogin;
use App\Repository\TLoginRepository;
use Doctrine\ORM\Query\Expr\Func;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Functions
{


    private ManagerRegistry $managerRegistry;
    private TLoginRepository $loginRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher, ManagerRegistry $managerRegistry,  TLoginRepository $loginRepository)
    {
        $this->managerRegistry = $managerRegistry;
        $this->loginRepository = $loginRepository;
        $this->hasher = $hasher;
    }


    public function jsondecode()
    {
        try{
            return file_get_contents('php://input')?json_decode(file_get_contents('php://input'),false,512,JSON_THROW_ON_ERROR| JSON_ERROR_NONE):[];
            
        }catch(Exception $e){

        }
    }


    public function success(array $data = null, $message='success',int $codeHttp=200): JsonResponse
    {
        return new JsonResponse([
            'status' => 1,
            'title' => $message,
            'message' => $message,
            'data' => $data
        ], $codeHttp);
    }


    public function error(array $error = ErrorHttp::MSG_ERROR, array $logData=[]): JsonResponse
    {
        return new JsonResponse([
            'status' => 0,
            'error' => $error['error']??'error',
            'title' => $$error['title']??"Erreur interne du serveur",
           'message' => $error['message']?? "La requête envoyée par le navigateur n'a pas pu être traitée."
        ], $error['code']??500);
    }


    public function em():ObjectManager
    {
        return $this->managerRegistry->getManager();
    }


    public function log(array $param = [])
    {

        $log = (new TLog())
        ->setUri($_SERVER['REQUEST_URI'])
        ->setMethod($_SERVER['REQUEST_METHOD'])
        ->setIp($_SERVER['REMOTE_ADDR'])
        ->setStatusCode($param['status_code']??200)
        ->setAction($param['action']??null)
        ->setMessage($param['message']??null)
        ->setFkLogin($param['fk_login']??null)
        ;
    }

    public function getUser($id) : TLogin
    {
        return $this->loginRepository->findOneBy(['id'=>$id,'state'=>true]);
    }

    public function hasher(): UserPasswordHasherInterface
    {
        return $this->hasher;
    }
}